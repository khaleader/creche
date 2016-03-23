@extends('layouts.default')

@section('css')
    <style>




    </style>
    @stop
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
<li><a data-year="2015,2016" href="{{ action('StatisticsController@graphs',['2015/2016']) }}">2015-2016</a></li>
<li><a data-year="2016,2017" href="{{ action('StatisticsController@graphs',['2016/2017']) }}">2016-2017</a></li>
<li><a data-year="2017,2018" href="{{ action('StatisticsController@graphs',['2017/2018']) }}">2017-2018</a></li>
<li><a data-year="2018,2019" href="{{ action('StatisticsController@graphs',['2018/2019']) }}">2018-2019</a></li>
<li><a data-year="2019,2020" href="{{ action('StatisticsController@graphs',['2019/2020']) }}">2019-2020</a></li>
<li><a data-year="2020,2021" href="{{ action('StatisticsController@graphs',['2020/2021']) }}">2020-2021</a></li>
<li><a data-year="2021,2022" href="{{ action('StatisticsController@graphs',['2021/2022']) }}">2021-2022</a></li>
<li><a data-year="2022,2023" href="{{ action('StatisticsController@graphs',['2022/2023']) }}">2022-2023</a></li>
<li><a data-year="2023,2024" href="{{ action('StatisticsController@graphs',['2023/2024']) }}">2023-2024</a></li>

                            </ul>
                        </div>

                    </div>
                    <div style="float: right">
                        <strong style="font-size: 15px;text-transform: capitalize">
                            @if(isset($year1) && isset($year2))
                                {{  $year1.'-'.$year2 }}
                            @endif
                        </strong>



                    </div>
                </div>

            </section>
        </div>
    </div>



    <!-- Radar factures -->
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    LES INSCRIPTIONS pour l'année scolaire 2015/2016
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
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
                    Rapport sur les absences par mois
                    <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
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
                    Rapport sur les absences par type
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">


                        <canvas  id="pie-chart-js" width="612" height="262px" ></canvas>

                    </div>



                </div>
            </section>
        </div>
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    Rapport sur les factures
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                         </span>
                </header>
                <div class="panel-body">


                    <div class="chartJS">
                        <canvas id="donut-chart-js" width="612"  height="262px" ></canvas>



                    </div>

                </div>
            </section>
        </div>
    </div>






@endsection

@section('jquery')
    <script src="{{ asset('js\chart-js\Chart.min.js') }}"></script>

    <script>


        var dataPie = [
            {
                value:
                     @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                  {{ json_encode(\Auth::user()->attendances()
                    ->whereIn(DB::raw('MONTH(start)'),[9,10,11,12])
                     ->whereIn(DB::raw('YEAR(start)'),[$year1])
                ->where('title','Maladie')->count()) +   json_encode(\Auth::user()->attendances()
                     ->whereIn(DB::raw('MONTH(start)'),[1,2,3,4,5,6,7,8])
                     ->whereIn(DB::raw('YEAR(start)'),[$year2])
                ->where('title','Maladie')->count()) }}

                @else
                  {{ json_encode(\Auth::user()->attendances()
                  ->whereYear('start','=', [\Carbon\Carbon::now()->year])
                ->where('title','Maladie')->count())  }}
                     @endif
,
                color:"#D9434E",
                highlight: "#d1575f",
                label: "Non Justifié"
            },
            {
                value:
                        @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                 {{ json_encode(\Auth::user()->attendances()
                    ->whereIn(DB::raw('MONTH(start)'),[9,10,11,12])
                     ->whereIn(DB::raw('YEAR(start)'),[$year1])
                ->where('title','Normal')->count()) +   json_encode(\Auth::user()->attendances()
                     ->whereIn(DB::raw('MONTH(start)'),[1,2,3,4,5,6,7,8])
                     ->whereIn(DB::raw('YEAR(start)'),[$year2])
                ->where('title','Normal')->count()) }}

                @else
                {{ json_encode(\Auth::user()->attendances()
                  ->whereYear('start','=', [\Carbon\Carbon::now()->year])
                ->where('title','Normal')->count())  }}
                @endif
,
                color: "#84E07B",
                highlight: "#96d88f",
                label: "Justifié"
            },
            {
                value:
                        @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
               {{ json_encode(\Auth::user()->attendances()
                    ->whereIn(DB::raw('MONTH(start)'),[9,10,11,12])
                     ->whereIn(DB::raw('YEAR(start)'),[$year1])
                ->where('title','Retard')->count()) +   json_encode(\Auth::user()->attendances()
                     ->whereIn(DB::raw('MONTH(start)'),[1,2,3,4,5,6,7,8])
                     ->whereIn(DB::raw('YEAR(start)'),[$year2])
                ->where('title','Retard')->count()) }}

                @else
                       {{ json_encode(\Auth::user()->attendances()
                  ->whereYear('start','=',[\Carbon\Carbon::now()->year])
                ->where('title','Retard')->count())  }}
                @endif
                ,
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Retard"
            }
        ];
        // heures de pontages
        var dataDoughnut = [
            {
                value:
                  @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                      {{
                            preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()
                             ->whereIn(DB::raw('MONTH(start)'),[9,10,11,12])
                           ->whereIn(DB::raw('YEAR(start)'),[$year1])
                            ->where('status',0)
                            ->sum("somme"))) +    preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()
                             ->whereIn(DB::raw('MONTH(start)'),[1,2,3,4,5,6,7,8])
                           ->whereIn(DB::raw('YEAR(start)'),[$year2])
                            ->where('status',0)
                            ->sum("somme")))
                                         }}
                  @else

                   '{{
                  preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()
                  ->whereYear('start','=',[\Carbon\Carbon::now()->year])
                  ->where('status',0)
                  ->sum("somme")))
                               }}'


                @endif

                ,

                color: "#D9434E",
                highlight: "#d1575f",
                label: "Somme des Factures Non Réglées En DH"
            },{
                value:
                        @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                                 {{
                            preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()
                             ->whereIn(DB::raw('MONTH(start)'),[9,10,11,12])
                           ->whereIn(DB::raw('YEAR(start)'),[$year1])
                            ->where('status',1)
                            ->sum("somme"))) +    preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()
                             ->whereIn(DB::raw('MONTH(start)'),[1,2,3,4,5,6,7,8])
                           ->whereIn(DB::raw('YEAR(start)'),[$year2])
                            ->where('status',1)
                            ->sum("somme")))
                                         }},
                            @else

                             '{{
                  preg_replace("/[^a-zA-Z0-9_.-\s]/", "",json_encode(\Auth::user()->bills()
                  ->whereYear('start','=',[\Carbon\Carbon::now()->year])
                  ->where('status',1)
                  ->sum("somme")))
                               }}'
