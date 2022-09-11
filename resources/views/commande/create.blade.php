<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-between">
          <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des commandes') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>
  
            <h2 class="font-semibold text-xl text-primary leading-tight">
                Création d'une nouvelle commande
            </h2>
          </div>
          <form class="w-[40%] flex" method="GET">
              <div class="relative w-[90%]">
                  <x-input class="w-full" placeholder='Réchercher un client ...' type="date" name="search"
                      :value="request('search')" required autofocus />
              </div>
              
              <x-button class="ml-3">
                  {{ __('Rechercher') }}
              </x-button>
          </form>
      </div>
  </x-slot>

    {{-- <a href="{{ asset('storage/img/users/default.jpg') }}" download=""{{ asset('storage/img/users/default.jpg') }}""  >image</a> --}}
    <div data-user="{{ auth()->user()->id }}" id="commande">
            
    </div>


</x-app-layout>