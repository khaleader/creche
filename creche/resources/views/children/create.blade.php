@extends('layouts.default')
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
                                <img class="pdp" src="{{  asset('images/no_avatar.jpg') }}" alt="">
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                            <div class="btn_upload">
                                <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Selectionner une image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                   {!! Form::file('photo',null,['class'=>'default']) !!}
                                                <!--   <input type="file" class="default">-->
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

  <!--  3 links nav -->
            <section class="panel">
                <a href="enfants.html">
                    <div class="panel-body bloc_informations">
                        <img src="{{ asset('images/enfants.png') }}" >
                        <span class="count"> &nbsp;{{   App\Child::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Enfants</p>
                    </div>
                </a>
            </section>
            <section class="panel">
                <a href="familles.html">
                    <div class="panel-body bloc_informations">
                        <img src="{{  asset('images/familles.png') }}" ><span class="count">&nbsp;
                             {{  App\Family::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Familles</p>
                    </div>
                </a>
            </section>

            <section class="panel">
                <a href="professeurs.html">
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
                                Ajouter un enfant
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


                            <div class="form_champ {{ $errors->has('nom_enfant') ? 'has-error': '' }}">
                                <label for="cname" class="control-label col-lg-3">Nom de l'enfant</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('nom_enfant')?:'' }}" type="text" name="nom_enfant" class="form_ajout_input" placeholder="Entrez le nom de l'enfant">
                                </div>
                            </div>

                          <!--  <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Age de l'enfant</label>
                                <div class="form_ajout">
                                    <input  type="text" disabled name="age_enfant" class="form_ajout_input" placeholder="Entrez l'age de l'enfant">

                                </div>
                            </div>-->
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Date de naissance</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('date_naissance')?:'' }}" type="date" name="date_naissance" class="form_ajout_input foronlydate" placeholder="Entrez la date de naissance de l'enfant">
                                    <div class="icone_input"><i class="fa fa-"></i></div>

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom du pére</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('nom_pere')?:'' }}" type="text" name="nom_pere" class="form_ajout_input" placeholder="Entrez le nom du père">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Nom de la mère</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('nom_mere')?:'' }}" type="text" name="nom_mere" class="form_ajout_input" placeholder="Entrez le nom de la mère">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Le résponsable</label>
                                <div class="form_ajout">
                                    <select name="responsable" class="form_ajout_input" placeholder="Choisissez le responsable">
                                        <option value="1">Père</option>
                                        <option value="0">Mère</option>

                                    </select>

                                </div>
                            </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Le Transport</label>
                            <div class="form_ajout">
                                <select id="transport" name="transport" class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option selected value="0">Non</option>
                                    <option value="1">Oui</option>

                                </select>

                            </div>
                        </div>




                        <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Email du responsable</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('email_responsable')?:'' }}" type="email" name="email_responsable" class="form_ajout_input" placeholder="Entrez l'email du responsable">

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Adresse</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('adresse')?:'' }}" type="text" name="adresse" class="form_ajout_input" placeholder="Entrez l'adresse du responsable">

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numero fixe</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('numero_fixe')?:'' }}" type="text" name="numero_fixe" class="form_ajout_input" placeholder="Entrez le numéro fix du responsable">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numero portable</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('numero_portable')?:'' }}" type="text" name="numero_portable" class="form_ajout_input" placeholder="Entrez le numéro portable du responsable ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">CIN du responsable</label>
                                <div class="form_ajout">
                                    <input value="{{ Request::old('cin')?:'' }}" type="text" name="cin" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

                                </div>
                            </div>
                        <div>
                            <button  id="submit" class="btn_form" type="submit">Enregistrer </button>
                            <img id="loader-to" src="{{  asset('images/ajax-loader.gif') }}" >
                        </div>
                        <?php
                        $check = App\CategoryBill::where('user_id',\Auth::user()->id)->get();
                        if($check->isEmpty())
                        {
                      echo '<script type="text/javascript">

                     alertify.set("notifier","position", "top-right");
                     alertify.set("notifier","delay", 30);
                     alertify.error("Vous n\'avez pas encoré remplissez les tarifs de paiement  **cliquez D\'abord sur votre  profile puis > " +
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
                                    <label for="cname" class="control-label col-lg-3">Nom complet</label>
                                    <div class="form_ajout">
                                        <input type="text" name="nom_teacher" class="form_ajout_input" placeholder="Entrez le nom complet">

                                    </div>
                                </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Date de naissance</label>
                                <div class="form_ajout">
                                    <input type="date" name="date_naissance" class="form_ajout_input" placeholder="Entrez la date de naissance ">
                                    <div class="icone_input"><i class="fa fa-"></i></div>

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Poste</label>
                                <div class="form_ajout">
                                    <input type="text" name="poste" class="form_ajout_input" placeholder="Entrez le poste ">

                                </div>
                            </div>

                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Le sexe</label>
                                <div class="form_ajout">
                                    <select name="sexe" class="form_ajout_input" placeholder="Le sexe">
                                        <option>Homme</option>
                                        <option>Femme</option>

                                    </select>

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Email </label>
                                <div class="form_ajout">
                                    <input type="text" name="email" class="form_ajout_input" placeholder="Entrez l'email ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numéro fixe</label>
                                <div class="form_ajout">
                                    <input type="text" name="num_fix" class="form_ajout_input" placeholder="Entrez le numéro fixe ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Numéro portable</label>
                                <div class="form_ajout">
                                    <input type="text" name="num_portable" class="form_ajout_input" placeholder="Entrez le numéro portable ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Adresse</label>
                                <div class="form_ajout">
                                    <input type="text" name="adresse" class="form_ajout_input" placeholder="Entrez l'adresse">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">CIN </label>
                                <div class="form_ajout">
                                    <input type="text" name="cin" class="form_ajout_input" placeholder="Entrez le CIN ">

                                </div>
                            </div>
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Salaire</label>
                                <div class="form_ajout">
                                    <input type="text" name="salaire" class="form_ajout_input" placeholder="Entrez le salaire ">

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
        <span id="prices" style="display: none;"></span>
    <div class="row"></div>
    @endsection

@section('jquery')
    <script>
          $(document).ready(function() {
              $('#loader-to').hide();
              $('#submit').click(function () {
                  $('#loader-to').show();
              });
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


              $('input[type="date"]').blur(function () {
                  var inputDate = new Date(this.value);
                  var inputDate = inputDate.toLocaleDateString();
                  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                  $.ajax({
                      url: '{{  URL::action('ChildrenController@getage')}}',
                      data: 'inputd=' + inputDate + '&_token=' + CSRF_TOKEN,
                      type: 'post',
                      success: function (data) {
                          if (data == '') {
                              alertify.set('notifier', 'position', 'bottom-right');
                              alertify.set('notifier', 'delay', 60);
                              alertify.error('Attention L\'age de Cet Enfant est Introuvable  veuillez le créer S\'il Vous plait');
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
          });

    </script>


@stop