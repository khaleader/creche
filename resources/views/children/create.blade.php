@extends('layouts.default')
<script>
    localStorage.classe ='';
</script>

@section('css')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/completer/completer.css') }}"/>

    <script src="{{  asset('css/completer/completer.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('js\codrops\PageLoadingEffects\css\component.css') }}" />
    <script src="{{ asset('js\codrops\PageLoadingEffects\js\snap.svg-min.js') }}"></script>
    <style>
        #loader-parent{
            position: fixed;
            width: 100%;
            height:100vh;
            background-color: white;
            opacity: 0.6;
            top:0;
            right:0;
            left:0;
            bottom:0;
            z-index:50000;
        }
        #loader-to{
            margin-left: 50%;
            margin-top: 25%;
        }


    </style>


@endsection
@section('loader')
  <!--  <div id="loader-parent">
        <img id="loader-to" src="{{  asset('images/ajax-loaderr.gif') }}" >
    </div> -->

@stop
@section('content')
        @include('partials.alert-success')
        @include('partials.alert-errors')

    <div class="row">
        {!!  Form::open(['url'=> action('ChildrenController@store'),'files'=>true]) !!}
        <div class="col-sm-3">
            <section id="image-h" class="panel">
                <div class="panel-body">
                    <div  class="form-group last">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>
                                <img class="pdp justhideit" src="{{  asset('images/no_avatar.jpg') }}" alt="">
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                            <div class="btn_upload">
                           <span class="btn btn-white btn-file">
                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i>   Sélectionner une image </span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input type="file" class="default" name="photo" id="uploadFile" />
                           </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

  <!--  3 links nav -->
            <section class="panel">
                <a href="{{ action('ChildrenController@index') }}">
                    <div class="panel-body bloc_informations">
                        <img src="{{ asset('images/enfants.png') }}" >
                        <span class="count"> &nbsp;{{   App\Child::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Elèves</p>
                    </div>
                </a>
            </section>
            <section class="panel">
                <a href="{{ action('FamiliesController@index') }}">
                    <div class="panel-body bloc_informations">
                        <img src="{{  asset('images/familles.png') }}" ><span class="count">&nbsp;
                             {{  App\Family::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Familles</p>
                    </div>
                </a>
            </section>

            <section class="panel">
                <a href="{{   action('TeachersController@index') }}">
                    <div class="panel-body bloc_informations">
                        <img src="{{  asset('images/professeurs.png') }}" >
                        <span class="count">{{  App\Teacher::where('user_id',\Auth::user()->id)->count()  }}</span>
                        <p>Professeurs</p>
                    </div>
                </a>
            </section>

            <!--  3 links nav -->
        </div>
        <div class="col-sm-9">


            <section class="panel">

               <!-- <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales
                    </h4>
                </header>-->
                <!-- Nav Tabs -->
                <header class="panel-heading tab-bg-dark-navy-blue">
                    <ul class="nav nav-tabs nav-justified ">
                        <li class="active">
                            <a data-toggle="tab" href="#informations">
                                Ajouter un Elève
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#password">
                                Ajouter un professeur ou administrateur
                            </a>
                        </li>
                    </ul>
                </header>
                <!-- Nav Tabs -->

                <div class="panel-body informations_general">
                    <div class="tab-content tasi-tab">
                        <div id="informations" class="tab-pane active">

                    <table class="table table-hover general-table table_informations">


                            <div class="form_champ c ">
                                <label for="cname" class="control-label col-lg-3">Nom de l'élève * </label>
                                <div class="form_ajout">
                                    <input  value="{{ Request::old('nom_enfant')?:'' }}" type="text" name="nom_enfant" class="form_ajout_input" placeholder="Entrez le nom de l'élève">
                                </div>
                            </div>

                          <!--  <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Age de l'enfant</label>
                                <div class="form_ajout">
                                    <input  type="text" disabled name="age_enfant" class="form_ajout_input" placeholder="Entrez l'age de l'enfant">

                                </div>
                            </div>-->
                            <div class="form_champ c">
                                <label for="cname"  class="control-label col-lg-3">Date de naissance * </label>
                                <div class="form_ajout">
                                    <input id="date_birth_child"  value="{{ Request::old('date_naissance')?:'' }}" type="date" name="date_naissance" class="form_ajout_input foronlydate" >
                                    <div class="icone_input"><i class="fa fa-"></i></div>

                                </div>
                            </div>

                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">Le Sexe  * </label>
                            <div class="form_ajout">
                                <select name="sexe" class="form_ajout_input" >
                                    <option value="Garçon">Garçon</option>
                                    <option value="fille">Fille</option>
                                </select>
                            </div>
                        </div>
                        <div class="form_champ only-for-email">
                            <?php
                            $emails =  App\Family::where('user_id',\Auth::user()->id)->lists('email_responsable','email_responsable')->toArray();
                            $output = array_values($emails);
                            $output = json_encode($output);
                            ?>

                            <label for="cname" class="control-label col-lg-3">Email du responsable *

                               <span class="tooltips tooltip-effect-2"><i class="fa fa-info-circle"></i>
                                    <span class="tooltip-content clearfix" style="padding-left:20px;"><span class="tooltip-text">
                                            Si L'email se génère automatiqement
                                            ca veut dire que ce responsable est déjà enregistré
                                               et vous pouvez facilement aller dans le profil du parent <br>
                                            et dans la partie Actions choisissez ajouter un élève pour ajouter
                                            l'élève






                                          </span></span>
                                </span>



                            </label>
                            <div class="form_ajout">
                                <input id="email_resp" completer data-suggest="true"
                                       data-source='<?php echo $output  ?>'
                                       value="{{ Request::old('email_responsable')?:'' }}"
                                       type="email" name="email_responsable" class="form_ajout_input"
                                       placeholder="Entrez l'email du responsable">

                            </div>

                        </div>


                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom du père * </label>
                                <div class="form_ajout">
                                    <?php
                                    $array =  App\Family::where('user_id',\Auth::user()->id)->lists('nom_pere','nom_pere')->toArray();
                                    $out = array_values($array);
                                    $out = json_encode($out);
                                    ?>
                                    <input id="nom_pere"  completer data-suggest="true"
                                           data-source='<?php echo $out  ?>'
                                           value="{{ Request::old('nom_pere')?:'' }}"
                                           type="text" name="nom_pere" class="form_ajout_input"
                                           placeholder="Entrez le nom du père">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom de la mère * </label>
                                <div class="form_ajout">
                                    <?php
                                    $array =  App\Family::where('user_id',\Auth::user()->id)->lists('nom_mere','nom_mere')->toArray();
                                    $out = array_values($array);
                                    $out = json_encode($out);
                                     ?>
                                    <input value="{{ Request::old('nom_mere')?:'' }}"  completer data-suggest="true"
                                           data-source='<?php echo $out  ?>'
                                           type="text" name="nom_mere"
                                           class="form_ajout_input" placeholder="Entrez le nom de la mère">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Le responsable * </label>
                                <div class="form_ajout">
                                    <select name="responsable" class="form_ajout_input" placeholder="Choisissez le responsable">
                                        <option value="1">Père</option>
                                        <option value="0">Mère</option>
                                    </select>
                                </div>
                            </div>
                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">Le Transport * </label>
                            <div class="form_ajout">
                                <select id="transport" name="transport" class="form_ajout_input">
                                    <option selected value="0">Non</option>
                                    <option value="1">Oui</option>

                                </select>

                            </div>
                        </div>
                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">Niveau Global * </label>
                            <div class="form_ajout">
                                <select id="grade" name="grade" class="form_ajout_input">
                                    <option selected>Sélectionnez</option>
                                    @foreach(\Auth::user()->grades as $grade)
                                        <option data-value="{{ $grade->name }}" value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div id="niveau-bloc" class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">Le Niveau * </label>
                            <div class="form_ajout">
                                <select id="niveau" name="niveau" class="form_ajout_input">


                                </select>

                            </div>
                        </div>

                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">La Classe * </label>
                            <div class="form_ajout">
                                <select id="classe" name="classe" class="form_ajout_input">


                                </select>

                            </div>
                        </div>

                        <div class="form_champ c" id="branche-bloc">
                            <label for="cname" class="control-label col-lg-3">La Branche * </label>
                            <div class="form_ajout">
                                <select id="branche" name="branche" class="form_ajout_input">

                                    <option selected>Choisissez une branche</option>
                                    @foreach(\Auth::user()->branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->nom_branche }}</option>
                                      @endforeach

                                </select>

                            </div>
                        </div>











                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Adresse</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('adresse')?:'' }}" type="text" name="adresse" class="form_ajout_input" placeholder="Entrez l'adresse du responsable">

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numéro fixe</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('numero_fixe')?:'' }}" type="text" name="numero_fixe" class="form_ajout_input" placeholder="Entrez le numéro fix du responsable">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numéro portable</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('numero_portable')?:'' }}" type="text" name="numero_portable" class="form_ajout_input" placeholder="Entrez le numéro portable du responsable ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">CIN du responsable * </label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('cin')?:'' }}" type="text" name="cin" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

                                </div>
                            </div>
                        <div>
                            <button  id="submit" class="btn_form" type="submit">Enregistrer </button>


                        </div>
                        <?php
                        $check = App\CategoryBill::where('user_id',\Auth::user()->id)->get();
                        if($check->isEmpty())
                        {
                      echo '<script type="text/javascript">

                     alertify.set("notifier","position", "top-right");
                     alertify.set("notifier","delay", 30);
                     alertify.error("Vous n\'avez pas encoré remplissez les tarifs de paiement  **cliquez D\'abord sur paramètres > " +
                      "options de paiement > Selectionnez une Catégorie pour remplir l\'intervalle de l\'age et les prix :)");

                        </script>';
                        }
                        ?>





                    </table>
                     </div>
                      {!! Form::close() !!}

                        <!--password  -->
                        <div id="password" class="tab-pane">
                           {!! Form::open(['url'=>action('TeachersController@store')]) !!}
                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Nom complet *</label>
                                    <div class="form_ajout">
                                        <input value="{{ Request::old('nom_teacher')?:'' }}" type="text" name="nom_teacher" class="form_ajout_input" placeholder="Entrez le nom complet">

                                    </div>
                                </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Date de naissance *</label>
                                <div class="form_ajout">
                                    <input type="date" value="{{ Request::old('date_naissance')?:'' }}" name="date_naissance" class="form_ajout_input" placeholder="Entrez la date de naissance ">
                                    <div class="icone_input"><i class="fa fa-"></i></div>

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Fonction *</label>
                                <div class="form_ajout">
                                    <select name="fonction" class="form_ajout_input" id="fonction">
                                        <option selected>Selectionnez s'il vous plait</option>
                                        <option value="professeur">professeur</option>
                                        <option value="rh">ressources humaines</option>

                                    </select>

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Matière *</label>
                                <div class="form_ajout">
                                  <!--  <input type="text" name="poste" class="form_ajout_input" placeholder="Entrez le poste "> -->
                                                    {!!  Form::select('poste',
                       App\Matter::where('user_id',\Auth::user()->id)->
                       lists('nom_matiere','id') ,null,['class'=>'form_ajout_input','id'=>'matierep']) !!}

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Le sexe *</label>
                                <div class="form_ajout">
                                    <select name="sexe" class="form_ajout_input" placeholder="Le sexe">
                                        <option>Homme</option>
                                        <option>Femme</option>

                                    </select>

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Email *</label>
                                <div class="form_ajout">
                                    <input type="text" value="{{ Request::old('email')?:'' }}" name="email" class="form_ajout_input" placeholder="Entrez l'email ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numéro fixe</label>
                                <div class="form_ajout">
                                    <input type="text" value="{{ Request::old('num_fix')?:'' }}" name="num_fix" class="form_ajout_input" placeholder="Entrez le numéro fixe ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numéro portable *</label>
                                <div class="form_ajout">
                                    <input type="text" value="{{ Request::old('num_portable')?:'' }}" name="num_portable" class="form_ajout_input" placeholder="Entrez le numéro portable ">

                                </div>
                            </div>





                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Adresse</label>
                                <div class="form_ajout">
                                    <input type="text" value="{{ Request::old('adresse')?:'' }}" name="adresse" class="form_ajout_input" placeholder="Entrez l'adresse">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">CIN *</label>
                                <div class="form_ajout">
                                    <input type="text" value="{{ Request::old('cin')?:'' }}" name="cin" class="form_ajout_input" placeholder="Entrez le CIN ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Salaire</label>
                                <div class="form_ajout">
                                    <input type="text" value="{{ Request::old('salaire')?:'' }}" name="salaire" class="form_ajout_input" placeholder="Entrez le salaire ">

                                </div>
                            </div>
                            <button class="btn_form" type="submit">Enregistrer</button>
                            {!! Form::close() !!}
                        </div>
                    </div> <!-- end of both tabs -->
                </div>
            </section>
        </div>



    </div>

        <div id="loader" class="pageload-overlay" data-opening="M20,15 50,30 50,30 30,30 Z;M0,0 80,0 50,30 20,45 Z;M0,0 80,0 60,45 0,60 Z;M0,0 80,0 80,60 0,60 Z" data-closing="M0,0 80,0 60,45 0,60 Z;M0,0 80,0 50,30 20,45 Z;M20,15 50,30 50,30 30,30 Z;M30,30 50,30 50,30 30,30 Z">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none">
                <path d="M30,30 50,30 50,30 30,30 Z"/>
            </svg>
        </div><!-- /pageload-overlay -->

    <div class="row">
    </div>
        <span id="prices" style="display: none;"></span>
    @endsection

