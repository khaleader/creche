@extends('layouts.default')


@section('content')


<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                {{ $count }} Factures générées ce mois

            </header>
            <div class="liste_actions">
                <span>Trier par :</span>
                <div class="btn-group hidden-phone">
                    <a data-toggle="dropdown" href="#" class="btn mini blue">
                        Statut
                        <i class="fa fa-angle-down "></i>
                    </a>
                    <ul class="dropdown-menu menu_actions">
                        <li><a id="status-regler" href="#">Réglées</a></li>
                        <li><a id="status-non-regler" href="#">Non Réglées</a></li>
                    </ul>
                </div>
                <div class="btn-group hidden-phone">
                    <a data-toggle="dropdown" href="#" class="btn mini blue">
                        Mois
                        <i class="fa fa-angle-down "></i>
                    </a>
                    <ul class="dropdown-menu menu_actions bill-months">
                        <li><a valeur="9" href="#">Septembre</a></li>
                        <li><a  valeur="10" href="#">Octobre</a></li>
                        <li><a valeur="11" href="#">Novembre</a></li>
                        <li><a valeur="12" href="#">Decembre</a></li>
                        <li><a valeur="1" href="#">Janvier</a></li>
                        <li><a valeur="2" href="#">Février</a></li>
                        <li><a valeur="3" href="#">Mars</a></li>
                        <li><a valeur="4" href="#">Avril</a></li>
                        <li><a valeur="5" href="#">Mai</a></li>
                        <li><a valeur="6" href="#">Juin</a></li>
                    </ul>
                </div>



            </div>

            <ul class="unstyled inbox-pagination liste_arrow">

                <li>
                    <a class="np-btn" href="{{  str_replace('/?','?',$bills->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                </li>
                <li>
                    <a class="np-btn" href="{{   str_replace('/?','?',$bills->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                </li>
            </ul>
            <div class="panel-body">
                <table class="table  table-hover general-table table_enfants">
                    <thead>
                    <tr>
                        <th>N° Facture</th>
                        <th></th>
                        <th> Nom complet</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($bills as $bill)
                        @unless($bill->child->deleted_at)
                            <tr>
                                <td>{{  $bill->id  }}</td>
                                <td><img class="avatar" src="{{  $bill->child->photo ? asset('uploads/'.$bill->child->photo):asset('images/avatar4.jpg') }}"></td>
                                <td>{{ $bill->child->nom_enfant  }}</td>
                                <td>{{  $bill->start->format('d-m-Y') }}</td>
                                <td>{{  $bill->somme  }} Dhs</td>
                                <td><span class="label {{  $bill->status == 0 ? 'label-danger': 'label-success'  }}  label-mini">
                                   {{  $bill->status == 0 ? 'Non réglée': 'réglée' }} </span>
                                </td>
                                <td>
                                    <a  href="{{--  action('BillsController@delete',[$bill->id]) --}}" class="actions_icons delete-bill">
                                        <i class="fa fa-trash-o liste_icons"></i></a>
                                    <a class="archive-bill" href="{{--  action('BillsController@archive',[$bill->id]) --}}"><i class="fa fa-archive liste_icons"></i>
                                    </a>
                                </td>

                                <td><a href="{{  action('BillsController@details',[$bill->id]) }}"><div  class="btn_details">Détails</div></a></td>
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

@section('jquery')
    <script>
        $(function(){
            $('.bill-months a').click(function(){
                $('tbody').empty();

                var month =$(this).attr('valeur');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@monthindex')}}',
                    data: 'month=' + month +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });

            $('#status-regler').click(function(){
                $('tbody').empty();
                var status = 1;
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@statusindex')}}',
                    data: 'status=' + status + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });
            $('#status-non-regler').click(function(){
                $('tbody').empty();
                var status =0;
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@statusindex')}}',
                    data: 'status=' + status  +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });



        });



    </script>

@stop