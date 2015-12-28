@extends('layouts.default')
@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')

    <div class="row">
        {!!  Form::model($family,['url'=> action('FamiliesController@update',[$family->id]),'method' => 'put','files'=>true]) !!}

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>

                                <img class="pdp" src="{{  $family->photo? asset('uploads/'.$family->photo):asset('images/no_avatar.jpg')  }}" alt="">

                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                            <div class="btn_upload">
                                <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Selectionner une image</span>
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
                            <label for="cname" class="control-label col-lg-3">Nom de l'homme</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{ $family->nom_pere }}" name="nom_enfant" class="form_ajout_input" placeholder="Entrez le nom de l'enfant">
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom de la femme</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{ $family->nom_mere }}" name="nom_enfant" class="form_ajout_input" placeholder="Entrez le nom de l'enfant">
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Le résponsable</label>
                            <div class="form_ajout">
                                @if($family->responsable == 1)
                                    <input type="text" disabled value="{{ 'Père'  }}"  class="form_ajout_input">
                                @else
                                    <input type="text" disabled value="{{ 'Mère'  }}"  class="form_ajout_input" >
                                @endif
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Email du responsable</label>
                            <div class="form_ajout">
                                <input type="text" disabled value="{{  $family->email_responsable }}" name="email_responsable" class="form_ajout_input" placeholder="Entrez l'email du responsable">
                                <input type="hidden" value="{{ $family->email_responsable  }}" name="em">
                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Adresse</label>
                            <div class="form_ajout">
                                {!! Form::text('adresse', $family->adresse,['class'=>'form_ajout_input']) !!}

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Numero fixe</label>
                            <div class="form_ajout">
                                {!! Form::text('numero_fixe', $family->numero_fixe,['class'=>'form_ajout_input']) !!}
                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Numero portable</label>
                            <div class="form_ajout">
                                {!! Form::text('numero_portable', $family->numero_portable,['class'=>'form_ajout_input']) !!}


                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">CIN du responsable</label>
                            <div class="form_ajout">
                                <input type="text" value="{{  $family->cin }}" disabled name="cin" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

                            </div>
                        </div>
                        <button class="btn_form" type="submit">Modifier</button>
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