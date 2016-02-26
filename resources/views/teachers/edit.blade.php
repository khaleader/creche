@extends('layouts.default')
@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')

    <div class="row">
        {!!  Form::model($teacher,['url'=> action('TeachersController@update',[$teacher->id]),'method' => 'put','files'=>true]) !!}

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>

                                <img class="pdp" src="{{  $teacher->photo? asset('uploads/'.$teacher->photo):asset('images/no_avatar.jpg')  }}" alt="">

                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                            @if($teacher->photo)
                                <div class="btn_upload">
                                <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Changer la photo</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                    {{--   Form::file('photo',null,['class'=>'default','id'=>'uploadFile']) --}}
                                    <input name="photo" type="file" class="default" id="uploadFile">
                              </span>

                                </div>

                            @else
                                <div class="btn_upload">
                                <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Selectionner une image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                    {{--   Form::file('photo',null,['class'=>'default','id'=>'uploadFile']) --}}
                                    <input name="photo" type="file" class="default" id="uploadFile">
                              </span>

                                </div>


                             @endif

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
                            <label for="cname" class="control-label col-lg-3">Nom</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{ $teacher->nom_teacher }}" name="nom_teacher" class="form_ajout_input" >
                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Poste</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{ $teacher->poste }}" name="poste" class="form_ajout_input" >
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Date De naissance</label>
                            <div class="form_ajout">
                                <input type="date" disabled value="{{ \Carbon\Carbon::parse($teacher->date_naissance)->toDateString() }}" name="date_naissance" class="form_ajout_input">
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Sexe</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{ $teacher->sexe }}" name="sexe" class="form_ajout_input" >
                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Email</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{ $teacher->email }}" name="email" class="form_ajout_input">
                            </div>
                        </div>


                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Adresse</label>
                            <div class="form_ajout">
                                {!! Form::text('adresse', $teacher->adresse,['class'=>'form_ajout_input']) !!}

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Numero fixe</label>
                            <div class="form_ajout">
                                {!! Form::text('num_fix', $teacher->num_fix,['class'=>'form_ajout_input']) !!}
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Numero portable</label>
                            <div class="form_ajout">
                                {!! Form::text('num_portable', $teacher->num_portable,['class'=>'form_ajout_input']) !!}


                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">CIN du responsable</label>
                            <div class="form_ajout">
                                <input type="text" value="{{  $teacher->cin }}" disabled name="cin" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Salaire</label>
                            <div class="form_ajout">
                                <input type="text" value="{{  $teacher->salaire }}"  name="salaire" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

                            </div>
                        </div>
                        <button class="btn_form" type="submit">Modifier</button>
                        <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                            class="btn_form" href="{{ URL::previous() }}">
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


        });


    </script>
@stop