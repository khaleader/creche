@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Planning

                </header>
                <div class="liste_actions">
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Mois
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#">Janvier</a></li>
                            <li><a href="#">Février</a></li>
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Jour
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                        </ul>
                    </div>
                    <div class="btn-group hidden-phone">
                        <a data-toggle="dropdown" href="#" class="btn mini blue">
                            Trier par salle
                            <i class="fa fa-angle-down "></i>
                        </a>
                        <ul class="dropdown-menu menu_actions">
                            <li><a href="#">Salle 1</a></li>
                            <li><a href="#">Salle 2</a></li>
                        </ul>
                    </div>
                </div>

                <ul class="unstyled inbox-pagination liste_arrow">

                    <li>
                        <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                    </li>
                    <li>
                        <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                    </li>
                </ul>

                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th>La classe</th>
                            <th>Matière</th>
                            <th>Professeur</th>
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
                                foreach ( $matiere->lesteachers  as $item) {
                                    echo $item->nom_teacher;
                                }
                                ?>

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
                                    echo $salle->matiere;

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
                                      echo $br->nom_branche;
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