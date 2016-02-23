@extends('layouts.default')



@section('content')
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des familles
                    <div class="actions_btn">
                        <ul>
                            <li><a id="imprimer" href="#"><img  src="{{ asset('images/imprimer.png')  }}">Imprimer</a></li>
                            <li><a href="{{ action('FamiliesController@exportExcel') }}"><img id="exporter" src="{{ asset('images/exporter.png')  }}">Exporter excel</a></li>
                            <li><a href="{{ action('FamiliesController@exportPdf') }}"><img id="pdf" src="{{ asset('images/pdf-icon.png')  }}">Exporter PDF</a></li>

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
                            <li><a id="delete-families" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                         <!--  <li><a id="archive-families" href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>



                </div>
                <div class="btn-toolbar alphabetical" id="alphabet-list-fam">
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
                        <a class="np-btn" href="{{  str_replace('/?','?',$families->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$families->nextPageUrl()) }}"><i class="fa fa-angle-right pagination-right"></i></a>
                    </li>
                </ul>
                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th> Nom du responsable</th>
                            <th class="hidden-phone">Nombre d'élèves</th>
                            <th>Statut de paiement</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($families as $family)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value="{{ $family->id }}" >

                                    </div>
                                </div></td>
                            <td>
                                @if(!empty($family->photo))
                                    <img class="avatar" src=" {{ asset('uploads/'.$family->photo)  }}">
                                @else
                                    <img class="avatar" src=" {{ asset('images/'.'no_avatar.jpg')  }}">
                                @endif
                            </td>
                            <td>
                            @if($family->responsable == 0)
                                {{  $family->nom_mere }}
                                @else
                                {{  $family->nom_pere  }}
                                @endif
                            </td>
                            <td> {{  $family->children->count() }}</td>
                            <td>
      <?php
           $count =0;
    foreach ($family->children as $c )
        {
            foreach($c->bills as $b)
            {
                if($b->status == 0)
                {
                    $count += 1;
                }
            }

        }
    if($count > 0)
    {
        echo  '<span class="label label-danger label-mini"><i class="fa fa-money"></i></span>';
    }
    else{
        echo  '<span class="label label-success label-mini"><i class="fa fa-money"></i></span>';
    }
        ?>
                            </td>
                       <td>
                                <a  href="{{  action('FamiliesController@delete',[$family->id]) }}" class="actions_icons delete-family">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a class="archive-family" href="{{  action('FamiliesController@archive',[$family->id]) }}"><i class="fa fa-archive liste_icons"></i>
                                </a> -->
                            </td>

                            <td><a href="{{ action('FamiliesController@show',[$family->id])  }}"><div  class="btn_details">Détails</div></a></td>
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
    <script src="{{ asset('js\print-widget\jquery.js') }}"></script>
    <script src="{{ asset('js\print-widget\jquery.tablesorter.js') }}"></script>
    <script src="{{ asset('js\print-widget\jquery.tablesorter.widgets.js') }}"></script>
    <script src="{{ asset('js\print-widget\widget-columnSelector.js') }}"></script>
    <script src="{{ asset('js\print-widget\widget-print.js') }}"></script>
    <script>
        $(document).ready(function(){


            $('.table').tablesorter({
                widgets:["print"],
                widgetOptions : {
                    print_extraCSS: "@media print {" +
                    ".avatar{ width:40px;height:40px;}" +
                    "td { text-align:center}" +
                    "td >span.label-danger:before { content:'non réglée'}" +
                    "td > span.label-success:before { content: 'réglée '}" +
                    "}",
                    print_title: 'La liste des Familles',
                    print_rows : 'v',
                    print_callback   : function(config, $table, printStyle){
                        // do something to the $table (jQuery object of table wrapped in a div)
                        // or add to the printStyle string, then...
                        // print the table using the following code
                        $.tablesorter.printTable.printOutput( config, $table.html(), printStyle );
                    }
                }
            });

            $('#imprimer').click(function(){
                $('.table').trigger('printTable');
            });

        /*  select checkbox */
        $('.select-all').click(function(){
            var status = this.checked;
            $("input[name='select[]']").each(function(){
                this.checked = status;
            });
        });

        /*  alpphabet filter */

        $('#alphabet-list-fam button').click(function(e){
            $('tbody').empty();
            var sCurrentLetter = $(this).text().toUpperCase();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('FamiliesController@fambyalph')}}',
                data: 'caracter=' + sCurrentLetter + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                 $('tbody').append(data);
                }
            });
        });


         /* delete by checkboxes  */
        $('#delete-families').click(function(){
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
                url: '{{  URL::action('FamiliesController@supprimer')}}',
                data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    console.log(data);
                }
            });
        });


        /*  archive by checkboxes */

        $('#archive-families').click(function(){
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
                url: '{{  URL::action('FamiliesController@archiver')}}',
                data: 'boxesarchives=' + $('#boxesarchives').text() + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    console.log(data);
                }
            });




        });


        $('body').on('click','.delete-family',function(e){
            e.preventDefault();
            var href = this.href;
            alertify.dialog('confirm')
                    .set({
                        'labels':{ok:'Oui', cancel:'Non'},
                        'message': 'voulez vous vraiment supprimer ? ',
                        'transition': 'slide',
                        'onok': function(){
                            window.location.href = href;
                            alertify.success('bien supprimé!');
                        },
                        'oncancel': function(){
                            alertify.error('Pas supprimé :)');
                        }
                    }).show();
        });
        $('body').on('click','.archive-family',function(e){
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
                            alertify.error('Pas archivé :)');
                        }
                    }).show();
        });
        });
    </script>
@stop