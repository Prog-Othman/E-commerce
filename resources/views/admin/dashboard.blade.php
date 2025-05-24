@extends('layouts.app')

@section('title', 'Tableau de bord')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Sidebar -->
    <div class="w-64 h-screen border-r border-gray-100">
        @include('partials.sidebar')
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="w-full border-b border-gray-100 bg-white">
            @include('partials.header')
        </header>

        <!-- Dashboard Content -->
        <div class="flex-1 p-8 bg-gray-50">
            <!-- Page Title -->
            <div class="mb-8">
                <h1 class="text-3xl font-light text-gray-900">Tableau de bord</h1>
                <p class="text-gray-500 mt-1">Bienvenue, voici ce qui se passe avec votre magasin.</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total des ventes</p>
                            <p class="text-2xl font-light text-gray-900 mt-1">{{ number_format($totalRevenue, 0) }} &euro;</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center">
                            <span class="material-icons text-orange-500 text-xl">attach_money</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-orange-500 text-sm">+3.1%</span>
                        <span class="text-gray-400 text-sm ml-2">par rapport &agrave; la semaine derni&egrave;re</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total des commandes</p>
                            <p class="text-2xl font-light text-gray-900 mt-1">{{ $totalOrders }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center">
                            <span class="material-icons text-orange-500 text-xl">shopping_cart</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-gray-400 text-sm">-2.9%</span>
                        <span class="text-gray-400 text-sm ml-2">par rapport &agrave; la semaine derni&egrave;re</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total des visiteurs</p>
                            <p class="text-2xl font-light text-gray-900 mt-1">{{ $totalVisitors ?? '237,782' }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center">
                            <span class="material-icons text-orange-500 text-xl">groups</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center">
                        <span class="text-orange-500 text-sm">+4.0%</span>
                        <span class="text-gray-400 text-sm ml-2">par rapport &agrave; la semaine derni&egrave;re</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Revenue Analytics -->
                @if($revenueChart)
                    <div class="lg:col-span-2 bg-white rounded-lg p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Analytiques des ventes</h3>
                            <span class="text-sm text-gray-500">Les 8 derniers jours</span>
                        </div>
                        <div>{!! $revenueChart->container() !!}</div>
                    </div>
                @else
                    <div class="lg:col-span-2 bg-white rounded-lg p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Analytiques des ventes</h3>
                            <span class="text-sm text-gray-500">Les 8 derniers jours</span>
                        </div>
                        <div class="text-center py-8 text-gray-500">
                            <p>Les graphiques ne sont pas disponibles pour le moment.</p>
                        </div>
                    </div>
                @endif

                <!-- Monthly Target -->
                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Objectif mensuel</h3>
                    <div class="flex flex-col items-center">
                        @if($targetChart)
                            <div>{!! $targetChart->container() !!}</div>
                            <div class="mt-4 text-center">
                                <div class="text-3xl font-light text-gray-900">{{ $targetChart->datasets[0]['data'][0] ?? '85' }}%</div>
                                <div class="text-sm text-orange-500 mt-1">+6.02% par rapport au mois dernier</div>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>Le graphique de l'objectif n'est pas disponible.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Secondary Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Top Categories -->
                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Cat&eacute;gories les plus populaires</h3>
                        <button class="text-orange-500 text-sm hover:text-orange-600">Voir tout</button>
                    </div>
                    <div class="mb-4">{!! $categoriesChart->container() !!}</div>
                    <div class="space-y-3">
                        @foreach($topCategories as $cat)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">{{ $cat['name'] }}</span>
                                <span class="font-medium text-gray-900">{{ number_format($cat['value'], 0) }} &euro;</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Traffic Sources -->
                <div class="bg-white rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Sources de trafic</h3>
                    <div class="mb-4">{!! $trafficChart->container() !!}</div>
                    <div class="space-y-3">
                        @foreach($trafficSources as $src)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">{{ $src['name'] }}</span>
                                <span class="font-medium text-gray-900">{{ $src['value'] }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 bg-white rounded-lg border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Commandes r&eacute;centes</h3>
                            <div class="flex items-center space-x-3">
                                <input type="text" placeholder="Rechercher les commandes..." 
                                       class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <button class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600">
                                    Filtrer
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commande</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        #{{ $order->order_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $order->user->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $order->items->first()->product->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($order->total_amount ?? 0, 2) }} &euro;
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                            {{ $order->status == 'Delivered' ? 'bg-green-100 text-green-800' :
                                               ($order->status == 'Shipped' ? 'bg-orange-100 text-orange-800' :
                                               ($order->status == 'Processing' ? 'bg-yellow-100 text-yellow-800' :
                                               'bg-gray-100 text-gray-800')) }}">
                                            {{ $order->status ?? 'En attente' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Activity & Active Users -->
                <div class="space-y-6">
                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Activité récente</h3>
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900">{{ $activity['text'] ?? 'Aucune activité récente' }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Active Users -->
                    <div class="bg-white rounded-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Utilisateurs actifs</h3>
                        <div class="text-center mb-4">
                            <div class="text-3xl font-light text-gray-900">{{ $activeUsers ?? '0' }}</div>
                            <div class="text-sm text-orange-500">+8.02% par rapport au mois dernier</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-100 bg-white">
            @include('partials.footer')
        </footer>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// Set clean chart colors
if (window.Apex) {
    Apex.colors = ['#f97316', '#6b7280', '#fed7aa', '#d1d5db']; // orange-500, gray-500, orange-200, gray-300
}
</script>
{!! $revenueChart->script() !!}
{!! $targetChart->script() !!}
{!! $categoriesChart->script() !!}
{!! $trafficChart->script() !!}
@endpush