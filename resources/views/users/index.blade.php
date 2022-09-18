<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Gestion des utilisateurs') }}
            </h2>
            <form class="w-2/3 flex" method="GET">
                <div class="relative w-[90%]">
                    <x-input class="w-full" placeholder='Réchercher un utilisateur ...' type="text" name="search"
                        :value="request('search')" required autofocus />
                    <i class="fa-solid fa-magnifying-glass absolute top-1/2 -translate-y-1/2 right-4 text-gray-500"></i>
                </div>
                <x-button class="ml-3">
                    {{ __('Rechercher') }}
                </x-button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
        <div class="flex items-center justify-start  mt-6">
            <a 
                target="_blank"
                href="{{ route('printUsers') }}"
                class="mr-4 px-6 py-1 shadow-md rounded-md bg-gray-500 border-4 hover:bg-gray-600 transition border-gray-600 text-white">
                <i class="fa-solid fa-download mr-3"></i> Imprimer la liste des utilisateurs
            </a>
            <a
                href="{{ route('users.create') }}"
                class="px-6 py-1 mr-4 shadow-md rounded-md bg-green-500 border-4 hover:bg-green-600 transition border-green-600 text-white">
                <i class="fa-solid fa-user-plus mr-3"></i> Ajouter un nouvel utilisateur
            </a>

            @if (request('search'))
                <a href="{{ route('users.index') }}"
                    class="px-6 py-1 shadow-md rounded-md bg-white bg-opacity-80 border-4 border-white ">
                    <i class="fa-solid fa-arrows-rotate"></i> Réactualiser
                </a>
            @endif

        </div>
        <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6">
            @unless(count($users) !== 0)
                @if (request('search'))
                <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80"> 
                    <i class="fa-solid fa-folder-open text-gray-400 text-8xl mb-3"></i> <br>
                    Aucun utilisateur ne correspond votre recherche <br>
                    <span class="text-secondary my-2 inline-block">" {{ request('search') }} "</span>
                </div>
                @else
                <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80"> 
                    <i class="fa-solid fa-folder-open text-gray-400 text-8xl mb-3"></i> <br>
                    Aucun utilisateur <br>
                </div>
                @endif
                
            @else
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nom & prenom</th>
                            <th class="py-3 px-6 text-left">Date d'ajout</th>
                            <th class="py-3 px-6 text-left">role</th>
                            <th class="py-3 px-6 text-left">Téléphone</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Activer/Desactiver</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-2 h-10 w-10 flex justify-center items-center bg-gray-100 rounded-full">
                                            @if ($user->photo)
                                                <img class=" h-10 w-10 rounded-full" src="{{ asset("storage/$user->photo") }}" alt="image">
                                            @else
                                                <i class="fa-solid text-2xl text-gray-400  fa-user"></i>
                                            @endif
                                        </div>
                                        <div class="flex items-start flex-col justify-start">
                                            <span class="font-bold">{{ ucfirst($user->lastname) }} {{ ucfirst($user->firstname) }}</span>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3 px-6 text-left">
                                    <span>{{ $user->created_at->format('d M Y') }}</span>
                                </td>

                                <td class="py-3 px-6 text-left">
                                    <span>{{ $user->role ? 'Utilisateur' : 'Administateur' }}</span>
                                </td>

                                <td class="py-1 px-6 text-left">
                                    {{ $user->tel }}
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <span
                                    class="{{ $user->active ? 'text-green-600 bg-green-200 ' : 'text-red-600 bg-red-200 ' }} py-1 px-3 rounded-full text-xs">{{ $user->active ? 'Actif' : 'Inactif' }}</span>
                                </td>

                                <td class="py-3 px-14 text-center">
                                    @if ($user->active )
                                        <span data-id="{{ $user->id }}"  data-modal-toggle="popup-active" data-mot="désactiver" class="bg-green-400 w-10 cursor-pointer shadow-lg flex rounded-full justify-end items-start active-btn">
                                            <span class="p-3 rounded-full bg-white"></span>
                                        </span>
                                    @else
                                        <span data-id="{{ $user->id }}" data-mot="activer" data-modal-toggle="popup-active" class="bg-red-400 w-10 cursor-pointer shadow-lg flex rounded-full justify-start items-start active-btn">
                                            <span class="p-3 rounded-full bg-white"></span>
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('users.show',$user->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('users.edit',$user->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <div data-id="{{ $user->id }}" data-mot="{{ $user->lastname.' '.$user->firstname }}"  data-modal-toggle="popup-delete" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110 delete-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endunless
        </div>
        {{ $users->links() }}
    </div>

    <form method="POST" action="" id="popup-active" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full" style="z-index: 1000">
        @csrf
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-active">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Voulez vous <span class="mot">mot</span> cet utilisateur ?</h3>
                    <button type="submit" data-modal-toggle="popup-active" type="button" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Confirmer
                    </button>
                    <button data-modal-toggle="popup-active" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
                </div>
            </div>
        </div>
    </form>

    <form method="POST" action="" id="popup-delete" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full" style="z-index: 1000">
        @csrf
        @method('DELETE')
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-delete">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Voulez vous vraiment supprimer l'utilisateur <span class="mot"></span> ?</h3>
                    <button type="submit" data-modal-toggle="popup-delete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Confirmer
                    </button>
                    <button data-modal-toggle="popup-delete" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
                </div>
            </div>
        </div>
    </form>


    <!-- js -->
    <x-slot name="js">
        
        <script defer>
            // changement d'etat de l'utilisateur
            Array.from(document.querySelectorAll('.active-btn')).forEach(element => {
                const form = document.getElementById('popup-active')
                element.addEventListener('click',e => {
                    form.setAttribute('action',`/users/toggle-active/${e.currentTarget.dataset.id}`)
                    form.querySelector('.mot').textContent = `${e.currentTarget.dataset.mot}`
                })
            })

            // suppression de l'utilisateur
            Array.from(document.querySelectorAll('.delete-btn')).forEach(element => {
                const form = document.getElementById('popup-delete')
                element.addEventListener('click',e => {
                    form.setAttribute('action',`/users/${e.currentTarget.dataset.id}`)
                    form.querySelector('.mot').textContent = `${e.currentTarget.dataset.mot}`
                })
            })
        </script>
    </x-slot>

</x-app-layout>
