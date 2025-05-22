@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-16 px-4">
    <h1 class="text-3xl font-bold text-indigo-700 mb-8">Nos Produits</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-indigo-200">
            <img src="{{ asset('image/iphone.jpg') }}" class="mb-4 rounded" alt="Produit 1">
            <h3 class="font-semibold text-lg mb-2">iphone 13</h3>
            <p class="text-gray-600 mb-2 text-center">Description courte du produit 1.</p>
            <span class="text-pink-600 font-bold mb-2">5600 DH</span>
            <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-pink-200">
            <img src="{{ asset('image/phone.jpg') }}" class="mb-4 rounded" alt="Produit 2">
            <h3 class="font-semibold text-lg mb-2">iphone 12</h3>
            <p class="text-gray-600 mb-2 text-center">Description courte du produit 2.</p>
            <span class="text-pink-600 font-bold mb-2">5000 DH</span>
            <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center border-b-4 border-green-200">
            <img src="{{ asset('image/ecran.jpg') }}" class="mb-4 rounded" alt="Produit 3">
            <h3 class="font-semibold text-lg mb-2">Ecran Mac</h3>
            <p class="text-gray-600 mb-2 text-center">Description courte du produit 3.</p>
            <span class="text-pink-600 font-bold mb-2">8000 DH</span>
            <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Voir</a>
        </div>
        <!-- Ajoutez d'autres produits ici si besoin -->
    </div>
</div>
@endsection 