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

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom de la classe</label>
                            <div class="form_ajout">
                                <input type="text" name="nom_classe" class="form_ajout_input" placeholder="Entrez le nom de la classe">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Code de la classe</label>
                            <div class="form_ajout">
                                <input type="text" name="code_classe" class="form_ajout_input" placeholder="Entrez le code de la classe">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Capacité de salle</label>
                            <div class="form_ajout">
                                <input type="text" name="capacite_classe" class="form_ajout_input" placeholder="Entrez le nombre des élèves maximum">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Niveau</label>
                            <div class="form_ajout">
                                {!!  Form::select('niveau',
           App\Level::where('user_id',\Auth::user()->id)->
           lists('niveau','id') ,null,['class'=>'form_ajout_input']) !!}
                           <!--     <select name="niveau" class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option>1 ère année bac</option>
                                    <option>2 ème année bac</option>

                                </select>-->

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Branche</label>
                            <div class="form_ajout">
                               <!-- <select class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option>Science physique</option>
                                    <option>littéraire</option>

                                </select>-->

                                                {!!  Form::select('branche',
                 App\Branch::where('user_id',\Auth::user()->id)->
                 lists('nom_branche','id') ,null,['class'=>'form_ajout_input']) !!}

                            </div>
                        </div>


                        <button class="btn_form" type="submit">Enregistrer</button>
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

    </script>


@stop