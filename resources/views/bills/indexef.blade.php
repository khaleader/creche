@extends('layouts.default')




@section('content')


    <div class="row">
        <div class="col-sm-12">

            <section class="panel">

                <header class="panel-heading">
                    Historique de factures

                </header>
                <div class="liste_actions">
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



                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>N° Facture</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Nom Elève</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($enfant as $baby)
                            @foreach($baby->bills as $bills)
                                <tr>
                                    <td><div class="minimal single-row">
                                        </div></td>
                                    <td>{{ $bills->id }}</td>
                                    <td>{{  $bills->start->format('d-m-Y') }} </td>
                                    <td>{{ $bills->somme }} Dhs</td>
                                    <td><span class="label {{ $bills->status == 0 ? 'label-danger' : 'label-success'  }} label-mini">
                                   {{ $bills->status == 0 ? 'Non Réglée ' : 'Réglée'  }}   </span>
                                    </td>
                                    <td>   {{ $bills->child->nom_enfant  }}</td>

                                    <td><a href="{{  action('BillsController@detailsef',[$bills->id]) }}"><div  class="btn_details">Détails</div></a></td>
                                </tr>

                            @endforeach
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





        <script>

            $(function(){
                $('.bill-year a').click(function(){
                    $('tbody').empty();

                    var year =$(this).attr('valeur');
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{  URL::action('BillsController@filterByYearef')}}',
                        data: 'year=' + year +  '&_token=' + CSRF_TOKEN,
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
                        url: '{{  URL::action('BillsController@filterByMonthef')}}',
                        data: 'month=' + month +  '&_token=' + CSRF_TOKEN,
                        type: 'post',
                        success: function (data) {
                            $('tbody').append(data);
                        }
                    });
                });

                $('#status-regler').click(function(){
                    $('tbody').empty();
                    var status = 1;
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{  URL::action('BillsController@statusindexef')}}',
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
                        url: '{{  URL::action('BillsController@statusindexef')}}',
                        data: 'status=' + status  +  '&_token=' + CSRF_TOKEN,
                        type: 'post',
                        success: function (data) {
                            $('tbody').append(data);
                        }
                    });
                });








            });




        </script>

            <!--   <script>
        $(function(){
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
                var id = $('#childid').text();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@status')}}',
                    data: 'status=' + status + '&id=' + id +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });
            });

            $('#status-non-regler').click(function(){
                $('tbody').empty();
                var status =0;
                var id = $('#childid').text();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@status')}}',
                    data: 'status=' + status +  '&id=' + id +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });

            });

            $('#months a').click(function(){
                $('tbody').empty();
                var id = $('#childid').text();
                var month = $(this).attr('valeur');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('BillsController@month')}}',
                    data: 'month=' + month +  '&id=' + id +  '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });


            });

            $('.delete-bill').click(function(){
                var answer =   confirm('voulez vous vraiment supprimer ?');
                if(answer)
                    return true;
                else
                    return false;
            });
            $('.archive-bill').click(function(){
                var answer =   confirm('voulez vous vraiment archiver ?');
                if(answer)
                    return true;
                else
                    return false;
            });


        });








    </script> -->





@stop