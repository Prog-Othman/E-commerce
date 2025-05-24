    @extends('layouts.guest')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen" x-data="{ 
    mobileMenuOpen: false, 
    currentSlide: 0,
    testimonialSlide: 0,
    scrollY: 0
}" 
x-init="
    setInterval(() => {
        testimonialSlide = (testimonialSlide + 1) % 3;
    }, 4000);
    window.addEventListener('scroll', () => scrollY = window.scrollY);
">
    <!-- Sticky Header with Glassmorphism -->
    <header class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-white/20 shadow-lg transition-all duration-300"
            :class="scrollY > 50 ? 'bg-white/90 shadow-xl' : 'bg-white/70'">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
            <!-- Logo with Animation -->
            <div class="flex items-center space-x-3 group">
                <span class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">TechShop</span>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#features" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 hover:scale-105 relative group">
                    Fonctionnalités
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#products" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 hover:scale-105 relative group">
                    Produits
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="/produits" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 hover:scale-105 relative group">
                    Catalogue
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="#testimonials" class="text-gray-700 hover:text-blue-600 font-medium transition-all duration-300 hover:scale-105 relative group">
                    Avis
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </nav>

            <!-- CTA Buttons -->
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('login') }}" 
                   class="px-6 py-2.5 rounded-full text-blue-600 font-semibold hover:bg-blue-50 transition-all duration-300 border border-blue-200 hover:border-blue-300">
                    Se connecter
                </a>
                <a href="{{ route('register') }}" 
                   class="px-6 py-2.5 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 relative overflow-hidden group">
                    <span class="relative z-10">Créer un compte</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-black/5 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white/95 backdrop-blur-xl border-t border-white/20">
            <div class="px-6 py-4 space-y-4">
                <a href="#features" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Fonctionnalités</a>
                <a href="#products" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Produits</a>
                <a href="/produits" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Catalogue</a>
                <a href="#testimonials" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Avis</a>
                <div class="pt-4 border-t border-gray-200 space-y-3">
                    <a href="{{ route('login') }}" class="block text-center px-4 py-2 text-blue-600 font-semibold">Se connecter</a>
                    <a href="{{ route('register') }}" class="block text-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg">Créer un compte</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Enhanced Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden pt-20">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-1/2 -right-1/2 w-96 h-96 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-1/2 -left-1/2 w-96 h-96 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 text-center px-6 max-w-6xl mx-auto">
            <!-- Main Headline with Typing Effect -->
            <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight">
                <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 bg-clip-text text-transparent animate-pulse">
                    L'avenir de la Tech
                </span>
                <br>
                <span class="text-gray-800">est entre vos mains</span>
            </h1>

            <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Découvrez une sélection exclusive de smartphones, PC gaming, accessoires high-tech et bien plus. 
                <span class="font-semibold text-blue-600">Innovation • Qualité • Performance</span>
            </p>

            <!-- Hero CTAs -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                <a href="#products" 
                   class="group px-10 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-lg font-bold rounded-full shadow-2xl hover:shadow-blue-500/25 transform hover:scale-105 transition-all duration-300 relative overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        Découvrir nos produits
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                <a href="#features" 
                   class="px-10 py-4 border-2 border-blue-600 text-blue-600 text-lg font-bold rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:scale-105">
                    En savoir plus
                </a>
            </div>

            <!-- Floating Tech Icons with Animation -->
            <div class="grid grid-cols-3 md:grid-cols-6 gap-8 max-w-2xl mx-auto">
                <div class="group flex flex-col items-center transform hover:scale-110 transition-all duration-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mb-2 group-hover:shadow-lg group-hover:shadow-blue-200 transition-all duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Phone" class="w-8 h-8">
                    </div>
                    <span class="text-sm font-medium text-gray-600">Smartphones</span>
                </div>
                <div class="group flex flex-col items-center transform hover:scale-110 transition-all duration-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-2 group-hover:shadow-lg group-hover:shadow-purple-200 transition-all duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747314.png" alt="Tablet" class="w-8 h-8">
                    </div>
                    <span class="text-sm font-medium text-gray-600">Tablettes</span>
                </div>
                <div class="group flex flex-col items-center transform hover:scale-110 transition-all duration-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center mb-2 group-hover:shadow-lg group-hover:shadow-green-200 transition-all duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747338.png" alt="Smartwatch" class="w-8 h-8">
                    </div>
                    <span class="text-sm font-medium text-gray-600">Montres</span>
                </div>
                <div class="group flex flex-col items-center transform hover:scale-110 transition-all duration-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-2xl flex items-center justify-center mb-2 group-hover:shadow-lg group-hover:shadow-yellow-200 transition-all duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747290.png" alt="Laptop" class="w-8 h-8">
                    </div>
                    <span class="text-sm font-medium text-gray-600">Laptops</span>
                </div>
                <div class="group flex flex-col items-center transform hover:scale-110 transition-all duration-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-200 rounded-2xl flex items-center justify-center mb-2 group-hover:shadow-lg group-hover:shadow-red-200 transition-all duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="TV" class="w-8 h-8">
                    </div>
                    <span class="text-sm font-medium text-gray-600">Smart TV</span>
                </div>
                <div class="group flex flex-col items-center transform hover:scale-110 transition-all duration-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center mb-2 group-hover:shadow-lg group-hover:shadow-indigo-200 transition-all duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/747/747327.png" alt="PC" class="w-8 h-8">
                    </div>
                    <span class="text-sm font-medium text-gray-600">PC Gaming</span>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section id="features" class="max-w-7xl mx-auto py-20 px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Pourquoi nous choisir ?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Des avantages exclusifs pour une expérience d'achat exceptionnelle</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400/10 to-blue-600/10 rounded-bl-3xl"></div>
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" alt="Nouveautés" class="w-10 h-10 brightness-0 invert">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Dernières Nouveautés</h3>
                <p class="text-gray-600 leading-relaxed">Soyez les premiers à découvrir les produits high-tech les plus récents, directement des plus grandes marques mondiales.</p>
            </div>

            <div class="group bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400/10 to-purple-600/10 rounded-bl-3xl"></div>
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/1170/1170576.png" alt="Promotions" class="w-10 h-10 brightness-0 invert">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Prix Imbattables</h3>
                <p class="text-gray-600 leading-relaxed">Profitez de promotions exclusives et d'offres limitées sur une large gamme de produits technologiques premium.</p>
            </div>

            <div class="group bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400/10 to-green-600/10 rounded-bl-3xl"></div>
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <img src="https://cdn-icons-png.flaticon.com/512/1040/1040230.png" alt="Livraison" class="w-10 h-10 brightness-0 invert">
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Livraison Express</h3>
                <p class="text-gray-600 leading-relaxed">Recevez vos commandes en 24-48h partout au Maroc avec un service de livraison premium et un suivi en temps réel.</p>
            </div>
        </div>
    </section>

    <!-- Enhanced Products Section -->
    <section id="products" class="max-w-7xl mx-auto py-20 px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Nos Best-Sellers</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Les produits les plus populaires, choisis par nos clients</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group bg-white rounded-3xl shadow-lg p-6 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold">-15%</div>
                <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl mb-4 overflow-hidden">
                    <img src="{{ asset('image/iphone.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="iPhone 13">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">iPhone 13 Pro</h3>
                <p class="text-gray-600 text-sm mb-4">Smartphone dernière génération avec puce A15 Bionic</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-blue-600">5,600 DH</span>
                        <span class="text-sm text-gray-400 line-through">6,600 DH</span>
                    </div>
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="text-sm text-gray-600 ml-1">4.8</span>
                    </div>
                </div>
                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    Ajouter au panier
                </button>
            </div>

            <div class="group bg-white rounded-3xl shadow-lg p-6 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold">Nouveau</div>
                <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl mb-4 overflow-hidden">
                    <img src="{{ asset('image/pc gamer.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="PC Gamer">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">PC Gaming Pro</h3>
                <p class="text-gray-600 text-sm mb-4">Configuration haute performance pour gaming intense</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-blue-600">10,000 DH</span>
                    </div>
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="text-sm text-gray-600 ml-1">4.9</span>
                    </div>
                </div>
                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    Ajouter au panier
                </button>
            </div>

            <div class="group bg-white rounded-3xl shadow-lg p-6 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl mb-4 overflow-hidden">
                    <img src="{{ asset('image/samsung.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Samsung">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Samsung Galaxy S23</h3>
                <p class="text-gray-600 text-sm mb-4">Design premium et performances exceptionnelles</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-blue-600">5,600 DH</span>
                    </div>
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="text-sm text-gray-600 ml-1">4.7</span>
                    </div>
                </div>
                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    Ajouter au panier
                </button>
            </div>

            <div class="group bg-white rounded-3xl shadow-lg p-6 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-purple-500 text-white text-xs px-2 py-1 rounded-full font-semibold">Populaire</div>
                <div class="w-full h-48 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl mb-4 overflow-hidden">
                    <img src="{{ asset('image/ecran.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Ecran Mac">
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Écran Mac Studio</h3>
                <p class="text-gray-600 text-sm mb-4">Moniteur professionnel 4K pour créateurs</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-blue-600">8,000 DH</span>
                    </div>
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="text-sm text-gray-600 ml-1">5.0</span>
                    </div>
                </div>
                <button class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    Ajouter au panier
                </button>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="/produits" class="inline-block px-8 py-4 bg-gradient-to-r from-gray-800 to-gray-900 text-white font-semibold rounded-full hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Voir tous nos produits →
            </a>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="max-w-6xl mx-auto py-16 px-6">
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-3xl p-8 shadow-lg border border-blue-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex items-center justify-center space-x-4 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Paiement Sécurisé</h3>
                        <p class="text-gray-600">SSL & Cryptage bancaire</p>
                    </div>
                </div>

                <div class="flex items-center justify-center space-x-4 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Livraison 24-48h</h3>
                        <p class="text-gray-600">Partout au Maroc</p>
                    </div>
                </div>

                <div class="flex items-center justify-center space-x-4 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Garantie Satisfait</h3>
                        <p class="text-gray-600">ou 100% remboursé</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Testimonials Section -->
    <section id="testimonials" class="max-w-7xl mx-auto py-20 px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Ce que disent nos clients</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Plus de 10,000 clients satisfaits nous font confiance</p>
        </div>

        <div class="relative">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 relative overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400/10 to-blue-600/10 rounded-bl-3xl"></div>
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" 
                             class="w-16 h-16 rounded-full border-4 border-blue-200 mr-4" alt="Client">
                        <div>
                            <h4 class="font-bold text-gray-800">Yassine Benali</h4>
                            <p class="text-gray-600 text-sm">Développeur Web</p>
                            <div class="flex text-yellow-400 mt-1">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic leading-relaxed">"Service exceptionnel ! Mon iPhone 13 est arrivé en parfait état en 24h. L'équipe est très professionnelle et les prix sont vraiment compétitifs."</p>
                    <div class="absolute bottom-4 right-6 text-6xl text-blue-100 font-serif">"</div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 relative overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-400/10 to-purple-600/10 rounded-bl-3xl"></div>
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" 
                             class="w-16 h-16 rounded-full border-4 border-purple-200 mr-4" alt="Cliente">
                        <div>
                            <h4 class="font-bold text-gray-800">Fatima Zahra</h4>
                            <p class="text-gray-600 text-sm">Architecte</p>
                            <div class="flex text-yellow-400 mt-1">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic leading-relaxed">"Interface magnifique et navigation fluide ! J'ai trouvé exactement ce que je cherchais. Les promotions sont vraiment avantageuses."</p>
                    <div class="absolute bottom-4 right-6 text-6xl text-purple-100 font-serif">"</div>
                </div>

                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 relative overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400/10 to-green-600/10 rounded-bl-3xl"></div>
                    <div class="flex items-center mb-6">
                        <img src="https://randomuser.me/api/portraits/men/65.jpg" 
                             class="w-16 h-16 rounded-full border-4 border-green-200 mr-4" alt="Client">
                        <div>
                            <h4 class="font-bold text-gray-800">Omar El Fassi</h4>
                            <p class="text-gray-600 text-sm">Ingénieur IT</p>
                            <div class="flex text-yellow-400 mt-1">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic leading-relaxed">"Très fiable ! J'ai commandé plusieurs fois et je n'ai jamais été déçu. La qualité des produits et le service après-vente sont excellents."</p>
                    <div class="absolute bottom-4 right-6 text-6xl text-green-100 font-serif">"</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter" class="max-w-4xl mx-auto py-20 px-6">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-center text-white relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-10 left-10 w-20 h-20 border border-white rounded-full"></div>
                <div class="absolute top-20 right-20 w-16 h-16 border border-white rounded-full"></div>
                <div class="absolute bottom-10 left-20 w-12 h-12 border border-white rounded-full"></div>
                <div class="absolute bottom-20 right-10 w-24 h-24 border border-white rounded-full"></div>
            </div>
            
            <div class="relative z-10">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Restez connecté !</h2>
                <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                    Soyez les premiers informés de nos nouveautés, offres exclusives et promotions flash
                </p>
                
                <form class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
                    <input type="email" 
                           placeholder="votre@email.com" 
                           class="w-full px-6 py-4 rounded-full text-gray-800 font-medium focus:outline-none focus:ring-4 focus:ring-white/30 transition-all"
                           required>
                    <button type="submit" 
                            class="px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg whitespace-nowrap">
                        S'abonner
                    </button>
                </form>
                
                <p class="text-sm opacity-75 mt-6">
                    🎁 Bonus : Recevez -10% sur votre première commande !
                </p>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="bg-gray-900 text-white py-16 mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand Section -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="https://laravel.com/img/logomark.min.svg" class="h-10 w-10" alt="Logo">
                        <span class="font-bold text-2xl bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">TechShop</span>
                    </div>
                    <p class="text-gray-300 leading-relaxed mb-6 max-w-md">
                        Votre destination #1 pour la technologie au Maroc. Nous proposons les derniers smartphones, PC gaming, et accessoires high-tech aux meilleurs prix.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.222.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z."/></svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-900 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-lg mb-6">Liens Rapides</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Smartphones</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">PC Gaming</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Accessoires</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Promotions</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Nouveautés</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="font-bold text-lg mb-6">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Livraison</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Retours</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Garantie</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} TechShop. Tous droits réservés. Fait avec ❤️ au Maroc.
                </div>
                <div class="flex space-x-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-white transition-colors">Politique de Confidentialité</a>
                    <a href="#" class="hover:text-white transition-colors">Conditions d'Utilisation</a>
                    <a href="#" class="hover:text-white transition-colors">Mentions Légales</a>
                </div>
            </div>
        </div>
    </footer>
</div>

@endsection

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        transform: translate3d(0, 0, 0);
    }
    40%, 43% {
        animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
        transform: translate3d(0, -8px, 0);
    }
    70% {
        animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
        transform: translate3d(0, -4px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

.hover-lift:hover {
    transform: translateY(-8px);
}

/* Custom scrollbar for horizontal scroll */
.scrollbar-thin {
    scrollbar-width: thin;
}

.scrollbar-thumb-indigo-300::-webkit-scrollbar-thumb {
    background-color: #a5b4fc;
}

.scrollbar-track-indigo-100::-webkit-scrollbar-track {
    background-color: #e0e7ff;
}
</style>

@push('scripts')
<script>
    // Any additional scripts can go here
</script>
@endpush