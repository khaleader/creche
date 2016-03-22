@extends('layouts.default')

@section('content')


    <div class="row">
        <div class="col-sm-3">
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
                            <li><a  href="{{ action('BusesController@edit',[$bus]) }}">Modifier</a></li>
                            <li><a class="delete-bus" href="{{ action('BusesController@delete',[$bus]) }}">Supprimer</a></li>
                        </ul>
                    </div>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Marque : </strong>{{ $bus->marque }}</span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Modèle : </strong>{{ $bus->modele }}</span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Matricule : </strong>{{ $bus->matricule }}</span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Chauffeur : </strong>{{ $bus->chauffeur }} </span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Capacité : </strong>{{ $bus->capacite }}</span></td>
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
        $(function(){
            $('body').on('click','.delete-bus',function(e){
                e.preventDefault();
                var href = this.href;
                alertify.dialog('confirm')
                        .set({
                            'labels':{ok:'Oui', cancel:'Non'},
                            'message': 'Voulez-vous vraiment supprimer cet élément ? ',
                            'transition': 'fade',
                            'onok': function(){
                                window.location.href = href;
                                alertify.success('bien Supprimé!');
                            },
                            'oncancel': function(){

                            }
                        }).show();

            });
        });

    </script>


@stop