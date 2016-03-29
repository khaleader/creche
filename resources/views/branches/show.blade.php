@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <section class="panel bloc2">
                <div class="panel-body">
                    <a href="{{  action('BranchesController@index') }}">
                        <div class="bloc_info2">
                            <div class="nbr_branches">
                                <span class="count">    {{ \App\Branch::where('user_id',\Auth::user()->id)->count() }}</span>
                            </div>
                            <p>Branches</p></div>
                    </a></div>
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
                            <li><a  href="{{ action('BranchesController@edit',[$branch]) }}">Modifier</a></li>
                          <!--  <li><a class="delete-branch" href="{{-- action('BranchesController@delete',[$branch]) --}}">Supprimer</a></li> -->
                        </ul>
                    </div>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom de la branche : </strong>{{ $branch->nom_branche }}</span></td>
                        </tr>

                        <tr>

                            <td><span><strong>Code de la branche : </strong>{{ $branch->code_branche }}</span></td>
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


        $('body').on('click','.delete-branch',function(e){
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