,
                @endif
                color: "#84E07B",
                highlight: "#96d88f",
                label: "Somme des Factures Réglées En DH"
            }
        ];

        //inscriptions anuelle
        var dataLine = {
            labels: ['Septembre','Octobre','Novembre','Décembre',
                "Janvier", "Février", "Mars",
                 "Avril", "Mai", "Juin", "Juillet",
                    'Aout'
            ],
            datasets: [
                {
                    label: "Les Inscriptions",
                    fillColor: "rgba(37, 119, 181,0.3)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#0B62A4",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [
                     @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                              @for($i =9;$i<=12;$i++)
                          {{   json_encode(\Auth::user()->children()
                            ->whereRaw('EXTRACT(month from created_at)= ?',[$i])
                              ->whereRaw('EXTRACT(year from created_at)= ?',[$year1])
                               ->count()).',' }}
                               @endfor
                                    @for($i = 1;$i<=8;$i++)
                         {{   json_encode(\Auth::user()->children()->
                           whereRaw('EXTRACT(month from created_at) = ?', [$i])
                 ->whereRaw('EXTRACT(year from created_at)= ?',[$year2])
                      ->count()).',' }}

                     @endfor
                     @else
                   @for($i =9;$i<=12;$i++)
                           {{   json_encode(\Auth::user()->children()->
        whereRaw('EXTRACT(month from created_at) = ?', [$i])
        ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
        ->count()).',' }}
                    @endfor
                    @for($i = 1;$i<=8;$i++)
                         {{   json_encode(\Auth::user()->children()->
        whereRaw('EXTRACT(month from created_at) = ?', [$i])
        ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
        ->count()).',' }}

                     @endfor
                     @endif

                      ]
                }

            ]
        };

           // pointages mensuelle
        var dataBar = {
            labels: ['Septembre','Octobre','Novembre','Décembre',
                "Janvier", "Février", "Mars",
                "Avril", "Mai", "Juin", "Juillet",
                'Aout',
            ],
            datasets: [
                {
                    label: "Justifié",
                    fillColor: "#84E07B",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "#84E07B",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                              @for($i =9;$i<=12;$i++)
                       {{
                           json_encode(\Auth::user()->attendances()->where('title','Normal')
                    ->whereRaw('EXTRACT(month from start) = ?', [$i])
                    ->whereRaw('EXTRACT(year from created_at)= ?',[$year1])
                   ->count()).','
                         }}
                         @endfor
                           @for($i =1;$i<=8;$i++)
                       {{
                           json_encode(\Auth::user()->attendances()->where('title','Normal')
                    ->whereRaw('EXTRACT(month from start) = ?', [$i])
                    ->whereRaw('EXTRACT(year from created_at)= ?',[$year2])
                   ->count()).','
                         }}
                         @endfor
                        @else

                    @for($i =9;$i<=12;$i++)
                       {{
                           json_encode(\Auth::user()->attendances()->where('title','Normal')
                    ->whereRaw('EXTRACT(month from start) = ?', [$i])
                    ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                   ->count()).','
                         }}
                         @endfor
                           @for($i =1;$i<=8;$i++)
                       {{
                           json_encode(\Auth::user()->attendances()->where('title','Normal')
                    ->whereRaw('EXTRACT(month from start) = ?', [$i])
                    ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                   ->count()).','
                         }}
                         @endfor
                         @endif
                       ]
                },
                {
                    label: "Non Justifié",
                    fillColor: "#D9434E",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "#84E07B",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                                 @for($i =9;$i<=12;$i++)
                          {{
                              json_encode(\Auth::user()->attendances()->where('title','Maladie')
                       ->whereRaw('EXTRACT(month from start) = ?', [$i])
                       ->whereRaw('EXTRACT(year from created_at)= ?',[$year1])
                      ->count()).','
                            }}
                            @endfor
                              @for($i =1;$i<=8;$i++)
                          {{
                              json_encode(\Auth::user()->attendances()->where('title','Maladie')
                       ->whereRaw('EXTRACT(month from start) = ?', [$i])
                       ->whereRaw('EXTRACT(year from created_at)= ?',[$year2])
                      ->count()).','
                            }}
                            @endfor
                           @else

                       @for($i =9;$i<=12;$i++)
                          {{
                              json_encode(\Auth::user()->attendances()->where('title','Maladie')
                       ->whereRaw('EXTRACT(month from start) = ?', [$i])
                       ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                      ->count()).','
                            }}
                            @endfor
                              @for($i =1;$i<=8;$i++)
                          {{
                              json_encode(\Auth::user()->attendances()->where('title','Maladie')
                       ->whereRaw('EXTRACT(month from start) = ?', [$i])
                       ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
                      ->count()).','
                            }}
                            @endfor
                            @endif


                           ]
                },
                {
                    label: "Retard",
                    fillColor: "#46BFBD",
                    strokeColor: "rgba(220,220,220,0.8)",
                    highlightFill: "#84E07B",
                    highlightStroke: "rgba(220,220,220,1)",
                    data: [
                        @if(isset($year1) &&  !is_null($year1) && isset($year2) && !is_null($year2))
                          @for($i =9;$i<=12;$i++)
                   {{
                       json_encode(\Auth::user()->attendances()->where('title','Retard')
                ->whereRaw('EXTRACT(month from start) = ?', [$i])
                ->whereRaw('EXTRACT(year from created_at)= ?',[$year1])
               ->count()).','
                     }}
                     @endfor
                       @for($i =1;$i<=8;$i++)
                   {{
                       json_encode(\Auth::user()->attendances()->where('title','Retard')
                ->whereRaw('EXTRACT(month from start) = ?', [$i])
                ->whereRaw('EXTRACT(year from created_at)= ?',[$year2])
               ->count()).','
                     }}
                     @endfor
                    @else

                @for($i =9;$i<=12;$i++)
                   {{
                       json_encode(\Auth::user()->attendances()->where('title','Retard')
                ->whereRaw('EXTRACT(month from start) = ?', [$i])
                ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
               ->count()).','
                     }}
                     @endfor
                       @for($i =1;$i<=8;$i++)
                   {{
                       json_encode(\Auth::user()->attendances()->where('title','Retard')
                ->whereRaw('EXTRACT(month from start) = ?', [$i])
                ->whereRaw('EXTRACT(year from created_at)= ?',[\Carbon\Carbon::now()->year])
               ->count()).','
                     }}
                     @endfor
                     @endif
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
//var radar =  document.getElementById("radar-chart-js").getContext("2d");



new Chart(line).Line(dataLine,options);
new Chart(pie).Pie(dataPie,options);
new Chart(donut).Doughnut(dataDoughnut,options);
new Chart(bar).Bar(dataBar,options);
//new Chart(radar).Radar(dataRadar,options);





        $('#years-statistics > li > a').click(function(){
            var annee_scolaire =$(this).attr('data-year');

        });

</script>

@stop