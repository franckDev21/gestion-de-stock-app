@props(['id','product'])

<form method="POST" action="{{ route('products.addOutput',$product->id) }}" id="{{ $id }}" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full"
    style="z-index: 1000">
    @csrf
    @method('POST')
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                data-modal-toggle="{{ $id }}">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <h1 class="text-2xl mb-2 mt-6 px-6 pt-6 pb-3 text-white border-b border-opacity-20 font-bold">Ajouter une Sortie</h1>
            
            <div class="pb-6 mt-4 px-6">
               <div class="mt-3 mb-6">
                  <x-label for="qte" :value="__('Quantité')" class="inline-block text-white mb-1 text-lg" /> <span class="text-xs italic text-gray-400"></span>
                  <x-input placeholder='Entrer la quantité a rétiré' id="qte" class="w-full placeholder:italic" min='1' max='100' type="number"
                    name="qte" :value="old('qte')" required autofocus />
               </div>

               <div class="mt-3 mb-6">
                    <x-label for="type" :value="__('Type de retrait')" class="inline-block text-white mb-1 text-lg" />
                    <select name="type" id="type" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="UNITE">Unité</option>
                        <option value="CARTON">{{ $product->type_approvionement }}</option>
                    </select>
                </div>

               <div class="mt-3 mb-6">
                    <x-label for="motif" :value="__('Motif')" class="inline-block text-white mb-1 text-lg" />
                    
                    <textarea name="modif" placeholder="Entrer le motif içi" required class="w-full placeholder:italic rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="" cols="30" rows="5">{{ old('motif') }}</textarea>
                </div>

                <div class="flex">
                    <button type="submit" type="button"
                        class="text-white bg-primary bg-opacity-80 hover:bg-opacity-100 focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Confirmer la sortie
                    </button>
                    <button data-modal-toggle="{{ $id }}" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>
