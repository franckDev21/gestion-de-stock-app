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

</x-app-layout>