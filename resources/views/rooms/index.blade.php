@extends('layouts.default')

@section('content')


    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des salles
                    <div class="liste_actions_header">

                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu" style="margin-left: -136px;">
                                <li><a href="{{ action('RoomsController@create') }}"><img src="{{ asset('images/add.png') }}">Ajouter</a></li>
                                <li><a id="exporter" href="{{ action('RoomsController@exportExcel') }}"><img src="{{ asset('images/excel.png') }}">Exporter Excel</a></li>
                                <li><a  id="pdf" href="{{ action('RoomsController@exportPdf') }}"><img src="{{ asset('images/pdf.png') }}">Imprimer</a></li>
                              <!--  <li><a id="imprimer" href="#"><img src="{{ asset('images/imprimern.png')  }}">Imprimer</a></li> -->

                            </ul>
                        </div>
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
                            <li><a id="delete-rooms" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                          <!--  <li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li> -->
                        </ul>
                    </div>




                </div>


                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$rooms->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$rooms->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th class="no-print"></th>
                            <th>Salle</th>
                            <th>Capacité de la salle</th>
                            <th class="no-print">Actions</th>
                            <th class="no-print"></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" name="select[]" value="{{ $room->id }}" >

                                    </div>
                                </div></td>
                            <td>{{  $room->nom_salle }}</td>
                            <td>{{ $room->capacite_salle }} élèves</td>
                            <td class="no-print">
                                <a href="{{ action('RoomsController@delete',[$room]) }}" class="actions_icons delete-room">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <!--<a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>
                            <td class="no-print"><a href="{{ action('RoomsController@show',[$room]) }}"><div  class="btn_details">Détails</div></a></td>


                        </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $rooms->currentPage() -1) * $rooms->perPage()  +1  }} à
                            @if((($rooms->currentPage() -1)  * $rooms->perPage() + $rooms->perPage()) > $rooms->total()  )
                                {{  $rooms->total() }} sur
                            @else
                                {{ ($rooms->currentPage() -1)  * $rooms->perPage() + $rooms->perPage() }} sur
                            @endif
                            {{ $rooms->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $rooms->render() !!}
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <span id="boxes" style="display: none;"></span>

@endsection

@section('jquery')
    <script src="{{ asset('js\printme\jQuery.print.js') }}"></script>
    <script>

        $(function(){


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
                    'color:#6b519d !important ;">La liste des salles</h3>',
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: 'La liste des salles',
                    doctype: '<!doctype html>'
                });
            });


        $('.select-all').click(function(){
            var status = this.checked;
            $("input[name='select[]']").each(function(){
                this.checked = status;
            });
        });
        $('body').on('click','.delete-room',function(e){
            e.preventDefault();
            var href = this.href;
            alertify.dialog('confirm')
                    .set({
                        'labels':{ok:'Oui', cancel:'Non'},
                        'message': 'Voulez-vous vraiment supprimer cet élément ?  ',
                        'transition': 'fade',
                        'onok': function(){
                            window.location.href = href;
                            alertify.success('bien Supprimé!');
                        },
                        'oncancel': function(){

                        }
                    }).show();

        });

        $('#delete-rooms').click(function(){
            var boxes;
            var status;
            $("input[name='select[]']").each(function(){
                if($(this).is(':checked'))
                {
                    status = true;
                    var valeur = $(this).val();
                 //   $(this).val(valeur).closest('tr').fadeOut();
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
                        'message': 'Voulez-vous vraiment supprimer ces éléments ? ',
                        'transition': 'zoom',
                        'onok': function () {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: '{{  URL::action('RoomsController@supprimer')}}',
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

