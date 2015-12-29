@extends('layouts.default')


@section('content')


<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                83 Factures générées ce mois

            </header>
            <div class="liste_actions">
                <span>Trier par :</span>
                <div class="btn-group hidden-phone">
                    <a data-toggle="dropdown" href="#" class="btn mini blue">
                        Statut
                        <i class="fa fa-angle-down "></i>
                    </a>
                    <ul class="dropdown-menu menu_actions">
                        <li><a href="#">Réglées</a></li>
                        <li><a href="#">Non Réglées</a></li>
                    </ul>
                </div>
                <div class="btn-group hidden-phone">
                    <a data-toggle="dropdown" href="#" class="btn mini blue">
                        Mois
                        <i class="fa fa-angle-down "></i>
                    </a>
                    <ul class="dropdown-menu menu_actions">
                        <li><a href="#">Janvier</a></li>
                        <li><a href="#">Féverier</a></li>
                        <li><a href="#">Mars</a></li>
                        <li><a href="#">Avril</a></li>
                        <li><a href="#">Mai</a></li>
                        <li><a href="#">Juin</a></li>
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
                    <tr>
                        <td>A0001</td>
                        <td><img class="avatar" src="images/avatar1.jpg"></td>
                        <td>Amine Daoudi</td>
                        <td>15-09-2015 </td>
                        <td>250 Dhs</td>
                        <td><span class="label label-success label-mini">réglée</span></td>
                        <td>
                            <a href="#" class="actions_icons">
                                <i class="fa fa-trash-o liste_icons"></i></a>
                            <a href="#"><i class="fa fa-archive liste_icons"></i>
                            </a>
                        </td>

                        <td><a href="facture détails.html"><div  class="btn_details">Détails</div></a></td>
                    </tr>
                    <tr>
                        <td>A0002</td>
                        <td><img class="avatar" src="images/avatar2.jpg"></td>
                        <td>Salma briki</td>
                        <td>15-09-2015 </td>
                        <td>300 Dhs</td>
                        <td><span class="label label-success label-mini">Réglée</span></td>
                        <td>
                            <a href="#" class="actions_icons">
                                <i class="fa fa-trash-o liste_icons"></i></a>
                            <a href="#"><i class="fa fa-archive liste_icons"></i>
                            </a>
                        </td>

                        <td><a href="Fiche enfant.html"><div  class="btn_details">Détails</div></a></td>
                    </tr>
                    <tr>
                        <td>A0003</td>
                        <td><img class="avatar" src="images/avatar3.jpg"></td>
                        <td>karim mrini</td>
                        <td>15-09-2015 </td>
                        <td>250 Dhs</td>
                        <td><span class="label label-success label-mini">Réglée</span></td>
                        <td>
                            <a href="#" class="actions_icons">
                                <i class="fa fa-trash-o liste_icons"></i></a>
                            <a href="#"><i class="fa fa-archive liste_icons"></i>
                            </a>
                        </td>

                        <td><a href=""><div  class="btn_details">Détails</div></a></td>
                    </tr>
                    <tr>
                        <td>A0004</td>
                        <td><img class="avatar" src="images/avatar4.jpg"></td>
                        <td>Jihad ismaili</td>
                        <td>15-09-2015 </td>
                        <td>250 Dhs</td>
                        <td><span class="label label-success label-mini">Réglée</span></td>
                        <td>
                            <a href="#" class="actions_icons">
                                <i class="fa fa-trash-o liste_icons"></i></a>
                            <a href="#"><i class="fa fa-archive liste_icons"></i>
                            </a>
                        </td>

                        <td><a href=""><div  class="btn_details">Détails</div></a></td>
                    </tr>
                    <tr>
                        <td>A0005</td>
                        <td><img class="avatar" src="images/avatar3.jpg"></td>
                        <td>Othman zitouni</td>
                        <td>15-09-2015 </td>
                        <td>250 Dhs</td>
                        <td><span class="label label-danger label-mini">Non réglée</span></td>
                        <td>
                            <a href="#" class="actions_icons">
                                <i class="fa fa-trash-o liste_icons"></i></a>
                            <a href="#"><i class="fa fa-archive liste_icons"></i>
                            </a>
                        </td>

                        <td><a href=""><div  class="btn_details">Détails</div></a></td>
                    </tr>
                    <tr>
                        <td>A0006</td>
                        <td><img class="avatar" src="images/avatar2.jpg"></td>
                        <td>Hind souadi</td>
                        <td>15-09-2015 </td>
                        <td>250 Dhs</td>
                        <td><span class="label label-success label-mini">Réglée</span></td>
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