<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-1">
                <x-label for="lastname" :value="__('Nom de l\'utilisateur')" />
                <div class="flex">
                    <div class="mt-1 w-1/2 mr-1 ">
                        <x-input placeholder='Entrer son nom' id="lastname" class="w-full" type="text" name="lastname" :value="old('lastname')" required autofocus />
                        @error('lastname')
                        <span class="text-sm text-red-400 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-1 w-1/2 ml-1">
                        <x-input placeholder='Entrer son prénom' id="firstname" class="w-full" type="text" name="firstname" :value="old('firstname')" required />
                        @error('firstname')
                        <span class="text-sm text-red-400 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
            <!-- Email Address -->
            <div class="">
                <x-label for="email" :value="__('Email de l\'utilisateur ')" />

                <x-input id="email" placeholder="Entrer l'addresse mail de l'utilisateur"  class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                @error('email')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>

            <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
            <!-- Email Address -->
            <div class="">
                <x-label for="tel" :value="__('Téléphone ')" class="inline" /> <span class="italic text-sm text-gray-400">( facutatif )</span>

                <x-input id="tel" placeholder="Entrer numéro de téléphone de l'utilisateur"  class="block mt-1 w-full" type="tel" name="tel" :value="old('tel')" required />
                @error('tel')
                    <span class="text-sm text-red-400 block">{{ $message }}</span>
                @enderror
            </div>
            
            <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
            <!-- Password -->
            <div class="">
                <x-label for="password" :value="__('Mot de passe de l\'utilisateur')" />

                <div class="relative eye-input">
                    <x-input placeholder="Mot de passe" id="password" class="block mt-1 w-full"
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
                    <x-input placeholder="Confirmation du mot de passe" id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
                    <i class="fa-solid absolute top-1/2 -translate-y-1/2 opacity-50 cursor-pointer right-2 fa-eye"></i>
                </div>
            </div>

            <span class="w-full h-[1px] bg-gray-50 inline-block my-0.5"></span>
            <div class="flex items-center justify-start cursor-pointer">
                <input type="checkbox" name="active" id="active" class="accent-primary rounded text-primary w-6 h-6 mr-2">
                <label for="active">Voulez vous directement activer l'utilisateur ?</label>
            </div>

            <div class="flex items-center justify-center mt-5">
                {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a> --}}

                <x-button class="w-full text-center flex justify-center items-center">
                    {{ __('Enregistrer l\'utilisateur ') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
