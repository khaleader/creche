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
                        <input type="hidden" name="familyid" value="{{ $family->id }}">

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