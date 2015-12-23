@extends('layouts.default')



@section('content')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">

                    <div class="nom">
                                <span>{{ $ecole->name }}</span>
                    </div>


                </div>

            </section>
            <section class="panel">
                <a href="historique factures.html">
                    <div class="panel-body paimenent_fiche_enfant">
                        <i class="fa fa-money"></i><span>Paiement effectué</span>
                    </div></a>
            </section>


        </div>
        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a href=""><div class="btn_supprimer">Supprimer</div></a>
                    <a href=""><div class="btn_archiver">Archiver</div></a>
                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>
                            <td><i class="fa fa-male"></i></td>
                            <td><span><strong>Nom du résponsable :</strong> {{ $ecole->nom_responsable }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-phone"></i></td>
                            <td><span><strong>Numéro fixe :</strong> {{ $ecole->tel_fixe }}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-mobile"></i></td>
                            <td><span><strong>Numéro portable :</strong> {{ $ecole->tel_portable }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-envelope"></i></td>
                            <td><span><strong>Email :</strong>  {{ $ecole->email }}</span></td>
                        </tr>

                        <tr>
                            <td><i class="fa fa-map-marker"></i></td>
                            <td><span><strong>Adresse :</strong>  {{ $ecole->adresse }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-map-marker"></i></td>
                            <td><span><strong>Ville :</strong>  {{ $ecole->ville }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-map-marker"></i></td>
                            <td><span><strong>Pays :</strong>  {{ $ecole->pays }} </span></td>
                        </tr>
                        </tbody>


                    </table>
                    </div>
            </section>
        </div>
    </div>






    @endsection