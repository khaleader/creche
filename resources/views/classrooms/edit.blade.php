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
                    Matières

                </header>
                <div class="panel-body">
                <?php $matieres = App\Matter::where('user_id',\Auth::user()->id)->get();
                    ?>
                    <table class="table  table-hover general-table">

                        {!!  Form::model($cr,['url'=> action('ClassroomsController@update',[$cr]),'method'=>'put']) !!}
                        <tbody>
                            @foreach($cr->matters as $mat)
                                @foreach($matieres as $matiere)
                                    @if($matiere->id == $mat->id)
                            <tr>
                                <td><div class="checkbox_liste2">
                                        <input name="select[]" type="checkbox" checked  value="{{  $mat->id }}">
                                    </div>
                                    <span><strong>{{ $mat->nom_matiere }}</strong></span></td>
                            </tr>
                             @endif


                              @endforeach
                            @endforeach

                            <?php
                                    $mt = Auth::user()->matters()->whereNotIn('id',$cr->matters()->lists('id'))->get();
                            ?>
                                    @foreach($mt as $m)
                                        <tr>
                                            <td><div class="checkbox_liste2">
                                                    <input name="select[]" type="checkbox"  value="{{  $m->id }}">
                                                </div>
                                                <span><strong>{{ $m->nom_matiere }}</strong></span></td>
                                        </tr>
                                @endforeach

                        </tbody>
                    </table>


                </div>


             <!--   <div class="panel-body">

                    <table class="table  table-hover general-table">


                        <tbody>
                        @foreach($cr->matieres->unique() as $m)

                            <tr>

                                <td><span><strong>{{-- $m->nom_matiere --}}  : </strong>
                                        <?php

                                     //   $teachers = $m->teachers;
                                     //   foreach($teachers as $y)
                                     //   {
                                        //    $ok =  DB::table('classroom_matter_teacher')
                                                //    ->where('classroom_id',$cr->id)
                                                //    ->where('matter_id',$m->id)
                                                 //   ->where('teacher_id',$y->id)
                                                  //  ->first();
                                       //   if($ok)
                                      //     {
                                               // echo $y->nom_teacher.'<br>';
                                        //  }

                                     //   }
                                        ?>
                                </span></td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> -->



            </section>
        </div>







        <div class="col-sm-9">

            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>

                    <a href="{{ action('TimesheetsController@edit',[$cr]) }}"><div class="btn2">Emploi du temps</div></a>

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
                            {!!   Form::select('niveau',
                               App\Level::where('user_id',\Auth::user()->id)->
                               lists('niveau','id') ,$lv[0],['class'=>'form_ajout_input']) !!}


                        </div>
                    </div>

                   <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Branche</label>
                        <div class="form_ajout">
                       {!!  Form::select('branche',
                        App\Branch::where('user_id',\Auth::user()->id)->
                       lists('nom_branche','id') ,$br[0],['class'=>'form_ajout_input']) !!}
                        </div>
                    </div>


                    <button class="btn_form" type="submit">Enregistrer</button>
                    <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                        class="btn_form" href="{{ URL::previous() }}">
                        Annuler
                    </a>
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

        $('body').on('click','.del-teac',function(){

           var teacher = $(this).attr('teacher');
            var matiere = $(this).attr('matiere');
            var cr = $(this).attr('cr');
            $(this).closest('td').slideUp();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('ClassroomsController@detach')}}',
                data: 'cr='+ cr + '&matiere=' +  matiere + '&teacher=' + teacher + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {


                }
            });

        });


    </script>


@stop