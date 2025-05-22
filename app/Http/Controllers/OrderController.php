<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_zipcode' => 'required|string',
            'shipping_phone' => 'required|string',
            'payment_method' => 'required|in:stripe,paypal',
            'notes' => 'nullable|string',
        ]);

        $cart = auth()->user()->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $cart->total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_country' => $request->shipping_country,
                'shipping_zipcode' => $request->shipping_zipcode,
                'shipping_phone' => $request->shipping_phone,
                'notes' => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'subtotal' => $item->subtotal,
                ]);

                // Update product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear the cart
            $cart->items()->delete();

            DB::commit();

            // Redirect to payment processing
            return redirect()->route('payment.process', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your order.');
        }
    }

    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);

            // Restore product stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            return back()->with('success', 'Order cancelled successfully.');
        }

        return back()->with('error', 'Cannot cancel this order.');
    }
} 