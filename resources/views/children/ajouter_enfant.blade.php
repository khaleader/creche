@extends('layouts.default')



@section('content')

    @include('partials.alert-success')
    @include('partials.alert-errors')

    <div class="row">
        {!!  Form::open(['url'=> action('ChildrenController@store_enfant'),'files'=>true]) !!}

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>
                                <img class="pdp" src="{{  asset('images/no_avatar.jpg') }}" alt="">
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                            <div class="btn_upload">
                                <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Selectionner une image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                   {{-- Form::file('photo',null,['class'=>'default']) --}}
                                                           <input name="photo" type="file" class="default" id="uploadFile">
                              </span>

                            </div>
                        </div>


                    </div>
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
                    <table class="table table-hover general-table table_informations">


                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom de l'enfant</label>
                            <div class="form_ajout">
                                <input type="text" name="nom_enfant" class="form_ajout_input" placeholder="Entrez le nom de l'enfant">

                            </div>
                        </div>
                       <!-- <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Age de l'enfant</label>
                            <div class="form_ajout">
                                <input type="text" disabled name="age_enfant" class="form_ajout_input" placeholder="Entrez l'age de l'enfant">

                            </div>
                        </div>-->
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Date de naissance</label>
                            <div class="form_ajout">
                                <input type="date" name="date_naissance" class="form_ajout_input foronlydate" placeholder="Entrez la date de naissance de l'enfant">
                                <div class="icone_input"><i class="fa fa-"></i></div>

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Le Sexe</label>
                            <div class="form_ajout">
                                <select name="sexe" class="form_ajout_input">
                                    <option value="garcon">Garcon</option>
                                    <option value="fille">Fille</option>
                                </select>
                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Le Transport</label>
                            <div class="form_ajout">
                                <select name="transport" class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option selected value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">La Classe</label>
                            <div class="form_ajout">

                                {!!  Form::select('classe',
                      App\Classroom::where('user_id',\Auth::user()->id)->
                      lists('nom_classe','id') ,null,['class'=>'form_ajout_input','id'=>'classe']) !!}
                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom du pére</label>
                            <div class="form_ajout">
                                {!!  Form::select('pere',
                                App\Family::where('user_id',\Auth::user()->id)->lists('nom_pere','id') ,null,['class'=>'form_ajout_input','id'=>'pere']) !!}
                              <!--  <input type="text" name="nom_pere" class="form_ajout_input" placeholder="Entrez le nom du père">-->

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom de la mère</label>
                            <div class="form_ajout">
                                {!!  Form::select('mere',App\Family::where('user_id',\Auth::user()->id)->lists('nom_mere','id'),null,['class'=>'form_ajout_input','id'=>'mere']) !!}

                                <!--<input type="text" name="nom_mere" class="form_ajout_input" placeholder="Entrez le nom de la mère">-->

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
                            <label for="cname" class="control-label col-lg-3">Email du responsable</label>
                            <div class="form_ajout">
                                <input type="text" name="email_responsable" class="form_ajout_input" placeholder="Entrez l'email du responsable">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Adresse</label>
                            <div class="form_ajout">
                                <input type="text" name="adresse" class="form_ajout_input" placeholder="Entrez l'adresse du responsable">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Numero fixe</label>
                            <div class="form_ajout">
                                <input type="text" name="numero_fixe" class="form_ajout_input" placeholder="Entrez le numéro fix du responsable">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Numero portable</label>
                            <div class="form_ajout">
                                <input type="text" name="numero_portable" class="form_ajout_input" placeholder="Entrez le numéro portable du responsable ">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">CIN du responsable</label>
                            <div class="form_ajout">
                                <input type="text" name="cin" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

                            </div>
                        </div>
                        <button class="btn_form" type="submit">Enregistrer</button>
                    </table>
                </div>
            </section>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row"></div>
@endsection

@section('jquery')
    <script>
 $(function(){
     $('div.pdp').hide();
     $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
         $(".alert-danger").alert('close');
     });
     $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
         $(".alert-success").alert('close');
     });


     $('#pere').change(function(){
         $('input').empty();
         var id_pere =  $(this).val();
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
             url: '{{  URL::action('ChildrenController@create_enfant')}}',
             data: 'id_pere=' + id_pere + '&_token=' + CSRF_TOKEN,
             type: 'post',
             success: function (data) {
                 var json = JSON.parse(data);
                 $('input[name=numero_fixe]').val(json['numero_fixe']);
                 $('input[name=numero_portable]').val(json['numero_portable']);
                 $('input[name=adresse]').val(json['adresse']);
                 $('input[name=cin]').val(json['cin']);
                 $('input[name=email_responsable]').val(json['email_responsable']);
                 $('select[name=responsable]').val(json['responsable']);
                 $('select[name=mere]').val(json['id']);
             }
         });

     });
     $('#mere').change(function(){
         $('input').empty();
         var id_mere =  $(this).val();
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
         $.ajax({
             url: '{{  URL::action('ChildrenController@create_enfant')}}',
             data: 'id_mere=' + id_mere + '&_token=' + CSRF_TOKEN,
             type: 'post',
             success: function (data) {
                 var json = JSON.parse(data);
                 $('input[name=numero_fixe]').val(json['numero_fixe']);
                 $('input[name=numero_portable]').val(json['numero_portable']);
                 $('input[name=adresse]').val(json['adresse']);
                 $('input[name=cin]').val(json['cin']);
                 $('input[name=email_responsable]').val(json['email_responsable']);
                 $('select[name=responsable]').val(json['responsable']);
                 $('select[name=pere]').val(json['id']);
             }
         });
     });

     $('#pere').prepend('<option value="default" selected>' +  " selectionnez s'il vous plait " +'</option>');
     $('#mere').prepend('<option value="default" selected>' +  " selectionnez s'il vous plait " +'</option>');

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

 });


    </script>


@stop