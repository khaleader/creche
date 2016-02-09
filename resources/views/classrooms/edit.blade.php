@extends('layouts.default')

@section('css')

    <style>
        .forthis > label{
            margin-left:34%;
        }

    </style>

@endsection

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
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
                                <td><span><strong>{{ $m->nom_matiere  }}  : </strong>
                                        <?php
                                        $ok =  DB::table('classroom_matter_teacher')
                                                ->where('classroom_id',$cr->id)
                                                ->where('matter_id',$m->id)
                                                ->first();
                                             $teachers = $m->teachers->toArray();
                                             foreach($teachers as $y)
                                                 {

                                                     echo $y['nom_teacher'].'<br>';
                                                 }



                                        ?>
                                </span></td>


                            </tr>
                        @endforeach
                        {!! Form::open(['url'=>action('EducatorsController@enregistrer')]) !!}
                        <tr>
                            <div class="form_champ forthis">
                                <label for="cname" class="control-label col-md-3">Professeur</label>
                                <div class="form_ajout col-md-9">
                                    {!!  Form::select('teacher',
        App\Teacher::where('user_id',\Auth::user()->id)->
        lists('nom_teacher','id') ,null,['class'=>'form_ajout_input']) !!}

                                </div>
                            </div>
                        </tr>
                        <tr>
                            <input type="hidden" value="{{ $cr->id }}" name="cr">
                            <div class="form_champ forthis">
                                <label for="cname" class="control-label col-md-3">Matière</label>
                                <div class="form_ajout col-md-9">
                                     <select class="form_ajout_input" name="matter">

                                     </select>

                                                    {{--  Form::select('matter',
                        App\Matter::where('user_id',\Auth::user()->id)->
                        lists('nom_matiere','id') ,null,['class'=>'form_ajout_input']) --}}

                                </div>
                            </div>
                        </tr>

                        <tr>
                            <button  class="btn_form"  style="margin-right: 34%;" type="submit">Enregistrer</button>
                        </tr>
                        {!!  Form::close() !!}


                        </tbody>
                    </table>
                </div>



            </section>
        </div>







        <div class="col-sm-9">
            {!!  Form::model($cr,['url'=> action('ClassroomsController@update',[$cr]),'method'=>'put']) !!}
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>

                    <a href="{{ action('TimesheetsController@index') }}"><div class="btn2">Emploi du temps</div></a>

                </header>
                <div class="panel-body informations_general">

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom de la classe</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $cr->nom_classe }}" name="nom_classe" class="form_ajout_input" placeholder="Entrez le nom de la classe">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Code de la classe</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $cr->code_classe }}" name="code_classe" class="form_ajout_input" placeholder="Entrez le code de la classe">

                        </div>
                    </div>

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Capacité de salle</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $cr->capacite_classe }}" name="capacite_classe" class="form_ajout_input" placeholder="Entrez le nombre des élèves maximum">

                        </div>
                    </div>

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Niveau</label>
                        <div class="form_ajout">
                            {!!  Form::select('niveau',
       App\Level::where('user_id',\Auth::user()->id)->
       lists('niveau','niveau') ,null,['class'=>'form_ajout_input']) !!}
                                    <!--     <select name="niveau" class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option>1 ère année bac</option>
                                    <option>2 ème année bac</option>

                                </select>-->

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Branche</label>
                        <div class="form_ajout">
                            <!-- <select class="form_ajout_input" placeholder="Choisissez le responsable">
                                 <option>Science physique</option>
                                 <option>littéraire</option>

                             </select>-->

                                            {!!  Form::select('branche',
                App\Branch::where('user_id',\Auth::user()->id)->
                lists('nom_branche','nom_branche') ,null,['class'=>'form_ajout_input']) !!}

                        </div>
                    </div>


                    <button class="btn_form" type="submit">Enregistrer</button>
                    {!!  Form::close() !!}
                </div>

            </section>
        </div>
    </div>
    <div class="row"></div>




@endsection

@section('jquery')
    <script>
        $('select[name=teacher]').prepend('<option selected>Selectionnez</option>');
        $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert-danger").alert('close');

        });
        $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
            $(".alert-success").alert('close');

        });

        $('select[name=teacher]').change(function(){
         var value = $(this).val();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('EducatorsController@getmatters')}}',
                data: 'value=' +  value + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('select[name=matter]').empty();
                    $('body select[name=matter]').prepend(data);

                }
            });

        });

    </script>


@stop