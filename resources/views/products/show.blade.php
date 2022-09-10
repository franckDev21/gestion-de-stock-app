<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between">
        <div class="flex items-center justify-start">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des produits') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

            <span class="text-primary font-semibold text-xl leading-tight">{{ ucfirst($product->nom) }}</span>
        </div>

        <div>
            <a data-modal-toggle="popup-output" href="#"
              class="px-6 py-1 mr-3 shadow-md rounded-md bg-red-500 border-4 hover:bg-red-600 transition border-red-600 text-white">
              -  Ajouter une sortie
            </a>
            <a data-modal-toggle="popup-input" href="#"
                class="px-6 py-1 mr-3 shadow-md rounded-md bg-green-500 border-4 hover:bg-green-600 transition border-green-600 text-white">
                + Ajouter une entrée
            </a>
            <a href="{{ route('printUsers') }}"
                class="px-6 py-1 shadow-md rounded-md bg-yellow-500 border-4 hover:bg-yellow-600 transition border-yellow-600 text-white">
                <i class="fa-solid fa-right-left rotate-90 mr-3"></i> Hostorique d'entrée  / sortie
            </a>
        </div>
      </div>
  </x-slot>


  <div class="max-w-5xl px-6 pb-6 pt-10 mt-4 bg-white mx-auto  rounded-md relative">
    <a href="{{ route('products.edit',$product) }}" class="absolute top-0 right-0 px-4 py-2 bg-primary inline-block text-white cursor-pointer"><i class="fa-solid text-sm fa-pen "></i></a>

    <div>

        <div class="flex items-start">
          <div class="w-1/3 mr-2 relative">
            <img id="image" class="w-full h-auto rounded-md" src="{{ $product->image ? asset("storage/$product->image"):asset('static/img/product.png') }}" alt="product">
            
            <div class="flex justify-start text-gray-600 text-lg mt-3">
              <span class="inline-flex items-center"> <span class="font-bold mr-2">En stock ? : </span> <span class="{{ $product->is_stock ? 'bg-green-100 text-green-700':'bg-red-100 text-red-600' }} py-1 px-3 rounded-full text-xs">{{ $product->is_stock ? 'Oui encore en stock' : 'Non , stock vide' }}</span></span>
            </div>

            <div class="flex justify-start text-gray-600 text-lg mt-3">
              <span class="inline-flex items-center"> <span class="font-bold mr-2">Stock d'alerte : </span> <span class="bg-red-100 text-red-600' py-1 px-3 rounded-full text-xs">{{ $product->qte_stock_alert }} {{ $product->type_approvionement }}(s)</span></span>
            </div>

          </div>
          <div class="w-2/3 ml-2">
            <x-label for="nom" :value="__('Description du produit')" class="inline-block" />
            <div class="p-2 bg-gray-100 text-gray-600 rounded-md">
              {{ $product->description ?? 'Aucune desciption' }}
            </div>

            <div class="flex justify-start text-gray-600 text-2xl mt-3">
              <span class="inline-block">Nom du produit : </span>
              <span class="inline-block ml-3 font-semibold text-primary">{{ $product->nom }} </span>
            </div>

            <div class="flex justify-start text-gray-600 text-2xl mt-3">
              <span class="inline-block">Quantité en stock : </span>
              <span class="inline-block ml-3 font-semibold text-primary">{{ $product->qte_en_stock }} {{ $product->type_approvionement }}(s) {{ $product->nbre_par_carton ? 'de '.$product->nbre_par_carton : null }}  </span>
            </div>

            @if($product->nbre_par_carton)
              <div class="flex justify-start text-gray-600 text-2xl mt-3">
                <span class="inline-block">Nombre unité restante  ({{ $product->unite_mesure }}) :  </span>
                <span class="inline-block ml-3 font-semibold text-primary">{{ $product->reste_unites ?? 0 }} </span>
              </div>

              <div class="flex justify-start text-gray-600 text-2xl mt-3">
                <span class="inline-block">Nombre par  {{ $product->type_approvionement }} :  </span>
                <span class="inline-block ml-3 font-semibold text-primary">{{ $product->nbre_par_carton }} </span>
              </div>
            @else
              <div class="flex justify-start text-gray-600 text-2xl mt-3">
                <span class="inline-block">Nombre unité restante  ({{ $product->unite_mesure }}) :  </span>
                <span class="inline-block ml-3 font-semibold text-primary">{{ $product->reste_unites ?? 0 }} </span>
              </div>

              @if ($product->qte_en_littre)
                <div class="flex justify-start text-gray-600 text-2xl mt-3">
                  <span class="inline-block">Poids du  {{ $product->type_approvionement }} :  </span>
                  <span class="inline-block ml-3 font-semibold text-primary">{{ $product->qte_en_littre ?? 0 }} {{ $product->unite_mesure }}</span>
                </div>
              @endif

              @if (!$product->qte_en_littre && $product->poids)
                <div class="flex justify-start text-gray-600 text-2xl mt-3">
                  <span class="inline-block">Poids du  {{ $product->type_approvionement }} :  </span>
                  <span class="inline-block ml-3 font-semibold text-primary">{{ $product->poids ?? 0 }} {{ $product->unite_mesure }}</span>
                </div>
              @endif
            
              <div class="flex justify-start text-gray-600 text-2xl mt-3">
                <span class="inline-block">Unité de mésure  :  </span>
                <span class="inline-block ml-3 font-semibold text-primary">{{ $product->unite_mesure }} </span>
              </div>
            @endif

            <div class="flex justify-start text-gray-600 text-2xl mt-3">
              <span class="inline-block">Prix unitaire : </span>
              <span class="inline-block ml-3 font-semibold text-primary">{{ $product->prix_unitaire }} F </span>
            </div>

            <div class="flex justify-start text-gray-600 text-2xl mt-3">
              <span class="inline-block">Date de création : </span>
              <span class="inline-block ml-3 font-semibold text-primary">{{ $product->created_at->format('d M Y') }}</span>
            </div>

            <div class="flex justify-start text-gray-600 text-2xl mt-3">
              <span class="inline-block">Date du dernier approvionnement : </span>
              <span class="inline-block ml-3 font-semibold text-primary">{{ $product->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
  </div>

  <x-add-input-product  :product="$product" id="popup-input" />
  <x-add-output-product :product="$product" id="popup-output" />


<form method="POST" action="{{ route('products.addOutput',$product->id) }}" id="" 
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full"
    style="z-index: 1000">
    @csrf
    @method('POST')
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                data-modal-toggle="">
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
                    <button data-modal-toggle="" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</form>

</x-app-layout>