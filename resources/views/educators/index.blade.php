@extends('layouts.default')

@include('partials.alert-errors')
@section('content')

    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('TeachersController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/professeurs.png') }}" ><span class="count">
      {{ \App\Teacher::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Professeurs</p>
                    </div></a>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>


                </header>
               {!! Form::open(['url'=>action('EducatorsController@store')]) !!}
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">




                        <tbody>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom de la classe</label>
                                <div class="form_ajout">


                                        {!!  Form::select('classe',
         App\Classroom::where('user_id',\Auth::user()->id)->
         lists('nom_classe','id') ,null,['class'=>'form_ajout_input','id'=>'classe']) !!}

                                </div>
                            </div>

                        </tbody>

                    </table>
                    <button class="btn_form" type="submit">Enregistrer</button>

                </div>
        {!!  Form::close() !!}
            </section>
        </div>
    </div>
    <div class="row"></div>


@endsection






@section('jquery')

    <script>

        $(function(){

            $('#classe').prepend('<option selected>selectionnez s\'il vous plait</option>');
            $('#classe').change(function(){
                $('tbody').empty();
               var value = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('EducatorsController@getmatieres')}}',
                    data: 'value=' +  value + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                      $('tbody').prepend(data);
                    }
                });


            });


        });


    </script>





 @stop