@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-64 h-screen">
        @include('partials.sidebar')
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col p-4 sm:p-6">
        <!-- Header -->
        <header class="w-full">
            @include('partials.header')
        </header>

        <!-- Dashboard Content -->
        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <!-- Top Row: Summary Cards -->
            <div class="col-span-1 md:col-span-2 xl:col-span-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow flex flex-col border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 text-gray-500 font-medium">
                        <span class="material-icons text-orange-400">attach_money</span>
                        Total Sales
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
                        <span>${{ number_format($totalRevenue, 0) }}</span>
                        <span class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded">+3.1% this week</span>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow flex flex-col border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 text-gray-500 font-medium">
                        <span class="material-icons text-orange-400">shopping_cart</span>
                        Total Orders
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
                        <span>{{ $totalOrders }}</span>
                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded">-2.9% this week</span>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow flex flex-col border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 text-gray-500 font-medium">
                        <span class="material-icons text-orange-400">groups</span>
                        Total Visitors
                    </div>
                    <div class="text-3xl font-extrabold text-gray-900 mt-2 flex items-center gap-2">
                        <span>{{ $totalVisitors ?? '237,782' }}</span>
                        <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded">+4.0% this week</span>
                    </div>
                </div>
            </div>
            <!-- Top Categories -->
            <div class="bg-white p-6 rounded-2xl shadow flex flex-col border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center gap-2 font-semibold text-gray-900">
                        <span class="material-icons text-orange-400">pie_chart</span>
                        Top Categories
                    </div>
                    <a href="#" class="text-xs text-orange-500 font-bold">See All</a>
                </div>
                <div>{!! $categoriesChart->container() !!}</div>
                <ul class="mt-4 space-y-2">
                    @foreach($topCategories as $cat)
                        <li class="flex justify-between text-sm">
                            <span class="text-gray-700">{{ $cat['name'] }}</span>
                            <span class="font-bold text-gray-900">${{ number_format($cat['value'], 0) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- Revenue Analytics & Monthly Target -->
            <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-2 font-semibold text-gray-900">
                            <span class="material-icons text-orange-400">show_chart</span>
                            Revenue Analytics
                        </div>
                        <div class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded">Last 8 Days</div>
                    </div>
                    <div>{!! $revenueChart->container() !!}</div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow flex flex-col items-center border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 font-semibold text-gray-900 mb-4">
                        <span class="material-icons text-orange-400">flag</span>
                        Monthly Target
                    </div>
                    <div>{!! $targetChart->container() !!}</div>
                    <div class="mt-4">
                        <div class="text-green-600 font-bold text-lg">{{ $targetChart->datasets[0]['data'][0] ?? '85' }}%</div>
                        <div class="text-xs text-gray-500">+6.02% from last month</div>
                    </div>
                </div>
            </div>
            <!-- Traffic Sources & Active User -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 col-span-1 md:col-span-2 xl:col-span-2">
                <div class="bg-white p-6 rounded-2xl shadow border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 font-semibold text-gray-900 mb-4">
                        <span class="material-icons text-orange-400">traffic</span>
                        Traffic Sources
                    </div>
                    <div>{!! $trafficChart->container() !!}</div>
                    <ul class="mt-4 space-y-2">
                        @foreach($trafficSources as $src)
                            <li class="flex justify-between text-sm">
                                <span class="text-gray-700">{{ $src['name'] }}</span>
                                <span class="font-bold text-gray-900">{{ $src['value'] }}%</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 font-semibold text-gray-900 mb-4">
                        <span class="material-icons text-orange-400">person</span>
                        Active User
                    </div>
                    <div class="text-2xl font-bold text-gray-900">{{ $activeUsers ?? '2,758' }}</div>
                    <div class="text-green-500 text-sm mb-2">+8.02% from last month</div>
                    <ul class="text-sm">
                        <li>United States <span class="float-right">36%</span></li>
                        <li>United Kingdom <span class="float-right">24%</span></li>
                        <li>Indonesia <span class="float-right">17.5%</span></li>
                        <li>Russia <span class="float-right">15%</span></li>
                    </ul>
                </div>
            </div>
            <!-- Recent Orders & Recent Activity -->
            <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow overflow-x-auto border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-2 font-semibold text-gray-900">
                            <span class="material-icons text-orange-400">receipt_long</span>
                            Recent Orders
                        </div>
                        <input type="text" placeholder="Search product, customer, etc" class="border border-gray-200 rounded-lg px-3 py-1 text-sm bg-gray-50">
                        <button class="bg-orange-100 text-orange-500 px-3 py-1 rounded text-xs font-bold ml-2">All Categories</button>
                    </div>
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500">
                                <th class="py-2 px-3">No</th>
                                <th class="py-2 px-3">Order #</th>
                                <th class="py-2 px-3">Customer</th>
                                <th class="py-2 px-3">Product</th>
                                <th class="py-2 px-3">Qty</th>
                                <th class="py-2 px-3">Total</th>
                                <th class="py-2 px-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $i => $order)
                            <tr class="border-b hover:bg-orange-50 transition-colors duration-200">
                                <td class="py-2 px-3">{{ $i+1 }}</td>
                                <td class="py-2 px-3">#{{ $order->order_number ?? '-' }}</td>
                                <td class="py-2 px-3">{{ $order->user->name ?? '-' }}</td>
                                <td class="py-2 px-3">{{ $order->items->first()->product->name ?? '-' }}</td>
                                <td class="py-2 px-3">{{ $order->items->first()->quantity ?? '-' }}</td>
                                <td class="py-2 px-3">${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                <td class="py-2 px-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        {{ $order->status == 'Shipped' ? 'bg-green-100 text-green-700' :
                                           ($order->status == 'Processing' ? 'bg-yellow-100 text-yellow-700' :
                                           ($order->status == 'Delivered' ? 'bg-blue-100 text-blue-700' :
                                           'bg-gray-100 text-gray-700')) }}">
                                        {{ $order->status ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow border-t-4 border-orange-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                    <div class="flex items-center gap-2 font-semibold text-gray-900 mb-4">
                        <span class="material-icons text-orange-400">history</span>
                        Recent Activity
                    </div>
                    <ul class="space-y-4 text-sm">
                        @foreach($recentActivities as $activity)
                            <li class="flex items-start">
                                <span class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-2"></span>
                                <div>
                                    <div>{{ $activity['text'] }}</div>
                                    <div class="text-xs text-gray-400">{{ $activity['time'] }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Footer -->
        @include('partials.footer')
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// Example: Set chart colors for ApexCharts
if (window.Apex) {
    Apex.colors = ['#fb923c', '#64748b']; // orange-400, gray-500
}
</script>
{!! $revenueChart->script() !!}
{!! $targetChart->script() !!}
{!! $categoriesChart->script() !!}
{!! $trafficChart->script() !!}
@endpush
