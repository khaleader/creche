@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Planning

                </header>
                <div class="liste_actions">
                  <!--  <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Mois
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#">Janvier</a></li>
                            <li><a href="#">Février</a></li>
                        </ul>
                    </div>-->
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Jour
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions jours">
                            <li><a href="#">lundi</a></li>
                            <li><a href="#">mardi</a></li>
                            <li><a href="#">mercredi</a></li>
                            <li><a href="#">jeudi</a></li>
                            <li><a href="#">vendredi</a></li>
                            <li><a href="#">samedi</a></li>
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier par salle
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions rooms">
                            <?php $rooms = Auth::user()->rooms()->get();  ?>
                            @foreach($rooms as $room)
                            <li><a room-value="{{ $room->id }}" href="#">{{ $room->nom_salle }}</a></li>
                                @endforeach

                        </ul>
                    </div>
                </div>

                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="{{  str_replace('/?','?',$plans->previousPageUrl())  }}"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="{{   str_replace('/?','?',$plans->nextPageUrl())  }}"><i class="fa fa-angle-right pagination-right"></i> </a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th>La classe</th>
                            <th>Matière</th>
                            <th>Professeur</th>
                            <th>Jour</th>
                            <th>Heure</th>
                            <th>Salle</th>
                            <th>Niveau</th>
                            <th>Branche</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($plans as $plan)
                            @if($plan->matter_id !== 0)
                        <tr>
                            <td>{{ \App\Classroom::where('id',$plan->classroom_id)->first()->nom_classe }}</td>
                                <td>
                                    {{ \App\Matter::where('id',$plan->matter_id)
                                ->first()->nom_matiere }}
                                </td>
                            <td>

                               <?php
                                $matiere =\App\Matter::where('id',$plan->matter_id)
                                        ->first();
                                foreach ( $matiere->lesteachers->unique()  as $item) {
                                    echo $item->nom_teacher;
                                }
                                ?>

                            </td>
                            <td>
                            {{ $plan->dayname }}
                            </td>

                            <td>{{ substr(\Carbon\Carbon::parse($plan->time)->toTimeString(),0,-3)  }}</td>
                            <td>
                                <?php

                                  $salle =\App\Timesheet::where('classroom_id',$plan->classroom_id)
                                                  ->where('time',$plan->time)
                                                   ->where('user_id',\Auth::user()->id)
                                                    ->where('color','#525252')
                                                      ->where('dayname',$plan->dayname)
                                                    ->first();
                                    if($salle)
                                    echo \Auth::user()->rooms()->where('id',$salle->room_id)->first()->nom_salle;

                                ?>


                            </td>

                            <td>
                                <?php
                                $classroom = \App\Classroom::where('id',$plan->classroom_id)->first();
                                foreach($classroom->lesNiveaux as $niveau)
                                {
                                  echo $niveau->niveau;
                                }
                                foreach($classroom->levels as $niveau)
                                {
                                    echo $niveau->niveau;
                                }
                                ?>

                            </td>
                            <td>
                                <?php
                                $classroom = \App\Classroom::where('id',$plan->classroom_id)->first();
                                if($classroom->branches->isEmpty())
                                    {
                                     echo '--';
                                    }else{
                                    foreach($classroom->branches as $br)
                                    {
                                        if($br->nom_branche)
                                            {
                                                echo $br->nom_branche;
                                            }else{
                                                   echo '--';
                                        }

                                    }
                                }



                                ?>
                            </td>
                        </tr>
                        @endif
                        @endforeach


                        </tbody>

                    </table>

                    <div class="row liste_footer">
                        <p>
                            {{( $plans->currentPage() -1) * $plans->perPage()  +1  }} à
                            @if((($plans->currentPage() -1)  * $plans->perPage() + $plans->perPage()) > $plans->total()  )
                                {{  $plans->total() }} sur
                            @else
                                {{ ($plans->currentPage() -1)  * $plans->perPage() + $plans->perPage() }} sur
                            @endif
                            {{ $plans->total() }} résultats</p>
                        <div class="pagination_liste">

                            {!!  $plans->render() !!}
                        </div>
                    </div>

                </div>
            </section>
        </div>

    </div>


@endsection



@section('jquery')
    <script>
        $(function(){

            $('.jours a').click(function(){
                var jour_text =   $(this).text();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('PlansController@trierparjour')}}',
                    data: 'jour_text=' + jour_text + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        $('tbody').empty();
                        $('tbody').append(data);
                        $('.liste_footer').hide();
                    }
                });
            });
            $('.rooms a').click(function(){
              var room_id =  $(this).attr('room-value');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url : '{{ URL::action('PlansController@trierparsalle')  }}',
                    data: 'room_id=' + room_id + '&_token=' + CSRF_TOKEN,
                   type: 'post',
                    success:function(data){
                        $('tbody').empty(data);
                        $('tbody').append(data);
                        $('.liste_footer').hide();
                    }
                });
            });







        });



    </script>


@endsection








