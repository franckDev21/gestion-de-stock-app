@props(['id','product'])

<form method="POST" action="{{ route('products.addInput',$product->id) }}" id="{{ $id }}" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full"
    style="z-index: 1000">
    @csrf
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
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
            
            <div class="p-6">
               <div class="mt-3 mb-6">
                  <x-label for="qte" :value="__('Quantité')" class="inline-block text-white mb-1 text-lg" /> <span class="text-xs italic text-gray-400">(En carton ou packet)</span>
                  <x-input placeholder='Entrer la quantité a ajouter' id="qte" class="w-full placeholder:italic" min='1' max='100' type="number"
                    name="qte" :value="old('qte',$product->qte)" required autofocus />
               </div>

               <div class="mt-3 mb-6">
                  <x-label for="prix" :value="__('Prix d\'achat')" class="inline-block text-white mb-1 text-lg" />
                  <x-input placeholder="Entrer le prix d'achat du produit" id="prix" class="w-full placeholder:italic" min='1' type="number"
                    name="prix" :value="old('prix',$product->qte)" required autofocus />
               </div>

                <div class="flex">
                  <button type="submit" type="button"
                    class="text-white bg-primary bg-opacity-80 hover:bg-opacity-100 focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Confirmer l'ajout en stock du produit
                </button>
                <button data-modal-toggle="{{ $id }}" type="button"
                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>
