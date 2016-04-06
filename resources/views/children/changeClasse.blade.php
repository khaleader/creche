@extends('layouts.default')
@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')

    <div class="row">
        {!!  Form::open(['url'=> action('ChildrenController@changeClasse',[$child->id]),'method' => 'post']) !!}

        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile">
                                <div class="pdp"></div>

                                <img class="pdp" src="{{  $child->photo? asset('uploads/'.$child->photo):asset('images/no_avatar.jpg')  }}" alt="">

                            </div>
                            <div class="nom">
                                <span>{{  $child->nom_enfant }}</span>
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail "></div>
                        </div>


                    </div>
                </div>
            </section>

        </div>
        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Changer La Classe
                    </h4>
                </header>
                <div class="panel-body informations_general">
                    <table class="table table-hover general-table table_informations">
                        <div class="form_champ c" id="niveau-bloc">
                            <label for="cname" class="control-label col-lg-3">Le Niveau  </label>
                            <div class="form_ajout">
                                @foreach($child->levels as $level)
                                <input type="text" readonly  value="{{ $level->niveau }}" name="niveau" class="form_ajout_input">
                                    <input type="hidden" name="niveauId" value="{{ $level->id }}">
                                @endforeach

                            </div>
                            <input type="hidden" value="{{ $child->id }}" name="childId">
                        </div>


                        <div class="form_champ c">
                            <label for="cname" class="control-label col-lg-3">La Classe * </label>
                            <div class="form_ajout">
                                <select id="classe" name="classe" class="form_ajout_input">
                                    <option selected> Sélectionnez la classe s'il vous plait</option>
                                    @foreach($child->levels as $level)
                                        @foreach($level->classrooms as $classroom)
                                            <option value="{{ $classroom->id }}">{{ $classroom->nom_classe }}</option>
                                        @endforeach
                                            @foreach($level->lesClasses as $classroom)
                                                <option value="{{ $classroom->id }}">{{ $classroom->nom_classe }}</option>
                                            @endforeach
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        @foreach($child->levels as $level)
                        @if($level->grade->name == 'Lycée')
                                <div class="form_champ c" id="branche-bloc">
                                    <label for="cname" class="control-label col-lg-3">La Branche * </label>
                                    <div class="form_ajout">
                                        <select id="branche" name="branche" class="form_ajout_input">

                                            <option selected>Choisissez une branche</option>
                                            @foreach(\Auth::user()->branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->nom_branche }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>

                        @endif
                        @endforeach









                        <button id="submit" class="btn_form" type="submit">Modifier</button>
                        <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                            class="btn_form" href="{{ URL::action('ChildrenController@show',[$child]) }}">
                            Annuler
                        </a>
                    </table>
                </div>
            </section>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row"></div>
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th>La classe</th>
                            <th>Code classe</th>
                            <th>Capacité de Classe</th>
                            <th>Nombre d'élèves </th>
                            <th>Niveau</th>
                            <th>Branche</th>
                            <th>statut</th>
                            <th class="no-print"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($child->levels  as $level)
                            @foreach($level->classrooms as $cr)
                            <tr>
                                <td>{{  $cr->nom_classe }}</td>
                                <td>{{  $cr->code_classe }}</td>
                                <td>{{ $cr->capacite_classe }} élèves</td>
                                <td> {{ $cr->children()->CurrentYear()->count() }}</td>
                                <td>{{  $cr->niveau ? \Auth::user()->leslevels()->where('id',$cr->niveau)->first()->niveau : '--' }}</td>
                                <td>{{  $cr->branche ? \Auth::user()->branches()->where('id',$cr->branche)->first()->nom_branche : '--'  }}</td>


                               <td>
                                   @if( $cr->children()->CurrentYear()->count() >= $cr->capacite_classe)
                                       <span style="background-color: #d9434e" class="label label-info label-mini">Saturé</span>
                                   @else
                                       <span style="background-color: #84e07b" class="label label-primary label-mini">Non Saturé</span>
                                   @endif
                               </td>
                                <td class="no-print"><a href="{{ action('ClassroomsController@show',[$cr]) }}"><div  class="btn_details">Détails</div></a></td>
                            </tr>
                             @endforeach
                        @endforeach
                        @foreach($child->levels  as $level)
                            @foreach($level->lesClasses as $cr)
                                <tr>
                                    <td>{{  $cr->nom_classe }}</td>
                                    <td>{{  $cr->code_classe }}</td>
                                    <td>{{ $cr->capacite_classe }} élèves</td>
                                    <td> {{ $cr->children()->CurrentYear()->count() }}</td>

                                    <td>{{  $cr->niveau ? \Auth::user()->leslevels()->where('id',$cr->niveau)->first()->niveau : '--' }}</td>
                                    <td>{{  $cr->branche ? \Auth::user()->branches()->where('id',$cr->branche)->first()->nom_branche : '--'  }}</td>
                                    <td>
                                    @if( $cr->children()->CurrentYear()->count() >= $cr->capacite_classe)
                                        <span style="background-color: #d9434e" class="label label-info label-mini">Saturé</span>
                                    @else
                                        <span style="background-color: #84e07b" class="label label-primary label-mini">Non Saturé</span>
                                    @endif
                                    </td>
                                    <td class="no-print"><a href="{{ action('ClassroomsController@show',[$cr]) }}"><div  class="btn_details">Détails</div></a></td>
                                </tr>
                            @endforeach
                        @endforeach



                        </tbody>
                    </table>




                </div>
            </section>
        </div>
    </div>

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




            var value = $('option').parent('select[name=transport]').val();
            if(value == 0)
            {
                $('option').parent('select[name=transport]').find('option[value="0"]').text('non');
                $('select[name=transport]').append('<option value="1">oui</option>');
            }else{
                $('select[name=transport]').append('<option value="0">non</option>');
                $('option').parent('select[name=transport]').find('option[value="1"]').text('oui');

            }


            $('#branche').prop('disabled','disabled');
            $('#classe').on('change',function(){
                var classe_id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ChildrenController@getBranchWhenClassid')}}',
                    data: 'classe_id=' + classe_id + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('#branche').prop('disabled','');
                        $('#branche').empty();
                        $('#branche').prepend('<option selected>Sélectionnez une branche</option>');
                        $('#branche').append(data);
                    }
                });

            });


           // $('#branche-bloc').hide();
            $('#niveau').prop('disabled','disabled');

          //  $('#classe').prop('disabled','disabled');
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
                        $('#classe').prepend('<option selected>sélectionnez une classe</option>');
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