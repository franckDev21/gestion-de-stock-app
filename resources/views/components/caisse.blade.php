@props(['type'])

@php
    $route = $type === 'entrer' ? route('caisse.store') : route('caisse.sortie');
    $title = $type === 'entrer' ? "Ajouter une nouvelle entrée" : "Ajouter une nouvelle sortie";
@endphp

<!-- Main modal -->
<form action="{{ $route }}" method="POST" id="{{$type}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
    @csrf  
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="{{ $type }}">
                      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 w-full">
                <div class="mt-1 mr-1 ">
                  <x-label for="montant" :value="__('Montant')" class="mb-1 text-lg" />
                  <x-input placeholder='Montant' id="montant" class="w-full" type="number" min='100'
                      name="montant" :value="old('montant')" required autofocus />
                  @error('montant')
                      <span class="text-sm text-red-400 block">{{ $message }}</span>
                  @enderror
              </div>
              <div class="mt-3 ml-1">
                  <x-label for="lastname" :value="__('Modif')" class="text-lg" />
                  <textarea placeholder='Modif' id="motif" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text"
                  name="motif" :value="old('motif')" required cols="30" rows="10"></textarea>
                  @error('motif')
                      <span class="text-sm text-red-400 block">{{ $message }}</span>
                  @enderror
              </div>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                  <button data-modal-toggle="{{ $type }}" type="submit" class="text-white bg-primary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary ">Cormfimer</button>
                  <button data-modal-toggle="{{ $type }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
              </div>
          </div>
      </div>
    </form>
  
