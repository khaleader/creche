@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des classes
                    <div class="actions_btn">
                        <ul>
                            <li><a href="{{ action('ClassroomsController@create') }}"><img id="ajouter" src="{{ asset('images/ajouter.png') }}">Ajouter</a></li>
                          <!--  <li><a href="#"><img id="exporter" src="{{ asset('images/exporter.png') }}">Exporter</a></li>
                            <li><a href="#"><img id="imprimer" src="{{ asset('images/imprimer.png') }}">Imprimer</a></li>
                            <li><a href="#"><img id="actuel" src="{{ asset('images/actuel.png')  }}">Actuel</a></li>
                            <li><a href="#"><img id="archive" src="{{ asset('images/archive.png')  }}">Archive</a></li> -->
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
                            <li><a id="delete-classrooms" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                           <!-- <li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier par branche
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions br-action">
                            @foreach($branches as $b)
                            <li><a href="#">{{ $b->nom_branche }}</a></li>
                                @endforeach
                        </ul>
                    </div>



                </div>


                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$classrooms->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$classrooms->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>La classe</th>
                            <th>Code classe</th>
                            <th>Capacité de salle</th>
                            <th>Niveau</th>
                            <th>Branche</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($classrooms as $cr)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="{{ $cr->id }}" name="select[]">

                                    </div>
                                </div></td>
                            <td>{{  $cr->nom_classe }}</td>
                            <td>{{  $cr->code_classe }}</td>
                            <td>{{ $cr->capacite_classe }} élèves</td>
                            <td>{{  $cr->niveau }}</td>
                            <td>{{  $cr->branche    }}</td>

                            <td>
                                <a href="{{  action('ClassroomsController@delete',[$cr]) }}" class="actions_icons delete-classe">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td><a href="{{ action('ClassroomsController@show',[$cr]) }}"><div  class="btn_details">Détails</div></a></td>
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
        $('.select-all').click(function(){
            var status = this.checked;
            $("input[name='select[]']").each(function(){
                this.checked = status;
            });
        });

        $('body').on('click','.delete-classe',function(e){
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

        $('#delete-classrooms').click(function(){
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
                url: '{{  URL::action('ClassroomsController@supprimer')}}',
                data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    console.log(data);
                }
            });
        });

        $('.br-action a').click(function(){
            $('tbody').empty();
            var branche = $(this).text();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('ClassroomsController@trierparbranche')}}',
                data: 'branche=' + branche + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('tbody').append(data);
                }
            });

        });





    </script>



@stop
