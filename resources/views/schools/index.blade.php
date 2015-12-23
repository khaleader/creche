@extends('layouts.default')





@section('content')



    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des écoles inscrits

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
                            <li><a href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                            <li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li>
                        </ul>
                    </div>



                </div>
                <div class="btn-toolbar alphabetical " id="alphabet-list">
                    <div class="btn-group btn-group-sm ">
                        <button class="btn btn-default">A</button>
                        <button class="btn btn-default">B</button>
                        <button class="btn btn-default">C</button>
                        <button class="btn btn-default">D</button>
                        <button class="btn btn-default">E</button>
                        <button class="btn btn-default">F</button>
                        <button class="btn btn-default">G</button>
                        <button class="btn btn-default">H</button>
                        <button class="btn btn-default">I</button>
                        <button class="btn btn-default">J</button>
                        <button class="btn btn-default">K</button>
                        <button class="btn btn-default">L</button>
                        <button class="btn btn-default">M</button>
                        <button class="btn btn-default">N</button>
                        <button class="btn btn-default">O</button>
                        <button class="btn btn-default">P</button>
                        <button class="btn btn-default">Q</button>
                        <button class="btn btn-default">R</button>
                        <button class="btn btn-default">S</button>
                        <button class="btn btn-default">T</button>
                        <button class="btn btn-default">U</button>
                        <button class="btn btn-default">V</button>
                        <button class="btn btn-default">W</button>
                        <button class="btn btn-default">X</button>
                        <button class="btn btn-default">Y</button>
                        <button class="btn btn-default">Z</button>
                    </div>
                </div>
                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$ecoles->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$ecoles->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th> Nom école</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Statut de paiement</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ecoles as $ecole)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="{{ $ecole->id }}" type="checkbox" name="select[]" >

                                    </div>
                                </div></td>
                            <td>{{ $ecole->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($ecole->created_at)->format('d-m-Y') }} </td>
                            <td><span class="label label-success label-mini"><i class="fa fa-money"></i></span></td>
                            <td>
                                <a href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="{{ action('SchoolsController@show',[$ecole->id]) }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
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

            $('#alphabet-list button').click(function(e){
                $('tbody').empty();
                var sCurrentLetter = $(this).text().toUpperCase();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('SchoolsController@schoolbyalph')}}',
                    data: 'caracter=' + sCurrentLetter + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });



        });

    </script>

    @stop