@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <a href="{{ action('MattersController@index') }}">
                    <div class="panel-body bloc_informations">

                        <img src="{{ asset('images/matieres.png') }}" ><span class="count">
                              {{ \App\Matter::where('user_id',\Auth::user()->id)->count() }}

                        </span><p>Matières</p>
                    </div></a>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a class="delete-matter" href="{{ action('MattersController@delete',[$matiere]) }}"><div class="btn2">Supprimer</div></a>
                    <a href="{{ action('MattersController@edit',[$matiere]) }}"><div class="btn2">Modifier</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom de la matière : </strong>{{ $matiere->nom_matiere }}</span></td>
                        </tr>
                        <tr>

                            <td><span><strong>Code de la matière : </strong>{{ $matiere->code_matiere }}</span></td>
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
    $('body').on('click','.delete-matter',function(e){
        e.preventDefault();
        var href = this.href;
        alertify.dialog('confirm')
                .set({
                    'labels':{ok:'Oui', cancel:'Non'},
                    'message': 'voulez vous vraiment supprimer ? ',
                    'transition': 'fade',
                    'onok': function(){
                        window.location.href = href;
                        alertify.success('bien Supprimé!');
                    },
                    'oncancel': function(){
                        alertify.error('Pas Supprimé :)');
                    }
                }).show();
    });


</script>
@stop
