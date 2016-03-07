@extends('layouts.default')
@section('content')
@include('partials.alert-success')
@include('partials.alert-errors')

<div class="row">
    {!!  Form::model($child,['url'=> action('ChildrenController@update',[$child->id]),'method' => 'put','files'=>true]) !!}

    <div class="col-sm-3">
        <section class="panel">
            <div class="panel-body">
                <div class="form-group last">


                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new  Photo_profile">
                            <div class="pdp"></div>

                            <img class="pdp" src="{{  $child->photo? asset('uploads/'.$child->photo):asset('images/no_avatar.jpg')  }}" alt="">

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
                        <label for="cname" class="control-label col-lg-3">Nom de l'élève</label>
                        <div class="form_ajout">

                            <input type="text" disabled value="{{ $child->nom_enfant }}" name="nom_enfant" class="form_ajout_input" placeholder="Entrez le nom de l'enfant">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Date de naissance</label>
                        <div class="form_ajout">
                            <input disabled value="{{ \Carbon\Carbon::parse($child->date_naissance)->toDateString() }}" type="date" name="date_naissance" class="form_ajout_input foronlydate" placeholder="Entrez la date de naissance de l'enfant">
                            <div class="icone_input"><i class="fa fa-"></i></div>
                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Le Sexe</label>
                        <div class="form_ajout">
                            <input type="text" disabled value="{{ $child->sexe }}" name="sexe" class="form_ajout_input">

                        </div>
                    </div>

                    <div class="form_champ c">
                        <label for="cname" class="control-label col-lg-3">La Branche</label>
                        <div class="form_ajout">
                            <select id="branche" name="branche" class="form_ajout_input">

                                <option value="nobr" selected>Choisissez une branche</option>
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





                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Le Transport</label>
                        <div class="form_ajout">
                          <!--  <select name="transport" class="form_ajout_input" placeholder="Choisissez le responsable">
                                <option selected value="0">Non</option>
                                <option value="1">Oui</option>

                            </select>-->
                            @if($child->transport == 0)
                             <?php $status = 'non' ?>
                            @else
                                <?php $status = 'oui' ?>
                            @endif
                                {!!  Form::select('transport',
                                  App\Child::where('user_id',\Auth::user()->id)->where('id',$child->id)
                              ->lists('transport','transport') ,$child->transport,['class'=>'form_ajout_input']) !!}



                        </div>
                    </div>

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom du pére</label>
                        <div class="form_ajout">

                            <input type="text" disabled   value="{{  $child->family->nom_pere }}" name="nom_mere" class="form_ajout_input" >

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom de la mère</label>
                        <div class="form_ajout">

                                  <input type="text"  disabled  value="{{  $child->family->nom_mere }}" name="nom_mere" class="form_ajout_input" >

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Le résponsable</label>
                        <div class="form_ajout">
                            @if($child->family->responsable == 1)
                            <input type="text" disabled value="{{ 'Père'  }}"  class="form_ajout_input">
                            @else
                                <input type="text" disabled value="{{ 'Mère'  }}"  class="form_ajout_input" >
                            @endif
                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Email du responsable</label>
                        <div class="form_ajout">
                            <input type="text" disabled value="{{  $child->family->email_responsable }}" name="email_responsable" class="form_ajout_input" placeholder="Entrez l'email du responsable">
                            <input type="hidden" value="{{$child->family->email_responsable  }}" name="em">
                        </div>
                    </div>

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Adresse</label>
                        <div class="form_ajout">
                            {!! Form::text('adresse', $child->family->adresse,['class'=>'form_ajout_input']) !!}

                        </div>
                    </div>

                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Numero fixe</label>
                        <div class="form_ajout">
                            {!! Form::text('numero_fixe', $child->family->numero_fixe,['class'=>'form_ajout_input']) !!}
                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Numero portable</label>
                        <div class="form_ajout">
                            {!! Form::text('numero_portable', $child->family->numero_portable,['class'=>'form_ajout_input']) !!}


                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">CIN du responsable</label>
                        <div class="form_ajout">
                            <input type="text" value="{{  $child->family->cin }}" disabled name="cin" class="form_ajout_input" placeholder="Entrez le CIN du responsable">

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



            $('option[value="0"]').text('non');
            $('option[value="1"]').text('oui');

            var value = $('option').val();
            if(value == 0)
            {
                $('select[name=transport]').append('<option value="1">oui</option>');
            }else{
                $('select[name=transport]').append('<option value="0">non</option>');
            }



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

            $('#niveau').click(function(){
                $('#classe').empty();
            });



        });


    </script>
@stop