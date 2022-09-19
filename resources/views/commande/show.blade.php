<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-between">
          <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des commandes') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>
  
            <h2 class="font-semibold text-xl text-primary leading-tight">
                Commande #{{ $commande->reference }} | {{ $commande->client->firstname }} {{ $commande->client->lastname }}
            </h2>
          </div>
          
      </div>
  </x-slot>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
    <div class="bg-white text-gray-500 min-h-[450px] px-6 py-5 rounded-md mt-5">
      <div class="flex pb-4 border-b justify-between">
        <h1 class="text-2xl font-bold">Total prix : <span class="text-primary">{{ $commande->cout }} F</span></h1>
        <div>
          <a data-modal-toggle="popup-facture2"class="inline-flex items-center px-4 py-2 bg-green-600 bg-opacity-70 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Facturer et payer la commande</a>
          <a data-modal-toggle="popup-facture" class="inline-flex items-center px-4 py-2 bg-primary bg-opacity-70 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Facturer le client</a>
        </div>
      </div>

      <h3 class="text-2xl font-bold mt-5 border-b">Liste des produits commandes</h3>
      
      <div class="grid grid-cols-3 gap-5">
        @foreach ($commande->commandeProducts as $item)
          <div class="mt-3 flex">
            @if($item->product->image)
              <div class="w-28 h-40 overflow-hidden relative">
                <img width="100" class=" absolute object-cover h-auto w-full"  src="{{ asset('/storage/'.$item->product->image) }}" alt="">
              </div>
            @else
            <img width="100"  src="{{ asset('/static/img/product.png') }}" alt="">
            @endif
            
            <div class="ml-3">
              <h2 class="text-2xl font-bold underline "><a href="{{ route('products.show',$item->product->id) }}">{{ ucfirst($item->product->nom) }}</a></h2>
              <h2 class="text-lg">Prix unitaire : <span class="text-primary font-bold {{ $item->prix_de_vente !== $item->product->prix_unitaire  ? 'line-through':''  }}">{{ $item->product->prix_unitaire }} F</span></h2>
              <h2 class="text-lg">Type vente : <span class="px-4 py-0.5 bg-orange-100 text-orange-400 text-sm">{{ ['PIECE' => $item->product->type_approvionement, 'DETAIL' => 'Détail'][$item->type_de_vente] }}</span></h2>
              @if ($item->prix_de_vente !== $item->product->prix_unitaire)
                <h2 class="text-lg">Prix unitaire de vente : <span class="text-primary font-bold">{{ $item->prix_de_vente }} F</span></h2>
              @endif
              <h2 class="text-xl font-bold">Quantité commander : {{ $item->qte }} </h2>
            </div>
          </div>
        @endforeach
      </div>
      

    </div>
  </div>

  <div id="popup-facture" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full" style="z-index: 1000">
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-facture">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6 text-center">
                  <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"> Choisissez le type de client <span class="mot"></span> ?</h3>
                  <a target="_blank" data-modal-toggle="popup-facture" href="{{ route('commandes.facture',$commande) }}?declare=true" type="submit" type="button" class="text-white bg-primary focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Client déclaré
                  </a>
                  <a target="_blank" data-modal-toggle="popup-facture" href="{{ route('commandes.facture',$commande) }}" type="submit" type="button" class="text-white bg-primary focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Client non déclaré
                  </a>
              </div>
          </div>
      </div>
  </div>

  <div id="popup-facture2" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full" style="z-index: 1000">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-facture2">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"> Choisissez le type de client <span class="mot"></span> ?</h3>
                <a target="_blank" data-modal-toggle="popup-facture2" href="{{ route('commandes.facture',$commande) }}/?payer=true&declare=true"  type="submit" type="button" class="text-white bg-primary focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                  Client déclaré
                </a>
                <a target="_blank" data-modal-toggle="popup-facture2" href="{{ route('commandes.facture',$commande) }}/?payer=true" type="submit" type="button" class="text-white bg-primary focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                  Client non déclaré
                </a>
            </div>
        </div>
    </div>
</div>

</x-app-layout>