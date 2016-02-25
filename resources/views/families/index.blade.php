@extends('layouts.default')
@section('css')
    <style>
        @media print {
            .paiement span.label{
                color: #fff;
                -webkit-print-color-adjust: exact;
            }

            i.fa{
                color: #FFF !important;
                -webkit-print-color-adjust: exact;
            }
            i.fa-money{
                color: #FFF !important;
                -webkit-print-color-adjust: exact;
            }
            .label{
                color: #FFF !important;
                -webkit-print-color-adjust: exact;
            }
            .paiement span.label-danger {
                background-color: #FF6C60 !important;
                -webkit-print-color-adjust: exact;
            }

            .paiement span.label-success{
                background-color: #A9D86E !important;
                -webkit-print-color-adjust: exact;
            }

        }
    </style>
@stop


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des familles
                    <div class="actions_btn">
                        <ul>
                            <li><a id="imprimer" href="#"><img  src="{{ asset('images/imprimer.png')  }}">Imprimer</a></li>
                            <li><a id="exporter" href="{{ action('FamiliesController@exportExcel') }}"><img id="exporter" src="{{ asset('images/exporter.png')  }}">Exporter excel</a></li>
                            <li><a id="pdf" href="{{ action('FamiliesController@exportPdf') }}"><img id="pdf" src="{{ asset('images/pdf-icon.png')  }}">Exporter PDF</a></li>

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
                            <th class="no-print"></th>
                            <th></th>
                            <th> Nom du responsable</th>
                            <th class="hidden-phone">Nombre d'élèves</th>
                            <th>Statut de paiement</th>
                            <th class="no-print">Actions</th>
                            <th class="no-print"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($families as $family)
                        <tr>
                            <td class="no-print"><div class="minimal single-row">
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
                            <td class="paiement">
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
                       <td class="no-print">
                                <a   href="{{  action('FamiliesController@delete',[$family->id]) }}" class="actions_icons delete-family">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a class="archive-family" href="{{  action('FamiliesController@archive',[$family->id]) }}"><i class="fa fa-archive liste_icons"></i>
                                </a> -->
                            </td>

                            <td class="no-print"><a href="{{ action('FamiliesController@show',[$family->id])  }}"><div  class="btn_details">Détails</div></a></td>
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
    <script src="{{ asset('js\printme\jQuery.print.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('#imprimer').click(function(){
                $('.table').print({
                    globalStyles: true,
                    mediaPrint: false,
                    stylesheet: null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: '<h3 style="width: 100%;height:50px;line-height: 50px !important;' +
                    ' text-align:center !important;border-radius:' +
                    ' 40px !important;background-color: #e9f1f3 !important;' +
                    'color:#6b519d !important ;">La liste des Familles</h3>',
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: 'La liste des familles',
                    doctype: '<!doctype html>'
                });
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



            var ExcelLink = $('#exporter').attr('href');
            var PdfLink = $('#pdf').attr('href');

            setInterval(function(){
                $('#exporter').attr('href',ExcelLink);
                $('#pdf').attr('href',PdfLink);
            },  10000);

            /* Excel avec le tri Awesome !*/
            var valuesExcel = '';
            $('#exporter').click(function(e) {
                valuesExcel = '';
                //  e.preventDefault();
                $("input[name='select[]']").each(function () {
                    valuesExcel += $(this).val() + ",";
                });
                $(this).attr('href', ExcelLink + '/' + valuesExcel);
                /* Excel avec le tri Awesome !*/

            });


            /* Pdf avec le tri Awesome !*/
            var valuesPdf = '';
            $('#pdf').click(function(e){
                valuesPdf = '';
                //  e.preventDefault();
                $("input[name='select[]']").each(function(){
                    valuesPdf += $(this).val() + ",";
                });
                $(this).attr('href',PdfLink + '/' + valuesPdf);
            });
            /* Pdf avec le tri Awesome !*/









        });
    </script>
@stop