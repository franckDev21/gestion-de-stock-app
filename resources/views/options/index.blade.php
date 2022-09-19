<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                    {{ __('Options') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">

        <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6 p-4">
            <h3 class="text-2xl text-gray-600 font-semibold flex items-center justify-between">
                <span>Liste des categories</span>
            </h3>
            <table class="min-w-full w-full table-auto mt-4">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">Nom du produit</th>
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($categories as $categorie)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">
                                <span>{{ $categorie->name }}</span>
                            </td>

                            <td class="py-3 px-4 text-left">
                                <span>{{ $categorie->created_at->format('d M Y') }}</span>
                            </td>


                            <td class="py-3 px-4 text-left">
                                <div class="flex">

                                    {{-- <a
                                        class="w-8 h-8 rounded bg-primary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a> --}}

                                    <a href="{{ route('options.categories.delete', $categorie->id) }}"
                                        class="w-8 h-8 rounded bg-red-400 mr-1 cursor-pointer transform text-white flex justify-center items-center hover:scale-110 delete-btn">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('options.categories.store') }}" method="POST" class="border rounded-md p-4 bg-slate-50 bg-opacity-40">
                @csrf
                <div class= items-center justify-between">
                    <x-label>Nom de la catégorie </x-label>
                    <div class="flex">
                        <input name="name" required class="rounded-md inline-block bg-gray-200 px-10 py-2 w-[calc(100%-400px)] shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Entrer le nom de la catégorie ..."  />
                        <x-button type="submit" class="ml-4" >Ajouter une nouvelle catégorie de produit</x-button>
                    </div>
                </div>
            </form>


            <h3 class="text-2xl mt-10 text-gray-600 font-semibold flex items-center justify-between">
                <span>Liste des fournisseurs</span>
            </h3>

            <table class="min-w-full w-full table-auto mt-4">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">Nom du produit</th>
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($fournisseurs as $fournisseur)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">
                                <span>{{ $fournisseur->name }}</span>
                            </td>

                            <td class="py-3 px-4 text-left">
                                <span>{{ $fournisseur->created_at->format('d M Y') }}</span>
                            </td>


                            <td class="py-3 px-4 text-left">
                                <div class="flex">

                                    {{-- <a
                                        class="w-8 h-8 rounded bg-primary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a> --}}

                                    <a href="{{ route('options.fournisseurs.delete', $fournisseur->id) }}"
                                        class="w-8 h-8 rounded bg-red-400 mr-1 cursor-pointer transform text-white flex justify-center items-center hover:scale-110 delete-btn">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form action="{{ route('options.fournisseurs.store') }}" method="POST" class="border rounded-md p-4 bg-slate-50 bg-opacity-40">
                @csrf
                <div class= items-center justify-between">
                    <x-label>Nom du fournisseur </x-label>
                    <div class="flex">
                        <input name="name" required class="rounded-md inline-block bg-gray-200 px-10 py-2 w-[calc(100%-400px)] shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Entrer le nom du fournisseur ..."  />
                        <x-button type="submit" class="ml-4" >Ajouter un nouveau fournisseur</x-button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</x-app-layout>
