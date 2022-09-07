<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des utilisateurs') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

            <h2 class="font-semibold text-xl text-primary leading-tight">
                {{ __('Edition de l\'utilisateur') }} <span class="text-secondary">{{ $user->firstname }}
                    {{ $user->lastname }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl px-6 py-4 mt-4 bg-white mx-auto  rounded-md">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf

            <!-- Name -->
            <div class="mb-1 flex justify-between">
                <div class="w-40 h-40 bg-gray-100"></div>
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
                        <span class="font-bold text-xl mr-2 text-primary">Addresse Email </span> :
                        <div class="ml-2">{{ $user->email }}</div>
                    </div>

                    <div class="mt-1justify-between flex items-center text-xl text-gray-500">
                        <span class="font-bold text-xl mr-2 text-primary">Téléphone </span> :
                        <div class="ml-2">{{ $user->tel }}</div>
                    </div>
                </div>
            </div>


        </form>
    </div>

</x-app-layout>
