@extends('layouts.default')


@section('content')
    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ $count }} nouvelles inscriptions En <strong>{{ $month.'-'.$year }}</strong>

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
                           <!-- <li><a id="archive-children" href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a class="sexe" href="#">Garçon</a></li>
                            <li><a class="sexe" href="#">Fille</a></li>
                        </ul>
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

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th> Nom complet</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Classe</th>
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
                            <td>
                                @foreach($child->classrooms as $cr)
                                    {{  $cr->nom_classe }}
                                @endforeach
                            </td>


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
                               <!-- <a class="archive-child" href="{{  action('ChildrenController@archive',[$child->id]) }}"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td><a href="{{ action('ChildrenController@show',[$child->id])  }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                             @endforeach




                        </tbody>
                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $children->currentPage() -1) * $children->perPage()  +1  }} à
                            @if((($children->currentPage() -1)  * $children->perPage() + $children->perPage()) > $children->total()  )
                                {{  $children->total() }} sur
                            @else
                                {{ ($children->currentPage() -1)  * $children->perPage() + $children->perPage() }} sur
                            @endif
                            {{ $children->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $children->render() !!}
                        </div>
                    </div>


                </div>
            </section>
        </div>
    </div>
    <span id="boxes" style="display: none;"></span>
    <span id="boxesarchives" style="display: none;"></span>


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

        $('body').on('click','.delete-child',function(e){
            e.preventDefault();
            var href = this.href;
            alertify.dialog('confirm')
                    .set({
                        'labels':{ok:'Oui', cancel:'Non'},
                        'message': 'Voulez-vous vraiment supprimer cet élément ?',
                        'transition': 'fade',
                        'onok': function(){
                            window.location.href = href;
                            alertify.success('bien Supprimé!');
                        },
                        'oncancel': function(){

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


            $('#delete-children').click(function(){
                var boxes;
                var status;
                $("input[name='select[]']").each(function(){
                    if($(this).is(':checked'))
                    {
                        status = true;
                        var valeur = $(this).val();
                       // $(this).val(valeur).closest('tr').fadeOut();
                        boxes = $(this).val() + ',';
                        $('#boxes').append(boxes);
                    }
                });
                if(boxes == null)
                {
                    alertify.alert("cocher d'abord !");
                    return false;
                }

                alertify.dialog('confirm')
                        .set({
                            'labels': {ok: 'Oui', cancel: 'Non'},
                            'message': 'voulez vous vraiment supprimer ces éléments ? ',
                            'transition': 'zoom',
                            'onok': function () {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: '{{  URL::action('ChildrenController@supprimer')}}',
                                    data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                                    type: 'post',
                                    success: function (data) {
                                        location.reload();
                                    }
                                });
                                alertify.success('bien supprimé!');
                            }
                        }).show();

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


            $('.sexe').click(function(e){
                $('tbody').empty();
                var sCurrentLetter = $(this).text().toLowerCase();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('StatisticsController@trier_sexe')}}',
                    data: 'sexe=' + sCurrentLetter + '&_token=' + CSRF_TOKEN + '&month=' + '{{ $month }}' + '&year=' + '{{ $year }}',
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });
            $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
                $(".alert-success").alert('close');
            });

        });



    </script>


@stop