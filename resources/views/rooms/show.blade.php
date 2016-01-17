@extends('layouts.default')

@section('content')


    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('RoomsController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/salles.png') }}" ><span class="count">
                                {{ \App\Room::where('user_id',\Auth::user()->id)->count() }}</span><p>Salles</p>
                    </div></a>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a href="{{ action('RoomsController@delete',[$room]) }}"><div class="btn2">Supprimer</div></a>
                    <a href="{{ action('RoomsController@edit',[$room]) }}"><div class="btn2">Modifier</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom de la salle : </strong>{{ $room->nom_salle }}</span></td>
                        </tr>

                        <tr>

                            <td><span><strong>Capacité de la salle : </strong>{{ $room->capacite_salle }} élèves</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </section>

        </div>
    </div>

    <div class="row"></div>



@endsection