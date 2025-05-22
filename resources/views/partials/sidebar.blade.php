<aside x-data="{ open: true }" class="w-64 h-screen bg-white shadow flex flex-col justify-between py-6 px-4 rounded-r-3xl fixed md:static z-30 transition-transform duration-300" :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
    <div>
        <div class="flex items-center mb-8">
            <span class="text-3xl font-extrabold text-orange-500">EzMart</span>
        </div>
        <nav class="flex-1 space-y-1">
            <a href="/dashboard" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-orange-500 bg-orange-50 shadow-sm hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-orange-400">dashboard</span> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">shopping_bag</span> Orders
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">category</span> Products
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">groups</span> Customers
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">bar_chart</span> Reports
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">local_offer</span> Discounts
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">integration_instructions</span> Integrations
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">help_outline</span> Help
            </a>
            <a href="#" class="flex items-center gap-3 py-2.5 px-4 rounded-lg font-medium text-gray-700 hover:bg-orange-100 hover:text-orange-600 transition-colors duration-200">
                <span class="material-icons text-gray-400">settings</span> Settings
            </a>
        </nav>
        <div class="mt-8 p-4 bg-gradient-to-br from-orange-400 to-orange-500 text-white rounded-2xl shadow-lg flex flex-col items-center">
            <div class="font-bold text-lg mb-2">Version 4.5 is Ready</div>
            <div class="text-xs mb-3 text-orange-100">Upgrade for advanced features and enhanced security.</div>
            <button class="bg-white text-orange-500 font-bold px-4 py-1 rounded-lg shadow hover:bg-orange-100 transition-colors duration-200">Upgrade Now</button>
        </div>
    </div>
    <div class="mt-8">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 py-2.5 px-4 text-left text-gray-700 hover:bg-orange-100 hover:text-orange-600 rounded-lg transition-colors duration-200">
                <span class="material-icons text-gray-400">logout</span> Logout
            </button>
        </form>
    </div>
    <!-- Hamburger for mobile -->
    <button @click="open = !open" class="md:hidden absolute top-4 right-[-48px] bg-orange-500 text-white p-2 rounded-full shadow-lg z-40">
        <span class="material-icons">menu</span>
    </button>
</aside>
<!-- Add Material Icons CDN in your main layout if not already present -->
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
<!-- Alpine.js required for sidebar toggle -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>