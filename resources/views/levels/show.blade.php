@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('LevelsController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/niveaux.png') }}" ><span class="count">
                          {{ \App\Level::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Niveaux</p>
                    </div></a>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales </h4>



                    <div class="btn-group dropdown_actions">
                        <button class="btn btn-white" type="button">Actions</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu" style="left: 0;">
                            <li><a  href="{{ action('LevelsController@edit',[$level]) }}">Modifier</a></li>
                            <li><a class="delete-level" href="{{ action('LevelsController@delete',[$level]) }}">Supprimer</a></li>
                        </ul>
                    </div>


                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Niveau global: </strong>{{ $level->grade->name }}</span></td>
                        </tr>

                        <tr>

                            <td><span><strong>Nom du niveau : </strong>{{ $level->niveau }}</span></td>
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
    $('body').on('click','.delete-level',function(e){
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