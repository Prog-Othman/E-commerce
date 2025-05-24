@extends('layouts.app')

@section('title', 'Gestion des Produits')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@section('content')
<div class="flex min-h-screen bg-white">
    <div class="w-64 h-screen sticky top-0">
        @include('partials.sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-x-hidden">
        <!-- Header -->
        <div class="sticky top-0 z-10">
            @include('partials.header')
        </div>

        <!-- Page Content -->
        <div class="flex-1 p-8 bg-gray-50">
            <!-- Page Title and Actions -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-light text-gray-900">Gestion des Produits</h1>
                    <p class="text-gray-500 mt-1">Gérez vos produits et leur disponibilité</p>
                </div>
                <a href="{{ route('admin.products.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <span class="material-icons mr-2 text-sm">add</span>
                    Nouveau Produit
                </a>
            </div>

        <!-- Search and Filters -->
        <div class="max-w-7xl mx-auto px-0 sm:px-6 lg:px-0 py-6 w-full">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-icons text-gray-400">search</span>
                                </div>
                                <input type="text" name="search" id="search" 
                                       value="{{ request('search') }}"
                                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200" 
                                       placeholder="Nom, description...">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                            <select id="category" name="category" class="mt-1 block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200">
                                <option value="">Toutes les catégories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200">
                                <option value="">Tous les statuts</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                                <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>En rupture</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <span class="material-icons mr-2 text-sm">filter_alt</span>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                            Réinitialiser les filtres
                        </a>
                    </div>
                </form>
            </div>

            <!-- Products Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span>Image</span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span>Produit</span>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="ml-2">
                                            <span class="material-icons text-gray-400 text-sm">
                                                {{ request('sort') === 'name' && request('direction') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                            </span>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catégorie
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span>Prix</span>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" class="ml-2">
                                            <span class="material-icons text-gray-400 text-sm">
                                                {{ request('sort') === 'price' && request('direction') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                            </span>
                                        </a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-10 w-10 rounded-md overflow-hidden">
                                            @if($product->hasMedia('images'))
                                                <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" 
                                                     alt="{{ $product->name }}"
                                                     class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                                    <span class="material-icons text-gray-400 text-xl">image</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($product->price, 2, ',', ' ') }} MAD 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $product->stock < 5 ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                        {{ $product->stock }} unités
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('admin.products.edit', $product) }}" 
                                               class="text-orange-600 hover:text-orange-900"
                                               title="Modifier">
                                                <span class="material-icons text-lg">edit</span>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')"
                                                        title="Supprimer">
                                                    <span class="material-icons text-lg">delete</span>
                                                </button>
                                            </form>
                                            <a href="#" 
                                               class="text-blue-600 hover:text-blue-900"
                                               title="Voir les détails">
                                                <span class="material-icons text-lg">visibility</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Aucun produit trouvé
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if($products->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                                    Précédent
                                </span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Précédent
                                </a>
                            @endif

                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Suivant
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                                    Suivant
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de
                                    <span class="font-medium">{{ $products->firstItem() }}</span>
                                    à
                                    <span class="font-medium">{{ $products->lastItem() }}</span>
                                    sur
                                    <span class="font-medium">{{ $products->total() }}</span>
                                    résultats
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <!-- Previous Page Link -->
                                    @if($products->onFirstPage())
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                            <span class="material-icons">chevron_left</span>
                                        </span>
                                    @else
                                        <a href="{{ $products->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="material-icons">chevron_left</span>
                                        </a>
                                    @endif

                                    <!-- Pagination Elements -->
                                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if($page == $products->currentPage())
                                            <span class="relative inline-flex items-center px-4 py-2 border border-orange-500 bg-orange-50 text-sm font-medium text-orange-600">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    <!-- Next Page Link -->
                                    @if($products->hasMorePages())
                                        <a href="{{ $products->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="material-icons">chevron_right</span>
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                            <span class="material-icons">chevron_right</span>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            </div> <!-- End of table container -->
        </div> <!-- End of page content -->
    </div> <!-- End of main content -->
</div> <!-- End of page wrapper -->
@endsection