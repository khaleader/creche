@extends('layouts.default')




@section('content')


    <div class="row">
        <div class="col-sm-12">

            <section class="panel">

                <header class="panel-heading">
                    Historique de factures pour : <span> <strong>{{  $child->nom_enfant }}</strong> </span>

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
                            <li><a id="status-regler"  href="#">Réglées</a></li>
                            <li><a id="status-non-regler"  href="#">Non Réglées</a></li>
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Mois
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions" id="months">
                            <li><a valeur="9" href="#">Septembre</a></li>
                            <li><a valeur="10" href="#">Octobre</a></li>
                            <li><a valeur="11" href="#">Novembre</a></li>
                            <li><a valeur="12" href="#">Décembre</a></li>
                            <li><a valeur="1" href="#">Janvier</a></li>
                            <li><a valeur="2" href="#">Février</a></li>
                            <li><a valeur="3" href="#">Mars</a></li>
                            <li><a valeur="4" href="#">Avril</a></li>
                            <li><a valeur="5" href="#">Mai</a></li>
                           <li><a valeur="6" href="#">Juin</a></li>
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
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($child->bills as $bills)
                            @unless($bills->deleted_at)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input value="{{ $bills->id }}" type="checkbox"  name="select[]">

                                    </div>
                                </div></td>
                            <td>{{ $bills->id }}</td>
                            <td>{{  $bills->start->format('d-m-Y') }} </td>
                            <td>{{ $bills->somme }} Dhs</td>
                            <td><span class="label {{ $bills->status == 0 ? 'label-danger' : 'label-success'  }} label-mini">
                                   {{ $bills->status == 0 ? 'Non Réglée ' : 'Réglée'  }}   </span>
                            </td>
                            <td>
                                <a  href="{{--  action('BillsController@delete',[$bills->id]) --}}" class="actions_icons delete-bill">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                <a class="archive-bill" href="{{--  action('BillsController@archive',[$bills->id]) --}}"><i class="fa fa-archive liste_icons"></i>
                                </a>
                            </td>

                            <td><a href="{{ action('BillsController@details',[$bills->id]) }}"><div  class="btn_details">Détails</div></a></td>
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
    <span id="childid" style="display: none;">{{  $child->id }}</span>




@endsection


@section('jquery')

    <script>
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


        });








    </script>





    @stop