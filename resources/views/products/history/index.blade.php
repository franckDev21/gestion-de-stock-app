<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                    {{ __('Gestion des produits') }}
                </h2>
                <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>
    
                <h2 class="font-semibold text-xl text-primary leading-tight">
                    {{ __('Historiques') }} 
                </h2>

                <a href="{{ route('approvisionnement.index') }}"
                    class="ml-4 px-4 py-1 shadow-md rounded-md bg-sky-900 bg-opacity-80 border-4 hover:bg-opacity-100 transition border-sky-900 text-white">
                    <i class="fa-solid fa-right-left rotate-90 mr-2"></i> Hostorique approvisionnement
                </a>
            </div>
          <form class="w-[40%] flex disabled" method="GET">
              <div class="relative w-[90%]">
                  <x-input class="w-full" placeholder='Réchercher un produit ...' type="text" name="search"
                      :value="request('search')"  />
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
          <a target="_blank" href="{{ route('history.print') }}"
              class="mr-4 px-6 py-1 shadow-md rounded-md bg-gray-500 border-4 hover:bg-gray-600 transition border-gray-600 text-white">
              <i class="fa-solid fa-download mr-3"></i> Imprimer l'historiques
          </a>

          <a href="{{ route('history.input') }}"
              class="mr-4 px-6 py-1 shadow-md rounded-md bg-green-500 border-4 hover:bg-green-600 transition border-green-600 text-white">
                historiques entrantes
          </a>

          <a href="{{ route('history.output') }}"
              class="mr-4 px-6 py-1 shadow-md rounded-md bg-red-500 border-4 hover:bg-red-600 transition border-red-600 text-white">
                historiques sortantes
          </a>
          
          <a href="{{ route('history.index') }}"
              class="px-6 py-1 shadow-md rounded-md bg-white bg-opacity-80 border-4 border-white ">
              <i class="fa-solid fa-arrows-rotate"></i> Réactualiser
          </a>

          

      </div>
      <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6">
          @unless(count($historiques) !== 0)
          <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80"> 
              <i class="fa-solid  fa-box-open text-gray-400 text-8xl mb-3"></i> <br>
              @if (request('search'))
                  Aucun resultat ne correspond votre rechercher <br>
                  <span class="text-secondary my-2 inline-block">" {{ request('search') }} "</span>
              @else
                  Historiques vide
              @endif
          </div>
          @else
              <table class="min-w-max w-full table-auto">
                  <thead>
                      <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                          <th class="py-3 px-4 text-left">Nom du produit</th>
                          <th class="py-3 px-4 text-left">Date & Heure</th>
                          <th class="py-3 px-4 text-left">Quantité <br> (Entrante ou sortante)</th>
                          <th class="py-3 px-4 text-left">Auteur de la <br> transaction</th>
                          <th class="py-3 px-4 text-left">Type</th>
                          <th class="py-3 px-4 text-left">Motif</th>
                          <th class="py-3 px-4 text-left">Actions</th>
                      </tr>
                  </thead>
                  <tbody class="text-gray-600 text-sm font-light">
                      @foreach ($historiques as $history)
                          <tr class="border-b border-gray-200 hover:bg-gray-100">
                              <td class="py-3 px-4 text-left whitespace-nowrap">
                                  <div class="flex items-center">
                                      <div
                                          class="mr-2 h-14 w-14 rounded-md overflow-hidden flex justify-center items-center ">
                                          @if ($history->product->image)
                                              <img class=" h-14 w-14 "
                                                  src="{{ asset("storage/{$history->product->image}") }}" alt="image">
                                          @else
                                              <i class="fa-solid text-2xl text-gray-400  fa-box-open "></i>
                                          @endif
                                      </div>
                                      <div class="flex items-start flex-col justify-start">
                                          <span class="font-bold">{{ ucfirst($history->product->nom) }}</span>
                                          {{ $history->product->nbre_par_carton ? $history->product->nbre_par_carton.' Par '.$history->product->type_approvionement : ($history->product->qte_en_littre ?? $history->product->poids).' '.$history->product->unite_mesure.' Par '.$history->product->type_approvionement }}
                                      </div>
                                  </div>
                              </td>

                              <td class="py-3 px-4 text-left">
                                  <span class="font-semibold">{{ $history->created_at->format('d M Y à H\hi') }}</span>
                              </td>

                              <td class="py-3 px-4 text-left flex flex-col">
                                  <span><span>{{ $history->quantite }} </span> {{ $history->is_unite  ? 'Unitée(s)': $history->product->type_approvionement.'(s)' }} </span>
                                {{-- <span>old_state_stock</span> --}}
                             </td>

                              <td class="py-1 px-4 text-left">
                                  {{-- <span --}}
                                      {{-- class="{{ $history->is_stock ? 'bg-green-100 text-green-700':'bg-red-100 text-red-600' }} py-1 px-3 rounded-full text-xs">{{ $history->is_stock ? 'Oui encore en stock' : 'Non , stock vide' }}</span> --}}

                                    <span
                                      class=" py-1 rounded-full font-semibold">{{ $history->user->firstname }} {{ $history->user->lastname }}</span>
                              </td>

                              <td class="py-3 px-4 text-left {{ $history->type === 'SORTIE' ? 'text-red-500':'text-green-500' }}"> 
                                  {{ $history->type }}
                              </td>

                              <td class="py-3 px-4 text-left"> 
                                  {{ $history->motif }}
                              </td>

                              <td class="py-3 px-4 text-left">
                                  <div class="flex item-center justify-center">
                                      <a href="{{ route('history.index.product',$history->product->id) }}" title="voir tous les entrées et sorties du {{ $history->product->nom }}"
                                          class="w-8 h-8 rounded bg-secondary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                          </svg>
                                      </a>

                                      {{-- <a href="#"
                                          class="w-8 h-8 rounded bg-primary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                          </svg>
                                      </a> --}}
                                      
                                      {{-- <div data-id="{{ $history->id }}"
                                          data-mot="{{ $history->nom }}"
                                          data-modal-toggle="popup-delete"
                                          class="w-8 h-8 rounded bg-red-400 mr-1 cursor-pointer transform text-white flex justify-center items-center hover:scale-110 delete-btn">
                                          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                          </svg>
                                      </div> --}}
                                  </div>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          @endunless
      </div>
      {{ $historiques->links() }}
  </div>

  <form method="POST" action="" id="popup-delete" tabindex="-1"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full"
      style="z-index: 1000">
      @csrf
      @method('DELETE')
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <button type="button"
                  class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                  data-modal-toggle="popup-delete">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                      xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6 text-center">
                  <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200"
                      fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Voulez vous vraiment
                      supprimer le produit <span class="mot text-primary"></span> ?</h3>
                  <button type="submit" data-modal-toggle="popup-delete" type="button"
                      class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                      Confirmer
                  </button>
                  <button data-modal-toggle="popup-delete" type="button"
                      class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
              </div>
          </div>
      </div>
  </form>


  <!-- js -->
  <x-slot name="js">

      <script defer>
          // suppression du produit
          Array.from(document.querySelectorAll('.delete-btn')).forEach(element => {
              const form = document.getElementById('popup-delete')
              element.addEventListener('click', e => {
                  form.setAttribute('action', `/historys/${e.currentTarget.dataset.id}`)
                  form.querySelector('.mot').textContent = `" ${e.currentTarget.dataset.mot} "`
              })
          })
      </script>
  </x-slot>

</x-app-layout>
