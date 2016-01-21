@extends('layouts.default')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des professeurs

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
                            <li><a id="archive-teachers" href="#"><i class="fa fa-archive"></i>Archiver</a></li>
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
                            <th></th>
                            <th></th>
                            <th> Nom complet</th>
                            <th>Poste</th>

                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teachers as $teacher)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox" value="{{ $teacher->id }}"  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar" src="{{ $teacher->photo ? asset('uploads/'.$teacher->photo):  asset('images/no_avatar.jpg') }}"></td>
                            <td>{{  $teacher->nom_teacher }}</td>
                            <td>{{ $teacher->poste }}</td>

                            <td>
                                <a href="{{ action('TeachersController@delete',[$teacher->id]) }}" class="actions_icons  delete-teacher">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-teacher" href="{{ action('TeachersController@archive',[$teacher->id]) }}">
                                    <i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="{{ action('TeachersController@show',[$teacher->id]) }}"><div  class="btn_details">Détails</div></a></td>
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

    <script>
$(document).ready(function(){

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
            url: '{{  URL::action('TeachersController@supprimer')}}',
            data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
            type: 'post',
            success: function (data) {
                console.log(data);
            }
        });


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


    $('body').on('click','.archive-teacher',function(e){
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






});








    </script>









@stop