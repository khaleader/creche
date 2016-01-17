@extends('layouts.default')

@section('content')


    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <header class="panel-heading">
                    Matières / Professeurs

                </header>
                <div class="panel-body">

                    <table class="table  table-hover general-table">


                        <tbody>
                        @foreach($cr->matieres as $m)

                        <tr>

                            <td><span><strong>{{ $m->nom_matiere }}  : </strong>
                                 <?php
                                   $ok =  DB::table('classroom_matter_teacher')
                                         ->where('classroom_id',$cr->id)
                                         ->where('matter_id',$m->id)
                                         ->first();
                                  $teacher =  App\Teacher::where('user_id',\Auth::user()->id)->where('id',$ok->teacher_id)->first();
                                       echo  $teacher->nom_teacher;

                                   ?>
                                </span></td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>



            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a href="{{ action('ClassroomsController@delete',[$cr]) }}"><div class="btn2">Supprimer</div></a>
                    <a href="{{ action('ClassroomsController@edit',[$cr]) }}"><div class="btn2">Modifier</div></a>
                    <a href="{{ action('TimesheetsController@edit',[$cr]) }}"><div class="btn2">Emploi du temps</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom de la classe : </strong>{{ $cr->nom_classe }}</span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Code de classe : </strong>{{ $cr->code_classe }}</span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Capacité de salle : </strong>{{ $cr->capacite_classe }} élèves </span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Niveau : </strong>{{ $cr->niveau }} </span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Branche : </strong>{{ $cr->branche }} </span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </section>
        </div>
    </div>
    <div class="row"></div>

@endsection