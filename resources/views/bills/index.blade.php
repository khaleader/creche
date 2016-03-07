@extends('layouts.default')
@section('css')
    <style>
        @media print {

            .label{
                color: #FFF !important;
                -webkit-print-color-adjust: exact;
                border-radius: .25em !important;

            }
             span.label-danger {
                background-color: #FF6C60 !important;
                -webkit-print-color-adjust: exact;
            }

             span.label-success{
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
                    Liste des factures
                    <div class="actions_btn">
                        <ul>
                            <li><a id="imprimer" href="#"><img  src="{{ asset('images/imprimer.png')  }}">Imprimer</a></li>
                            <li><a id="exporter" href="{{ action('BillsController@exportExcel') }}"><img  src="{{ asset('images/exporter.png')  }}">Exporter excel</a></li>
                            <li><a id="pdf" href="{{ action('BillsController@exportPdf') }}"><img  src="{{ asset('images/pdf-icon.png')  }}">Exporter PDF</a></li>

                        </ul>
                    </div>

                </header>
                <div class="liste_actions">
                    <div class="chk-all">
                        <div class="pull-left mail-checkbox ">
                            <input type="checkbox" class="select-all">
                        </div>

                        <div class="btn-group">
                            <a data-toggle="dropdown" href="#" class="btn mini all  ">
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
                            <li><a id="regler-bills" href="#">Réglée</a></li>
                            <li><a id="non-regler-bills" href="#">Non Réglée</a></li>
                        </ul>
                    </div>

                    <span>Trier par :</span>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Statut
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a id="status-regler" href="#">Réglées</a></li>
                            <li><a id="status-non-regler" href="#">Non Réglées</a></li>
                        </ul>
                    </div>

                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Mois
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions bill-months">
                            <li><a valeur="1" href="#">Janvier</a></li>
                            <li><a valeur="2" href="#">Février</a></li>
                            <li><a valeur="3" href="#">Mars</a></li>
                            <li><a valeur="4" href="#">Avril</a></li>
                            <li><a valeur="5" href="#">Mai</a></li>
                            <li><a valeur="6" href="#">Juin</a></li>
                            <li><a valeur="7" href="#">Juillet</a></li>
                            <li><a valeur="8" href="#">Aout</a></li>
                            <li><a valeur="9" href="#">Septembre</a></li>
                            <li><a  valeur="10" href="#">Octobre</a></li>
                            <li><a valeur="11" href="#">Novembre</a></li>
                            <li><a valeur="12" href="#">Decembre</a></li>
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Année
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions bill-year">
                            <li><a valeur="2015"  href="#">2015</a></li>
                            <li><a valeur="2016" href="#">2016</a></li>
                            <li><a valeur="2017"  href="#">2017</a></li>
                            <li><a valeur="2018" href="#">2018</a></li>
                            <li><a valeur="2019"  href="#">2019</a></li>
                            <li><a valeur="2020" href="#">2020</a></li>
                        </ul>
                    </div>


                </div>
                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$bills->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$bills->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>
                <div class="search-form">
                    <form action="#">
                        <input id="bill-search-inst" type="text" name="search" class="search-input" placeholder="Cherchez un élève...">
                        <button type="submit">
                            <div class="fa fa-search"></div>
                        </button>
                    </form>
                </div>
                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th class="no-print"></th>
                            <th>N° Facture </th>
                            <th></th>
                            <th> Nom complet</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                           <!-- <th>Actions</th>-->
                            <th class="no-print"></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($bills as $bill)
                            @unless($bill->child->deleted_at)
                        <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="{{ $bill->id }}" type="checkbox"  name="select[]">
                                    </div>
                                </div></td>
                            <td>{{  $bill->id  }}</td>
                            <td><img class="avatar" src="{{  $bill->child->photo ? asset('uploads/'.$bill->child->photo):asset('images/avatar4.jpg') }}"></td>
                            <td>{{ $bill->child->nom_enfant  }}</td>
                            <td>
                                <span class="date-f">{{  $bill->start->format('d-m-Y') }} </span>

                                    @if(Carbon\Carbon::now() > $bill->start && $bill->status == 0)
                                        <!--<span class="label label-danger label-mini"
                                              style="position:relative;display:inline-block;width: 25px;height: 25px;vertical-align: middle;">
                                        <i style="position:absolute;top: 4px; left:6px;"
                                           class="fa fa-clock-o fa-2x"></i></span> -->
                        <strong class="tooltip-jqui" title=" {{ $bill->start->diffInDays()  }} Jours de Retard">
                            <i class="fa fa-info-circle" style="color: #FF6C60;"></i></strong>



                                    @elseif(Carbon\Carbon::now() < $bill->start  && $bill->status == 0)
                                        <strong class="tooltip-jqui" title=" {{  '('.$bill->start->diffInDays() .' Jours Restants avant la Date de Paiement)' }} " > <i class="fa fa-info-circle"></i></strong>

                                    @endif



                            </td>
                            <td>{{  $bill->somme  }},00 Dhs</td>
                            <td><span class="label {{  $bill->status == 0 ? 'label-danger': 'label-success'  }}  label-mini">
                                   {{  $bill->status == 0 ? 'Non réglée': 'réglée' }} </span>
                            </td>
                            <!--   <td>
                              <a  href="{{--  action('BillsController@delete',[$bill->id]) --}}" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="{{--  action('BillsController@archive',[$bill->id]) --}}"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>-->

                            <td class="no-print"><a href="{{  action('BillsController@details',[$bill->id]) }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        @endunless
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    <span id="boxesregler" style="display: none"></span>
    <span id="boxesnonregler" style="display: none"></span>
    <span id="childid" style="display: none;">{{--  $child->id --}}</span>
@endsection
@section('jquery')
  <!--  <script src="{{-- asset('js\print-widget\jquery.js') --}}"></script> -->

    <script src="{{ asset('js\printme\jQuery.print.js') }}"></script>


    <script>
        $(document).ready(function(){

            $('#imprimer').click(function(){
                $(document).find('.table').print
              ({
                    globalStyles: true,
                    mediaPrint: false,
                    stylesheet:null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: '<h3 style="width: 100%;height:50px;line-height: 50px !important;' +
                    ' text-align:center !important;border-radius:' +
                    ' 40px !important;background-color: #e9f1f3 !important;' +
                    'color:#6b519d !important ;">La liste des Factures</h3>',
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: 'La liste des Factures',
                    doctype: '<!doctype html>'
                });

            });


            $('.select-all').click(function(){
                var status = this.checked;
                $("input[name='select[]']").each(function(){
                    this.checked = status;
                });
            });

            $('#regler-bills').click(function(){
                var boxes;
                $("input[name='select[]']").each(function(){
                    if($(this).is(':checked'))
                    {
                        var valeur = $(this).val();
                        // $(this).val(valeur).closest('tr').fadeOut();
                        boxes = $(this).val() + ',';
                        $('#boxesregler').append(boxes);
                    }
                });
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@regler')}}',
                    data: 'regler=' + $('#boxesregler').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        location.reload();
                        // console.log(data);
                    }
                });
            });
            $('#non-regler-bills').click(function () {
                var boxes;
                $("input[name='select[]']").each(function(){
                    if($(this).is(':checked'))
                    {
                        var valeur = $(this).val();
                        // $(this).val(valeur).closest('tr').fadeOut();
                        boxes = $(this).val() + ',';
                        $('#boxesnonregler').append(boxes);
                    }
                });
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@nonregler')}}',
                    data: 'nonregler=' + $('#boxesnonregler').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        location.reload();
                    }
                });
            });

        $('#status-regler').click(function(){
            $('tbody').empty();
            var status = 1;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('BillsController@statusindex')}}',
                data: 'status=' + status + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('tbody').append(data);
                }
            });
        });
        $('#status-non-regler').click(function(){
            $('tbody').empty();
            var status =0;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('BillsController@statusindex')}}',
                data: 'status=' + status  +  '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('tbody').append(data);
                }
            });
        });

        $('.bill-months a').click(function(){
            $('tbody').empty();

            var month =$(this).attr('valeur');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('BillsController@monthindex')}}',
                data: 'month=' + month +  '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('tbody').append(data);
                }
            });
        });

            $('.bill-year a').click(function(){
                $('tbody').empty();

                var year =$(this).attr('valeur');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@filterByYear')}}',
                    data: 'year=' + year +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });




            $('#bill-search-inst').keyup(function(){
                var terms =  $(this).val();
                if($(this).val().length == 0)
                {
                  $('tbody').empty();
                }
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                   url : '{{ URL::action('BillsController@searchinst')  }}',
                    data: 'terms=' + terms + '&_token=' + CSRF_TOKEN,
                    type :'post',
                    success:function(data){
                        $('tbody').html(data);
                    }
                });
            });




            $('body').on('click','.delete-bill',function(e){
                e.preventDefault();
                var href = this.href;
                alertify.dialog('confirm')
                        .set({
                            'labels':{ok:'Oui', cancel:'Non'},
                            'message': 'voulez vous vraiment supprimer ? ',
                            'transition': 'fade',
                            'onok': function(){
                                window.location.href = href;
                                alertify.success('bien supprimé!');
                            },
                            'oncancel': function(){
                                alertify.error('Pas supprimé :)');
                            }
                        }).show();
            });
            $('body').on('click','.archive-bill',function(e){
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
            $('.tooltip-jqui').css('visibility','hidden');
            $('tbody').hover(function(){
               $('strong.tooltip-jqui').css('visibility','visible');
            });
            $('tbody').mouseleave(function(){
               $('strong.tooltip-jqui').css('visibility','hidden');
            });

            $('.tooltip-jqui').tooltip();

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




             /*   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url : '{{ URL::action('BillsController@exportExcel')  }}',
                    data: 'values=' + values + '&_token=' + CSRF_TOKEN,
                    type :'post',
                    success:function(data){

                    }
                });*/




        });
    </script>
    @stop