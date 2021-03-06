@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des professeurs
                    <div class="liste_actions_header">

                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                Actions <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu" style="margin-left: -136px;">
                                <li><a id="exporter" href="{{ action('TeachersController@exportExcel') }}"><img src="{{ asset('images/excel.png') }}">Exporter Excel</a></li>
                                <li><a  id="pdf" href="{{ action('TeachersController@exportPdf') }}"><img src="{{ asset('images/pdf.png') }}">Imprimer</a></li>
                               <!-- <li><a id="imprimer" href="#"><img src="{{ asset('images/imprimern.png')  }}">Imprimer</a></li> -->

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
                            <li><a id="delete-teachers" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                          <!--  <li><a id="archive-teachers" href="#"><i class="fa fa-archive"></i>Archiver</a></li> -->
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
                        <a class="np-btn" href="{{  str_replace('/?','?',$teachers->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$teachers->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>
                @include('partials.alert-success')
                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th class="no-print"></th>
                            <th></th>
                            <th> Nom complet</th>
                            <th>Poste</th>

                            <th class="no-print">Actions</th>
                            <th class="no-print"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teachers as $teacher)
                        <tr>
                            <td class="no-print"><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value="{{ $teacher->id }}"  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="{{ $teacher->photo ? asset('uploads/'.$teacher->photo):  asset('images/no_avatar.jpg') }}"></td>
                            <td>{{  $teacher->nom_teacher }}</td>
                            <td>{{ $teacher->poste }}</td>

                            <td class="no-print">
                                <a href="{{ action('TeachersController@delete',[$teacher->id]) }}" class="actions_icons  delete-teacher">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                              <!--  <a class="archive-teacher" href="{{ action('TeachersController@archive',[$teacher->id]) }}">
                                    <i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>

                            <td class="no-print"><a href="{{ action('TeachersController@show',[$teacher->id]) }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $teachers->currentPage() -1) * $teachers->perPage()  +1  }} à
                            @if((($teachers->currentPage() -1)  * $teachers->perPage() + $teachers->perPage()) > $teachers->total()  )
                                {{  $teachers->total() }} sur
                            @else
                                {{ ($teachers->currentPage() -1)  * $teachers->perPage() + $teachers->perPage() }} sur
                            @endif
                            {{ $teachers->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $teachers->render() !!}
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
    <script src="{{ asset('js\print-widget\jquery.js') }}"></script>
    <script src="{{ asset('js\printme\jQuery.print.js') }}"></script>
    <script>
$(document).ready(function(){


    $('#imprimer').click(function(){
        $('.table').print({
            globalStyles: true,
            mediaPrint: false,
            stylesheet:null,
            noPrintSelector: ".no-print",
            iframe: true,
            append: null,
            prepend: '<h3 style="width: 100%;height:50px;line-height: 50px !important;' +
            ' text-align:center !important;border-radius:' +
            ' 40px !important;background-color: #e9f1f3 !important;' +
            'color:#6b519d !important ;">La liste des Professeurs Et RH</h3>',
            manuallyCopyFormValues: true,
            deferred: $.Deferred(),
            timeout: 250,
            title: 'La liste des Professeurs et RH',
            doctype: '<!doctype html>'
        });
    });







    $('.select-all').click(function(){
        var status = this.checked;
        $("input[name='select[]']").each(function(){
            this.checked = status;
        });
    });

    $('#delete-teachers').click(function(){
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
                            url: '{{  URL::action('TeachersController@supprimer')}}',
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


    $('#archive-teachers').click(function(){
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
            url: '{{  URL::action('TeachersController@archiver')}}',
            data: 'boxesarchives=' + $('#boxesarchives').text() + '&_token=' + CSRF_TOKEN,
            type: 'post',
            success: function (data) {
                console.log(data);
            }
        });
    });



    $('body').on('click','.delete-teacher' ,function(e){
        e.preventDefault();
        var href = this.href;
        alertify.dialog('confirm')
                .set({
                    'labels':{ok:'Oui', cancel:'Non'},
                    'message': 'Voulez-vous vraiment supprimer cet élément ? ',
                    'transition': 'slide',
                    'onok': function(){
                        window.location.href = href;
                        alertify.success('bien supprimé!');
                    },
                    'oncancel': function(){

                    }
                }).show();
    });


    $('body').on('click','.archive-teacher',function(e){
        e.preventDefault();
        var href = this.href;
        alertify.dialog('confirm')
                .set({
                    'labels':{ok:'Oui', cancel:'Non'},
                    'message': 'Voulez vous vraiment archiver ? ',
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

    $('#alphabet-list button').click(function(e){
        $('tbody').empty();
        var sCurrentLetter = $(this).text().toUpperCase();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{  URL::action('TeachersController@teacherbyalph')}}',
            data: 'caracter=' + sCurrentLetter + '&_token=' + CSRF_TOKEN,
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