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

  <div class="max-w-5xl px-6 pb-4 pt-8 mt-4 bg-white mx-auto  rounded-md">
    @if(Session::has('errors'))
        <div x-data="{show: true}" x-init="setTimeout(() => show = false, 10000)" x-show="show" class="p-4 mb-2 bg-red-100 text-center text-red-500 font-bold">{{Session::get('errors')->first()}}</div>
    @endif
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="flex">
          <label for="photo" class="w-1/3 bg-gray-100 mr-2 relative after:w-full after:h-full after:bg-slate-600 after:bg-opacity-30 after:absolute after:z-10 after:opacity-0 hover:after:opacity-100 after:transition cursor-pointer">
            <img id="image" class="absolute w-full h-full object-cover" src="{{ asset('static/img/product.png') }}" alt="product">
            @error('image')
            <span class="text-sm text-red-400 block">{{ $message }}</span>
            @enderror
          </label>
          <input hidden class="hidden" type="file" accept="image/*" name="image" id="photo">
          <div class="w-2/3 ml-2">
            <x-label for="nom" :value="__('Description du produit')" class="inline-block" /> <span class="text-gray-400 text-xs italic inline-block ml-1">(Facultatif)</span>
            <textarea name="description" placeholder="Entrer la description du produit ici … " class="w-full placeholder:italic rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="" cols="30" rows="6"></textarea>
        </div>
        </div>
        <div class="mt-2">
          <div class="flex pb-3 ">
            <div class="mt-1 w-1/2 mr-1 ">
                <x-label for="nom" :value="__('Nom du produit')" class="inline-block" />
                <x-input placeholder='Entrer le nom du produit' id="nom" class="w-full placeholder:italic" type="text"
                    name="nom" :value="old('nom')" required autofocus />
                @error('nom')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-1 w-1/2 ml-1">
                <x-label for="prix_unitaire" :value="__('Prix unitaire')" class="inline-block" /> <span class="text-gray-400 text-xs italic inline-block mx-1">(En FCFA)</span>
                <x-input placeholder='le produit coûte combien ?' id="prix_unitaire" class="w-full placeholder:italic" type="number"
                    name="prix_unitaire" :value="old('prix_unitaire')" required />
                @error('prix_unitaire')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
          </div>

          <div class="flex mt-2 pb-3 ">
            <div class="mt-1 w-1/2 mr-1 ">
                <x-label for="qte_stock_alert" :value="__('Quantité stock d\'alert')" class="inline-block" />
                <x-input placeholder="stock d'alerte" id="qte_stock_alert" class="w-full placeholder:italic" type="number"
                    name="qte_stock_alert" :value="old('qte_stock_alert')" required  />
                @error('qte_stock_alert')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-1 w-1/2 ml-1">
                <x-label for="type_approvionement" :value="__('Type d\'approvionnement ')" class="inline-block" /> <span class="text-gray-400 text-xs italic inline-block ml-1">(NB: séparer chaque type par une virgule)</span>
                <x-input placeholder='Vous-vous approvionner en ...(Carton,Bidon)' id="type_approvionement" class="w-full placeholder:italic" type="text"
                    name="type_approvionement" :value="old('type_approvionement')"  />

                @error('type_approvionement')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
          </div>

          <div class="flex mt-2 pb-3 ">
            <div class="mt-1 w-1/2 mr-1 ">
                <x-label for="category_id" :value="__('Catégorie')" class="inline-block" />
                <select name="category_id" required class="w-full placeholder:italic rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="">
                  @foreach ($categories as $item )
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
                @error('category_id')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-1 w-1/2 ml-1">
                <x-label for="type_approvionement" :value="__('Choisissez votre fournisseur')" class="inline-block" />
                <select name="fournisseur_id" required class="w-full placeholder:italic rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="">
                  @foreach ($fournisseurs as $item )
                      <option value="{{ $item->id }}">{{ $item->nom }}</option>
                  @endforeach
                </select>
                @error('type_approvionement')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
          </div>
          
          <div class="my-3">
            <x-button>Enregistrer le produit</x-button>
          </div>
        </div> 
    </form>
  </div>

  <!-- js -->
  <x-slot name="js">
        
    <script defer>
        document.getElementById('photo').addEventListener('change', e => {
          if(e.target.files.length === 0){
            document.getElementById('image').src = '/static/img/product.png'
            return
          }
          let file = e.target.files[0]
          let url  = URL.createObjectURL(file)
          document.getElementById('image').src = url
        })
    </script>
  </x-slot>

</x-app-layout>