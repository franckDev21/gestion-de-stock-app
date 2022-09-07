<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des utilisateurs') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

            <h2 class="font-semibold text-xl text-primary leading-tight">
                {{ __('Ajouter un nouvel utilisateur') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl px-6 py-4 mt-4 bg-white mx-auto  rounded-md">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <!-- Name -->
            <div class="mb-1">
                <div class="flex">
                    <div class="mt-1 w-1/2 mr-1 ">
                        <x-label for="lastname" :value="__('Nom de l\'utilisateur')" />
                        <x-input placeholder='Entrer son nom' id="lastname" class="w-full" type="text"
                            name="lastname" :value="old('lastname')" required autofocus />
                        @error('lastname')
                            <span class="text-sm text-red-400 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-1 w-1/2 ml-1">
                        <x-label for="lastname" :value="__('Prénom de l\'utilisateur')" />
                        <x-input placeholder='Entrer son prénom' id="firstname" class="w-full" type="text"
                            name="firstname" :value="old('firstname')" required />
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
                        type="email" name="email" :value="old('email')" required />
                    @error('email')
                        <span class="text-sm text-red-400 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-1 w-1/2 ml-1">
                    <x-label for="tel" :value="__('Téléphone ')" class="inline" /> <span
                        class="italic text-sm text-gray-400">(
                        facutatif )</span>

                    <x-input id="tel" placeholder="Entrer numéro de téléphone de l'utilisateur"
                        class="block w-full" type="tel" name="tel" :value="old('tel')" required />
                    @error('tel')
                        <span class="text-sm text-red-400 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
            <!-- Password -->
            <div class="flex">
                <div class="mt-1 w-1/2 mr-1">
                    <x-label for="password" :value="__('Mot de passe de l\'utilisateur')" />

                    <div class="relative eye-input">
                        <x-input placeholder="Mot de passe" id="password" class="block mt-1 w-full" type="password"
                            name="password" required autocomplete="new-password" />
                        <i
                            class="fa-solid absolute top-1/2 -translate-y-1/2 opacity-50 cursor-pointer right-2 fa-eye"></i>
                    </div>
                    @error('password')
                        <span class="text-sm text-red-400 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-1 w-1/2 ml-1">
                    <x-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

                    <div class="relative eye-input">
                        <x-input placeholder="Confirmation du mot de passe" id="password_confirmation"
                            class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        <i
                            class="fa-solid absolute top-1/2 -translate-y-1/2 opacity-50 cursor-pointer right-2 fa-eye"></i>
                    </div>
                </div>
            </div>

            <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
            <div class="flex items-center justify-start cursor-pointer">
                <input type="checkbox" name="active" id="active"
                    class="accent-primary rounded text-primary w-6 h-6 mr-2">
                <label for="active" class="text-gray-500 cursor-pointer">Voulez vous directement activer l'utilisateur ?</label>
            </div>

            <div class="flex items-center justify-end mt-5">

                <x-button class="text-center flex justify-center items-center">
                    {{ __('Enregistrer le nouvel utilisateur ') }}
                </x-button>
            </div>
        </form>
    </div>

</x-app-layout>
