<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product', 'status']);

        // Search filter
        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($status = $request->query('status')) {
            $query->whereHas('status', function($q) use ($status) {
                $q->where('name', $status);
            });
        }

        // Date range filter
        if ($dateFrom = $request->query('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->query('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Sorting
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');
        
        $validSorts = ['id', 'total_amount', 'created_at', 'status'];
        $sort = in_array($sort, $validSorts) ? $sort : 'created_at';
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'desc';
        
        // Handle status sorting through the relationship
        if ($sort === 'status') {
            $query->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
                  ->orderBy('order_statuses.name', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }
        
        $query->orderBy($sort, $direction);

        $orders = $query->paginate(15)->withQueryString();
        $statuses = OrderStatus::all();
        
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'coupon', 'status']);
        $statuses = OrderStatus::all();
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_id' => 'required|exists:order_statuses,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            $newStatus = OrderStatus::findOrFail($request->status_id);
            $previousStatus = $order->status;
            
            // Update the order status
            $order->order_status_id = $newStatus->id;
            $order->save();

            // Record status change history if the status has changed
            if (!$previousStatus || $previousStatus->id !== $newStatus->id) {
                $order->statusHistory()->create([
                    'user_id' => auth()->id(),
                    'status' => $newStatus->name,
                    'notes' => $request->notes ?? 'Status mis à jour',
                ]);

                // Trigger events based on status change
                if ($newStatus->name === 'Expédié') {
                    // Send shipping notification
                    $order->user->notify(new OrderShipped($order));
                } elseif ($newStatus->name === 'Livré') {
                    // Send delivery confirmation
                    $order->user->notify(new OrderDelivered($order));
                }
                if ($newStatus->name === 'Annulé' && (!$previousStatus || !in_array($previousStatus->name, ['Annulé', 'Remboursé']))) {
                    foreach ($order->items as $item) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            DB::commit();
            return back()->with('success', 'Statut de la commande mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Échec de la mise à jour du statut de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Process a refund for the order.
     */
    public function processRefund(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $order->total_amount,
            'reason' => 'required|string|max:1000',
        ]);

        // TODO: Implement actual refund logic with payment gateway
        
        // Update order status to refunded
        $refundedStatus = OrderStatus::where('name', 'refunded')->firstOrFail();
        
        $order->update([
            'status_id' => $refundedStatus->id,
            'status' => 'refunded',
            'refund_amount' => $request->amount,
            'refund_reason' => $request->reason,
            'refunded_at' => now(),
        ]);

        // Add status history
        $order->statusHistory()->create([
            'status_id' => $refundedStatus->id,
            'status' => 'refunded',
            'notes' => 'Refund processed: ' . $request->reason . ' - Amount: ' . number_format($request->amount, 2),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Refund processed successfully.');
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Apply filters if any
        if ($status = $request->query('status')) {
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply date range filter if provided
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();

        $columns = [
            'ID', 'N° Commande', 'Date', 'Client', 'Email', 'Statut', 
            'Sous-total', 'TVA', 'Livraison', 'Remise', 'Total', 'Méthode de paiement', 'Date de création'
        ];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fputs($file, "\xEF\xBB\xBF");
            
            // Add CSV headers
            fputcsv($file, $columns, ';');

            // Add order data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->order_number,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->user->name,
                    $order->user->email,
                    $order->status ? $order->status->name : 'Inconnu',
                    number_format($order->subtotal, 2, ',', ' '),
                    number_format($order->tax_amount, 2, ',', ' '),
                    number_format($order->shipping_amount, 2, ',', ' '),
                    number_format($order->discount_amount, 2, ',', ' '),
                    number_format($order->total_amount, 2, ',', ' '),
                    $order->payment_method,
                    $order->created_at->format('d/m/Y')
                ], ';');
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
