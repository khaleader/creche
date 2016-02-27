@extends('layouts.default')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <section class="panel bloc_setting">
                <div class="panel-body">
                    <div class="liste_setting">
                        <div class="btn-group hidden-phone">
                            <a data-toggle="dropdown" href="#" class="btn mini blue">
                                Trier par année
                                <i class="fa fa-angle-down "></i>
                            </a>
                            <ul class="dropdown-menu menu_actions" id="years-statistics">
                                <li><a data-year="2015" href="#">2015</a></li>
                                <li><a data-year="2016" href="#">2016</a></li>
                                <li><a data-year="2017" href="#">2017</a></li>
                                <li><a data-year="2018" href="#">2018</a></li>
                                <li><a data-year="2019" href="#">2019</a></li>
                                <li><a data-year="2020" href="#">2020</a></li>
                                <li><a data-year="2021" href="#">2021</a></li>
                                <li><a data-year="2022" href="#">2022</a></li>
                                <li><a data-year="2023" href="#">2023</a></li>

                            </ul>
                        </div>
                        <div class="btn-group hidden-phone">
                            <a data-toggle="dropdown" href="#" class="btn mini blue">
                                Mois
                                <i class="fa fa-angle-down "></i>
                            </a>
                            <ul class="dropdown-menu menu_actions" id="months-statistics">
                                <li><a data-month="1" href="#">Janvier</a></li>
                                <li><a data-month="2" href="#">Février</a></li>
                                <li><a data-month="3" href="#">Mars</a></li>
                                <li><a data-month="4" href="#">Avril</a></li>
                                <li><a data-month="5" href="#">Mai</a></li>
                                <li><a data-month="6" href="#">Juin</a></li>
                                <li><a data-month="7" href="#">Juillet</a></li>
                                <li><a data-month="8" href="#">Aout</a></li>
                                <li><a data-month="9" href="#">Septembre</a></li>
                                <li><a data-month="10" href="#">Octobre</a></li>
                                <li><a data-month="11" href="#">Novembre</a></li>
                                <li><a data-month="12" href="#">Décembre</a></li>
                            </ul>
                        </div>
                    </div>
                    <div style="float: right">
                        <strong style="font-size: 15px;text-transform: capitalize" id="show-month"></strong>
                        <strong style="font-size: 15px" id="show-year"></strong>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <div class="row partie-up">
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@monthly_absence',
                    [\Carbon\Carbon::now()->year,\Carbon\Carbon::now()->month]) }}">
                        <div class="bloc_statistique"><img src="images/pointages.png" ><span class="count">{{$count_absence }}</span><p>Cas d'absence ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">{{ $count_abs_normale }}</span><p>Justifiées</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">{{  $count_abs_maladie }}</span><p>Non Justifiées</p>
                            </div>

                        </div>
                    </a>

                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@new_subscribers', [\Carbon\Carbon::now()->year,\Carbon\Carbon::now()->month]) }}">
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
                    <a href="{{ action('StatisticsController@monthly_bills',  [\Carbon\Carbon::now()->year,\Carbon\Carbon::now()->month]) }}">
                        <div class="bloc_statistique"><img src="images/factures.png" ><span class="count">{{ $count_bills }}</span><p>Factures générées ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">{{  $regled_bills }}</span><p>Réglées</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">{{ $non_regled_bills }}</span><p>Non réglées</p>
                            </div>

                        </div>
                    </a>


                </div>
            </section>
        </div>


    </div>
    <div class="row partie-down">
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="#">
                        <div class="bloc_statistique"><img src="images/statistiques.png" ><span class="count">{{ $somme }} </span><p>Dhs total estimé ce mois</p></div>
                        <div class="bloc_statistique_details">
                            <div class="bloc_statistique_d1">
                                <span class="count">{{ $encaisse }} </span><p>Dhs encaissé</p>
                            </div>
                            <div class="bloc_statistique_d2">
                                <span class="count">{{ $reste }} </span><p>Dhs qui reste</p>
                            </div>

                        </div>
                    </a>

                </div>
            </section>
        </div>
    </div>

@endsection

@section('jquery')
    <script>
        $(document).ready(function(){
           $('#months-statistics li').hide();
             var year, month, monthtext;
            $('#years-statistics > li > a').click(function(){
              year =  $(this).attr('data-year');
                $('#months-statistics li').show();

            });

            $('#months-statistics > li > a ').click(function(){
                 month =  $(this).attr('data-month');
                 monthtext = $(this).text();
                $('#show-month').text(' '+ monthtext + ' ');
                $('#show-year').text(year);

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('StatisticsController@getYearAndMonth')}}',
                    data: 'month=' + month  + '&monthtext=' + monthtext + '&year='+ year + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('.partie-up').empty();
                        $('.partie-down').empty();
                         $('section.wrapper').append(data);
                    }
                });


            });


        });


    </script>





@endsection










