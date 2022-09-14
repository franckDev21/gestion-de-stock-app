<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Tableau de bord') }}
            </h2>
            <form class="w-2/3 flex disabled">
                <div class="relative w-[90%]">
                    <x-input class="w-full" placeholder='Search ...' type="text" name="search" :value="old('search')" required  />
                    <i class="fa-solid fa-magnifying-glass absolute top-1/2 -translate-y-1/2 right-4 text-gray-500"></i>
                </div>
                <x-button class="ml-3">
                    {{ __('Rechercher') }}
                </x-button>
            </form>
        </div>
    </x-slot>

    <div class="pt-5 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4 mt-6">
            <a href="{{ route('approvisionnement.index') }}"
                class="px-4 mr-2 py-1 shadow-md rounded-md bg-sky-900 bg-opacity-80 border-4 hover:bg-opacity-100 transition border-sky-900 text-white">
                <i class="fa-solid fa-right-left rotate-90 mr-2"></i> Hostorique des approvisionnement (tous les produits)
            </a>
            <a href="{{ route('history.index') }}"
                class="mr-2 px-4 py-1 shadow-md rounded-md bg-yellow-500  border-4 hover:bg-yellow-600 transition border-yellow-600 text-white">
                <i class="fa-solid fa-right-left rotate-90 mr-2"></i> Hostorique d'entrée  / sortie produit (tous les produits)
            </a>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-4">
            <a href="{{ route('users.index') }}" class="p-4 rounded-md bg-white flex items-start text-gray-500">
                <i class="fa-solid text-yellow-900 fa-user text-4xl mr-4"></i>
                <div>
                    <span class="text-2xl text-primary font-bold">{{ $totalUser }} utilisateur(s)</span>
                    <span class="w-full h-[1px] bg-gray-400 bg-opacity-40 block"></span>
                    <h2 class="font-bold text-yellow-900">Gestion des utilisateurs</h2>
                </div>
            </a>

            <a href="{{ route('caisse.index') }}" class="p-4 rounded-md bg-white flex items-start text-gray-500">
                <i class="fa-solid fa-sack-dollar text-yellow-900 text-4xl mr-4"></i>
                <div>
                    <span class="text-2xl text-primary font-bold">{{ number_format($totalCaisse,0,',','.') }} FCFA</span>
                    <span class="w-full h-[1px] bg-gray-400 bg-opacity-40 block"></span>
                    <h2 class="font-bold text-yellow-900">Gestion de la caisse</h2>
                </div>
            </a>

            <a href="{{ route('products.index') }}" class="p-4 rounded-md bg-white flex items-start text-gray-500">
                <i class="fa-solid text-yellow-900 fa-box-open text-4xl mr-4"></i>
                <div>
                    <span class="text-2xl text-primary font-bold">{{ $totalProduct }} produit(s)</span>
                    <span class="w-full h-[1px] bg-gray-400 bg-opacity-40 block"></span>
                    <h2 class="font-bold text-yellow-900">Gestion de stock</h2>
                </div>
            </a>

            <a href="{{ route('clients.index') }}" class="p-4 rounded-md bg-white flex items-start text-gray-500">
                <i class="fa-solid text-yellow-900 fa-duotone fa-users text-4xl mr-4"></i>
                <div>
                    <span class="text-2xl text-primary font-bold">{{ $totalClient }} Client(s)</span>
                    <span class="w-full h-[1px] bg-gray-400 bg-opacity-40 block"></span>
                    <h2 class="font-bold text-yellow-900">Gestion des Cliens</h2>
                </div>
            </a>

            <a href="{{ route('commandes.index') }}" class="p-4 rounded-md bg-white flex items-start text-gray-500">
                <i class="fa-solid text-yellow-900 fa-shop text-4xl mr-4"></i>
                <div>
                    <span class="text-2xl text-primary font-bold">{{ $totalCommande }} commande(s)</span>
                    <span class="w-full h-[1px] bg-gray-400 bg-opacity-40 block"></span>
                    <h2 class="font-bold text-yellow-900">Gestion des commandes</h2>
                </div>
            </a>

        </div>
        
    </div>
</x-app-layout>
