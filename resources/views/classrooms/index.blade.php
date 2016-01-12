@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des classes
                    <div class="actions_btn">
                        <ul>
                            <li><a href="{{ action('ClassroomsController@create') }}"><img id="ajouter" src="{{ asset('images/ajouter.png') }}">Ajouter</a></li>
                            <li><a href="#"><img id="exporter" src="{{ asset('images/exporter.png') }}">Exporter</a></li>
                            <li><a href="#"><img id="imprimer" src="{{ asset('images/imprimer.png') }}">Imprimer</a></li>
                            <li><a href="#"><img id="actuel" src="{{ asset('images/actuel.png')  }}">Actuel</a></li>
                            <li><a href="#"><img id="archive" src="{{ asset('images/archive.png')  }}">Archive</a></li>
                        </ul>
                    </div>
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
                        <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>La classe</th>
                            <th>Code classe</th>
                            <th>Capacité de salle</th>
                            <th>Niveau</th>
                            <th>Branche</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td>1ére année littéraire 1</td>
                            <td>1L1</td>
                            <td>35 élèves</td>
                            <td>1ére année Bac</td>
                            <td>Littéraire</td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href=""><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td>1ére année littéraire 1</td>
                            <td>1L1</td>
                            <td>35 élèves</td>
                            <td>1ére année Bac</td>
                            <td>Littéraire</td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href=""><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td>1ére année littéraire 1</td>
                            <td>1L1</td>
                            <td>35 élèves</td>
                            <td>1ére année Bac</td>
                            <td>Littéraire</td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href=""><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td>1ére année littéraire 1</td>
                            <td>1L1</td>
                            <td>35 élèves</td>
                            <td>1ére année Bac</td>
                            <td>Littéraire</td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href=""><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td>1ére année littéraire 1</td>
                            <td>1L1</td>
                            <td>35 élèves</td>
                            <td>1ére année Bac</td>
                            <td>Littéraire</td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href=""><div  class="btn_details">Détails</div></a></td>
                        </tr>





                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>













@endsection