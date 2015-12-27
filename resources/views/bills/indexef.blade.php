@extends('layouts.default')




@section('content')


    <div class="row">
        <div class="col-sm-12">

            <section class="panel">

                <header class="panel-heading">
                    Historique de factures

                </header>



                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>N° Facture</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Nom Enfant</th>
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

                                    <td><a href="{{  action('BillsController@showef',[$bills->child_id]) }}"><div  class="btn_details">Détails</div></a></td>
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