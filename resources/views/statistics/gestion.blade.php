@extends('layouts.default')


@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('MattersController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_matieres">
                                <span class="count">{{ $matter_count }}</span>
                            </div>
                            <p>Matières</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('LevelsController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_niveaux">
                                <span class="count">{{ $level_count }}</span>
                            </div>
                            <p>Niveaux</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('BranchesController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_branches">
                                <span class="count">{{ $branch_count }}</span>
                            </div>
                            <p>Branches</p></div>
                    </a></div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('ClassroomsController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_classes">
                                <span class="count">{{ $cr_count }}</span>
                            </div>
                            <p>Classes</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>




    </div>
    <div class="row">
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('RoomsController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_salles">
                                <span class="count">{{ $room_count }}</span>
                            </div>
                            <p>Salles</p>
                        </div></a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('TimesheetsController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/emplois.png') }}" ><p>Emplois du temps</p></div></a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('EducatorsController@index') }}">

                        <div class="bloc_info2"><img src="{{ asset('images/repartitions.png') }}" >
                            <p>Répartition </br>enseignants</p></div>
                    </a>
                </div>
            </section>
        </div>


      <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('BusesController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/bus.png') }}" ><p>Transports</p></div></a>
                </div>
            </section>
        </div>





    </div>






@endsection

@section('jquery')
    <script>
        $(function(){
            $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
                $(".alert-success").alert('close');
                $('#loader-to').hide();
            });
        });

    </script>

@endsection