@section('jquery')
            <!-- codrops -->
        <script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\classie.js') }}"></script>
        <script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\modernizr.custom.js') }}"></script>
        <script src="{{ asset('js\codrops\PageLoadingEffects\js\svgLoader.js') }}"></script>

        <!-- codrops -->
    <script>
          $(document).ready(function() {
              //only loader effect
              function showLoader()
              {
                  var pageWrap = document.getElementById( 'container'),
                          pages = [].slice.call( pageWrap.querySelectorAll( 'div.container' ) ),
                          currentPage = 0,
                  //triggerLoading = [].slice.call( pageWrap.querySelectorAll( 'a.pageload-link' ) ),
                          loader = new SVGLoader( document.getElementById( 'loader' ), {
                              speedIn : 100 ,
                          } );
                  loader.show();
              }

              function hideLoader()
              {
                  var pageWrap = document.getElementById( 'container'),
                          pages = [].slice.call( pageWrap.querySelectorAll( 'div.container' ) ),
                          currentPage = 0,
                  //triggerLoading = [].slice.call( pageWrap.querySelectorAll( 'a.pageload-link' ) ),
                          loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 100 } );
                  loader.hide();
              }
              //loader effect only



              $('select[name=classe]').prepend("<option selected>sélectionnez la classe s'il vous plait</option>");
              $('select[name=poste]').prepend("<option selected>sélectionnez la matière s'il vous plait</option>");
             // $('#loader-parent').show();
              $('#loader-parent').hide();
              $('div.pdp').hide();

              $(".alert-danger").fadeTo(10000, 500).slideUp(500, function () {
                  $(".alert-danger").alert('close');
              });
              $(".alert-success").fadeTo(3000, 500).slideUp(500, function () {
                  $(".alert-success").alert('close');
              });

              $('input[name=age_enfant]').keyup(function () {
                  alert($(this).val());
              });

              $('a[href="#password"]').click(function () {
                  $('input[type="file"]').prop('disabled', true);
                  $('#image-h').hide();
              });
              $('a[href="#informations"]').click(function () {
                  $('input[type="file"]').prop('disabled', false);
                  $('#image-h').show();
              });
              $('#date_birth_child').blur(function () {
                           var date = $(this).val();
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  $.ajax({
                      url: '{{  URL::action('ChildrenController@getage')}}',
                      data: 'inputd=' + date + '&_token=' + CSRF_TOKEN,
                      type: 'post',
                      success: function (data) {
                          if (data == '') {
                              alertify.set('notifier', 'position', 'bottom-right');
                              alertify.set('notifier', 'delay', 60);
                              alertify.error("Attention la catégorie pour cet age n'est pas encore crée veuillez la créer S'il Vous plait >>> Redirection Automatique");
                              window.setTimeout(function(){
                                  location.href = '{{ URL::action('SchoolsController@edit',[\Auth::user()->id])  }}'
                              },5000);

                              //location.reload();

                          } else {
                              alertify.set('notifier', 'position', 'bottom-right');
                              alertify.set('notifier', 'delay', 30);
                              alertify.warning(data);
                              var data = data.substr(-7);
                              var data = data.substr(0, 3);
                              $('#prices').empty();
                              $('#prices').append(data);
                          }
                      }
                  });
              });

            /*  $('input[name=cin]').keyup(function(){
                  var cin = $(this).val();
                 var email_resp = $('input[name=email_responsable]').val();
                  var fix = $('input[name=numero_fixe]').val();
                  var portable = $('input[name=numero_portable]').val();
                  var nom_pere = $('input[name=nom_pere]').val();
                  var nom_mere = $('input[name=nom_mere]').val();

                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  $.ajax({
                     url :'{{-- URL::action('ChildrenController@checktoreturn')  --}}',
                      data : 'email_resp=' + email_resp + '&fix=' + fix + '&portable=' +portable + '&nom_pere=' + nom_pere
                               + '&nom_mere=' + nom_mere + '&cin=' + cin + '&_token=' + CSRF_TOKEN,
                      type: 'post',
                      success : function(data){
                             if(data ==  'here')
                             {
                                 var href = '{{-- URL::action('ChildrenController@create_enfant')  --}}';
                                 window.location.href = href;
                             }
                      }
                  });
              });*/
              $('#transport').change(function () {
                  var trans = $(this).val();
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  if (trans == 1) {
                      $.ajax({
                          url: '{{  URL::action('ChildrenController@checktransport')}}',
                          data: 'status=' + 1 + '&_token=' + CSRF_TOKEN,
                          type: 'post',
                          success: function (data) {
                             if(data == '')
                             {
                                 alertify.set('notifier', 'position', 'bottom-left');
                                 alertify.set('notifier', 'delay', 60);
                                 alertify.error("Attention vous n'avez pas encore spécifié un prix pour le transport");
                             }else{
                                 if ($('#prices').text().length > 0) {
                                     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                     var prix = $('#prices').text();
                                     $.ajax({
                                         url: '{{  URL::action('ChildrenController@total')}}',
                                         data: 'prix=' + prix + '&_token=' + CSRF_TOKEN,
                                         type: 'post',
                                         success: function (data) {
                                             if(data)
                                             {
                                                 alertify.set('notifier', 'position', 'bottom-left');
                                                 alertify.set('notifier', 'delay', 30);
                                                 alertify.success("Le Total à Payer (+Transport) est :" + data + " Dhs");

                                             }
                                         }
                                     });
                                 }else{
                                     alertify.set('notifier', 'position', 'bottom-left');
                                     alertify.set('notifier', 'delay', 20);
                                     alertify.error("Veuillez préciser la date de naissance ");
                                 }
                             }
                          }
                      });




                  }
              });
              $('.nav-tabs  a').click(function (e) {
                  e.preventDefault();
                  $(this).tab('show');
              });
              $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
                  var id = $(e.target).attr("href");
                  localStorage.setItem('selectedTab', id)
              });
              var selectedTab = localStorage.getItem('selectedTab');
              $('.nav-tabs a[href="' + selectedTab + '"]').tab('show');

              $('#uploadFile').on('change',function(){
                  $('img.pdp.justhideit').hide();
                  $('div.pdp').show();
                  var files = !!this.files ? this.files : [];
                  if (!files.length || !window.FileReader) return;
                  if (/^image/.test( files[0].type)){ // only image file
                      var reader = new FileReader(); // instance of the FileReader
                      reader.readAsDataURL(files[0]); // read the local file

                      reader.onloadend = function(){ // set image data as background of div
                          $('img.pdp').attr('src','');
                          $("div.pdp").css({ "background-image":"url("+this.result+")",});
                          $('span.fileupload-new').text('changer la photo');
                      }

                  }
              });



           $('#email_resp').blur(function(){
             var email =  $(this).val();
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   url : '{{ URL::action('ChildrenController@checkiffamily')  }}',
                   data: 'email=' + email + '&_token=' + CSRF_TOKEN,
                   type :'post',
                   success:function(data){
                       if(data)
                       {
                           var json = JSON.parse(data);
                           $('input[name=numero_fixe]').val(json['numero_fixe']);
                           $('input[name=numero_portable]').val(json['numero_portable']);
                           $('input[name=adresse]').val(json['adresse']);
                           $('input[name=cin]').val(json['cin']);
                           $('input[name=nom_pere]').val(json['nom_pere']);
                           $('input[name=nom_mere]').val(json['nom_mere']);
                         //  $('input[name=email_responsable]').val(json['email_responsable']);
                           $('select[name=responsable]').val(json['responsable']);
                          // $('select[name=pere]').val(json['id']);



                        /*   alertify.set('notifier', 'position', 'bottom-right');
                           alertify.set('notifier', 'delay', 20);
                           var notification =   alertify.error("si le parent son nom est " + data +
                                   " veuillez vous rediriger vers ajouter un enfant en cliquant ici ");*/

                       }
                       //var canDismiss = false;
                     /*  notification.ondismiss = function(){
                           var href = '{{-- URL::action('ChildrenController@create_enfant')  --}}';
                           window.location.href = href;
                           return canDismiss;
                       };*/
                       setTimeout(function(){
                           canDismiss = true;
                       }, 1000);
                   }
               });
           });




              $('#matierep').attr('disabled','disabled');
              $('#fonction').change(function(){
               var fonction =  $(this).val();
                  if(fonction == 'professeur')
                  {
                      $('#matierep').attr('disabled',null);
                  }else{
                      $('#matierep').attr('disabled','disabled');
                  }

              });

              $(window).on('scroll',function(){
                  var scrollTop = $(window).scrollTop();
                  if(scrollTop > 316)
                  {
                      $('.tooltips.tooltip-effect-2').hide();
                  }else{
                      $('.tooltips.tooltip-effect-2').show();
                  }
                  console.log(scrollTop);
              });

             /* $('.email-info').tooltip(
                      { tooltipClass: 'withColor'}
              );*/

              $('.tooltips').css('visibility','hidden');
              $('div.form_champ.only-for-email').hover(function(){
                  $('.tooltips').css('visibility','visible');
              });
              $('div.form_champ.only-for-email').mouseleave(function(){
                  $('.tooltips').css('visibility','hidden');
              });



              $('#branche').prop('disabled','disabled');
              $('#classe').on('change',function(){
                var classe_id = $(this).val();
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  $.ajax({
                      url: '{{  URL::action('ChildrenController@getBranchWhenClassid')}}',
                      data: 'classe_id=' + classe_id + '&_token=' + CSRF_TOKEN,
                      type: 'post',
                      success: function (data) {
                          $('#branche').prop('disabled','');
                          $('#branche').empty();
                          $('#branche').prepend('<option selected>selectionnez une branche</option>');
                          $('#branche').append(data);
                      }
                  });

              });


              $('#branche-bloc').hide();
              $('#niveau').prop('disabled','disabled');
              $('#grade').on('change',function() {
                  var grade_id = $(this).val();
                  var grade_text = $(this).find('option:selected').text();

                  if (grade_text == 'Crèche') {
                      $('#branche-bloc').hide();
                      $('#niveau-bloc').hide();
                      $('#classe').prop('disabled', '');

                      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                      $.ajax({
                          url: '{{  URL::action('ChildrenController@getclassforcreche')}}',
                          data: 'grade_id=' + grade_id + '&_token=' + CSRF_TOKEN,
                          type: 'post',
                          success: function (data) {
                              $('#classe').empty();
                              $('#classe').prepend('<option selected>selectionnez une classe</option>');
                              $('#classe').append(data);
                          }
                      });
                  } else {

                  switch (grade_text) {
                      case 'Primaire':
                          $('#branche-bloc').hide();
                          $('#niveau-bloc').show()
                          $('#classe').prop('disabled', 'disabled');
                          ;
                          break;
                      case 'Collège':
                          $('#branche-bloc').hide();
                          $('#niveau-bloc').show()
                          $('#classe').prop('disabled', 'disabled');
                          ;
                          break;
                      case 'Lycée':
                          $('#branche-bloc').show();
                          $('#niveau-bloc').show()
                          $('#classe').prop('disabled', 'disabled');
                          ;
                          break;
                      case 'Crèche' :
                          $('#branche-bloc').hide();
                          $('#niveau-bloc').hide();
                          $('#classe').prop('disabled', '');
                          ;
                          break;
                      case 'Maternelle' :
                          $('#branche-bloc').hide();
                          $('#niveau-bloc').show();
                          $('#classe').prop('disabled', 'disabled');
                          ;
                          break;
                  }
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  $.ajax({
                      url: '{{  URL::action('ChildrenController@getLevelWhenGradeIsChosen')}}',
                      data: 'grade_id=' + grade_id + '&_token=' + CSRF_TOKEN,
                      type: 'post',
                      success: function (data) {
                          $('#niveau').prop('disabled', '');
                          $('#niveau').empty();
                          $('#niveau').prepend('<option selected>selectionnez un niveau</option>');
                          $('#niveau').append(data);
                      }
                  });
              }
              });



              $('#classe').prop('disabled','disabled');
              $('#niveau').on('change',function(){
                  var level_id = $(this).val();
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  $.ajax({
                      url: '{{  URL::action('ChildrenController@getClassroomWhenLevelId')}}',
                      data: 'level_id=' + level_id + '&_token=' + CSRF_TOKEN,
                      type: 'post',
                      success: function (data) {
                          $('#classe').prop('disabled','');
                          $('#classe').empty();
                          $('#classe').prepend('<option selected>selectionnez une classe</option>');
                          $('#classe').append(data);
                      }
                  });

              });

              $('#niveau').click(function(){
                  $('#classe').empty();
              });



                $('.username').click(function(){

                    $('li.dropdown').toggleClass('open');
                });



                 $('#submit').click(function(){
                     var grade = $('#grade option:selected').text();
                     if(grade == 'Lycée'  &&  !$.isNumeric($('#niveau').val()))
                     {
                         alertify.alert('vous devez choisir un niveau');
                         return false;
                     }
                     if(grade == 'Lycée'  &&  !$.isNumeric($('#branche').val()))
                     {
                         alertify.alert('vous devez choisir une branche');
                         return false;
                     }

                     if(grade == 'Collège' && !$.isNumeric($('#niveau').val()))
                     {
                         alertify.alert('vous devez choisir un niveau');
                         return false;
                     }
                     if(grade == 'Primaire' && !$.isNumeric($('#niveau').val()))
                     {
                         alertify.alert('vous devez choisir un niveau');
                         return false;
                     }
                     if(grade == 'Maternelle' && !$.isNumeric($('#niveau').val()))
                     {
                         alertify.alert('vous devez choisir un niveau');
                         return false;
                     }
                     if(grade == 'Crèche' && !$.isNumeric($('#classe').val()))
                     {
                         alertify.alert('vous devez choisir une classe');
                         return false;
                     }
                     if($.isNumeric($('#niveau').val()) && !$.isNumeric($('#classe').val()))
                     {
                         alertify.alert('vous devez choisir une classe');
                         return false;
                     }
                          showLoader();


                 });







          });
    </script>
@stop