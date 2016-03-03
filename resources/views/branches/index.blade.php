@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des branches
                    <div class="actions_btn">
                        <ul>
                            <li><a href="{{ action('BranchesController@create') }}"><img id="ajouter" src="{{ asset('images/ajouter.png') }}">Ajouter</a></li>
                          <li><a id="exporter" href="{{ action('BranchesController@exportExcel') }}"><img  src="{{ asset('images/exporter.png')  }}">Exporter excel</a></li>
                            <li><a id="pdf" href="{{ action('BranchesController@exportPdf') }}"><img  src="{{ asset('images/pdf-icon.png')  }}">Exporter PDF</a></li>

                             <li><a id="imprimer" href="#"><img  src="{{ asset('images/imprimer.png')  }}">Imprimer</a></li>
                           <!--  <li><a href="#"><img id="actuel" src="{{ asset('images/actuel.png')  }}">Actuel</a></li>
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
                            <li><a id="delete-branches" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                            <!--<li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>
                </div>
                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$branches->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$branches->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th  class="no-print"></th>
                            <th>Branche</th>
                            <th>Code de la branche</th>
                            <th>Nombre d'élèves</th>
                            <th  class="no-print">Actions</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($branches as $branch)

                        <tr>
                            <td  class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value="{{ $branch->id }}" name="select[]" >

                                    </div>
                                </div></td>
                            <td>{{  $branch->nom_branche }}</td>
                            <td>{{  $branch->code_branche }}</td>

                            <td>{{ $branch->children()->count() }}</td>
                            <td>
                                <a  class="no-print delete-branch" href="{{  action('BranchesController@delete',[$branch]) }}" class="actions_icons delete-branch">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <!--<a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>
                            <td class="no-print"><a href="{{ action('BranchesController@show',[$branch]) }}"><div  class="btn_details">Détails</div></a></td>

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
                    'color:#6b519d !important ;">Les Branches</h3>',
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: 'Les Branches',
                    doctype: '<!doctype html>'
                });

            });




            $('.select-all').click(function(){
            var status = this.checked;
            $("input[name='select[]']").each(function(){
                this.checked = status;
            });
        });

        $('body').on('click','.delete-branch',function(e){
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

        $('#delete-branches').click(function(){
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
                url: '{{  URL::action('BranchesController@supprimer')}}',
                data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    console.log(data);
                }
            });
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