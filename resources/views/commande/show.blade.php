<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-between">
          <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des commandes') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>
  
            <h2 class="font-semibold text-xl text-primary leading-tight">
                Commande #{{ $commande->reference }} | {{ $commande->client->firstname }}{{ $commande->client->lastname }}
            </h2>
          </div>
          
      </div>
  </x-slot>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
    <div class="bg-white text-gray-500 min-h-[450px] px-6 py-5 rounded-md mt-5">
      <div class="flex pb-4 border-b justify-between">
        <h1 class="text-2xl font-bold">Total prix : <span class="text-primary">{{ $commande->cout }} F</span></h1>
        <div>
          <a href="{{ route('commandes.facture',$commande) }}/?payer=true" class="inline-flex items-center px-4 py-2 bg-green-600 bg-opacity-70 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Facturer et payer la commande</a>
          <a href="{{ route('commandes.facture',$commande) }}" class="inline-flex items-center px-4 py-2 bg-primary bg-opacity-70 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-100 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Facturer le client</a>
        </div>
      </div>

      <h3 class="text-2xl font-bold mt-5 border-b">Liste des produits commandes</h3>
      
      <div class="grid grid-cols-3 gap-5">
        @foreach ($commande->commandeProducts as $item)
          <div class="mt-3 flex">
            @if($item->product->image)
              <img width="100"  src="{{ asset('/storage/'.$item->product->image) }}" alt="">
            @else
            <img width="100"  src="{{ asset('/static/img/product.png') }}" alt="">
            @endif
            
            <div class="ml-3">
              <h2 class="text-2xl font-bold ">{{ ucfirst($item->product->nom) }}</h2>
              <h2 class="text-xl">Prix unitaire : <span class="text-primary font-bold {{ $item->prix_de_vente !== $item->product->prix_unitaire  ? 'line-through':''  }}">{{ $item->product->prix_unitaire }} F</span></h2>
              @if ($item->prix_de_vente !== $item->product->prix_unitaire)
                <h2 class="text-xl">Prix de vente : <span class="text-primary font-bold">{{ $item->prix_de_vente }} F</span></h2>
              @endif
              <h2 class="text-xl font-bold">Quantité commander : {{ $item->qte }} </h2>
            </div>
          </div>
        @endforeach
      </div>
      

    </div>
  </div>

</x-app-layout>