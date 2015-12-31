@extends('layouts.default')


@section('content')


    <div class="row">
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@monthly_absence') }}">
                        <div class="bloc_statistique"><img src="images/pointages.png" ><span class="count">{{$count_absence }}</span><p>Cas d'absence ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">{{ $count_abs_normale }}</span><p>Normales</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">{{  $count_abs_maladie }}</span><p>Maladies</p>
                            </div>

                        </div>
                    </a>

                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@new_subscribers') }}">
                        <div class="bloc_statistique"><img src="images/inscription.png" ><span class="count">{{ $ns_number }}</span><p>Nouvelles inscriptions ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">{{ $garcons }}</span><p>Garçons</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">{{ $filles }}</span><p>Filles</p>
                            </div>
                        </div>
                    </a>


                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@monthly_bills') }}">
                        <div class="bloc_statistique"><img src="images/factures.png" ><span class="count">{{ $count_bills }}</span><p>Factures générées ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">46</span><p>Réglées</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">37</span><p>Non réglées</p>
                            </div>

                        </div>
                    </a>


                </div>
            </section>
        </div>


    </div>
    <div class="row">
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="factures statistiques.html">
                        <div class="bloc_statistique"><img src="images/statistiques.png" ><span class="count">5000 </span><p>Dhs total estimé ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">3200 </span><p>Dhs encaissé</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">1800 </span><p>Dhs qui reste</p>
                            </div>

                        </div>
                    </a>

                </div>
            </section>
        </div>


    </div>








@endsection