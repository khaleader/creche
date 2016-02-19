@extends('layouts.default')
@section('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('js\codrops\PageLoadingEffects\css\component.css') }}" />
    <script src="{{ asset('js\codrops\PageLoadingEffects\js\snap.svg-min.js') }}"></script>

@stop

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">

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
                    <table class="table  table-hover general-table table_informations">
                        <tbody>
                        <div>
                            {!! Form::open(['url'=> action('SchoolsController@store')]) !!}

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom de l'école</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('nom_ecole')?:'' }}" type="text" name="nom_ecole" class="form_ajout_input" placeholder="Entrez le nom de l'école">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom du résponsable</label>
                                <div class="form_ajout">
                                    <input  value="{{ Request::old('nom_responsable')?:'' }}" type="text" name="nom_responsable" class="form_ajout_input" placeholder="Entrez le nom du résponsable">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="sexe" class="control-label col-lg-3">Sexe</label>
                                <div class="form_ajout">
                                    <select name="sexe" class="form_ajout_input">
                                        <option value="homme">Homme</option>
                                        <option value="femme">Femme</option>

                                    </select>

                                </div>
                            </div>


                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Téléphone fixe</label>
                                <div class="form_ajout">
                                    <input  value="{{ Request::old('tel_fix')?:'' }}" type="text" name="tel_fix" class="form_ajout_input" placeholder="Entrez le numéro fixe">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Téléphone portable</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('tel_por')?:'' }}" type="text" name="tel_por" class="form_ajout_input" placeholder="Entrez le numéro portable">

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Email de l'école</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('email_ecole')?:'' }}" type="email" name="email_ecole" class="form_ajout_input" placeholder="Entrez l'email de l'école">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Adresse</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('ecole_adresse')?:'' }}" type="text" name="ecole_adresse" class="form_ajout_input" placeholder="Entrez l'adresse de l'école">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Ville</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('ecole_ville')?:'' }}"  type="text" name="ecole_ville" class="form_ajout_input" placeholder="Entrez la ville de l'école">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Pays</label>
                                <div class="form_ajout">
                                    <select name="country" class="form_ajout_input" placeholder="Choisissez le pays">
                                        <option>Choisissez le pays s'il vous plait</option>
                                        <option value="maroc">Maroc</option>
                                        <option value="france">France</option>

                                    </select>

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Compte</label>
                                <div class="form_ajout">
                                    <select name="typeCompte" class="form_ajout_input">
                                        <option>Choisissez le Compte s'il vous plait</option>
                                        <option value="0">Essai</option>
                                        <option value="1">Officiel</option>

                                    </select>

                                </div>
                            </div>

                            <button class="btn_form" type="submit">Enregistrer</button>
                            {!!  Form::close() !!}
                        </div>
                        </tbody>
                    </table>


                </div>
            </section>
        </div>
    </div>
    <div id="loader" class="pageload-overlay" data-opening="m -5,-5 0,70 90,0 0,-70 z m 5,35 c 0,0 15,20 40,0 25,-20 40,0 40,0 l 0,0 C 80,30 65,10 40,30 15,50 0,30 0,30 z">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" >
            <path d="m -5,-5 0,70 90,0 0,-70 z m 5,5 c 0,0 7.9843788,0 40,0 35,0 40,0 40,0 l 0,60 c 0,0 -3.944487,0 -40,0 -30,0 -40,0 -40,0 z"/>
        </svg>
    </div><!-- /pageload-overlay -->
    <div class="row"></div>




@endsection


@section('jquery')
        <!-- codrops -->
    <script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\classie.js') }}"></script>
    <script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\modernizr.custom.js') }}"></script>
    <script src="{{ asset('js\codrops\PageLoadingEffects\js\svgLoader.js') }}"></script>

    <!-- codrops -->

    <script>
        $(function(){
           


            $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
                $(".alert-danger").alert('close');
            });
            function showLoader()
            {
                var pageWrap = document.getElementById( 'container'),
                        pages = [].slice.call( pageWrap.querySelectorAll('div.container') ),
                        currentPage = 0,
                //triggerLoading = [].slice.call( pageWrap.querySelectorAll( 'a.pageload-link' ) ),
                        loader = new SVGLoader( document.getElementById( 'loader' ), {
                            speedIn : 400, easingIn : mina.easeinout
                        } );
                loader.show();
            }
            $('button[type=submit]').click(function(){
               showLoader();
            });

            function hideLoader()
            {
                var pageWrap = document.getElementById( 'container'),
                        pages = [].slice.call( pageWrap.querySelectorAll( 'div.container' ) ),
                        currentPage = 0,
                //triggerLoading = [].slice.call( pageWrap.querySelectorAll( 'a.pageload-link' ) ),
                        loader = new SVGLoader( document.getElementById( 'loader' ), {  speedIn : 400, easingIn : mina.easeinout} );
                loader.hide();
            }

        });
    </script>
@stop