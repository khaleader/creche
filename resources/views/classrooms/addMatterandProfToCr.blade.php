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
                                                echo $y->nom_teacher.' <a class="del-teac" teacher="'.$y->id.'" matiere="'.$m->id.'"
             cr="'.$cr->id.'"
             href="#"><i class="fa fa-2x fa-times-circle" style="vertical-align:middle"></i></a>' .'<br>';
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
            {!! Form::open(['url'=>action('EducatorsController@enregistrer')]) !!}
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>

                    <a href="{{ action('TimesheetsController@edit',[$cr]) }}"><div class="btn2">Emploi du temps</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">

                        <tbody>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Professeur</label>
                            <div class="form_ajout">
                                                {!!  Form::select('teacher',
                    \Auth::user()->teachers()->whereIn('fonction',['professeur'])->
                    lists('nom_teacher','id') ,null,['class'=>'form_ajout_input']) !!}

                            </div>
                        </div>


                        <input type="hidden" value="{{ $cr->id }}" name="cr">
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Matière</label>
                            <div class="form_ajout">
                                <select class="form_ajout_input" name="matter">
                                </select>

                                {{--  Form::select('matter',
    App\Matter::where('user_id',\Auth::user()->id)->
    lists('nom_matiere','id') ,null,['class'=>'form_ajout_input']) --}}

                            </div>
                        </div>
                        </tbody>
                        </table>


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