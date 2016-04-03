@extends('layouts.default')




@section('content')


    <div class="row">
        <div class="col-sm-12">

            <section class="panel">

                <header class="panel-heading">
                    Historique de factures pour : <span> <strong>{{  $child->nom_enfant }}</strong> </span>

                </header>



                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <!-- <th>Actions</th>-->
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($child->bills as $bills)
                            @unless($bills->deleted_at)
                                <tr>
                                    <td>{{ $bills->id }}</td>
                                    <td>{{  $bills->start->format('d-m-Y') }} </td>
                                    <td>{{ $bills->somme }},00 Dhs</td>
                                    <td><span class="label {{ $bills->status == 0 ? 'label-danger' : 'label-success'  }} label-mini">
                                   {{ $bills->status == 0 ? 'Non Réglée ' : 'Réglée'  }}   </span>
                                    </td>
                                    <!--   <td>
                                <a  href="{{--  action('BillsController@delete',[$bills->id]) --}}" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="{{--  action('BillsController@archive',[$bills->id]) --}}"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                                    <td><a href="{{ action('BillsController@details',[$bills->id]) }}"><div  class="btn_details">Détails</div></a></td>
                                </tr>
                            @endunless
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

@endsection
