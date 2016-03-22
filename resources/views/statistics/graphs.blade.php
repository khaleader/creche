@extends('layouts.default')

@section('css')
    <style>




    </style>
    @stop
@section('content')

   <!-- <div class="row">
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
    </div> -->



    <!-- Radar factures -->
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                  Les inscriptions en {{ Carbon\Carbon::now()->year }}
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">

                        <canvas id="line-chart-js" height="50px" ></canvas>


                    </div>



                </div>
            </section>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Les Cas de pointages par nombres mensuel
                    <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">

                        <canvas id="bar-chart-js" height="50px" ></canvas>


                    </div>



                </div>
            </section>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                   Les Cas de pointages par nombres annuel
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">


                        <canvas  id="pie-chart-js" height="90px" ></canvas>

                    </div>



                </div>
            </section>
        </div>
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    Statistiques des heures de pointages annuel
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">
                        <canvas id="donut-chart-js"  height="90px" ></canvas>



                    </div>

                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                   La somme des factures Réglées Et Non Réglées Par Mois
                    <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">

                        <canvas id="radar-chart-js"  height="90px"></canvas>


                    </div>



                </div>
            </section>
        </div>

    </div>



<?php
$countJust='';
$countNonjust = '';
$countRet = '';
?>

@endsection

@section('jquery')
    <script src="{{ asset('js\chart-js\Chart.min.js') }}"></script>

    <script>


        var dataPie = [
            {
                value: '{{ json_encode(\Auth::user()->attendances()
                  ->whereRaw('EXTRACT(year from start) = ?', [Carbon\Carbon::now()->year])
                ->where('title','Maladie')->count())  }}',
                color:"#D9434E",
                highlight: "#d1575f",
                label: "Non Justifié"
            },
            {
                value: '{{ json_encode(\Auth::user()->attendances()
                   ->whereRaw('EXTRACT(year from start) = ?', [Carbon\Carbon::now()->year])
                ->where('title','Normal')->count())  }}',
                color: "#84E07B",
                highlight: "#96d88f",
                label: "Justifié"
            },
            {
                value: '{{ json_encode(\Auth::user()->attendances()
                   ->whereRaw('EXTRACT(year from start) = ?', [Carbon\Carbon::now()->year])
                ->where('title','Retard')->count())  }}',
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Retard"
            }
        ];
        // heures de pontages
        var dataDoughnut = [
            {
                value:
               @foreach(\Auth::user()->attendances as $att)

                        @if($att->title == 'Normal')
                        <?php $countJust +=  \Carbon\Carbon::parse($att->start)->diffInHours($att->end) ?>
                         @endif

                @endforeach
            '{{  $countJust }}',
                color: "#84E07B",
                highlight: "#96d88f",
                label: "Justifié"
            },{
                value:
                @foreach(\Auth::user()->attendances as $att)

                   @if($att->title == 'Maladie')
                   <?php $countNonjust +=  \Carbon\Carbon::parse($att->start)->diffInHours($att->end)  ?>
                    @endif

           @endforeach
       '{{  $countNonjust }}',
                color: "#D9434E",
                highlight: "#d1575f",
                label: "Non Justifié"
            },{
                value:
                @foreach(\Auth::user()->attendances as $att)

                   @if($att->title == 'Retard')
                   <?php $countRet +=\Carbon\Carbon::parse($att->start)->diffInHours($att->end)  ?>
                    @endif

           @endforeach
       '{{  $countRet }}',
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Retard"
            }
        ];

        //inscriptions anuelle
        var dataLine = {
            labels: ["Janvier", "Février", "Mars",
                 "Avril", "Mai", "Juin", "Juillet",
                    'Aout','Septembre','Octobre','Novembre','Décembre'
            ],
            datasets: [
                {
                    label: "Les Inscriptions",
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [
                   @for($i =1;$i<=12;$i++)
                    {{
                           json_encode(\Auth::user()->children()->
        whereRaw('EXTRACT(month from created_at) = ?', [$i])
        ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
        ->count()).','
                      }}
                      @endfor
                      ]
                }

            ]
        };

           // pointages mensuelle
        var dataBar = {
            labels: ["Janvier", "Février", "Mars",
                "Avril", "Mai", "Juin", "Juillet",
                'Aout','Septembre','Octobre','Novembre','Décembre'
            ],
            datasets: [
                {
                    label: "Justifié",
                    fillColor: "#84E07B",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "#84E07B",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        @for($i =1;$i<=12;$i++)
                        {{
                            json_encode(\Auth::user()->attendances()->where('title','Normal')
                     ->whereRaw('EXTRACT(month from start) = ?', [$i])
                     ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                    ->count()).','
                          }}
                          @endfor
                        ]
                },
                {
                    label: "Non Justifié",
                    fillColor: "#D9434E",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "#84E07B",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        @for($i =1;$i<=12;$i++)
                        {{
                            json_encode(\Auth::user()->attendances()->where('title','Maladie')
                     ->whereRaw('EXTRACT(month from start) = ?', [$i])
                     ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                    ->count()).','
                          }}
                          @endfor
                        ]
                },
                {
                    label: "Retard",
                    fillColor: "#46BFBD",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "#84E07B",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        @for($i =1;$i<=12;$i++)
                        {{
                            json_encode(\Auth::user()->attendances()->where('title','Retard')
                     ->whereRaw('EXTRACT(month from start) = ?', [$i])
                     ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                    ->count()).','
                          }}
                          @endfor
                        ]
                }
            ]
        };

          // radar

        var dataRadar = {

            labels: ["Janvier", "Février", "Mars",
                "Avril", "Mai", "Juin", "Juillet",
                'Aout','Septembre','Octobre','Novembre','Décembre'
            ],
            datasets: [
                {
                    label: "Somme des Factures Non Payés",
                    fillColor: "#D9434E",
                    strokeColor: "#D9434E",
                    pointColor: "#D9434E",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data:
                    [
                        @for($i =1;$i<=12;$i++)
                              {{
                                     preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()->
                  whereRaw('EXTRACT(month from start) = ?', [$i])
                  ->whereRaw('EXTRACT(year from start)= ?',[\Carbon\Carbon::now()->year])
                  ->where('status',0)
                  ->sum("somme"))).','
                                }}
                                @endfor

                    ]
    },
    {
        label: "Somme des Factures payés",
        fillColor: "#84E07B",
        strokeColor: "#84E07B",
        pointColor: "#84E07B",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: [
            @for($i =1;$i<=12;$i++)
                {{
                       preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()->
    whereRaw('EXTRACT(month from start) = ?', [$i])
    ->whereRaw('EXTRACT(year from start)= ?',[\Carbon\Carbon::now()->year])
    ->where('status',1)
    ->sum("somme"))).','
                  }}
                  @endfor
]
    }
]
};

var options ={
responsive:true,
// maintainAspectRatio: true
}

var pie = document.getElementById("pie-chart-js").getContext("2d");
var donut =  document.getElementById("donut-chart-js").getContext("2d");
var line =  document.getElementById("line-chart-js").getContext("2d");
var bar =  document.getElementById("bar-chart-js").getContext("2d");
var radar =  document.getElementById("radar-chart-js").getContext("2d");



new Chart(line).Line(dataLine,options);
new Chart(pie).Pie(dataPie,options);
new Chart(donut).Doughnut(dataDoughnut,options);
new Chart(bar).Bar(dataBar,options);
new Chart(radar).Radar(dataRadar,options);


</script>

@stop