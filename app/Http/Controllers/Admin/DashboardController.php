<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalProducts = Product::count();
        $totalCustomers = User::role('customer')->count();
        $totalVisitors = 237782; // Example static value
        $activeUsers = 2758; // Example static value

        // Initialize empty chart data
        $revenueChart = null;
        $targetChart = null;
        
        // Check if LarapexChart is available
        if (class_exists('ArielMejiaDev\LarapexCharts\LarapexChart')) {
            try {
                // 1. Revenue Analytics (last 8 days)
                $dates = collect(range(0, 7))->map(function ($i) {
                    return Carbon::today()->subDays(7 - $i)->format('Y-m-d');
                });
                
                $orders = Order::where('created_at', '>=', Carbon::today()->subDays(7))
                    ->where('status', 'completed')
                    ->get()
                    ->groupBy(function ($order) {
                        return Carbon::parse($order->created_at)->format('Y-m-d');
                    });
                    
                $revenueData = [];
                $orderCountData = [];
                foreach ($dates as $date) {
                    $dayOrders = $orders->get($date, collect());
                    $revenueData[] = $dayOrders->sum('total_amount');
                    $orderCountData[] = $dayOrders->count();
                }
                
                $revenueChart = (new LarapexChart)->lineChart()
                    ->setTitle('Revenue Analytics')
                    ->addData('Revenue', $revenueData)
                    ->addData('Orders', $orderCountData)
                    ->setXAxis($dates->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray());
                
                // 2. Monthly Target (radial)
                $targetChart = (new LarapexChart)->radialChart()
                    ->setTitle('Monthly Target')
                    ->addData([75])
                    ->setLabels(['Target']);
                    
            } catch (\Exception $e) {
                // Log error but don't break the page
                \Log::error('Error generating charts: ' . $e->getMessage());
            }
        }
        
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        $monthlyRevenue = Order::where('payment_status', 'completed')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('total_amount');
        $target = 60000; // Set your monthly target here
        $percent = $target > 0 ? round(($monthlyRevenue / $target) * 100, 2) : 0;
        $targetChart = (new LarapexChart)->radialChart()
            ->setTitle('Monthly Target')
            ->addData([$percent])
            ->setLabels(['Target']);

        // 3. Top Categories (donut)
        $topCategoriesRaw = Category::with(['products.orderItems.order' => function($q) {
            $q->where('payment_status', 'completed');
        }])->get()->map(function($cat) {
            $total = 0;
            foreach ($cat->products as $product) {
                foreach ($product->orderItems as $item) {
                    if ($item->order && $item->order->payment_status === 'completed') {
                        $total += $item->quantity * $item->price;
                    }
                }
            }
            return [
                'name' => $cat->name,
                'value' => $total,
            ];
        })->sortByDesc('value')->take(4)->values();
        $categoriesChart = (new LarapexChart)->donutChart()
            ->setTitle('Top Categories')
            ->addData($topCategoriesRaw->pluck('value')->toArray())
            ->setLabels($topCategoriesRaw->pluck('name')->toArray());
        $topCategories = $topCategoriesRaw->toArray();

        // 4. Traffic Sources (static)
        $trafficChart = (new LarapexChart)->donutChart()
            ->setTitle('Traffic Sources')
            ->addData([40, 30, 15, 10, 5])
            ->setLabels(['Direct Traffic', 'Organic Search', 'Social Media', 'Referral Traffic', 'Email Campaign']);
        $trafficSources = [
            ['name' => 'Direct Traffic', 'value' => 40],
            ['name' => 'Organic Search', 'value' => 30],
            ['name' => 'Social Media', 'value' => 15],
            ['name' => 'Referral Traffic', 'value' => 10],
            ['name' => 'Email Campaign', 'value' => 5],
        ];

        // Recent Orders
        $recentOrders = Order::with(['user', 'items.product'])->latest()->take(5)->get();

        // Recent Activities (dummy)
        $recentActivities = [
            ['text' => 'Maureen Steel purchased 2 items totaling $100.', 'time' => '10:24 AM'],
            ['text' => 'The price of "Smart TV" was updated from $500 to $450.', 'time' => '9:50 AM'],
            ['text' => 'Vincent Lauren left a 5-star review for Wireless Headphones.', 'time' => '9:30 AM'],
            ['text' => '"Running Shoes" stock is below 10', 'time' => '9:18 AM'],
            ['text' => 'Demian Upto\'s order status changed from "Pending" to "Processing".', 'time' => '7:02 AM'],
        ];

        // Ensure we have all required variables
        $data = [
            'totalOrders' => $totalOrders ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalProducts' => $totalProducts ?? 0,
            'totalCustomers' => $totalCustomers ?? 0,
            'totalVisitors' => $totalVisitors ?? 0,
            'activeUsers' => $activeUsers ?? 0,
            'revenueChart' => $revenueChart ?? null,
            'targetChart' => $targetChart ?? null,
            'categoriesChart' => $categoriesChart ?? null,
            'trafficChart' => $trafficChart ?? null,
            'trafficSources' => $trafficSources ?? [],
            'topCategories' => $topCategories ?? [],
            'recentOrders' => $recentOrders ?? [],
            'recentActivities' => $recentActivities ?? [],
            'topProducts' => [] ?? [],
            'cartItemsCount' => 0, // Default value for cart items count
        ];
        
        return view('admin.dashboard', $data);
    }

    public function dashboard()
    {
        $totalOrders = \App\Models\Order::count();
        $totalRevenue = \App\Models\Order::sum('total');
        $totalProducts = \App\Models\Product::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();

        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'totalProducts', 'totalCustomers'));
    }
} 