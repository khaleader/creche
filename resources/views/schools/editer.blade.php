@extends('layouts.default')

@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')
    <div class="row">
        {!!  Form::model(\Auth::user(),['url'=> action('SchoolsController@profile',[\Auth::user()->id]),'method' => 'put','files'=>true]) !!}

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>
                                  <?php  $user = \Auth::user(); ?>
                                <img class="pdp" src="{{  $user->photo? asset('uploads/'.$user->photo ):asset('images/no_avatar.jpg')  }}" alt="">

                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                            <div class="btn_upload">
                                <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Sélectionner une image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                    {{--   Form::file('photo',null,['class'=>'default','id'=>'uploadFile']) --}}
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
                            <label for="cname" class="control-label col-lg-3">Nom de l'école</label>
                            <div class="form_ajout">
                                <input   value="{{ \Auth::user()->name }}"
                                         type="text" name="name" class="form_ajout_input"
                                         placeholder="Entrez le nom de l'école">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom du résponsable</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->nom_responsable }}" type="text" name="nom_responsable" class="form_ajout_input" placeholder="Entrez le nom du résponsable">

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

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Adresse</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->adresse }}"

                                       type="text" name="adresse" class="form_ajout_input"
                                       placeholder="Entrez l'adresse de l'école">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Ville</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->ville }}" type="text" name="ville" class="form_ajout_input" placeholder="Entrez la ville de l'école">

                            </div>
                        </div>


                        <!-- -->

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Site Web</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->site_web ? :''  }}"

                                       type="text" name="site_web" class="form_ajout_input"
                                       placeholder="Entrez le site web">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Page Facebook</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->page_facebook ?:''}}"

                                       type="text" name="page_facebook" class="form_ajout_input"
                                       placeholder="Entrez la page facebook">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Patente</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->patente }}"

                                       type="text" name="patente" class="form_ajout_input"
                                       placeholder="Entrez la patente">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Registre du commerce</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->registre_du_commerce }}"

                                       type="text" name="registre_du_commerce" class="form_ajout_input"
                                       placeholder="Entrez le registre du commerce">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Identification Fiscale</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->identification_fiscale }}"

                                       type="text" name="identification_fiscale" class="form_ajout_input"
                                       placeholder="Entrez l'identification fiscale">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">CNSS</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->cnss }}"

                                       type="text" name="cnss" class="form_ajout_input"
                                       placeholder="Entrez le Numéro CNSS">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">RIB</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->rib }}"

                                       type="text" name="rib" class="form_ajout_input"
                                       placeholder="Entrez le rib">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">ICE</label>
                            <div class="form_ajout">
                                <input value="{{ \Auth::user()->profile->ice }}"

                                       type="text" name="ice" class="form_ajout_input"
                                       placeholder="Entrez le ICE">

                            </div>
                        </div>
















                        <button class="btn_form" type="submit">Modifier</button>
                        <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                            class="btn_form" href="{{ URL::action('SchoolsController@profile',[\Auth::user()->id]) }}">
                            Annuler
                        </a>
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
        $(document).ready(function() {
            $('div.pdp').hide();
            $('#uploadFile').on('change', function () {
                $('img.pdp').hide();
                $('div.pdp').show();
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return;
                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function () { // set image data as background of div
                        $('.pdp').attr('src', '');
                        $(".pdp").css({"background-image": "url(" + this.result + ")",});
                        $('span.fileupload-new').text('changer la photo');
                    }

                }
            });
        });
            </script>

    @endsection