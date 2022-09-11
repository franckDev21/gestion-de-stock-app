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
          <x-button class="bg-green-600 bg-opacity-90">Facturer et payer la commande</x-button>
          <x-button class="bg-opacity-90">Facturer le client</x-button>
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
              <h2 class="text-xl">Prix unitaire : <span class="text-primary font-bold">{{ $item->product->prix_unitaire }} F</span></h2>
              <h2 class="text-xl font-bold">Quantité commander : {{ $item->qte }} </h2>
            </div>
          </div>
        @endforeach
      </div>
      

    </div>
  </div>

</x-app-layout>