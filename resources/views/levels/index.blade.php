@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des niveaux
                    <div class="actions_btn">
                        <ul>
                            <li><a href="{{ action('LevelsController@create') }}"><img id="ajouter" src="{{ asset('images/ajouter.png') }}">Ajouter</a></li>
                        </ul>
                    </div>

                </header>
                <div class="liste_actions">
                    <div class="chk-all">
                        <div class="pull-left mail-checkbox ">
                            <input type="checkbox" class="select-all">
                        </div>

                        <div class="btn-group">
                            <a data-toggle="dropdown" href="#" class="btn mini all">
                                Tous

                            </a>

                        </div>
                    </div>


                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Actions
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a id="delete-levels" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                         <!--   <li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li> -->
                        </ul>
                    </div>
                </div>
                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$levels->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$levels->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Niveau</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($levels as $l)

                            <tr>
                                <td><div class="minimal single-row">
                                        <div class="checkbox_liste ">
                                            <input type="checkbox" value="{{ $l->id }}" name="select[]" >

                                        </div>
                                    </div></td>
                                <td>{{  $l->niveau }}</td>
                                <td>
                                    <a href="{{  action('LevelsController@delete',[$l]) }}" class="actions_icons delete-level">
                                        <i class="fa fa-trash-o liste_icons"></i></a>
                                    <!--<a href="#"><i class="fa fa-archive liste_icons"></i>
                                    </a>-->
                                </td>
                                <td><a href="{{ action('LevelsController@show',[$l]) }}"><div  class="btn_details">Détails</div></a></td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <span id="boxes" style="display: none;"></span>
@endsection


@section('jquery')

    <script>
        $(function(){
            $('.select-all').click(function(){
                var status = this.checked;
                $("input[name='select[]']").each(function(){
                    this.checked = status;
                });
            });

            $('body').on('click','.delete-level',function(e){
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

            $('#delete-levels').click(function(){
                var boxes;
                var status;
                $("input[name='select[]']").each(function(){
                    if($(this).is(':checked'))
                    {
                        status = true;
                        var valeur = $(this).val();
                        $(this).val(valeur).closest('tr').fadeOut();
                        boxes = $(this).val() + ',';
                        $('#boxes').append(boxes);
                    }
                });
                if($('#boxes').text() ===  null)
                {
                    alert('check please');
                    return false;
                }
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('LevelsController@supprimer')}}',
                    data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        console.log(data);
                    }
                });
            });



        });


    </script>


    @stop