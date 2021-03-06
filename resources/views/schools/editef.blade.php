@extends('layouts.default')

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">

                    <div class="form-group last">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile" >
                                <div class="pdp"></div>
                                <?php
                              $user =  \App\User::where('id',\Auth::user()->id)->where('type','famille')->first();
                                if($user->photo)
                                   {
                                    $img =  asset('uploads/'.$user->photo);
                                   } else{
                                    $img =  asset('images/no_avatar.jpg');
                                }

                                ?>
                                <img class="pdp" src="{{ $img }}" alt="" />

                            </div>

                            <div class="fileupload-preview fileupload-exists thumbnail " ></div>
                            {!! Form::open(['url' => action('SchoolsController@upimage'),'files' => true]) !!}
                            @if($user->photo)
                            <div class="btn_upload">
                           <span class="btn btn-white btn-file">
                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Modifier La Photo</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input type="file" class="default" name="photo" id="uploadFile" />
                           </span>
                            </div>
                                @else
                                <div class="btn_upload">

                           <span class="btn btn-white btn-file">
                           <span class="fileupload-new"><i class="fa fa-paper-clip"></i>  Selectionner une image</span>
                           <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                           <input type="file" class="default" name="photo" id="uploadFile" />
                           </span>
                                </div>
                                @endif

                            <button style="float:none; margin-left:33%" class="btn_form"
                                    type="submit"  id="onlyphoto">Enregistrer</button>
                            {!! Form::close() !!}


                        </div>


                    </div>
                </div>
            </section>

        </div>
        {!! Form::open(['url' => action('SchoolsController@updatepassef'),'files'=>true]) !!}
        <div class="col-sm-9">

            <section class="panel">


                <div class="panel-body">
                    <div>
                        <div id="password" class="tab-pane">

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

                        </div>

                    </div>
                </div>
            </section>
            </tbody>
        </div>
        {!! Form::close() !!}
    </div>


@endsection


@section('jquery')
    <script>
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




           /* var image = $('#uploadFile');
            var formData = new FormData();
            formData.append('photo', image[0].files[0]);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('SchoolsController@upimage')}}',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: 'image=' + formData,
                type: 'post',
                dataType: 'json',
                contentType: 'multipart/form-data',
                processData: false,
                success: function (data) {
                    if(data)
                    {
                         console.log(data);
                    }
                }
            });*/



        });

       /* $('#onlyphoto').click(function(e){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('SchoolsController@upimage')}}',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                data: 'image=' + new FormData($("#upload_form")[0]),
                type: 'post',
                success: function (data) {
                    if(data)
                    {
                        console.log(data);
                    }
                }
            });


        });*/



    </script>


@stop