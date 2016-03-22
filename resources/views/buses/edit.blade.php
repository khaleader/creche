@extends('layouts.default')

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>


                </header>

                <div class="panel-body informations_general">
                    {!! Form::model($bus,['url'=> action('BusesController@update',$bus),'method' => 'put']) !!}
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Marque</label>
                        <div class="form_ajout">
                            <input type="text" name="marque" value="{{ $bus->marque }}" class="form_ajout_input" placeholder="Entrez la marque">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Modèle</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $bus->modele }}" data-mask="00/00/0000" name="modele" class="form_ajout_input" placeholder="Entrez le modèle">

                        </div>
                    </div>

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Matricule</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $bus->matricule }}" data-mask="00000/A/00" data-mask-selectonfocus="true"  name="matricule" class="form_ajout_input" placeholder="Entrez le matricule">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Chauffeur</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $bus->chauffeur }}" name="chauffeur" class="form_ajout_input" placeholder="Entrez le nom du chauffeur">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Capacité</label>
                        <div class="form_ajout">
                            <input type="text"  value="{{ $bus->capacite }}"    data-mask="000" data-mask-selectonfocus="true" name="capacite" class="form_ajout_input" placeholder="Entrez la capacité de l'autocar">

                        </div>
                    </div>
                    <button class="btn_form" type="submit">Enregistrer</button>
                    <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                        class="btn_form" href="{{ URL::action('BusesController@show',[$bus]) }}">
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
    <script src="{{ asset('js\jquery.mask.min.js') }}"></script>
    <script>

        $(function(){
            $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
                $(".alert-danger").alert('close');
                $('#loader-to').hide();
            });
        });

    </script>
@endsection