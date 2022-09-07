<x-app-layout>
  <x-slot name="header">
      <div class="flex items-center justify-start">
          <h2 class="font-semibold text-xl text-primary leading-tight">
              {{ __('Mon profil') }}
              <span class="h-4 w-0.5 bg-gray-600 mx-2 inline-block"></span>
               <span class="text-secondary">{{ $user->firstname }}
                  {{ $user->lastname }}</span>
          </h2>
      </div>
  </x-slot>

  <div x-cloak x-data="{ open: {{ $errors->any() ? 'true':'false'  }}}" class="max-w-4xl px-6 pb-4 pt-6 mt-4 bg-white mx-auto  rounded-md relative">

    <a @click="open = !open" href="#" title="Editer l'utilisateur" class=" absolute top-2 right-2 cursor-pointer hover:bg-opacity-100 hover:text-white text-primary px-4 py-0.5 ml-3 flex-none flex justify-center items-center rounded-md bg-primary bg-opacity-30" >
        <span x-show="!open"><i class="fa-solid text-sm fa-pen mr-2"></i> Modifier mes informations</span>
        <span x-show="open">Fermer le formulaire</span>
    </a>

    <h2 class="text-2xl font-bold text-gray-600 mb-4 mt-2 block pb-3 border-b ">Bonjour <span class="text-secondary">{{ $user->firstname }} {{ $user->lastname }}</span></h2>

    <form x-show="open" method="POST" action="{{ route('profil.update',$user->id) }}">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="mb-1">
            <div class="flex">
                <div class="mt-1 w-1/2 mr-1 ">
                    <x-label for="lastname" :value="__('Nom de l\'utilisateur')" />
                    <x-input placeholder='Entrer son nom' id="lastname" class="w-full" type="text"
                        name="lastname" :value="old('lastname',$user->lastname)"  autofocus />
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

        <div class="flex items-center justify-start mt-5">

            <x-button class="text-center flex justify-center items-center">
            {{ __('Mettre à jour mes informations ') }}
            </x-button>
        </div>
        <span class="w-full h-[1px] bg-gray-100 inline-block my-1"></span>
    </form>

    <div>
        <!-- Name -->
        <div class="mb-1 flex justify-between">
            <div>
            <div class="w-40 flex justify-center items-center h-40 bg-gray-100 relative">
                @if ($user->photo)
                    <img id="image" class="absolute object-cover w-full h-full" src="{{ asset("/storage/$user->photo") }}" alt="image">
                @else
                    <img id="image" class="absolute object-cover w-full h-full" src="{{ asset("/storage/img/users/default.jpg") }}" alt="image">
                @endif
            </div>
            <form method="POST" action="{{ route('profil.photo') }}" enctype="multipart/form-data" class="flex flex-col">
                @csrf
                @method('POST')
                <input hidden class="hidden" type="file" accept="image/*" name="photo" id="photo">
                @error('photo')
                    <span class="text-sm text-red-400">{{ $message }}</span>
                @enderror
                <div class="w-40">
                    <label for="photo" class="cursor-pointer text-sm text-center inline-block text-white bg-primary bg-opacity-70 hover:bg-opacity-100 active:scale-95 px-4 py-1 rounded w-full mt-2">Modifier ma photo</label>
                    <button type="submit" class="cursor-pointer text-sm text-center inline-block text-white bg-green-600 bg-opacity-90 hover:bg-opacity-100 active:scale-95 px-4 py-1 rounded w-full mt-2">Sauvegarder <i class="ml-2 fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
            
            </div>

            <div class="ml-4 w-[calc(100%-10rem)]">
                <div class="mt-1justify-between flex items-center text-xl text-gray-500 mb-3">
                    <span class="font-bold text-xl mr-2 text-primary">Nom </span> :
                    <div class="ml-2">{{ $user->lastname }}</div>
                </div>

                <div class="mt-1justify-between flex items-center text-xl text-gray-500 mb-3">
                    <span class="font-bold text-xl mr-2 text-primary">Prénom </span> :
                    <div class="ml-2">{{ $user->firstname }}</div>
                </div>

                <div class="mt-1justify-between flex items-center text-xl text-gray-500 mb-3">
                    <span class="font-bold text-xl mr-2 text-primary">Date d'ajout </span> :
                    <div class="ml-2">{{ $user->created_at->format('d M Y') }}</div>
                </div>

                <div class="mt-1justify-between flex items-center text-xl text-gray-500 mb-3">
                    <span class="font-bold text-xl mr-2 text-primary">Addresse Email </span> :
                    <div class="ml-2">{{ $user->email }}</div>
                </div>

                <div class="mt-1justify-between flex items-center text-xl text-gray-500">
                    <span class="font-bold text-xl mr-2 text-primary">Téléphone </span> :
                    <div class="ml-2">{{ $user->tel }}</div>
                </div>

            </div>
        </div>
    </div>
  </div>

  <div x-cloak x-data="{ open: {{ $errors->any() ? 'true':'false'  }}}" class="max-w-4xl px-6 pb-4 pt-6 mt-4 bg-white mx-auto  rounded-md relative">
    <h2 class="text-2xl font-bold text-gray-600 mb-4 mt-2 block pb-3 border-b ">Modifier votre mot de passe</h2>

    <a @click="open = !open" href="#" title="Editer l'utilisateur" class=" absolute top-2 right-2 cursor-pointer hover:bg-opacity-100 hover:text-white text-primary px-4 py-0.5 ml-3 flex-none flex justify-center items-center rounded-md bg-primary bg-opacity-30" >
        <span x-show="!open"><i class="fa-solid text-sm fa-eye mr-2"></i> Afficher</span>
        <span x-show="open">Fermer le formulaire</span>
    </a>

    @if(Session::has('errors'))
        <div x-data="{show: true}" x-init="setTimeout(() => show = false, 10000)" x-show="show" class="p-4 mb-2 bg-red-100 text-center text-red-500 font-bold">{{Session::get('errors')->first()}}</div>
    @endif

    <form x-show="open" action="{{ route('profil.update-password') }}" method="post">
        @csrf
        <!-- Password -->
        <div class="mb-6">
            <x-label for="password" :value="__('Ancien mot de passe de l\'utilisateur')" />

            <div class="relative eye-input">
                <x-input placeholder="Entrer votre ancien mot de passe" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password-old"
                            required autocomplete="new-password" />
                <i class="fa-solid absolute top-1/2 -translate-y-1/2 opacity-50 cursor-pointer right-2 fa-eye"></i>
            </div>
            @error('message')
                <span class="text-sm text-red-400 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="">
            <x-label for="password" :value="__('Nouveau mot de passe')" />

            <div class="relative eye-input">
                <x-input placeholder="Entrer votre nouveau mot de passe" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
                <i class="fa-solid absolute top-1/2 -translate-y-1/2 opacity-50 cursor-pointer right-2 fa-eye"></i>
            </div>
            @error('password')
                <span class="text-sm text-red-400 block">{{ $message }}</span>
            @enderror
        </div>
        
        <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
        <!-- Confirm Password -->
        <div class="">
            <x-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

            <div class="relative eye-input">
                <x-input placeholder="Confirmation du nouveau de mot de passe" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required />
                <i class="fa-solid absolute top-1/2 -translate-y-1/2 opacity-50 cursor-pointer right-2 fa-eye"></i>
            </div>
        </div>

        <x-button class="text-center flex justify-center mt-4 items-center">
        {{ __('Mettre votre mot de passe ') }}
        </x-button>
    </form>
  </div>

  <!-- js -->
  <x-slot name="js">
        
    <script defer>
        document.getElementById('photo').addEventListener('change', e => {
          if(e.target.files.length === 0){
            document.getElementById('image').src = '/storage/img/users/default.jpg'
            return
          }
          let file = e.target.files[0]
          let url  = URL.createObjectURL(file)
          document.getElementById('image').src = url
        })
    </script>
  </x-slot>

</x-app-layout>
