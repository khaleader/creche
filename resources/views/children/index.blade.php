@extends('layouts.default')



@section('content')
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des enfants inscrits

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
                            <li><a id="delete-children" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                            <li><a id="archive-children" href="#"><i class="fa fa-archive"></i>Archiver</a></li>
                        </ul>
                    </div>



                </div>
                <div class="btn-toolbar alphabetical" id="alphabet-list" >
                    <div class="btn-group btn-group-sm " >
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
                        <a class="np-btn" href="{{  str_replace('/?','?',$children->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$children->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                @include('partials.alert-success')

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants" id="filterByAlpha">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th> Nom complet</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Statut de paiement</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($children as $child)

                        <tr id="{{  ucwords($child->nom_enfant) }}">
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value="{{ $child->id  }}"  name="select[]">

                                    </div>
                                </div></td>
                            <td>
                                @if(!empty($child->photo))
                                <img class="avatar" src=" {{ asset('uploads/'.$child->photo)  }}">
                                @else
                                    <img class="avatar" src=" {{ asset('images/'.'avatar4.jpg')  }}">
                                @endif
                            </td>

                            <td>{{  ucwords($child->nom_enfant) }}</td>
                            <td>{{  \Carbon\Carbon::parse($child->created_at)->format('d-m-Y')  }} </td>
                          <?php

                          $counter =  App\Bill::where('child_id',$child->id)->where('status',0)->count(); ?>

                            <td>
                                @if(App\Bill::all()->count() == 0)
                                {{ 'pas de factures'  }}
                                    @else
                                    <span class="label {{ $counter == 0 ? 'label-success' : 'label-danger' }} label-mini">
                                    <i class="fa fa-money"></i>
                                </span>
                               @endif

                            </td>

                            <td>
                                <a  class="delete-child actions_icons"   href="{{ action('ChildrenController@delete',[$child->id]) }}">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-child" href="{{  action('ChildrenController@archive',[$child->id]) }}"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="{{ action('ChildrenController@show',[$child->id])  }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    <span id="boxes" style="display: none;"></span>
    <span id="boxesarchives" style="display: none;"></span>
@endsection
@section('jquery')
    <script type="text/javascript">
        $(document).ready(function(){



            $('.select-all').click(function(){
               var status = this.checked;
                $("input[name='select[]']").each(function(){
                    this.checked = status;
                });
            });

            $('#delete-children').click(function(){
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
                    url: '{{  URL::action('ChildrenController@supprimer')}}',
                    data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                       console.log(data);
                    }
                });
            });


            $('#archive-children').click(function(){
                var boxes;
                var status;
                $("input[name='select[]']").each(function(){
                    if($(this).is(':checked'))
                    {
                        status = true;
                        var valeur = $(this).val();
                        $(this).val(valeur).closest('tr').fadeOut();
                        boxes = $(this).val() + ',';
                        $('#boxesarchives').append(boxes);
                    }
                });
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ChildrenController@archiver')}}',
                    data: 'boxesarchives=' + $('#boxesarchives').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        console.log(data);
                    }
                });
            });


            $('#alphabet-list button').click(function(e){
                $('tbody').empty();
                var sCurrentLetter = $(this).text().toUpperCase();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ChildrenController@enfbyalph')}}',
                    data: 'caracter=' + sCurrentLetter + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                    $('tbody').append(data);
                    }
                });
            });


            $('body').on('click','.delete-child',function(e){
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


            $('body').on('click','.archive-child',function(e){
                e.preventDefault();
                var href = this.href;
                alertify.dialog('confirm')
                        .set({
                            'labels':{ok:'Oui', cancel:'Non'},
                            'message': 'voulez vous vraiment archiver ? ',
                            'transition': 'fade',
                            'onok': function(){
                                window.location.href = href;
                                alertify.success('bien archivé!');
                            },
                            'oncancel': function(){
                                alertify.error('Pas Archivé :)');
                            }
                        }).show();

            });
            $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
                $(".alert-success").alert('close');
            });






        });

    </script>

    @stop


