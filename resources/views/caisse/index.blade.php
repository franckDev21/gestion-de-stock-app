<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                    {{ __('Gestion de la caisse') }}
                </h2>

            </div>

            <div>
                <a href="{{ route('caisse.print') }}"
                    class="px-6 py-1 mr-3 shadow-md rounded-md cursor-pointer bg-gray-500 border-4 hover:bg-gray-600 transition border-gray-600 text-white">
                    <i class="fa-solid fa-print text-white mr-2"></i> Imprimerl'état de la caisse
                </a>
                <a data-modal-toggle="sortie"
                    class="px-6 py-1 mr-3 shadow-md rounded-md cursor-pointer bg-red-500 border-4 hover:bg-red-600 transition border-red-600 text-white">
                    <i class="fa-solid fa-minus text-white"></i> Ajouter une sortie en caisse
                </a>
                <a data-modal-toggle="entrer"
                    class="px-6 py-1 mr-3 shadow-md rounded-md cursor-pointer bg-green-500 border-4 hover:bg-green-600 transition border-green-600 text-white">
                    <i class="fa-solid fa-plus"></i> Ajouter une entrée en caisse
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-4 mt-5">
        <span
            class="py-4 mb-2 px-8 border-slate-200 border-8 rounded text-5xl font-bold text-gray-500 bg-slate-50 inline-block">
            <i class="fa-solid fa-sack-dollar"></i> Total : <span
                class="text-primary">{{ number_format($total, 0, ',', '.') }} F</span>
        </span>
        <span class="inline-block w-full h-[1px] bg-slate-100 "></span>

        @unless(count($caisses) !== 0)
            <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80">
                <i class="fa-solid fa-money-bill text-gray-400 text-8xl mb-3"></i> <br>
                Aucune entrée ou sortie en caisse <br>
            </div>
        @else
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Date d'ajout</th>
                        <th class="py-3 px-6 text-left">montant</th>
                        <th class="py-3 px-6 text-left">type</th>
                        <th class="py-3 px-6 text-left">utilisateur</th>
                        <th class="py-3 px-6 text-left">Motif</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 text-sm font-light">
                    @foreach ($caisses as $caisse)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <span>{{ $caisse->created_at->format('d M Y à H\hi') }}</span>
                            </td>

                            <td class="py-3 px-6 text-left">
                                <span class=" font-bold">{{ $caisse->montant }} f</span>
                            </td>

                            <td class="py-3 px-6 text-left">
                                <span>{{ $caisse->type }}</span>
                            </td>

                            <td class="py-3 px-6 text-left">
                                <span>{{ $caisse->user->firstname }} {{ $caisse->user->lastname }}</span>
                            </td>

                            <td class="py-3 px-6 text-left">
                                <span> {{ $caisse->motif }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endunless

        <div class="mt-4">{{ $caisses->links() }}</div>
    </div>


    <x-caisse type="entrer" />
    <x-caisse type="sortie" />


</x-app-layout>
