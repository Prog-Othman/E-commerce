<header class="bg-white flex items-center justify-between px-8 py-4 w-full">
    <div class="flex items-center">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-light text-gray-900">Tableau de bord</h1>
        </div>
    </div>
    
    <div class="flex items-center space-x-6">
        <!-- Search -->
        <div class="relative">
            <input type="text" 
                   placeholder="Rechercher..." 
                   class="w-80 pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200">
            <span class="material-icons absolute left-3 top-7 transform -translate-y-1/2 text-gray-400 text-lg">search</span>
        </div>
        
        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <span class="material-icons text-gray-600 text-xl">shopping_cart</span>
            @if(isset($cartItemsCount) && $cartItemsCount > 0)
                <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                    {{ $cartItemsCount }}
                </span>
            @endif
        </a>
        
        <!-- Notifications -->
        <button class="relative p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
            <span class="material-icons text-gray-600 text-xl">notifications_none</span>
            <span class="absolute top-1 right-1 w-2 h-2 bg-orange-500 rounded-full"></span>
        </button>
        
        <!-- User Profile -->
        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" 
                 class="w-10 h-10 rounded-full ring-2 ring-orange-100" 
                 alt="User Profile">
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</span>
                <span class="text-xs text-gray-500">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>
</header>