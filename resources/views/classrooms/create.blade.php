@extends('layouts.default')

@section('content')
    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <header class="panel-heading">
                    Matières

                </header>
                <div class="panel-body">

                    <table class="table  table-hover general-table">

                        {!!  Form::open(['url'=> action('ClassroomsController@store')]) !!}
                        <tbody>
                        @foreach($matieres as $mat)
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input name="select[]" type="checkbox"  value="{{  $mat->id }}">
                                </div>
                                <span><strong>{{ $mat->nom_matiere }}</strong></span></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>
            </section>
        </div>








        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>

                    <a href="{{ action('TimesheetsController@index') }}"><div class="btn2">Emploi du temps</div></a>

                </header>
                <div class="panel-body informations_general">
                    <div class="form_champ c" id="niveau-bloc">
                        <label for="cname" class="control-label col-lg-3">Année Scolaire</label>
                        <div class="form_ajout">
                            <select id="ann_scol" name="ann_scol" class="form_ajout_input">
                                <option selected>L'année Scolaire ?</option>
                                @foreach(\Auth::user()->schoolyears()->get() as $ann_scol)
                                <option  value="{{ $ann_scol->id }}">{{ $ann_scol->ann_scol }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom de la classe</label>
                            <div class="form_ajout">
                                <input  type="text" name="nom_classe" class="form_ajout_input" value="{{ Request::old('nom_classe')?:'' }}" placeholder="Entrez le nom de la classe">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Code de la classe</label>
                            <div class="form_ajout">
                                <input  type="text" name="code_classe" class="form_ajout_input" value="{{ Request::old('code_classe')?:'' }}" placeholder="Entrez le code de la classe">

                            </div>
                        </div>


                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Capacité de Classe</label>
                            <div class="form_ajout">
                                <input  type="text" name="capacite_classe" class="form_ajout_input" value="{{ Request::old('capacite_classe')?:'' }}" placeholder="Entrez le nombre des élèves maximum">

                            </div>
                        </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Niveau global</label>
                        <div class="form_ajout">
                            <select id="grade" name="grade" class="form_ajout_input">

                            </select>

                        </div>
                    </div>

                    <div class="form_champ c" id="niveau-bloc">
                        <label for="cname" class="control-label col-lg-3">Le Niveau</label>
                        <div class="form_ajout">
                            <select id="niveau" name="niveau" class="form_ajout_input">


                            </select>

                        </div>
                    </div>
                        <div class="form_champ" id="branche-bloc">
                            <label for="cname" class="control-label col-lg-3">Branche</label>
                            <div class="form_ajout">
                                                {!!  Form::select('branche',
                 App\Branch::where('user_id',\Auth::user()->id)->
                 lists('nom_branche','id') ,null,['class'=>'form_ajout_input','id'=>'branche']) !!}
                            </div>
                        </div>


                        <button id="submit" class="btn_form" type="submit">Enregistrer</button>
                    {!!  Form::close() !!}
                </div>

            </section>
        </div>
    </div>
    <div class="row"></div>




@endsection

@section('jquery')
    <script>

        $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert-danger").alert('close');
            $('#loader-to').hide();
        });
        $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
            $(".alert-success").alert('close');

        });

        $('#branche').prepend("<option selected>quelle Branche ?</option>");
        $('#niveau').prop('disabled','disabled');
        $('#branche-bloc').hide();
        $('#grade').on('change',function(){
            var grade_id = $(this).val();
            var grade_text =  $(this).find('option:selected').text();
            switch(grade_text)
            {
                case 'Primaire': $('#branche-bloc').hide(); $('#niveau-bloc').show()  ;break;
                case 'Collège': $('#branche-bloc').hide();  $('#niveau-bloc').show()   ;break;
                case 'Lycée': $('#branche-bloc').show();  $('#niveau-bloc').show()   ;break;
                case 'Crèche' :$('#branche-bloc').hide(); $('#niveau-bloc').show();  ;break;
                case 'Maternelle' :$('#branche-bloc').hide(); $('#niveau-bloc').show();  ;break;
            }
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('ChildrenController@getLevelWhenGradeIsChosen')}}',
                data: 'grade_id=' + grade_id + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('#niveau').prop('disabled','');
                    $('#niveau').empty();
                    $('#niveau').prepend('<option selected>Quel Niveau ?</option>');
                    $('#niveau').append(data);
                }
            });
        });


        $('#niveau').on('change',function(){
          var niveau_text = $('#niveau option:selected').text();
            if(niveau_text == 'Tronc Commun' || niveau_text == '1ère Baccalauréat' || niveau_text == 'Baccalaureat')
            {
                var niveau_id = $(this).val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ClassroomsController@getBranchWhenLevelIsChosen')}}',
                    data: 'niveau_id=' + niveau_id + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('#branche').empty();
                        $('#branche').prepend('<option selected>Quelle Branche ?</option>');
                        $('#branche').append(data);
                    }
                });
            }
        });

        $('#submit').click(function(){
            var grade = $('#grade option:selected').text();
            if(grade == 'Lycée'  &&  !$.isNumeric($('#niveau').val()))
            {
                alertify.alert('vous devez choisir un niveau');
                return false;
            }
            if(grade == 'Lycée'  &&  !$.isNumeric($('#branche').val()))
            {
                alertify.alert('vous devez choisir une branche');
                return false;
            }

            if(grade == 'Collège' && !$.isNumeric($('#niveau').val()))
            {
                alertify.alert('vous devez choisir un niveau');
                return false;
            }
            if(grade == 'Primaire' && !$.isNumeric($('#niveau').val()))
            {
                alertify.alert('vous devez choisir un niveau');
                return false;
            }
            if(grade == 'Maternelle' && !$.isNumeric($('#niveau').val()))
            {
                alertify.alert('vous devez choisir un niveau');
                return false;
            }
        });

        $('select#ann_scol').change(function(){
            var scool_year_id = $(this).val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('ClassroomsController@getGrades')}}',
                data: 'scool_year_id=' + scool_year_id + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('#grade').empty().prepend('<option selected>Quelle Niveau Global ?</option>');
                    $('#grade').append(data);

                }
            });



        });



    </script>


@stop