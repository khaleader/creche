@extends('layouts.default')




@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des enfants absents

                </header>


                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th> Nom complet</th>
                            <th>Dernière Date d'absence</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($children as $child)
                            <tr>
                                <td><div class="minimal single-row">
                                        <div class="checkbox_liste ">
                                            <input type="checkbox" >

                                        </div>
                                    </div></td>
                                <td><img class="avatar" src="{{ $child->photo?  asset('uploads/'.$child->photo) : asset('images/avatar4.jpg') }}"></td>
                                <td>{{  $child->nom_enfant }}</td>

                                <td>
                                    <?php
                                    $gather = '';
                                    foreach($child->attendances  as $c)
                                    {
                                        $gather.=$c->start->toDateString().',';
                                    }
                                    $last =  substr($gather,0,-1);
                                    $dates = explode(',',$last);
                                    echo max($dates);







                                    ?>
                                </td>


                                <td>
                                </td>

                                <td><a href="{{  action('AttendancesController@showef',[$child->id])  }}"><div  class="btn_details">Détails</div></a></td>
                            </tr>
                        @endforeach




                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>



@endsection

@section('jquery')
    <script>
        $(document).ready(function(){


            $('#alphabet-list button').click(function(e){
                $('tbody').empty();
                var sCurrentLetter = $(this).text().toUpperCase();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('AttendancesController@attbyalph')}}',
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

