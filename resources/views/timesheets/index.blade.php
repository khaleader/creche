@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des emplois du temps
                </header>
                <div class="liste_actions">
                    <div class="chk-all">
                        <div class="pull-left mail-checkbox ">
                            <input type="checkbox" class="">
                        </div>

                        <div class="btn-group">
                            <a data-toggle="dropdown" href="#" class="btn mini all">
                                Tous

                            </a>

                        </div>
                    </div>


                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Actions
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                            <li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li>
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier par branche
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#">Littéraire</a></li>
                            <li><a href="#">Sciences</a></li>
                        </ul>
                    </div>



                </div>


                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$tsheets->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$tsheets->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Classe</th>
                            <th>Branche</th>
                            <th></th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tsheets as $ts)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td>{{ $ts->nom_classe }}</td>
                            <td>{{ $ts->branche }}</td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>
                            <td><a href="{{ action('TimesheetsController@edit',[$ts]) }}">
                                    <div  class="btn_details">Détails</div></a></td>

                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>


@endsection