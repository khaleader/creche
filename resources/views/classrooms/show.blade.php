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
                        @foreach($cr->matieres->unique() as $m)

                        <tr>

                            <td><span><strong>{{ $m->nom_matiere }}  : </strong>
                                 <?php

                                    $teachers = $m->teachers;
                                    foreach($teachers as $y)
                                    {
                                        $ok =  DB::table('classroom_matter_teacher')
                                                ->where('classroom_id',$cr->id)
                                                ->where('matter_id',$m->id)
                                                ->where('teacher_id',$y->id)
                                                ->first();
                                        if($ok)
                                            {
                                                echo $y->nom_teacher.'<br>';
                                            }

                                    }
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
                    <h4 class="gen-case"> Informations générales  </h4>

                    <div class="btn-group dropdown_actions">
                        <button class="btn btn-white" type="button">Actions</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu" style="left: -28px;">
                            <li><a  href="{{ action('ClassroomsController@edit',[$cr]) }}">Modifier</a></li>
                            <li><a class="delete-classe" href="{{ action('ClassroomsController@delete',[$cr]) }}">Supprimer</a></li>
                            <li><a  href="{{ action('TimesheetsController@edit',[$cr]) }}">Emploi du temps</a></li>
                            <li><a  href="{{ action('ClassroomsController@addMatterandProfToCr',[$cr]) }}">ajouter Un Professeur</a></li>


                        </ul>
                    </div>




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
                            <td><span><strong>Nombre d'élèves inscrits : </strong> {{ $cr->children()->count() }} </span></td>

                        </tr>
                        <tr>

                            <td><span><strong>Niveau : </strong>{{ \Auth::user()->leslevels()->where('id',$cr->niveau)->first()->niveau }} </span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Branche : </strong>
                                 @if(\Auth::user()->branches()->where('id',$cr->branche)->first())
                                    {{ \Auth::user()->branches()->where('id',$cr->branche)->first()->nom_branche }}
                                     @else
                                     {{ '-----' }}
                                     @endif
                                </span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </section>
        </div>
    </div>
    <div class="row"></div>

@endsection

@section('jquery')

    <script>
        $('body').on('click','.delete-classe',function(e){
            e.preventDefault();
            var href = this.href;
            alertify.dialog('confirm')
                    .set({
                        'labels':{ok:'Oui', cancel:'Non'},
                        'message': 'voulez vous vraiment supprimer cet élément ?  ',
                        'transition': 'fade',
                        'onok': function(){
                            window.location.href = href;
                            alertify.success('bien Supprimé!');
                        },
                        'oncancel': function(){

                        }
                    }).show();

        });



    </script>




@stop