@extends('layouts.default')

@section('content')

    <div class="row">

        <?php
        $ynow = \Carbon\Carbon::now()->year;
        $ynext = \Carbon\Carbon::now()->year + 1;
        $both =$ynow.'-'.$ynext;
        $month = \Carbon\Carbon::now()->month;
        $result = \Auth::user()->schoolyears()->where('ann_scol',$both)->first();
        if($result)
        {
            $tab = explode('-',$result->ann_scol);
        }
            ?>
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                  Liste des classes
                    <div class="liste_actions_header">

                        @if($month  >= 1 &&  $month < 7 && $result)
                            <div class="btn-group">
                                <a href="#" class="btn btn-white">année</a>
                                <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                                <ul role="menu" class="dropdown-menu" style="margin-left: -97px">
                                    <a style="display: block;padding-left: 18px;" href="{{ url('classes',[$tab[0],$tab[1] }}">{{ $both }} </a>


                                </ul>
                            </div>
                        @endif

                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu" style="margin-left: -136px;">
                                <li><a  href="{{ action('ClassroomsController@create') }}"><img src="{{ asset('images/add.png') }}">Ajouter</a></li>

                                <li><a id="exporter" href="{{ action('ClassroomsController@exportExcel')}}"><img src="{{ asset('images/excel.png') }}">Exporter Excel</a></li>
                                <li><a  id="pdf" href="{{ action('ClassroomsController@exportPdf')}}"><img src="{{ asset('images/pdf.png') }}">Exporter PDF</a></li>
                                <li><a id="imprimer" href="#"><img src="{{ asset('images/imprimern.png')  }}">Imprimer</a></li>

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
                            <li><a id="delete-classrooms" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                           <!-- <li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier par niveau
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions br-action niveaux-ul">
                            @foreach($niveaux as $niv)
                            <li><a class="niveau" data-id="{{ $niv->id }}" href="#">{{ $niv->niveau }}</a></li>
                                @endforeach
                        </ul>
                    </div>
                        <!-- -->

                        <div class="btn-group hidden-phone">
                            <a data-toggle="dropdown" href="#" class="btn mini blue">
                                trier par branche
                                <i class="fa fa-angle-down "></i>
                            </a>
                            <ul class="dropdown-menu menu_actions bill-months branche">

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
                            <th class="no-print"></th>
                            <th>La classe</th>
                            <th>Code classe</th>
                            <th>Capacité de Classe</th>
                            <th>Nombre d'élèves </th>
                            <th>Niveau</th>
                            <th>Branche</th>
                            <th class="no-print">Actions</th>
                            <th class="no-print"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($classrooms as $cr)
                        <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="{{ $cr->id }}" name="select[]">

                                    </div>
                                </div></td>
                            <td>{{  $cr->nom_classe }}</td>
                            <td>{{  $cr->code_classe }}</td>
                            <td>{{ $cr->capacite_classe }} élèves</td>
                            <td> {{ $cr->children()->count() }}</td>
                            <td>{{  $cr->niveau ? \Auth::user()->leslevels()->where('id',$cr->niveau)->first()->niveau : '--' }}</td>
                            <td>{{  $cr->branche ? \Auth::user()->branches()->where('id',$cr->branche)->first()->nom_branche : '--'  }}</td>

                            <td class="no-print">
                                <a href="{{  action('ClassroomsController@delete',[$cr]) }}" class="actions_icons delete-classe">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>
                               @if(isset($year1) && isset($year2))
                            <td class="no-print"><a href="{{ action('ClassroomsController@indexelc',[$cr,$ynow,$ynext]) }}"><div  class="btn_details">Détails</div></a></td>
                             @else
                                <td class="no-print"><a href="{{ action('ClassroomsController@indexelc',[$cr]) }}"><div  class="btn_details">Détails</div></a></td>

                            @endif
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $classrooms->currentPage() -1) * $classrooms->perPage()  +1  }} à
                            @if((($classrooms->currentPage() -1)  * $classrooms->perPage() + $classrooms->perPage()) > $classrooms->total()  )
                                {{  $classrooms->total() }} sur
                            @else
                                {{ ($classrooms->currentPage() -1)  * $classrooms->perPage() + $classrooms->perPage() }} sur
                            @endif
                            {{ $classrooms->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $classrooms->render() !!}
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
                    'color:#6b519d !important ;">La Liste des Classes</h3>',
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: 'La Liste des Classes',
                    doctype: '<!doctype html>'
                });

            });








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
                        'message': 'Voulez-vous vraiment supprimer cet élément ? ',
                        'transition': 'fade',
                        'onok': function(){
                            window.location.href = href;
                            alertify.success('bien Supprimé!');
                        },
                        'oncancel': function(){

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
                        'message': 'Voulez-vous vraiment supprimer ces éléments ? ',
                        'transition': 'zoom',
                        'onok': function () {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: '{{  URL::action('ClassroomsController@supprimer')}}',
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

        $('.niveaux-ul a').click(function(){
            $('tbody').empty();
            var niveau_id = $(this).attr('data-id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('ClassroomsController@trierparniveau')}}',
                data: 'niveau_id=' + niveau_id + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    $('tbody').append(data);
                }
            });

        });

            var ExcelLink = $('#exporter').attr('href');
            var PdfLink = $('#pdf').attr('href');

            setInterval(function(){
                $('#exporter').attr('href',ExcelLink);
                $('#pdf').attr('href',PdfLink);
            },  10000);


            $('.niveau').on('click',function(){
             var niveau_id = $(this).attr('data-id');
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ClassroomsController@getLevel')}}',
                    data: 'niveau_id=' + niveau_id + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('.branche').empty();
                    $('.branche').append(data);
                    }
                });

            });

            $('body').on('click','.branch',function(){
                var branch_id = $(this).attr('data-id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('ClassroomsController@trierparbranche')}}',
                    data: 'branch_id=' + branch_id + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').empty();
                        $('tbody').append(data);
                    }
                });

            });



















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
