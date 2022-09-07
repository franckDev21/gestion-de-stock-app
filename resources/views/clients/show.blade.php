<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-start">
          <h2 class="font-semibold text-xl text-gray-600 leading-tight">
              {{ __('Gestion des utilisateurs') }}
          </h2>
          <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

          <h2 class="font-semibold text-xl text-primary leading-tight">
              {{ __('Informations du client ') }} <span class="text-secondary">{{ $client->firstname }}
                  {{ $client->lastname }}</span>
          </h2>
      </div>
  </x-slot>

  <div class="max-w-4xl px-6 py-4 mt-4 bg-white mx-auto  rounded-md relative">

      <a href="{{ route('clients.edit',$client) }}" title="Editer l'utilisateur" class=" absolute top-2 right-2 cursor-pointer hover:bg-opacity-100 hover:text-white text-primary w-8 h-8 ml-3 flex-none flex justify-center items-center rounded-full bg-primary bg-opacity-30" >
          <i class="fa-solid text-sm fa-pen "></i>
      </a>

      <span title="Supprimer le client " class="cursor-pointer absolute top-2 right-14  hover:bg-red-500 hover:text-white text-red-500 w-8 h-8 ml-3 flex-none flex justify-center items-center rounded-full bg-red-100 delete-btn" data-id="{{ $client->id }}" data-mot="{{ $client->lastname.' '.$client->firstname }}"  data-modal-toggle="popup-delete">
        <i class="fa-solid text-sm fa-trash "></i>
      </span>

      <form method="POST" action="{{ route('clients.update', $client->id) }}">
          @csrf

          <!-- Name -->
          <div class="mb-1 flex justify-between">
              <div class="w-40 flex justify-center items-center h-40 bg-gray-100 relative">
                  @if ($client->photo)
                      <img class="absolute object-cover w-full h-full" src="{{ asset("storage/$client->photo") }}" alt="image">
                  @else
                      <i class="fa-solid text-8xl text-gray-400 absolute fa-user"></i>
                  @endif
              </div>
              <div class="ml-4 w-[calc(100%-10rem)]">
                  <div class="mt-1 justify-start flex items-center text-xl text-gray-500 mb-3">
                      <span class="font-bold text-xl mr-2 text-primary">Nom </span> :
                      <div class="ml-2">{{ $client->lastname }}</div>
                  </div>

                  <div class="mt-1 justify-start flex items-center text-xl text-gray-500 mb-3">
                      <span class="font-bold text-xl mr-2 text-primary">Prénom </span> :
                      <div class="ml-2">{{ $client->firstname }}</div>
                  </div>

                  <div class="mt-1 justify-start flex items-center text-xl text-gray-500 mb-3">
                      <span class="font-bold text-xl mr-2 text-primary">Date d'ajout </span> :
                      <div class="ml-2">{{ $client->created_at->format('d M Y') }}</div>
                  </div>

                  <div class="mt-1 justify-start flex items-center text-xl text-gray-500 mb-3">
                      <span class="font-bold text-xl mr-2 text-primary">Addresse Email </span> :
                      <div class="ml-2">{{ $client->email }}</div>
                  </div>

                  <div class="mt-1 justify-start flex items-center text-xl text-gray-500">
                      <span class="font-bold text-xl mr-2 text-primary">Téléphone </span> :
                      <div class="ml-2">{{ $client->tel }}</div>
                  </div>

                  <div class="mt-1 justify-start flex items-center text-xl text-gray-500">
                      <span class="font-bold text-xl mr-2 text-primary">Nombre de commande </span> :
                      <div class="ml-2 flex items-center">

                          10 Commandes
                      </div>
                  </div>
              </div>
          </div>


      </form>
  </div>


  <form method="POST" action="" id="popup-delete" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full" style="z-index: 1000">
      @csrf
      @method('DELETE')
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-delete">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6 text-center">
                  <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                  <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Voulez vous vraiment supprimer le client <span class="mot"></span> ?</h3>
                  <button type="submit" data-modal-toggle="popup-delete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                      Confirmer
                  </button>
                  <button data-modal-toggle="popup-delete" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
              </div>
          </div>
      </div>
  </form>

  <!-- modal -->

  <!-- js -->
  <x-slot name="js">
      
      <script defer>
          // suppression de l'utilisateur
          Array.from(document.querySelectorAll('.delete-btn')).forEach(element => {
              const form = document.getElementById('popup-delete')
              element.addEventListener('click',e => {
              form.setAttribute('action',`/clients/${e.currentTarget.dataset.id}`)
                  form.querySelector('.mot').textContent = `${e.currentTarget.dataset.mot}`
              })
          })
      </script>
  </x-slot>

</x-app-layout>
