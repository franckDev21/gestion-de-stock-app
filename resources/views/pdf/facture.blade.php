<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <style>
        *{
            font-family: sans-serif;
        }

        .title{
            background-color: gray;
            text-align: right;
            padding: .6rem 1rem;
            margin: 0;
            text-transform: uppercase;
        }

        .title span{
            color: #fff;
        }

        .title-2{
            background-color: rgba(128, 128, 128, 0.297);
            text-align: left;
            padding: .6rem 1rem;
            margin: 0;
            text-transform: uppercase;
        }

        .line{
            text-align: right;
            padding: .6rem 1rem;
            margin: 0;
        }

        .bold{
            font-weight: bold;
        }

        .mb-3{
            margin-bottom: 1rem;
        }

        table{
            border-collapse: collapse;
            border: 1px solid gray;
            width: 100%;
            text-align: left ;
            margin-top: 1rem;
        }

        tr,td,th{
            border: 1px solid gray;
            text-align: left;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <x-header-doc :declare="$clientDeclare ?? false" />

    <h3 class='text-center title'><span>Facture</span> | {{ now() }}</h3>
    <h3 class='text-center title-2'><span>Commande #</span> {{ $commande->reference }} </h3>

    <div class="line">
        <span>Nom du client : <span class="bold"> {{ $commande->client->firstname }} {{ $commande->client->lastname }}</span></span>
    </div>

    <div class="line">
        <span>Email : <span class="bold"> {{ $commande->client->email }} </span></span>
    </div>

    <div class="line">
        <span>Tél : <span class="bold"> {{ $commande->client->tel }} </span></span>
    </div>
    
    @php
        $total =  $commande->cout;
    @endphp

    <table>
        <thead>
            <th>Nom du produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>total</th>
        </thead>
        <tbody>
            @foreach ($commandes as $commande)
                <tr>
                    <td class="bold">{{ ucfirst($commande->product->nom) }}</td>
                    <td>{{ $commande->qte }}</td>
                    <td>{{ $commande->prix_de_vente !== $commande->product->prix_unitaire ? $commande->prix_de_vente : $commande->product->prix_unitaire }}</td>
                    <td>{{ $commande->qte * (int)implode('',explode('.',$commande->prix_de_vente !== $commande->product->prix_unitaire ? $commande->prix_de_vente : $commande->product->prix_unitaire)) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right">Total</th>
                <th>{{ $total}} F</th>
            </tr>
        </tfoot>
    </table>

</body>

</html>
