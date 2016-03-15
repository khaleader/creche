@extends('layouts.default')



<script  src="{{ asset('js/jscolor.js') }}"></script>

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{ action('MattersController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_matieres">
                                <span class="count">{{ \App\Matter::where('user_id',\Auth::user()->id)->count() }}</span>
                            </div>
                            <p>Matières</p>
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
                    {!! Form::model($matter,['url'=> action('MattersController@update',[$matter]),'method'=>'put']) !!}
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom de la matière</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $matter->nom_matiere }}" name="nom_matiere" class="form_ajout_input" placeholder="Entrez le nom de la matière">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Code de la matière</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $matter->code_matiere }}" name="code_matiere" class="form_ajout_input" placeholder="Entrez le code de la matière">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Couleur de la matière</label>
                        <div class="form_ajout">
                            <input id="color" value="{{ $matter->color }}"  name="color" class="form_ajout_input jscolor" placeholder="choisissez le couleur de la matière">

                        </div>
                    </div>
                    <button class="btn_form" type="submit">Enregistrer</button>
                    <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                        class="btn_form" href="{{ URL::previous() }}">
                        Annuler
                    </a>
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
