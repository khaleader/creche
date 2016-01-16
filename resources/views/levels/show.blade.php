@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('LevelsController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/branches.png') }}" ><span class="count">
                          {{ \App\Level::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Niveaux</p>
                    </div></a>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a href="{{ action('LevelsController@delete',[$level]) }}"><div class="btn2">Supprimer</div></a>
                    <a href=""><div class="btn2">Modifier</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom du niveau : </strong>{{ $level->niveau }}</span></td>
                        </tr>


                        </tbody>
                    </table>
                </div>


            </section>
        </div>
    </div>
    <div class="row"></div>


@endsection