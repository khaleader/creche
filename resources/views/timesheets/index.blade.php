@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des emplois du temps
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
                            <li><a id="delete-ts" href="#"><i class="fa fa-trash-o"></i>Supprimer</a></li>
                            <!--<li><a href="#"><i class="fa fa-archive"></i>Archiver</a></li>-->
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier par branche
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="br-action dropdown-menu menu_actions">
                            <?php  $branches = \App\Branch::where('user_id',\Auth::user()->id)->get();?>
                            @foreach($branches as $b)
                                <li><a href="#">{{ $b->nom_branche }}</a></li>
                            @endforeach
                        </ul>
                    </div>



                </div>


                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$tsheets->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$tsheets->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Classe</th>
                            <th>Branche</th>
                            <th>Actions</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tsheets as $ts)
                        <tr>
                            <td><div class="minimal single-row">
                                    <div class="checkbox_liste ">
                                        <input type="checkbox"  value="{{ $ts->id }}" name="select[]">

                                    </div>
                                </div></td>
                            <td>{{ $ts->nom_classe }}</td>
                            <td>{{ $ts->branche?:'--' }}</td>
                            <td>
                                <a href="{{ action('TimesheetsController@delete',[$ts]) }}" class="actions_icons delete-ts">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                               <!-- <a href="#"><i class="fa fa-archive liste_icons"></i>
                                </a>-->
                            </td>
                            <td><a href="{{ action('TimesheetsController@edit',[$ts]) }}">
                                    <div  class="btn_details">Détails</div></a></td>

                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row liste_footer">
                        <p>
                            {{( $tsheets->currentPage() -1) * $tsheets->perPage()  +1  }} à
                            @if((($tsheets->currentPage() -1)  * $tsheets->perPage() + $tsheets->perPage()) > $tsheets->total()  )
                                {{  $tsheets->total() }} sur
                            @else
                                {{ ($tsheets->currentPage() -1)  * $tsheets->perPage() + $tsheets->perPage() }} sur
                            @endif
                            {{ $tsheets->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $tsheets->render() !!}
                        </div>
                    </div>


                </div>
            </section>
        </div>
    </div>
    <span id="boxes" style="display: none;"></span>

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

            $('body').on('click','.delete-ts',function(e){
                e.preventDefault();
                var href = this.href;
                alertify.dialog('confirm')
                        .set({
                            'labels':{ok:'Oui', cancel:'Non'},
                            'message': 'Voulez-vous vraiment supprimer la classe et l\'emploi du temps associé ? ',
                            'transition': 'fade',
                            'onok': function(){
                                window.location.href = href;
                                alertify.success('bien Supprimé!');
                            },
                            'oncancel': function(){

                            }
                        }).show();

            });

                // selectbox
            $('#delete-ts').click(function(){
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
                            'message': 'Voulez-vous vraiment supprimer ces classes et l\'emploi du temps associé ?',
                            'transition': 'zoom',
                            'onok': function () {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: '{{  URL::action('TimesheetsController@supprimer')}}',
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


            $('.br-action a').click(function(){
                $('tbody').empty();
                var branche = $(this).text();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('TimesheetsController@trierparbranche')}}',
                    data: 'branche=' + branche + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').append(data);
                    }
                });

            });



        });



    </script>









    @stop