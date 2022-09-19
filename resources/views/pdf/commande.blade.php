<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <style>
        * {
            font-family: sans-serif;
        }

        .title {
            background-color: gray;
            text-align: right;
            padding: .6rem 1rem;
            margin: 0;
            text-transform: uppercase;
        }

        .title span {
            color: #fff;
        }

        .title-2 {
            background-color: rgba(128, 128, 128, 0.297);
            text-align: left;
            padding: .6rem 1rem;
            margin: 0;
            text-transform: uppercase;
        }

        .line {
            text-align: left;
            padding: .6rem 1rem;
            margin: 0;
        }

        .bold {
            font-weight: bold;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        table {
            border-collapse: collapse;
            border: 1px solid gray;
            width: 100%;
            text-align: left;
            margin-top: 1rem;
        }

        tr,
        td,
        th {
            border: 1px solid gray;
            text-align: left;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <x-header-doc />

    <h3 class='text-center title'><span>Liste des commandes</span> | {{ now() }}</h3>

    <div class="bg-white shadow-md rounded-md overflow-hidden mt-2 mb-6">
        @unless(count($commandes) !== 0)
            <div class="p-10 rounded-md bg-white text-3xl text-center font-bold text-primary opacity-80">
                <i class="fa-solid  fa-box-open text-gray-400 text-8xl mb-3"></i> <br>

                @if (request('search'))
                    Aucun resultat ne correspond votre rechercher <br>
                    <span class="text-secondary my-2 inline-block">" {{ request('search') }} "</span>
                @else
                    Aucune commande
                @endif

            </div>
        @else
            <table class="min-w-full w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-4 text-left">quantite produits</th>
                        <th class="py-3 px-4 text-left">coût</th>
                        <th class="py-3 px-4 text-left">etat</th>
                        <th class="py-3 px-4 text-left">client</th>
                        <th class="py-3 px-4 text-left">date Création</th>
                        <th class="py-3 px-4 text-left">autheur</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($commandes as $commande)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-4 text-left">
                                <span>{{ $commande->quantite }} Unité(s)</span>
                            </td>

                            <td class="py-3 px-4 text-left">
                                <span class="px-1 font-semibold">{{ $commande->cout }} F</span>
                            </td>

                            <td class="py-1 px-4 text-left">
                                <span
                                    class="{{ $commande->etat === 'PAYER' || $commande->etat === 'FACTURER' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }} py-1 px-3 rounded-full text-xs">{{ $commande->etat }}</span>
                            </td>

                            <td class="py-3 px-4 text-left flex flex-col justify-start items-start">
                                <span class="font-bold">{{ $commande->client->firstname }}
                                    {{ $commande->client->lastname }}</span>
                                <span
                                    class="py-1 scrollbar-none max-w-[150px] overflow-x-scroll">{{ $commande->client->email }}</span>
                            </td>

                            <td class="py-3 px-4 text-left">
                                {{ $commande->created_at->format('d M Y à h\h:i') }}
                            </td>

                            <td class="py-3 px-4 text-left">
                                {{ $commande->user->firstname }} {{ $commande->user->lastname }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endunless
    </div>

</body>

</html>
