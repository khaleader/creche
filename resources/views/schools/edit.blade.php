@extends('layouts.default')




@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">
                        {!! Form::model($school,['url'=>action('SchoolsController@update',[\Auth::user()->id]),'method'=>'put','files'=>true]) !!}


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile" >
                                <div class="pdp"></div>
                                <img class="pdp" src="{{  $school->photo ? asset('uploads/'.$school->photo) :asset('images/no_avatar.jpg') }}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail " ></div>
                            <div class="btn_upload">
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Selectionner une image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                   <input type="file" class="default" name="photo" id="uploadFile" />
                                                   </span>

                            </div>
                        </div>


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
                                Modifier les informations
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#password">
                                Changer le mot de passe
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#paiement" class="contact-map">
                                Options de paiement
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content tasi-tab">
                        <div id="informations" class="tab-pane active">
                            <div class="row">
                                <tbody>

                                <div >
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




                        <div id="paiement" class="tab-pane">
                            <section class="panel">
                                {!! Form::open(['url'=> action('SchoolsController@category')]) !!}
                                    <div class="form_champ">
                                        <label for="cname" class="control-label col-lg-3">Nombre de catégories</label>
                                        <div class="form_ajout">
                                            <select id="categories" name="categories" class="form_ajout_input" placeholder="Choisissez le responsable">
                                                <option>Selectionnez La Categorie</option>
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
    <script>
        $(document).ready(function(){
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



        });
    </script>
    @stop