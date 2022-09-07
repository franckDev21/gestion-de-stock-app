<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-start">
          <h2 class="font-semibold text-xl text-gray-600 leading-tight">
              {{ __('Gestion des utilisateurs') }}
          </h2>
          <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

          <h2 class="font-semibold text-xl text-primary leading-tight">
              {{ __('Edition de l\'utilisateur') }} <span class="text-secondary">{{ $user->firstname }} {{ $user->lastname }}</span>
          </h2>
      </div>
  </x-slot>

  <div class="max-w-4xl px-6 py-4 mt-4 bg-white mx-auto  rounded-md pt-14 relative">

    <a href="{{ route('users.show',$user) }}" title="Voir l'utilisateur" class=" absolute top-2 right-6 cursor-pointer hover:bg-opacity-100 hover:text-white text-primary w-8 h-8 ml-3 flex-none flex justify-center items-center rounded-full bg-primary bg-opacity-30" >
        <i class="fa-solid text-sm fa-eye "></i>
    </a>

      <form method="POST" action="{{ route('users.update',$user->id) }}">
          @csrf
          @method('PATCH')

          <!-- Name -->
          <div class="mb-1">
              <div class="flex">
                  <div class="mt-1 w-1/2 mr-1 ">
                      <x-label for="lastname" :value="__('Nom de l\'utilisateur')" />
                      <x-input placeholder='Entrer son nom' id="lastname" class="w-full" type="text"
                          name="lastname" :value="old('lastname',$user->lastname)" required autofocus />
                      @error('lastname')
                          <span class="text-sm text-red-400 block">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="mt-1 w-1/2 ml-1">
                      <x-label for="lastname" :value="__('Prénom de l\'utilisateur')" />
                      <x-input placeholder='Entrer son prénom' id="firstname" class="w-full" type="text"
                          name="firstname" :value="old('firstname',$user->firstname)" required />
                      @error('firstname')
                          <span class="text-sm text-red-400 block">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
          </div>

          <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
          <!-- Email Address -->
          <div class="flex">
              <div class="mt-1 w-1/2 mr-1 ">
                  <x-label for="email" :value="__('Email de l\'utilisateur ')" />

                  <x-input id="email" placeholder="Entrer l'addresse mail de l'utilisateur" class="block w-full"
                      type="email" name="email" :value="old('email',$user->email)" required />
                  @error('email')
                      <span class="text-sm text-red-400 block">{{ $message }}</span>
                  @enderror
              </div>

              <div class="mt-1 w-1/2 ml-1">
                  <x-label for="tel" :value="__('Téléphone ')" class="inline" /> <span
                      class="italic text-sm text-gray-400">(
                      facutatif )</span>

                  <x-input id="tel" placeholder="Entrer numéro de téléphone de l'utilisateur"
                      class="block w-full" type="tel" name="tel" :value="old('tel',$user->tel)" required />
                  @error('tel')
                      <span class="text-sm text-red-400 block">{{ $message }}</span>
                  @enderror
              </div>
          </div>

          <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
          <div class="flex items-center justify-start cursor-pointer">
              <input type="checkbox" @checked($user->active) name="active" id="active"
                  class="accent-primary rounded text-primary w-6 h-6 mr-2">
              <label for="active" class="text-gray-500 cursor-pointer">Voulez vous directement activer l'utilisateur ?</label>
          </div>
    
          <div class="flex items-center justify-end mt-5">

              <x-button class="text-center flex justify-center items-center">
                <i class="fa-solid fa-pen mr-2"></i> {{ __('Mettre à jour l\'utilisateur ') }}
              </x-button>
          </div>
      </form>
  </div>

</x-app-layout>
