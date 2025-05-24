@extends('layouts.app')

@section('title', 'Modifier le produit : ' . $product->name)

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900">Modifier le produit : {{ $product->name }}</h1>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <span class="material-icons mr-2 text-sm">arrow_back</span>
                            Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Informations de base</h3>
                            <p class="mt-1 text-sm text-gray-500">Informations générales sur le produit.</p>
                            
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Product Name -->
                                <div class="sm:col-span-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du produit <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="sm:col-span-4">
                                    <label for="slug" class="block text-sm font-medium text-gray-700">URL personnalisée</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            {{ config('app.url') }}/products/
                                        </span>
                                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
                                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-orange-500 focus:border-orange-500 sm:text-sm border-gray-300">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Laissez vide pour générer automatiquement à partir du nom</p>
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="sm:col-span-4">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <select id="category_id" name="category_id" required
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Sélectionnez une catégorie</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="sm:col-span-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="4"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Décrivez votre produit en détail.</p>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Prix et stock</h3>
                            <p class="mt-1 text-sm text-gray-500">Définissez le prix et la quantité en stock.</p>
                            
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Price -->
                                <div class="sm:col-span-2">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Prix (€) <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                            class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                            placeholder="0.00">
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Compare at Price -->
                                <div class="sm:col-span-2">
                                    <label for="compare_at_price" class="block text-sm font-medium text-gray-700">Ancien prix</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                        <input type="number" name="compare_at_price" id="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}" step="0.01" min="0"
                                            class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                            placeholder="0.00">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Laissez vide pour ne pas afficher de réduction</p>
                                    @error('compare_at_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Cost per item -->
                                <div class="sm:col-span-2">
                                    <label for="cost_per_item" class="block text-sm font-medium text-gray-700">Coût unitaire</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                        <input type="number" name="cost_per_item" id="cost_per_item" value="{{ old('cost_per_item', $product->cost_per_item) }}" step="0.01" min="0"
                                            class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                            placeholder="0.00">
                                    </div>
                                    @error('cost_per_item')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div class="sm:col-span-2">
                                    <label for="stock" class="block text-sm font-medium text-gray-700">Quantité en stock <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    @error('stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- SKU -->
                                <div class="sm:col-span-2">
                                    <label for="sku" class="block text-sm font-medium text-gray-700">Référence (SKU)</label>
                                    <div class="mt-1">
                                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Barcode -->
                                <div class="sm:col-span-2">
                                    <label for="barcode" class="block text-sm font-medium text-gray-700">Code-barres (EAN, UPC, etc.)</label>
                                    <div class="mt-1">
                                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="sm:col-span-6">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="is_active" name="is_active" type="checkbox" value="1" 
                                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                                class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_active" class="font-medium text-gray-700">Produit actif</label>
                                            <p class="text-gray-500">Désactivez pour masquer ce produit du catalogue.</p>
                                        </div>
                                    </div>
                                    @error('is_active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Images du produit</h3>
                            <p class="mt-1 text-sm text-gray-500">Téléchargez les images de votre produit. La première image sera utilisée comme image principale.</p>
                            
                            <div class="mt-6">
                                <!-- Current Images -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Images actuelles</label>
                                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                                        @php
                                            $mediaItems = $product->getMedia('images');
                                        @endphp
                                        
                                        @if($mediaItems->count() > 0)
                                            @foreach($mediaItems as $media)
                                                <div class="relative group" id="image-container-{{ $media->id }}">
                                                    <img src="{{ $media->getUrl('thumb') }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity duration-200 flex items-center justify-center">
                                                        <button type="button" 
                                                                onclick="deleteImage({{ $media->id }})"
                                                                class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="deleted_images[]" id="deleted-image-{{ $media->id }}" value="">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 col-span-full">Aucune image pour le moment.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="mt-6">
                                    <label for="images" class="block text-sm font-medium text-gray-700">Ajouter des images</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                    <span>Télécharger des fichiers</span>
                                                    <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only">
                                                </label>
                                                <p class="pl-1">ou glissez-déposez</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF jusqu'à 10MB
                                            </p>
                                        </div>
                                    </div>
                                    <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                                        <!-- Preview will be added here -->
                                    </div>
                                    @error('images')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @error('images.*')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Référencement (SEO)</h3>
                            <p class="mt-1 text-sm text-gray-500">Optimisez la visibilité de votre produit dans les moteurs de recherche.</p>
                            
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Meta Title -->
                                <div class="sm:col-span-6">
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                                    <div class="mt-1">
                                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Titre à afficher dans les résultats de recherche (50-60 caractères recommandés)</p>
                                    @error('meta_title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta Description -->
                                <div class="sm:col-span-6">
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                    <div class="mt-1">
                                        <textarea id="meta_description" name="meta_description" rows="3"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Description à afficher dans les résultats de recherche (150-160 caractères recommandés)</p>
                                    @error('meta_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta Keywords -->
                                <div class="sm:col-span-6">
                                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Mots-clés (séparés par des virgules)</label>
                                    <div class="mt-1">
                                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Mots-clés pertinents pour le référencement</p>
                                    @error('meta_keywords')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                Annuler
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-')      // Replace spaces with -
            .replace(/--+/g, '-')       // Replace multiple - with single -
            .trim();
        
        // Only update if slug is empty or if the current slug matches the auto-generated one
        const currentSlug = document.getElementById('slug').value;
        const autoSlug = slug.toLowerCase();
        if (!currentSlug || currentSlug === autoSlug || currentSlug === '') {
            document.getElementById('slug').value = autoSlug;
        }
    });

    // Handle image deletion
    function deleteImage(mediaId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            const container = document.getElementById(`image-container-${mediaId}`);
            if (container) {
                container.style.display = 'none';
                const input = document.getElementById(`deleted-image-${mediaId}`);
                if (input) {
                    input.value = mediaId;
                }
            }
        }
    }

    // Image preview for new uploads
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = ''; // Clear previous previews
        
        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview" 
                             class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity duration-200 flex items-center justify-center">
                            <button type="button" 
                                    class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="this.closest('.relative').remove(); updateFileInput();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Update file input when removing previews
    function updateFileInput() {
        const input = document.getElementById('images');
        const files = input.files;
        const dataTransfer = new DataTransfer();
        
        // Add all files except the ones that were removed
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const previews = document.querySelectorAll('#image-preview img');
            let keepFile = false;
            
            for (let j = 0; j < previews.length; j++) {
                if (previews[j].alt === 'Preview' && previews[j].src.includes(file.name)) {
                    keepFile = true;
                    break;
                }
            }
            
            if (keepFile) {
                dataTransfer.items.add(file);
            }
        }
        
        input.files = dataTransfer.files;
    }

    // Character counters for SEO fields
    document.getElementById('meta_title').addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('meta-title-count').textContent = count;
    });

    document.getElementById('meta_description').addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('meta-desc-count').textContent = count;
    });

    // Initialize counters on page load
    document.addEventListener('DOMContentLoaded', function() {
        const metaTitle = document.getElementById('meta_title');
        const metaDesc = document.getElementById('meta_description');
        
        if (metaTitle) {
            document.getElementById('meta-title-count').textContent = metaTitle.value.length;
        }
        
        if (metaDesc) {
            document.getElementById('meta-desc-count').textContent = metaDesc.value.length;
        }
    });
</script>
@endpush

@endsection