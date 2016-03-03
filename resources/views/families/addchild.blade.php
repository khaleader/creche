@extends('layouts.default')



@section('content')

    @include('partials.alert-success')
    @include('partials.alert-errors')

    <div class="row">
        {!!  Form::open(['url'=> action('FamiliesController@addchild'),'files'=>true]) !!}

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
                                <input id="date_birth_child" type="date" name="date_naissance" class="form_ajout_input foronlydate" placeholder="Entrez la date de naissance de l'enfant">
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
                                <select name="transport" id="transport" class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option selected value="0">Non</option>
                                    <option value="1">Oui</option>
                                </select>

                            </div>
                        </div>

                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">La Branche</label>
                            <div class="form_ajout">
                                <select id="branche" name="branche" class="form_ajout_input">

                                    <option selected>Choisissez une branche</option>
                                    @foreach(\Auth::user()->branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->nom_branche }}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>

                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">Le Niveau</label>
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


                        <input type="hidden" name="familyid" value="{{ $family->id }}">

                        <button class="btn_form" type="submit">Enregistrer</button>
                    </table>
                </div>
            </section>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row"></div>
    <span id="prices" style="display: none;"></span>
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



            $('#niveau').prop('disabled','disabled');
            $('#branche').on('change',function(){
                var branche_id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ChildrenController@getLevelWhenBranchId')}}',
                    data: 'branche_id=' + branche_id + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('#niveau').prop('disabled','');
                        $('#niveau').empty();
                        $('#niveau').prepend('<option selected>selectionnez un niveau</option>');
                        $('#niveau').append(data);
                    }
                });

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


        });


    </script>


@stop