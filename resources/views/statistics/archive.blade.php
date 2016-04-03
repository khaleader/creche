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
                            <ul class="dropdown-menu menu_actions">
                                 <?php $years = \Auth::user()->schoolyears()->where('current',1)->get(); ?>
                                @foreach($years as $year)
                                <li><a href="{{ action('StatisticsController@archive',[str_replace('-','/',$year->ann_scol)]) }}">{{ str_replace('-','/',$year->ann_scol) }}</a></li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="btn-group hidden-phone">
                            <a data-toggle="dropdown" href="#" class="btn mini blue">
                                Trier par classe
                                <i class="fa fa-angle-down "></i>
                            </a>
                            <ul class="dropdown-menu menu_actions">

                                <?php $classes = \Auth::user()->classrooms()->get(); ?>
                                @foreach($classes as $classe)
                                <li><a href="#">{{ $classe->nom_classe }}</a></li>
                                 @endforeach
                            </ul>
                        </div>
                    </div></div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des enfants Archivés
                    <strong>{{ isset($year1) && isset($year2) ? 'En '.$year1.'/'.$year2 : '' }} </strong>

                </header>
                <div class="liste_actions">



                </div>
                <div class="btn-toolbar alphabetical " id="alphabet-list">
                    <div class="btn-group btn-group-sm ">
                        <button class="btn btn-default">A</button>
                        <button class="btn btn-default">B</button>
                        <button class="btn btn-default">C</button>
                        <button class="btn btn-default">D</button>
                        <button class="btn btn-default">E</button>
                        <button class="btn btn-default">F</button>
                        <button class="btn btn-default">G</button>
                        <button class="btn btn-default">H</button>
                        <button class="btn btn-default">I</button>
                        <button class="btn btn-default">J</button>
                        <button class="btn btn-default">K</button>
                        <button class="btn btn-default">L</button>
                        <button class="btn btn-default">M</button>
                        <button class="btn btn-default">N</button>
                        <button class="btn btn-default">O</button>
                        <button class="btn btn-default">P</button>
                        <button class="btn btn-default">Q</button>
                        <button class="btn btn-default">R</button>
                        <button class="btn btn-default">S</button>
                        <button class="btn btn-default">T</button>
                        <button class="btn btn-default">U</button>
                        <button class="btn btn-default">V</button>
                        <button class="btn btn-default">W</button>
                        <button class="btn btn-default">X</button>
                        <button class="btn btn-default">Y</button>
                        <button class="btn btn-default">Z</button>
                    </div>
                </div>
                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$children->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$children->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>

                            <th></th>
                            <th> Nom complet</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Statut de paiement</th>
                            <th>Classe</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($children as $child)
                        <tr>

                            <td>
                                @if(!empty($child->photo))
                                    <img class="avatar" src=" {{ asset('uploads/'.$child->photo)  }}">
                                @else
                                    <img class="avatar" src=" {{ asset('images/'.'avatar4.jpg')  }}">
                                @endif
                            </td>
                            <td>{{ $child->nom_enfant }}</td>
                            <td>{{ \Carbon\Carbon::parse($child->created_at)->format('d-m-Y') }} </td>

                            <?php

                            $counter =  \Auth::user()->bills()->where('child_id',$child->id)->where('status',0)->count(); ?>

                            <td class="paiement">
                                @if(App\Bill::all()->count() == 0)
                                    {{ 'pas de factures'  }}
                                @else
                                    <span class="label {{ $counter == 0 ? 'label-success' : 'label-danger' }} label-mini">
                                    <i class="fa fa-money"></i>
                                </span>
                                @endif

                            </td>
                            <td>
                                @foreach($child->classrooms as $cr)
                                    {{  $cr->nom_classe }}
                                @endforeach
                            </td>
                            <td><a href="{{ action('StatisticsController@show',[$child]) }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        @endforeach



                        </tbody>

                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $children->currentPage() -1) * $children->perPage()  +1  }} à
                            @if((($children->currentPage() -1)  * $children->perPage() + $children->perPage()) > $children->total()  )
                                {{  $children->total() }} sur
                            @else
                                {{ ($children->currentPage() -1)  * $children->perPage() + $children->perPage() }} sur
                            @endif
                            {{ $children->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $children->render() !!}
                        </div>
                    </div>
                </div>
            </section>
        </div>




    </div>


@endsection

@section('jquery')
    <script>
        $(document).ready(function () {
            $('#alphabet-list button').click(function(e){
                $('tbody').empty();
                var sCurrentLetter = $(this).text().toUpperCase();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('StatisticsController@enfbyalph')}}',
                    data: 'caracter=' + sCurrentLetter + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });
        });



    </script>


@stop
