@extends('layouts.default')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des enfants

                </header>


                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants" id="filterByAlpha">
                        <thead>
                        <tr>

                            <th></th>
                            <th> Nom complet</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Statut de paiement</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(Auth::user()->enfants as $child)

                            <tr id="{{  ucwords($child->nom_enfant) }}">
                                <td><img class="avatar" src=" {{ $child->photo ? asset('uploads/'.$child->photo):'images/avatar4.jpg'  }}"></td>

                                <td>{{  ucwords($child->nom_enfant) }}</td>
                                <td>{{  \Carbon\Carbon::parse($child->created_at)->format('d-m-Y')  }} </td>

                                <?php
                                $counter =  App\Bill::where('child_id',$child->id)->where('status',0)->count();
                                ?>
                                <td><span class="label {{ $counter == 0 ? 'label-success' : 'label-danger' }} label-mini"><i class="fa fa-money"></i></span></td>


                                <td><a href="{{ action('ChildrenController@showef',[$child->id])  }}"><div  class="btn_details">Détails</div></a></td>
                            </tr>
                        @endforeach






                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>





@endsection