    <!-- Sidebar -->
    <div class="w-64 h-screen border-r border-gray-100 bg-white">
        <!-- Sidebar content directly included -->
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-100">
                <span class="text-2xl font-light text-gray-900">EzMart</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.dashboard') ? 'text-orange-500' : 'text-gray-400' }} text-lg">dashboard</span>
                        Tableau de bord
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.orders.*') ? 'text-orange-500' : 'text-gray-400' }} text-lg">shopping_bag</span>
                        Commandes
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.products.*') ? 'text-orange-500' : 'text-gray-400' }} text-lg">category</span>
                        Produits
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.users.*') ? 'text-orange-500' : 'text-gray-400' }} text-lg">people</span>
                        Utilisateurs
                    </a>
                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.promotions.*') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.promotions.*') ? 'text-orange-500' : 'text-gray-400' }} text-lg">local_offer</span>
                        Promotions
                    </a>
                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.reports.*') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.reports.*') ? 'text-orange-500' : 'text-gray-400' }} text-lg">analytics</span>
                        Rapports
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.coupons.*') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.coupons.*') ? 'text-orange-500' : 'text-gray-400' }} text-lg">local_offer</span>
                        Coupons
                    </a>
                </div>

                <!-- Bottom section -->
                <div class="mt-auto pt-4 border-t border-gray-100">
                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium {{ request()->routeIs('admin.settings') ? 'text-orange-600 bg-orange-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors duration-200">
                        <span class="material-icons {{ request()->routeIs('admin.settings') ? 'text-orange-500' : 'text-gray-400' }} text-lg">settings</span>
                        Paramètres
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 py-3 px-4 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors duration-200">
                            <span class="material-icons text-red-400 text-lg">logout</span>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </div>

<!-- Add Material Icons CDN in your main layout if not already present -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Alpine.js required for sidebar toggle -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>