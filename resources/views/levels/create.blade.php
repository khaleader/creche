@extends('layouts.default')

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('LevelsController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/branches.png') }}" ><span class="count">
                            {{ \App\Level::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>niveaux</p>
                    </div></a>
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

        $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert-danger").alert('close');
        });
        $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
            $(".alert-success").alert('close');

        });

    </script>


@stop