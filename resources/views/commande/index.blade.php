<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-between">
          <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des commandes') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>
  
            <h2 class="font-semibold text-xl text-primary leading-tight">
                Liste des commandes
            </h2>
          </div>
          <form class="w-[40%] flex" method="GET">
              <div class="relative w-[90%]">
                  <x-input class="w-full" placeholder='Réchercher un client ...' type="text" name="search"
                      :value="request('search')" required autofocus />
                  <i class="fa-solid fa-magnifying-glass absolute top-1/2 -translate-y-1/2 right-4 text-gray-500"></i>
              </div>
              
              <x-button class="ml-3">
                  {{ __('Rechercher') }}
              </x-button>
          </form>
      </div>
  </x-slot>

    
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
    <div class="flex items-center justify-start  mt-6">

        <a target="_blank" href="#"
            class="mr-4 px-4 py-1 shadow-md rounded-md bg-gray-500 border-4 hover:bg-gray-600 transition border-gray-600 text-white">
            <i class="fa-solid fa-download mr-2"></i> Imprimer la liste des commandes
        </a>

        <a target="_blank" href="{{ route('commandes.create') }}"
            class="mr-4 px-4 py-1 shadow-md rounded-md bg-green-500 border-4 hover:bg-green-600 transition border-green-600 text-white">
            <i class="fa-solid fa-cart-shopping"></i> Ajouter une nouvelle commande
        </a>
        
        <div class="flex items-center text-gray-600 px-3 py-1 border-2 rounded-md bg-gray-50">
            <span>Filter par : </span>
            <div class="ml-3 flex items-center">
                <label for="all" class="mr-2 flex items-center">
                    <input type="radio" class="border-2 mr-2 outline-none focus:border-none focus:outline-none focus:ring-0 inline-block h-5 w-5 text-secondary" checked name="statut" value="all" id="all">  Tous
                </label>

                <label for="payer" class="mr-2 flex items-center">
                    <input type="radio" class="border-2 mr-2 outline-none focus:border-none focus:outline-none focus:ring-0 inline-block h-5 w-5 text-green-500" name="statut" value="payer" id="payer">  Payer
                </label>

                <label for="impayer" class="mr-2 flex items-center">
                    <input type="radio" class="border-2 mr-2 outline-none focus:border-none focus:outline-none focus:ring-0 inline-block h-5 w-5 text-red-500" name="statut" value="impayer" id="impayer">  Impayer
                </label>

                <label for="facturer" class="mr-2 flex items-center">
                    <input type="radio" class="border-2 mr-2 outline-none focus:border-none focus:outline-none focus:ring-0 inline-block h-5 w-5 text-primary" name="statut" value="facturer" id="facturer">  Facturer
                </label>
            </div>
        </div>

    </div>
    <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6">
        @unless(count($commandes) !== 0)
        <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80"> 
            <i class="fa-solid  fa-box-open text-gray-400 text-8xl mb-3"></i> <br>
            
            @if (request('search'))
                Aucun resultat ne correspond votre rechercher <br>
                <span class="text-secondary my-2 inline-block">" {{ request('search') }} "</span>
            @else
                Aucune commande
            @endif
            
        </div>
        @else
            <table class="min-w-full w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">reference</th>
                        <th class="py-3 px-4 text-left">quantite produits</th>
                        <th class="py-3 px-4 text-left">coût</th>
                        <th class="py-3 px-4 text-left">etat</th>
                        <th class="py-3 px-4 text-left">client</th>
                        <th class="py-3 px-4 text-left">date Création</th>
                        <th class="py-3 px-4 text-left">autheur</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($commandes as $commande)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">
                                <span class="font-semibold">#{{ $commande->reference }}</span>
                            </td>

                            <td class="py-3 px-4 text-left">
                                <span>{{ $commande->quantite }} Unité(s)</span>
                            </td>

                            <td class="py-3 px-4 text-left">
                                <span class="px-1 font-semibold">{{ $commande->cout }} F</span>
                            </td>

                            <td class="py-1 px-4 text-left">
                                <span
                                    class="{{ $commande->etat === 'PAYER' || $commande->etat === 'FACTURER' ? 'bg-green-100 text-green-700':'bg-red-100 text-red-600' }} py-1 px-3 rounded-full text-xs">{{ $commande->etat }}</span>
                            </td>

                            <td class="py-3 px-4 text-left flex flex-col justify-start items-start">
                                <span
                                    class="font-bold">{{ $commande->client->firstname }} {{ $commande->client->lastname }}</span>
                                <span class="py-1 scrollbar-none max-w-[150px] overflow-x-scroll">{{ $commande->client->email }}</span>
                            </td>

                            <td class="py-3 px-4 text-left"> 
                                {{ $commande->created_at->format('d M Y à h\h:i') }}
                            </td>

                            <td class="py-3 px-4 text-left"> 
                                {{ $commande->user->firstname }} {{ $commande->user->lastname }}
                            </td>

                            <td class="py-3 text-left">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('commandes.show', $commande->id) }}"
                                        class="w-8 h-8 rounded bg-yellow-600 mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </a>

                                    <a href="{{ route('commandes.show', $commande->id) }}"
                                        class="w-8 h-8 rounded bg-secondary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('commandes.edit', $commande->id) }}"
                                        class="w-8 h-8 rounded bg-primary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    
                                    <div data-id="{{ $commande->id }}"
                                        data-mot="{{ $commande->nom }}"
                                        data-modal-toggle="popup-delete"
                                        class="w-8 h-8 rounded bg-red-400 mr-1 cursor-pointer transform text-white flex justify-center items-center hover:scale-110 delete-btn">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endunless
    </div>
    {{ $commandes->links() }}
</div>


</x-app-layout>