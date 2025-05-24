@extends('layouts.app')

@section('title', 'Ajouter un produit')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Ajouter un produit</h1>
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
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Informations de base</h3>
                            <p class="mt-1 text-sm text-gray-500">Informations générales sur le produit.</p>
                            
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Product Name -->
                                <div class="sm:col-span-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du produit <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
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
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description') }}</textarea>
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
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
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
                                        <input type="number" name="compare_at_price" id="compare_at_price" value="{{ old('compare_at_price') }}" step="0.01" min="0"
                                            class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                            placeholder="0.00">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Laissez vide pour ne pas afficher de réduction</p>
                                    @error('compare_at_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Stock -->
                                <div class="sm:col-span-2">
                                    <label for="stock" class="block text-sm font-medium text-gray-700">Quantité en stock <span class="text-red-500">*</span></label>
                                    <div class="mt-1">
                                        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
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
                                        <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Numéro de référence unique</p>
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Barcode -->
                                <div class="sm:col-span-2">
                                    <label for="barcode" class="block text-sm font-medium text-gray-700">Code-barres</label>
                                    <div class="mt-1">
                                        <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="sm:col-span-2">
                                    <label for="is_active" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <div class="mt-1">
                                        <select id="is_active" name="is_active"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="1" {{ old('is_active', true) ? 'selected' : '' }}>Actif</option>
                                            <option value="0" {{ !old('is_active', true) ? 'selected' : '' }}>Inactif</option>
                                        </select>
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
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                <span>Télécharger des fichiers</span>
                                                <input id="images" name="images[]" type="file" multiple class="sr-only">
                                            </label>
                                            <p class="pl-1">ou glissez-déposez</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF jusqu'à 10MB
                                        </p>
                                    </div>
                                </div>
                                @error('images')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('images.*')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Image preview container (will be populated by JavaScript) -->
                            <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                                <!-- Preview images will be added here -->
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="px-4 py-5 sm:p-6 border-t border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Référencement (SEO)</h3>
                            <p class="mt-1 text-sm text-gray-500">Optimisez la visibilité de votre produit dans les moteurs de recherche.</p>
                            
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <!-- Meta Title -->
                                <div class="sm:col-span-6">
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700">Titre SEO</label>
                                    <div class="mt-1">
                                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" maxlength="60"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Généralement limité à 60 caractères</p>
                                    @error('meta_title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta Description -->
                                <div class="sm:col-span-6">
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700">Description SEO</label>
                                    <div class="mt-1">
                                        <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('meta_description') }}</textarea>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Généralement limité à 160 caractères</p>
                                    @error('meta_description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Meta Keywords -->
                                <div class="sm:col-span-6">
                                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Mots-clés SEO</label>
                                    <div class="mt-1">
                                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                                            class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="mots-clés, séparés par des virgules">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Séparez les mots-clés par des virgules</p>
                                    @error('meta_keywords')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                Annuler
                            </a>
                            <button type="submit" class="ml-3 inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <span class="material-icons mr-2 text-sm">save</span>
                                Enregistrer le produit
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
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        if (nameInput && slugInput) {
            nameInput.addEventListener('input', function() {
                if (!slugInput.dataset.manuallyEdited) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '') // Remove special chars
                        .replace(/\s+/g, '-') // Replace spaces with -
                        .replace(/--+/g, '-') // Replace multiple - with single -
                        .trim();
                    slugInput.value = slug;
                }
            });

            slugInput.addEventListener('change', function() {
                this.dataset.manuallyEdited = true;
            });
        }

        // Image preview functionality
        const imageInput = document.getElementById('images');
        const imagePreview = document.getElementById('image-preview');
        
        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function(e) {
                // Clear previous previews
                imagePreview.innerHTML = '';
                
                // Show preview for each selected file
                for (const file of this.files) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const preview = document.createElement('div');
                            preview.className = 'relative group';
                            preview.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-32 object-cover rounded-md">
                                <button type="button" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="this.parentElement.remove(); updateFileInput();">
                                    <span class="material-icons text-sm">close</span>
                                </button>
                            `;
                            imagePreview.appendChild(preview);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                }
            });
            
            // Handle drag and drop
            const dropZone = imageInput.closest('div[class*="border-dashed"]');
            
            if (dropZone) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });
                
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, highlight, false);
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, unhighlight, false);
                });
                
                function highlight() {
                    dropZone.classList.add('border-orange-500', 'bg-orange-50');
                }
                
                function unhighlight() {
                    dropZone.classList.remove('border-orange-500', 'bg-orange-50');
                }
                
                dropZone.addEventListener('drop', handleDrop, false);
                
                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    imageInput.files = files;
                    
                    // Trigger change event
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            }
        }
        
        // Update file input when removing previews
        window.updateFileInput = function() {
            const dt = new DataTransfer();
            const files = imageInput.files;
            const previewedFiles = Array.from(files);
            
            // Remove files that don't have a preview anymore
            const remainingPreviews = Array.from(imagePreview.children).map(preview => 
                preview.querySelector('img').src
            );
            
            for (let i = 0; i < previewedFiles.length; i++) {
                const file = previewedFiles[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (remainingPreviews.includes(e.target.result)) {
                        dt.items.add(file);
                    }
                    
                    // If this is the last file, update the input
                    if (i === previewedFiles.length - 1) {
                        imageInput.files = dt.files;
                    }
                };
                
                reader.readAsDataURL(file);
            }
        };
    });
</script>
@endpush

@endsection