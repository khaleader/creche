@extends('layouts.default')

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('LevelsController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_niveaux">
                                <span class="count"> {{ \App\Level::where('user_id',\Auth::user()->id)->count() }}</span>
                            </div>
                            <p>Niveaux</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>






        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales
                    </h4>
                </header>
                <div class="panel-body informations_general">
                    {!! Form::open(['url'=> action('LevelsController@store')]) !!}


                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Niveau global</label>
                        <div class="form_ajout">
                                        {!!  Form::select('grade',
            App\Grade::where('user_id',\Auth::user()->id)->where('name','!=','Crèche')->where('school_year_id',App\SchoolYear::getSchoolYearId())
            ->lists('name','id') ,null,['class'=>'form_ajout_input']) !!}

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom du niveau</label>
                        <div class="form_ajout">
                            <input type="text" name="niveau" class="form_ajout_input" placeholder="Entrez le niveau">

                        </div>
                    </div>


                    <button class="btn_form" type="submit">Enregistrer</button>
                    {!! Form::close() !!}
                </div>






            </section>
        </div>
    </div>
    <div class="row"></div>







@endsection

@section('jquery')
    <script>
$(function(){
    $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
        $(".alert-danger").alert('close');
    });
    $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
        $(".alert-success").alert('close');
    });

});


    </script>


@stop