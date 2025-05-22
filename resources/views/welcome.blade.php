@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@section('content')
<div class="bg-gradient-to-br from-indigo-100 via-white to-pink-50 min-h-screen flex flex-col">
    <!-- Sticky Header -->
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
            <div class="flex items-center space-x-2">
                <img src="https://laravel.com/img/logomark.min.svg" class="h-8 w-8" alt="Logo">
                <span class="font-bold text-xl text-indigo-700">E-Shop</span>
            </div>
            <nav class="space-x-4">
                <a href="#features" class="text-gray-700 hover:text-indigo-600 font-medium">Fonctionnalités</a>
                <a href="#products" class="text-gray-700 hover:text-indigo-600 font-medium">Produits</a>
                <a href="/produits" class="text-gray-700 hover:text-indigo-600 font-medium">Catalogue</a>
                <a href="#testimonials" class="text-gray-700 hover:text-indigo-600 font-medium">Avis</a>
                <a href="#newsletter" class="text-gray-700 hover:text-indigo-600 font-medium">Newsletter</a>
            </nav>
            <div class="space-x-2">
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-indigo-600 font-semibold hover:bg-indigo-50 transition">Se connecter</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">Créer un compte</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="flex-1 flex flex-col justify-center items-center text-center py-20 px-4 bg-gradient-to-br from-white to-indigo-50 relative overflow-hidden">
        <!-- Tech background image (local public asset) -->
        <!-- Removed background image from hero section -->
        <div class="relative z-10">
            <h1 class="text-5xl md:text-6xl font-extrabold text-indigo-700 mb-6 drop-shadow">
                Bienvenue sur <span class="text-pink-500">E-Shop Digital</span>
            </h1>
            <p class="text-xl text-gray-700 mb-8 max-w-2xl mx-auto">
                Découvrez les dernières nouveautés en smartphones, tablettes, montres connectées, TV, PC et accessoires high-tech. Profitez de nos offres exclusives et équipez-vous avec le meilleur de la technologie !
            </p>
            <a href="#products" class="inline-block px-10 py-4 bg-pink-500 text-white rounded-xl text-lg font-bold shadow-lg hover:bg-pink-600 transition">
                Voir les produits high-tech
            </a>
            <!-- Optionally, add some floating device images/icons for more tech vibes -->
            <div class="flex justify-center gap-6 mt-10">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Phone" class="w-14 h-14 drop-shadow-lg">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747314.png" alt="Tablet" class="w-14 h-14 drop-shadow-lg">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747338.png" alt="Smartwatch" class="w-14 h-14 drop-shadow-lg">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747290.png" alt="Laptop" class="w-14 h-14 drop-shadow-lg">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="TV" class="w-14 h-14 drop-shadow-lg">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747327.png" alt="PC" class="w-14 h-14 drop-shadow-lg">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="max-w-6xl mx-auto py-16 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center border-t-4 border-indigo-400">
                <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png" alt="Nouveautés" class="w-20 h-20 mb-4">
                <h2 class="text-xl font-bold text-indigo-700 mb-2">Nouveautés</h2>
                <p class="text-gray-600 text-center">Découvrez les derniers produits ajoutés à notre catalogue, toujours à la pointe de la tendance.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center border-t-4 border-pink-400">
                <img src="https://cdn-icons-png.flaticon.com/512/1170/1170576.png" alt="Promotions" class="w-20 h-20 mb-4">
                <h2 class="text-xl font-bold text-pink-500 mb-2">Promotions</h2>
                <p class="text-gray-600 text-center">Profitez de nos offres spéciales et réductions exclusives sur une sélection de produits.</p>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col items-center border-t-4 border-green-400">
                <img src="https://cdn-icons-png.flaticon.com/512/1040/1040230.png" alt="Livraison rapide" class="w-20 h-20 mb-4">
                <h2 class="text-xl font-bold text-green-600 mb-2">Livraison rapide</h2>
                <p class="text-gray-600 text-center">Commandez aujourd'hui, recevez vos articles en un temps record partout au Maroc.</p>
            </div>
        </div>
    </section>

    <!-- Produits populaires -->
    <section id="products"
        class="max-w-6xl mx-auto py-16 px-4 relative overflow-hidden"
        style="">
        <div class="absolute inset-0 pointer-events-none"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-12">Produits populaires</h2>
            <div class="flex space-x-8 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-indigo-300 scrollbar-track-indigo-100">
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
                    <img src="{{ asset('image/iphone.jpg') }}" class="mb-4 rounded" alt="Produit 1">
                    <h3 class="font-semibold text-lg mb-2">iphone 13</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
                    <span class="text-pink-600 font-bold mb-2">5600 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-pink-200">
                    <img src="{{ asset('image/phone.jpg') }}" class="mb-4 rounded" alt="Produit 2">
                    <h3 class="font-semibold text-lg mb-2">iphone  12</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 2.</p>
                    <span class="text-pink-600 font-bold mb-2">5000 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-green-200">
                    <img src="{{ asset('image/ecran.jpg') }}" class="mb-4 rounded" alt="Produit 3">
                    <h3 class="font-semibold text-lg mb-2">Ecran Mac</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 3.</p>
                    <span class="text-pink-600 font-bold mb-2">8000 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
                    <img src="{{ asset('image/pc gamer.jpg') }}" class="mb-4 rounded" alt="Produit 1">
                    <h3 class="font-semibold text-lg mb-2">pc gamer</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
                    <span class="text-pink-600 font-bold mb-2">10000 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
                    <img src="{{ asset('image/samsung.jpg') }}" class="mb-4 rounded" alt="Produit 1">
                    <h3 class="font-semibold text-lg mb-2">samsung</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
                    <span class="text-pink-600 font-bold mb-2">5600 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
                    <img src="{{ asset('image/S21 ultra.jpg') }}" class="mb-4 rounded" alt="Produit 1">
                    <h3 class="font-semibold text-lg mb-2">S21 ultra</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
                    <span class="text-pink-600 font-bold mb-2">4300 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
                    <img src="{{ asset('image/geforce rtx.jpg') }}" class="mb-4 rounded" alt="Produit 1">
                    <h3 class="font-semibold text-lg mb-2">carte grafique</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
                    <span class="text-pink-600 font-bold mb-2">7300 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <div class="bg-white min-w-[300px] rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
                    <img src="{{ asset('image/note 9.jpg') }}" class="mb-4 rounded" alt="Produit 1">
                    <h3 class="font-semibold text-lg mb-2">samsung note 9</h3>
                    <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
                    <span class="text-pink-600 font-bold mb-2">4000 DH</span>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
                </div>
                <!-- Ajoutez d'autres produits ici si besoin -->
            </div>
        </div>
    </section>

    <!-- Bandeau Confiance -->
    <section class="max-w-4xl mx-auto mb-20 flex flex-col md:flex-row items-center justify-between bg-indigo-50 rounded-lg p-8 shadow-lg border border-indigo-100">
        <div class="flex items-center space-x-4">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
            <span class="text-lg font-semibold text-gray-700">Paiement sécurisé</span>
        </div>
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 10h18M9 16h6"></path></svg>
            <span class="text-lg font-semibold text-gray-700">Livraison rapide</span>
        </div>
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"></path></svg>
            <span class="text-lg font-semibold text-gray-700">Satisfait ou remboursé</span>
        </div>
    </section>

    <!-- Témoignages clients -->
    <section id="testimonials" class="max-w-6xl mx-auto py-16 px-4">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-12">Ils nous font confiance</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center border-l-4 border-indigo-200">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-16 h-16 rounded-full mb-4 border-2 border-indigo-400" alt="Client 1">
                <p class="text-gray-600 italic mb-2 text-center">"Super service, livraison rapide et produits de qualité !"</p>
                <span class="font-semibold text-indigo-700">Yassine B.</span>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center border-l-4 border-pink-200">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-16 h-16 rounded-full mb-4 border-2 border-pink-400" alt="Client 2">
                <p class="text-gray-600 italic mb-2 text-center">"J'ai adoré les promotions et le service client est top !"</p>
                <span class="font-semibold text-pink-500">Fatima Z.</span>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center border-l-4 border-green-200">
                <img src="https://randomuser.me/api/portraits/men/65.jpg" class="w-16 h-16 rounded-full mb-4 border-2 border-green-400" alt="Client 3">
                <p class="text-gray-600 italic mb-2 text-center">"Site fiable, je recommande à 100% !"</p>
                <span class="font-semibold text-green-600">Omar E.</span>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section id="newsletter" class="w-full bg-white rounded-2xl shadow-xl p-8 max-w-2xl mx-auto mb-16 border-t-4 border-indigo-400">
        <h2 class="text-2xl font-bold text-center text-indigo-700 mb-4">Restez informé des nouveautés</h2>
        <form class="flex flex-col md:flex-row items-center justify-center gap-4">
            <input type="email" placeholder="Votre email" class="w-full md:w-auto px-6 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
            <button type="submit" class="px-8 py-3 bg-pink-500 text-white rounded-lg font-bold shadow hover:bg-pink-600 transition">S'inscrire</button>
        </form>
        <p class="text-gray-500 text-center mt-4 text-sm">Recevez nos offres et nouveautés directement dans votre boîte mail.</p>
    </section>

    <!-- Footer -->
    <footer class="w-full bg-indigo-700 text-white py-8 mt-auto">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between px-4">
            <div class="flex items-center space-x-2 mb-4 md:mb-0">
                <img src="https://laravel.com/img/logomark.min.svg" class="h-7 w-7" alt="Logo">
                <span class="font-bold text-lg">E-Shop</span>
            </div>
            <div class="text-sm">&copy; {{ date('Y') }} E-Shop. Tous droits réservés.</div>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-pink-300">Facebook</a>
                <a href="#" class="hover:text-pink-300">Instagram</a>
                <a href="#" class="hover:text-pink-300">Contact</a>
            </div>
        </div>
    </footer>
</div>
@endsection
