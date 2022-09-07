<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-start">
          <h2 class="font-semibold text-xl text-gray-600 leading-tight">
              {{ __('Gestion des clients') }}
          </h2>
          <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

          <h2 class="font-semibold text-xl text-primary leading-tight">
              {{ $client->firstname }} {{ $client->lastname }}
          </h2>
      </div>
  </x-slot>

  <div class="max-w-4xl px-6 py-4 mt-4 bg-white mx-auto  rounded-md">
      <form method="POST" action="{{ route('clients.update',$client->id) }}">
          @csrf
          @method('PATCH')
          <!-- Name -->
          <div class="mb-1">
              <div class="flex">
                  <div class="mt-1 w-1/2 mr-1 ">
                      <x-label for="lastname" :value="__('Nom du client')" />
                      <x-input placeholder='Entrer son nom' id="lastname" class="w-full" type="text"
                          name="lastname" :value="old('lastname',$client->lastname)" required autofocus />
                      @error('lastname')
                          <span class="text-sm text-red-400 block">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="mt-1 w-1/2 ml-1">
                      <x-label for="lastname" :value="__('Prénom du client')" />
                      <x-input placeholder='Entrer son prénom' id="firstname" class="w-full" type="text"
                          name="firstname" :value="old('firstname',$client->firstname)" required />
                      @error('firstname')
                          <span class="text-sm text-red-400 block">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
          </div>

          <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
          
          <div class="mr-1 ">
            <x-label for="email" class="inline" :value="__('Email du client ')" /> <span class="italic text-sm text-gray-400">( facutatif )</span>

            <x-input id="email" placeholder="Entrer l'addresse mail du client" class="block w-full"
                type="email" name="email" :value="old('email',$client->email)"  />
            @error('email')
                <span class="text-sm text-red-400 block">{{ $message }}</span>
            @enderror
          </div>

          <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>

          <div class="ml-1">
            <x-label for="tel" :value="__('Téléphone ')" class="inline" /> <span
                  class="italic text-sm text-gray-400">(
                  facutatif )</span>

            <x-input id="tel" placeholder="Entrer numéro de téléphone du client"
                class="block w-full  mt-1" type="tel" name="tel" :value="old('tel',$client->tel)" />
            @error('tel')
                <span class="text-sm text-red-400 block">{{ $message }}</span>
            @enderror
          </div>

          <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>

          <div class="ml-1">
            <x-label for="tel" :value="__('Adresse ')" class="inline" /> <span class="italic text-sm text-gray-400">( facutatif )</span>

            <x-input id="address" placeholder="Adresse" class="block w-full mt-1" type="text" name="address" :value="old('address',$client->address)"  />
            @error('address')
                <span class="text-sm text-red-400 block">{{ $message }}</span>
            @enderror
          </div>

          <div class="flex items-center justify-end mt-5">

              <x-button class="text-center flex justify-center items-center">
                  {{ __('Mettre à jour le client ') }}
              </x-button>
          </div>
      </form>
  </div>

</x-app-layout>
