@extends('layouts.default')

@section('content')


    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('RoomsController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/salles.png') }}" ><span class="count">
                                {{ \App\Room::where('user_id',\Auth::user()->id)->count() }}</span><p>Salles</p>
                    </div></a>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>


                    <div class="btn-group dropdown_actions">
                        <button class="btn btn-white" type="button">Actions</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu" style="left: 0;">
                            <li><a  href="{{ action('RoomsController@edit',[$room]) }}">Modifier</a></li>
                            <li><a class="delete-room" href="{{ action('RoomsController@delete',[$room]) }}">Supprimer</a></li>


                        </ul>
                    </div>


                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom de la salle : </strong>{{ $room->nom_salle }}</span></td>
                        </tr>

                        <tr>

                            <td><span><strong>Capacité de la salle : </strong>{{ $room->capacite_salle }} élèves</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </section>

        </div>
    </div>

    <div class="row"></div>



@endsection

@section('jquery')
<script>
    $('body').on('click','.delete-room',function(e){
        e.preventDefault();
        var href = this.href;
        alertify.dialog('confirm')
                .set({
                    'labels':{ok:'Oui', cancel:'Non'},
                    'message': 'voulez vous vraiment supprimer cet élément ? ',
                    'transition': 'fade',
                    'onok': function(){
                        window.location.href = href;
                        alertify.success('bien Supprimé!');
                    },
                    'oncancel': function(){

                    }
                }).show();

    });


</script>
@stop