@extends('layouts.default')

@section('content')

    @include('partials.alert-errors')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('RoomsController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_salles">
                                <span class="count">{{ \App\Room::where('user_id',\Auth::user()->id)->count() }}</span>
                            </div>
                            <p>Salles</p>
                        </div></a>
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
                    {!! Form::model($room,['url'=> action('RoomsController@update',[$room]),'method'=> 'put']) !!}
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Nom de la salle</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $room->nom_salle }}" name="nom_salle" class="form_ajout_input" placeholder="Entrez le nom de la salle">

                        </div>
                    </div>
                    <div class="form_champ">
                        <label for="cname" class="control-label col-lg-3">Capacité de la salle</label>
                        <div class="form_ajout">
                            <input type="text" value="{{ $room->capacite_salle }}" name="capacite_salle" class="form_ajout_input" placeholder="Entrez la capacité de la salle">

                        </div>
                    </div>

                    <button class="btn_form" type="submit">Enregistrer</button>
                    <a  style="line-height:40px; text-align:center;margin-right: 10px;"
                        class="btn_form" href="{{ URL::previous() }}">
                        Annuler
                    </a>
                    {!! Form::close() !!}
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