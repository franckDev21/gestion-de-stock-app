<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-start">
          <h2 class="font-semibold text-xl text-gray-600 leading-tight">
              {{ __('Gestion des produits') }}
          </h2>
          <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

          <h2 class="font-semibold text-xl text-primary leading-tight">
              {{ __('Ajouter un nouveau produit') }}
          </h2>
      </div>
  </x-slot>

  <div class="max-w-4xl px-6 py-4 mt-4 bg-white mx-auto  rounded-md">
    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <div class="flex">
          <div class="w-40 h-40 bg-gray-100 mr-2"></div>
          <div class="ml-2 w-[calc(100%-10rem)]">
          {{-- 
            
            
          --}}
            <div></div>

            Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum ipsam molestias mollitia voluptatum error earum sapiente, vel at explicabo consectetur porro inventore similique dolore, eius unde nobis? Veniam, aperiam perferendis?
          </div>
        </div>
    </form>
  </div>

</x-app-layout>