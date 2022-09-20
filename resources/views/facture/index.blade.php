<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-start">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                {{ __('Factures factures') }}
            </h2>
            <span class="h-4 w-0.5 bg-gray-600 mx-2"></span>

            <h2 class="font-semibold text-xl text-primary leading-tight">
                {{ __('Informations du client ') }} <span class="text-secondary">
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4">
        <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6">
            @unless(count($factures) !== 0)
                <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80">
                    <i class="fa-solid fa-folder-open text-gray-400 text-8xl mb-3"></i> <br>
                    Aucun client ne correspond votre rechercher <br>
                    <span class="text-secondary my-2 inline-block">" {{ request('search') }} "</span>
                </div>
            @else
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Numéro</th>
                            <th class="py-3 px-6 text-left">Date création</th>
                            <th class="py-3 px-6 text-left">Commande</th>
                            <th class="py-3 px-6 text-left">Client</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($factures as $facture)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <span>N⁰{{ $facture->id }} /{{ date('m / Y') }}</span>
                                </td>

                                <td class="py-3 px-6 text-left">
                                    <span>{{ $facture->created_at->format('d M Y') }}</span>
                                </td>

                                <td class="py-3 px-6 text-left">
                                    <span> <a class="font-semibold underline" href="{{ route('commandes.show',$facture->commande->id) }}">Voir la commade</a> <br> {{ $facture->commande->quantite }} produit(s) commandé(s) <br> par {{ $facture->client->firstname }} {{ $facture->client->lastname }} </span>
                                </td>

                                <td class="py-3 px-6 text-left font-semibold">
                                    <span>{{ $facture->client->firstname }} {{ $facture->client->lastname }}</span>
                                </td>

                                <td class="py-3 text-left">
                                    <div class="flex item-center justify-center">
                                        <a
                                            href="{{ route('factures.show',$facture->id) }}"
                                            class="w-8 h-8 rounded bg-secondary mr-1 transform text-white flex justify-center items-center hover:scale-110">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        <div 
                                            class="w-8 h-8 disabled rounded bg-red-400 mr-1 cursor-pointer transform text-white flex justify-center items-center hover:scale-110 delete-btn">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
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
        {{ $factures->links() }}
    </div>


</x-app-layout>
