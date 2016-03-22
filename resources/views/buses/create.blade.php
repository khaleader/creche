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
                   {!! Form::open(['url'=> action('BusesController@store')]) !!}
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Marque</label>
                            <div class="form_ajout">
                                <input type="text" name="marque" class="form_ajout_input" placeholder="Entrez la marque">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Modèle</label>
                            <div class="form_ajout">
                                <input type="text" data-mask="00/00/0000" name="modele" class="form_ajout_input" placeholder="Entrez le modèle">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Matricule</label>
                            <div class="form_ajout">
                                <input type="text" data-mask="00000/A/00" data-mask-selectonfocus="true"  name="matricule" class="form_ajout_input" placeholder="Entrez le matricule">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Chauffeur</label>
                            <div class="form_ajout">
                                <input type="text" name="chauffeur" class="form_ajout_input" placeholder="Entrez le nom du chauffeur">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Capacité</label>
                            <div class="form_ajout">
                                <input type="text"     data-mask="000" data-mask-selectonfocus="true" name="capacite" class="form_ajout_input" placeholder="Entrez la capacité de l'autocar">

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