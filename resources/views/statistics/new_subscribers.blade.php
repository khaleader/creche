@extends('layouts.default')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    24 nouvelles inscriptions ce mois

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
                            Trier
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#">Garçons</a></li>
                            <li><a href="#">Filles</a></li>
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
                            <th></th>
                            <th> Nom complet</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Statut de paiement</th>
                            <th>Actions</th>
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
                            <td><img class="avatar" src="images/avatar1.jpg"></td>
                            <td>Amine rihani</td>
                            <td>15-09-2015 </td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></td>
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
                            <td><img class="avatar" src="images/avatar2.jpg"></td>
                            <td>Salma briki</td>
                            <td>15-09-2015 </td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="Fiche enfant.html"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" >

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="images/avatar3.jpg"></td>
                            <td>karim mrini</td>
                            <td>15-09-2015 </td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
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
                            <td><img class="avatar" src="images/avatar4.jpg"></td>
                            <td>Jihad ismaili</td>
                            <td>15-09-2015 </td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
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
                            <td><img class="avatar" src="images/avatar3.jpg"></td>
                            <td>Othman zitouni</td>
                            <td>15-09-2015 </td>
                            <td><span class="label label-danger label-mini"><i class="fa fa-money"></i></span></td>
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
                            <td><img class="avatar" src="images/avatar2.jpg"></td>
                            <td>Hind souadi</td>
                            <td>15-09-2015 </td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
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