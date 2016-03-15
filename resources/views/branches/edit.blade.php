@extends('layouts.default')

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('BranchesController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_branches">
                                <span class="count">    {{ \App\Branch::where('user_id',\Auth::user()->id)->count() }}</span>
                            </div>
                            <p>Branches</p></div>
                    </a></div>
            </section>
        </div>






        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>



                </header>
                <div class="panel-body informations_general">
                    {!! Form::model($branch,['url'=> action('BranchesController@update',[$branch]),'method'=> 'put']) !!}
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom de la branche</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $branch->nom_branche }}" name="nom_branche" class="form_ajout_input" placeholder="Entrez le nom de la branche">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Code de la branche</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $branch->code_branche }}" name="code_branche" class="form_ajout_input" placeholder="Entrez le code de la branche">

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

        $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert-danger").alert('close');
        });
        $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
            $(".alert-success").alert('close');

        });

    </script>


@stop