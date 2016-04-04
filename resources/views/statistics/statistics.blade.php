@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@index') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/statistiques.png') }}" ><p>Chiffres</p></div></a>
                </div>
            </section>
        </div>


        <div class="col-md-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('StatisticsController@graphs') }}">
                        <div class="bloc_info2"><img src="{{ asset('images/chart-stats.png') }}" ><p>Rapports</p></div></a>
                </div>
            </section>
        </div>






    </div>



@endsection