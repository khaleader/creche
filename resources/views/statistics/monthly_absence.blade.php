@extends('layouts.default')


@section('content')

    @include('partials.alert-success')
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                   {{  $count }} cas d'absence En <strong> {{ $month.'-'.$year }}</strong>

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
                            <li><a id="delete-attendance" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                           <!--  <li><a id="archive-attendance" href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a id="normale" href="#">Justifiée</a></li>
                            <li><a id="maladie" href="#">Non Justifiée</a></li>
                        </ul>
                    </div>



                </div>

                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$att->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$att->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>


                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th> Nom complet</th>
                            <th>Date d'absence</th>
                            <th>Raison</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($att as $t)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste">
                                        <input type="checkbox" value="{{ $t->id }}"  name="select[]">

                                    </div>
                                </div></td>
                            <td><img class="avatar"
                                     src="{{   $t->child->photo ? asset('uploads/'.$t->child->photo) : asset('images/no_avatar.jpg') }}"></td>
                            <td>{{  ucwords($t->child->nom_enfant) }}</td>
                            <td>{{  \Carbon\Carbon::parse($t->start)->format('d-m-Y') }} </td>
                            @if($t->title == 'Maladie')
                            <td><span class="label label-info label-mini">Non Justifiée</span></td>
                             @else
                                <td><span class="label label-primary label-mini">Justifiée</span></td>
                            @endif
                            <td>
                                <a href="{{ action('StatisticsController@delete_att',[$t]) }}" class="actions_icons delete-att">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                              <!--  <a class="archive-att" href="{{  action('StatisticsController@archive_att',[$t]) }}"><i class="fa fa-archive liste_icons "></i>
                                </a>-->
                            </td>

                            <td><a href="{{  action('AttendancesController@show',[$t->child->id]) }}"><div  class="btn_details">Détails</div></a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $att->currentPage() -1) * $att->perPage()  +1  }} à
                            @if((($att->currentPage() -1)  * $att->perPage() + $att->perPage()) > $att->total()  )
                                {{  $att->total() }} sur
                            @else
                                {{ ($att->currentPage() -1)  * $att->perPage() + $att->perPage() }} sur
                            @endif
                            {{ $att->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $att->render() !!}
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
        $(document).ready(function(){
            $('.select-all').click(function(){
                var status = this.checked;
                $("input[name='select[]']").each(function(){
                    this.checked = status;
                });
            });

            $('#normale').click(function(){
                $('tbody').empty();
                var status = 'Normal';
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('StatisticsController@absence_raison')}}',
                    data: 'status=' + status + '&month=' +  '{{ $month }}' + '&year=' + '{{ $year }}'
                    + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });
            $('#maladie').click(function(){
                $('tbody').empty();
               var  status = 'Maladie';
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('StatisticsController@absence_raison')}}',
                    data: 'status=' + status + '&month=' + '{{ $month }}' + '&year=' + '{{ $year }}'
                    + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });

            $('#delete-attendance').click(function(){
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
                    url: '{{  URL::action('StatisticsController@supprimer_att')}}',
                    data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        console.log(data);
                    }
                });
            });

            $('#archive-attendance').click(function(){
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
                    url: '{{  URL::action('StatisticsController@archiver_att')}}',
                    data: 'boxesarchives=' + $('#boxesarchives').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        console.log(data);
                    }
                });
            });



            $('body').on('click','.delete-att',function(e){
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

            $('body').on('click','.archive-att',function(e){
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