@extends('layouts.default')
<script>
    localStorage.classe ='';
    localStorage.link ='';
</script>
@section('css')
  <link rel="stylesheet" href="{{ asset('js\bootstrap-datepicker\css\b-datepicker.css')  }}" type="text/css">
  <style>


  </style>
@stop



@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">



                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>
                                <img class="pdp" src="{{  $school->photo ? asset('uploads/'.$school->photo) :asset('images/no_avatar.jpg') }}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail " ></div>

                            {!! Form::open(['url' => action('SchoolsController@upimageecole'),'files' => true,'id'=>'FormImage']) !!}
                        @if($school->photo)
                            <div class="btn_upload">
                           <span class="btn btn-white btn-file">
                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i>  Changer La Photo</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input type="file" class="default" name="photo" id="uploadFile" />
                           </span>
                            </div>
                            @else
                                <div class="btn_upload">
                           <span class="btn btn-white btn-file">
                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i>   Selectionner une image </span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input type="file" class="default" name="photo" id="uploadFile" />
                           </span>
                                </div>
                            @endif
                            {!! Form::close() !!}

                        </div>


                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">

                        {!! Form::open(['url' => action('ProfilesController@store'),'files' => true,'id'=>'FormLogo']) !!}
                        @if(\Auth::user()->profile->logo)
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile" >
                                <img class="logo_school" src="{{ asset('uploads/'.Auth::user()->profile->logo) }}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail thumbnail_logo " ></div>

                            <div class="btn_upload">
                           <span class="btn btn-white btn-file">
                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Changer votre logo</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input name="logo" type="file" class="default" />
                           </span>
                            </div>
                        </div>
                            @else
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new  Photo_profile" >
                                    <img class="logo_school" src="{{ asset('images/no_logo.png') }}" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail thumbnail_logo " ></div>

                                <div class="btn_upload">
                           <span class="btn btn-white btn-file">
                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Uploader votre logo</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input name="logo" type="file" class="default" />
                           </span>
                                </div>
                            </div>
                        @endif
                            {!!  Form::close() !!}



                    </div>
                </div>
            </section>

        </div>
        <div class="col-sm-9">
            <section class="panel">

                <header class="panel-heading tab-bg-dark-navy-blue">
                    <ul class="nav nav-tabs nav-justified ">
                        <li class="active">
                            <a data-toggle="tab" href="#informations">
                               mes informations
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#password">
                                 mot de passe
                            </a>
                        </li>
                       <!-- <li>
                            <a data-toggle="tab" href="#paiement" class="contact-map">
                               paiem
                            </a>
                        </li>-->
                        <li>
                            <a data-toggle="tab" href="#school">
                                Scolarité
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#paiements" class="contact-map">
                                Paiements
                            </a>
                        </li>



                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content tasi-tab">
                        <div id="informations" class="tab-pane active">
                            <div class="row">
                                <tbody>

                                      <div>
                                          {!! Form::model($school,['url'=>action('SchoolsController@update',[\Auth::user()->id]),'method'=>'put','files'=>true]) !!}
                                          <div style="display: none;" class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Nom de l'école</label>
                                            <div class="form_ajout">
                                                <input   value="{{ $school->name }}"
                                                        style="background-color:#CED7DE "
                                                        type="text" name="name" class="form_ajout_input"
                                                        placeholder="Entrez le nom de l'école">

                                            </div>
                                        </div>
                                        <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Nom du résponsable</label>
                                            <div class="form_ajout">
                                                <input value="{{ $school->nom_responsable }}" type="text" name="nom_responsable" class="form_ajout_input" placeholder="Entrez le nom du résponsable">

                                            </div>
                                        </div>


                                        <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Téléphone fixe</label>
                                            <div class="form_ajout">
                                                {!! Form::text('tel_fixe',null,['class'=>'form_ajout_input','placeholder'=>'Entrez le numéro fixe']) !!}

                                            </div>
                                        </div>
                                        <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Téléphone portable</label>
                                            <div class="form_ajout">
                                                {!!  Form::text('tel_portable',null,['class'=>'form_ajout_input','placeholder'=>'Entrez le numéro portable']) !!}

                                            </div>
                                        </div>

                                        <div style="display: none;" class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Email de l'école</label>
                                            <div class="form_ajout">
                                                {!! Form::text('email',null,['placeholder'=>'Entrez l\'email de l\'école',
                                                'class'=>'form_ajout_input']) !!}
                                            </div>
                                        </div>
                                        <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Adresse</label>
                                            <div class="form_ajout">
                                                <input value="{{ $school->adresse }}"

                                                       type="text" name="adresse" class="form_ajout_input"
                                                       placeholder="Entrez l'adresse de l'école">

                                            </div>
                                        </div>
                                        <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Ville</label>
                                            <div class="form_ajout">
                                                <input value="{{ $school->ville }}" type="text" name="ville" class="form_ajout_input" placeholder="Entrez la ville de l'école">

                                            </div>
                                        </div>
                                    <!--   <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">Pays</label>
                                            <div class="form_ajout">

                                              <!--  <select name="pays" class="form_ajout_input" placeholder="Choisissez le responsable">
                                                    <option value="{{-- $school->pays --}}">{{-- $school->pays --}}</option>
                                                </select> -->
                                              <!--  <input type="text" disabled class="form_ajout_input" value="{{-- $school->pays --}}">

                                            </div>
                                        </div> -->

                                        <div>
                                            <button id="submit" class="btn_form" type="submit">Enregistrer</button>
                                            <img id="loader-to" src="{{  asset('images/ajax-loader.gif') }}" >
                                        </div>
                                    {!!  Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div id="password" class="tab-pane">
                           {!! Form::open(['url' => action('SchoolsController@updatepass')]) !!}
                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Mot de passe actuel</label>
                                    <div class="form_ajout">
                                        <input type="password" name="actualpass" class="form_ajout_input" placeholder="Entrez le mot de passe actuel">

                                    </div>
                                </div>
                                <div id="password" class="tab-pane">
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Le nouveau mot de passe</label>
                                        <div class="form_ajout">
                                            <input type="password" name="password" class="form_ajout_input" placeholder="Entrez le nouveau mot de passe">

                                        </div>
                                    </div>
                                </div>
                                <div id="password" class="tab-pane">
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Saisir à nouveau</label>
                                        <div class="form_ajout">
                                            <input type="password" name="password_confirmation" class="form_ajout_input" placeholder="Confirmer le nouveau mot de passe">

                                        </div>
                                    </div>
                                </div>
                                <button class="btn_form" type="submit">Enregistrer</button>
                            {!! Form::close() !!}
                        </div>




                       <!-- <div id="paiement" class="tab-pane">
                            <section class="panel">
                                {!! Form::open(['url'=> action('SchoolsController@category')]) !!}
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Nombre de catégories</label>
                                        <div class="form_ajout">
                                            <select id="categories" name="categories" class="form_ajout_input" placeholder="Choisissez le responsable">
                                                <option>Sélectionnez La Catégorie</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>

                                            </select>

                                        </div>
                                    </div>
                                    <div id="categorie1" data-value="1">
                                    <label class="categorie_label">Catégorie <strong></strong> :</label>
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Age de </label>
                                        <div class="form_paiement">
                                            <input id="age_de" type="number" name="age_de" class="form_paiement_input" placeholder="1">

                                        </div>
                                    </div>
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">à </label>
                                        <div class="form_paiement">
                                            <input id="age_a" type="number" name="age_a" class="form_paiement_input" placeholder="1">

                                        </div>
                                    </div>
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Prix</label>
                                        <div class="form_paiement">
                                            <input id="prix" type="text" name="prix" class="form_paiement_input" placeholder="Entrez le prix">

                                        </div>
                                    </div>
                                    </div>
                                    <div class="form_paiement_sep"></div>
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Prix transport</label>
                                        <div class="form_ajout">
                                            @if(App\Transport::where('user_id',\Auth::user()->id)->exists())
                                            <input type="text" value="{{ \Auth::user()->transport->somme}}"
                                                   name="somme" class="form_ajout_input" placeholder="Entrez le prix du transport">
                                              @else
                                                <input type="text" value="0"
                                                       name="somme" class="form_ajout_input" placeholder="Entrez le prix du transport">
                                            @endif

                                        </div>
                                    </div>
                                  <input id="cat" name="cat" type="hidden">
                                    <button class="btn_form" type="submit">Enregistrer</button>


                                {!!  Form::close() !!}
                            </section>
                        </div> -->



                        <div id="school" class="tab-pane">
                            <section class="panel">
                                {!! Form::open(['url'=>action('SchoolYearsController@store')]) !!}
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">
                                            Sélectionnez une année scolaire
                                           <!-- <strong  class="tooltip-annee" title="quand vous créez une nouvelle année scolaire ca veut
                                            dire que tout ce que vous voyez dans l'application est en relation avec cette année scolaire
                                             donc l'année scolaire précédente est renvoyé automatiquement à l'historique">
                                             <i class="fa fa-info-circle"></i>
                                            </strong>-->
                                        </label>
                                        <div class="form_ajout">

                                                <?php
                                               //$ann_scol = Auth::user()->schoolyears()->first()->ann_scol;
                                                ?>
                                                    <!--<select  name="ann_scol" class="form_ajout_input">
                                                    <option selected value="{{-- $ann_scol --}}">{{-- str_replace('-','/',$ann_scol) --}}</option>
                                                    </select>-->

                                                <select name="ann_scol" class="form_ajout_input">

                                                    <option value="0" selected>Sélectionnez une année scolaire</option>
                                                    <option value="2015-2016">2015/2016</option>
                                                    <option value="2016-2017">2016/2017</option>
                                                    <option value="2017-2018">2017/2018</option>
                                                    <option value="2018-2019">2018/2019</option>
                                                    <option value="2019-2020">2019/2020</option>
                                                    <option value="2020-2021">2020/2021</option>
                                                </select>



                                        </div>
                                    </div>
                                    <div id="school" class="tab-pane">
                                        <div class="form_champ">
                                            <label for="cname" class="control-label col-lg-3">
                                                Type de périodes  <strong class="tooltip-type" title="remplissez les dates avec précaution car cela risque de ne pas générer
                                             des factures si la date de génération de facture n'est pas entre la première date et la dernière date">
                                                    <i class="fa fa-info-circle"></i></strong></label>


                                            <div class="form_ajout">
                                                <select name="TrimSemis" class="form_ajout_input">
                                                    <option value="0" selected>Selectionnez s'il vous plait</option>
                                                    <option value="Trim">Trimestrielle</option>
                                                    <option value="Semis">Semestrielle</option>

                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <ul class="informations_general trimestres">

                                        <li class="picker ">
                                            <label class="type_label">Trimestre 1 :</label>
                                            <div class="type_choice">
                                                <span><strong>de : </strong></span>
                                                <input name="champ1start" data-format="hh:mm:ss" type="text" class="calendarpicker calpicker">
                                            </div>
                                            <div class="type_choice">
                                                <span><strong>à : </strong></span>
                                                <input name="champ1end" data-format="hh:mm:ss" type="text" class="calendarpicker calpicker">
                                            </div>
                                        </li>
                                        <li class="picker ">
                                            <label class="type_label">Trimestre 2 :</label>
                                            <div class="type_choice">
                                                <span><strong>de : </strong></span>
                                                <input name="champ2start" data-format="hh:mm:ss" type="text" class="calendarpicker calpicker">
                                            </div>
                                            <div class="type_choice">
                                                <span><strong>à : </strong></span>
                                                <input name="champ2end" data-format="hh:mm:ss" type="text" class="calendarpicker calpicker">
                                            </div>
                                        </li>
                                        <li class="picker ">
                                            <label class="type_label">Trimestre 3 :</label>
                                            <div class="type_choice">
                                                <span><strong>de : </strong></span>
                                                <input name="champ3start" data-format="hh:mm:ss" type="text" class="calendarpicker calpicker">
                                            </div>
                                            <div class="type_choice">
                                                <span><strong>à : </strong></span>
                                                <input name="champ3end" data-format="hh:mm:ss" type="text" class="calendarpicker calpicker">
                                            </div>
                                        </li>


                                    </ul>

                                    <button id="submit-ann" class="btn_form" type="submit">Enregistrer</button>
                                {!!  Form::close() !!}



                            </section>
                        </div>




                        <!--  paiements par niveau -->

                        <div id="paiements" class="tab-pane">
                            <section class="panel">
                                {!! Form::open(['url'=> action('SchoolsController@price_bills_store')]) !!}

                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Année scolaire</label>
                                    <div class="form_ajout">
                                        <select id="ann_scol_years" name="school_year" class="form_ajout_input">
                                            <option>Année scolaire ?</option>
                                            @foreach(Auth::user()->schoolyears()->get() as $yearschool)

                                                <option value="{{ $yearschool->id }}">{{ $yearschool->ann_scol }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Les Niveaux</label>
                                    <div class="form_ajout">
                                        <select id="niveaux" name="niveau" class="form_ajout_input">


                                        </select>
                                    </div>
                                </div>
                                <div id="price_div" >
                                    <label class="categorie_label"> <strong></strong> </label>

                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Prix</label>
                                        <div class="form_paiement">
                                            <input id="price" type="text" name="price" class="form_paiement_input" placeholder="Entrez le prix">

                                        </div>
                                    </div>
                                </div>
                                <div class="form_paiement_sep"></div>
                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Prix transport</label>
                                    <div class="form_ajout">
                                        @if(App\Transport::where('user_id',\Auth::user()->id)->exists())
                                            <input type="text" value="{{ \Auth::user()->transport->somme}}"
                                                   name="somme" class="form_ajout_input" placeholder="Entrez le prix du transport">
                                        @else
                                            <input type="text" value="0"
                                                   name="somme" class="form_ajout_input" placeholder="Entrez le prix du transport">
                                        @endif

                                    </div>
                                </div>
                                <input id="cat" name="cat" type="hidden">
                                <button id="submit-p" class="btn_form" type="submit">Enregistrer</button>


                                {!!  Form::close() !!}
                            </section>
                        </div>


                    </div>
                </div>
            </section>
            </tbody>
        </div>

    </div>
    <div class="row"></div>
@endsection

@section('jquery')
    <script src="{{ asset('js\bootstrap-datepicker\js\moment.js') }}"></script>
    <script src="{{ asset('js\bootstrap-datepicker\js\b-datepicker.js') }}"></script>
    <script>
        $(document).ready(function(){
           // $('div#categorie1').hide();
            $('div.pdp').hide();
            $('#uploadFile').on('change',function(){
                $('img.pdp').hide();
                $('div.pdp').show();
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return;
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function(){ // set image data as background of div
                        $('.pdp').attr('src','');
                        $(".pdp").css({ "background-image":"url("+this.result+")",});
                        $('span.fileupload-new').text('changer la photo');
                    }

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

// store the currently selected tab in the hash value


            // on load of the page: switch to the currently selected tab


            $('#loader-to').hide();
            $('#submit').click(function(){
                $('#loader-to').show();
            });
        $('a[href="#paiement"]').on('click',function(){
            localStorage.tab = 'paiem';
                $('#categorie1').hide();
                $('input[type="file"]').prop('disabled',true);
            });
            $('a[href="#password"]').on('click',function(){
                localStorage.tab = 'pass';
                $('input[type="file"]').prop('disabled',true);

            });
            $('a[href="#informations"]').on('click',function(){
                localStorage.tab = 'info';
                $('input[type="file"]').prop('disabled',false);
            });
        $('#categories').on('change',function(){
            var cat =  $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('SchoolsController@show_cat_bills')}}',
                data: 'cat=' + cat + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                  var json = JSON.parse(data);
                    if(json)
                    {
                        $('input[name=age_de]').val(json['age_de']);
                        $('input[name=age_a]').val(json['age_a']);
                        $('input[name=prix]').val(json['prix']);
                    }
                }
            });
          if($(this).val() == 1)
          {
              localStorage.category =1;
              $('#cat').val(localStorage.category);
              $('div#categorie1 strong').text(1);
              $('div#categorie1').show();
          }else if($(this).val() == 2)
          {
              $('div#categorie1').show();
              localStorage.category =2;
              $('#cat').val(localStorage.category);
              $('div#categorie1 strong').text(2);
          }
          else if($(this).val() == 3)
          {
              $('div#categorie1').show();
              localStorage.category =3;
              $('#cat').val(localStorage.category);
              $('div#categorie1 strong').text(3);
          }
          else if($(this).val() == 4)
          {
              $('div#categorie1').show();
              localStorage.category =4;
              $('div#categorie1 strong').text(4);
              $('#cat').val(localStorage.category);

          }else{
              $('div#categorie1').hide();
              $('#age_de').val(0);
              $("#age_a").val(0);
              $('#prix').val(0);
          }
        });
            $(".alert-danger").fadeTo(15000, 500).slideUp(500, function(){
                $(".alert-danger").alert('close');
            });


            $('#niveaux').change(function(){
              var niveau_id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('SchoolsController@show_price_bills')}}',
                    data: 'niveau_id=' + niveau_id + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {

                      var json = JSON.parse(data);
                        if(json)
                        {
                            $('input[name=price]').val(json['prix']);

                        }
                    }
                });
            });

            $('#submit-p').click(function(){
                if(!$.isNumeric($('#ann_scol_years').val()))
                {
                    alertify.alert("l'année scolaire est requis");
                    return false;
                }
                if(!$.isNumeric($('#niveaux').val()))
                {
                    alertify.alert('Selectionnez Un Niveau !');
                    return false;
                }


               if($.isNumeric($('#niveaux').val()) && $('#price').val() == 0)
               {
                   alertify.alert('le prix de niveau est requis');
                   return false;
               }
                if($.isNumeric($('#niveaux').val()) && $('#price').val() == '')
                {
                    alertify.alert('le prix de niveau est requis !');
                    return false;
                }
            });

            $('ul.trimestres > li').hide();
            $('select[name=TrimSemis]').change(function() {
                var TrimSemisType = $(this).val();
                if (TrimSemisType == 'Trim') {
                    $('ul.trimestres > li').show();
                }
                if (TrimSemisType == 'Semis') {
                    $('ul.trimestres > li').show();
                    $('ul.trimestres  li:last-child').hide();
                }
                if (TrimSemisType == 0) {
                    $('ul.trimestres > li').hide();
                }


                if ($('select[name=ann_scol]').val() == 0) {
                    alertify.alert('selectionnez l\'année scolaire');
                    $('ul.trimestres > li').hide();
                    return false;
                }

                var user_id = '{{  \Auth::user()->id }}';
                var ann_scol = $('select[name=ann_scol]').val();
                var type = TrimSemisType;

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('SchoolYearsController@getdates')}}',
                    data: 'user_id=' + user_id + '&type='+ type +'&ann_scol='+ ann_scol  +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                             var json = JSON.parse(data);
                             if (json) {

                                 $('input[name=champ1start]').val(moment(json['startch1']).format('DD-MM-YYYY'));
                                 $('input[name=champ1end]').val(moment(json['endch1']).format('DD-MM-YYYY'));
                                 $('input[name=champ2start]').val(moment(json['startch2']).format('DD-MM-YYYY'));
                                 $('input[name=champ2end]').val(moment(json['endch2']).format('DD-MM-YYYY'));
                                 if(json['startch3'] !== null && json['endch3'] !== null)
                                 {
                                     $('input[name=champ3start]').val(moment(json['startch3']).format('DD-MM-YYYY'));
                                     $('input[name=champ3end]').val(moment(json['endch3']).format('DD-MM-YYYY'));
                                 }

                             }
                            if(data == '[]')
                            {
                                $('input[name=champ1start]').val('');
                                $('input[name=champ1end]').val('');
                                $('input[name=champ2start]').val('');
                                $('input[name=champ2end]').val('');
                                $('input[name=champ3start]').val('');
                                $('input[name=champ3end]').val('');
                            }
                    }
                });


            });

            $('select[name=ann_scol]').change(function(){
                $('select[name=TrimSemis]').val(0).prop('selected','selected');
                $('input[name=champ1start]').val('');
                $('input[name=champ1end]').val('');
                $('input[name=champ2start]').val('');
                $('input[name=champ2end]').val('');
                $('input[name=champ3start]').val('');
                $('input[name=champ3end]').val('');
            });


            $('#submit-ann').click(function(){
              if($('select[name=ann_scol]').val() == 0)
              {
                  alertify.alert('vous devez selectionner  l\'année scolaire!');
                  return false;
              }
                if($('select[name=TrimSemis]').val() == 0)
                {
                    alertify.alert('Selectionnez un type de période');
                    return false;
                }

            });

            $('input[name=champ1start]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left bottom',
                language: 'fr'
            });
            $('input[name=champ1end]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left bottom',
                language: 'fr'
            });
            $('input[name=champ2start]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left bottom',
                language: 'fr'
            });
            $('input[name=champ2end]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left bottom',
                language: 'fr'
            });
            $('input[name=champ3start]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left bottom',
                language: 'fr'
            });
            $('input[name=champ3end]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left bottom',
                language: 'fr'
            });

            $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
                $(".alert-success").alert('close');
                $('#loader-to').hide();
            });
            $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
                $(".alert-danger").alert('close');
                $('#loader-to').hide();
            });
            var position = { my: 'center top', at: 'center bottom+10' };
        $('.tooltip-type').tooltip();
           /* $('.tooltip-annee').tooltip(
                    'option', 'position', position

            );*/


            $('input[name=logo]').on("change",function () {

                var fileExtension = ['jpeg','jpg','png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    // alert("Only '.jpeg','.jpg' formats are allowed.");
                    alertify.alert(this.value);
                    alertify.alert("Votre logo n'est pas valide");
                    return false;
                }
                else {
                  $('#FormLogo').submit();
                }
            });
            $('input[name=photo]').on("change",function () {

                var fileExtension = ['jpeg','jpg','png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    // alert("Only '.jpeg','.jpg' formats are allowed.");
                    alertify.alert(this.value);
                    alertify.alert("Votre Image n'est pas valide");
                    return false;
                }
                else {
                    $('#FormImage').submit();
                }
            });
            if(localStorage.scYear)
            {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('SchoolYearsController@getLevels')}}',
                    data: 'school_year_id=' + localStorage.scYear+ '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('#ann_scol_years').val(localStorage.scYear).attr('selected','selected');
                        $('select[name=niveau]').empty().append(data);
                        $('select[name=niveau]').prepend('<option>Quel Niveau ?</option>');
                    }
                });
            }

        $('#ann_scol_years').change(function(){
            var school_year_id =  $(this).val();
            localStorage.scYear = school_year_id;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('SchoolYearsController@getLevels')}}',
                data: 'school_year_id=' + school_year_id + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                 $('select[name=niveau]').empty().append(data);
                }
            });

        });










        });
    </script>
    @stop