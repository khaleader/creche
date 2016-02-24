@extends('layouts.default')


@section('content')

    <div class="row">
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('MattersController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/matieres.png') }}" ><p>Matières</p></div></a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('LevelsController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/salles.png') }}" ><p>Niveaux</p></div></a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('BranchesController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/branches.png') }}" ><p>Branches</p></div>
                    </a></div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('ClassroomsController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/classes.png') }}" ><p>Classes</p></div>
                    </a></div>
            </section>
        </div>




    </div>
    <div class="row">
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('EducatorsController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/repartitions.png') }}" ><p>Répartition </br>enseignants</p></div></a>
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
                    <a href="{{  action('RoomsController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/salles.png') }}" ><p>Salles</p></div></a>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="#">
                        <div class="bloc_info2"><img src="{{ asset('images/bus.png') }}" ><p>Transports</p></div></a>
                </div>
            </section>
        </div>





    </div>






@endsection