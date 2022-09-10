<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-between">
          <h2 class="font-semibold text-xl text-gray-600 leading-tight">
              {{ __('Approvionnement') }}
          </h2>
          <form class="w-2/3 flex" method="GET">
              <div class="relative w-[90%]">
                  <x-input class="w-full" placeholder='Réchercher un produit ...' type="text" name="search"
                      :value="request('search')" autofocus />
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
          <a target="_blank" href=""
              class="mr-4 px-4 py-1 shadow-md rounded-md bg-gray-500 border-4 hover:bg-gray-600 transition border-gray-600 text-white">
              <i class="fa-solid fa-download mr-2"></i> Imprimer l'historique
          </a>
          <a href="{{ route('approvisionnement.index') }}"
              class="px-4 py-1 shadow-md rounded-md bg-white bg-opacity-80 border-4 border-white ">
              <i class="fa-solid fa-arrows-rotate"></i> Réactualiser
          </a>

      </div>
      <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6">
          @unless(count($approvisionnements) !== 0)
          <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80"> 
              <i class="fa-solid  fa-box-open text-gray-400 text-8xl mb-3"></i> <br>
              
              @if (request('search'))
                  Aucun resultat ne correspond votre rechercher <br>
                  <span class="text-secondary my-2 inline-block">" {{ request('search') }} "</span>
              @else
                  Aucun resultat
              @endif
              
          </div>
          @else
              <table class="min-w-full w-full table-auto">
                  <thead>
                      <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                          <th class="py-3 px-4 text-left">Nom du produit</th>
                          <th class="py-3 px-4 text-left">Date de l'approvionnement</th>
                          <th class="py-3 px-4 text-left">Quantité</th>
                          <th class="py-3 px-4 text-left">prix d'achat</th>
                          <th class="py-3 px-4 text-left">utilisateur</th>
                          <th class="py-3 px-4 text-left">Actions</th>
                      </tr>
                  </thead>
                  <tbody class="text-gray-600 text-sm font-light">
                      @foreach ($approvisionnements as $approvisionnement)
                          <tr class="border-b border-gray-200 hover:bg-gray-100">
                              <td class="py-3 px-4 text-left whitespace-nowrap">
                                  <div class="flex items-center">
                                      <div
                                          class="mr-2 h-14 w-14 rounded-md overflow-hidden flex justify-center items-center ">
                                          @if ($approvisionnement->product->image)
                                              <img class=" h-14 w-14 "
                                                  src="{{ asset("storage/{$approvisionnement->product->image}") }}" alt="image">
                                          @else
                                              <i class="fa-solid text-2xl text-gray-400  fa-box-open "></i>
                                          @endif
                                      </div>
                                      <div class="flex items-start flex-col justify-start">
                                          <span class="font-bold">{{ ucfirst($approvisionnement->product->nom) }}</span>
                                      </div>
                                  </div>
                              </td>

                              <td class="py-3 px-4 text-left">
                                  <span>{{ $approvisionnement->created_at->format('d M Y') }}</span>
                              </td>

                              <td class="py-3 px-4 text-left">
                                  <span>{{ $approvisionnement->quantite }} {{ $approvisionnement->is_unite ? 'Unitée(s)':$approvisionnement->product->type_approvionement }}s</span>
                              </td>

                              <td class="py-1 px-4 text-left">
                                  <span class=" py-1 px-3 rounded-full font-semibold">{{ $approvisionnement->prix_achat }} F</span>
                              </td>

                              <td class="py-3 px-4 text-left">
                                  <span
                                      class="py-1 px-3 font-bold">{{ $approvisionnement->user->firstname }} {{ $approvisionnement->user->lastname }}</span>
                              </td>

                              <td class="py-3 text-left disabled">
                                  <div class="flex item-center justify-center">
                                      <a href="#"
                                          class="w-8 h-8 rounded bg-secondary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                          </svg>
                                      </a>
                                  </div>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          @endunless
      </div>
      {{ $approvisionnements->links() }}
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
                  form.setAttribute('action', `/approvisionnements/${e.currentTarget.dataset.id}`)
                  form.querySelector('.mot').textContent = `" ${e.currentTarget.dataset.mot} "`
              })
          })
      </script>
  </x-slot>

</x-app-layout>
