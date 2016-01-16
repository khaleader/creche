@extends('layouts.default')
@section('css')
    <style>

        .mat div{
            margin-bottom: 10px;
        }
        .forrooms tr div{
            margin-bottom: 10px;
        }

    </style>

  @stop

@section('content')
<?php

/*
\Maatwebsite\Excel\Facades\Excel::create('ok',function($excel){
    $excel->sheet('sheetname',function($sheet){
        $sheet->setPageMargin(array(
                0.25, 0.30, 0.25, 0.30
        ));
     $data =  \App\Classroom::all();
        $model = new \App\Classroom();

      // $data = array_push($data);
      $sheet->fromModel(\App\Classroom::all());

    });
})->download('csv');
*/
        ?>

    <div style="width:700px;" >
        <div class="left">
            <table>
                <?php
                $matieres = \App\Matter::where('user_id',\Auth::user()->id)->get();
                    $salles = \App\Room::where('user_id',\Auth::user()->id)->get();
                ?>
                @foreach($matieres as $mat)
                <tr class="mat">
                    <td>
                        <div color="{{ $mat->color }}" class="item francais" style="background-color:{{ $mat->color }}">{{ $mat->nom_matiere }}</div>
                    </td>
                </tr>
                 @endforeach
            </table>
            <table class="classes forrooms">
                @foreach($salles as $s)
                <tr>
                    <td><div color="{{ $s->color }}" style="color:white;  background-color:{{ $s->color }} " class="item2">{{ $s->nom_salle }}</div></td>
                </tr>
                @endforeach


            </table>
        </div>
        <div class="right">
            <table class="planning">
                <tr>
                    <td class="blank"></td>
                    <td class="title">08:00</td>
                    <td class="title">09:00</td>
                    <td class="title">10:00</td>
                    <td class="title">11:00</td>
                    <td class="title">12:00</td>
                    <td class="title">13:00</td>
                    <td class="title">14:00</td>
                    <td class="title">15:00</td>
                    <td class="title">16:00</td>
                    <td class="title">17:00</td>
                    <td class="title">18:00</td>
                </tr>
                <?php
                $kda = App\Timesheet::where('classroom_id',$ts->classroom_id)->where('user_id',\Auth::user()->id)->get();
                ?>
                <tr>
                    <td class="time"  data-day='lundi' >Lundi</td>
                    <td class="drop" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '08:00:00')
                                <div class="item  assigned"  value="{{ $t->id }}"
                                     style="position: static;background-color:{{ $t->color }}

                               ">{{ $t->matiere }}</div>
                            @endif

                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '09:00:00')
                                <div class="item   assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                               ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '10:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                               ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '11:00:00')
                                <div class="item assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                               ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '12:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                               ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '13:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                               ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00"  >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '14:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                              ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '15:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                             ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                              ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '17:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}"
                               >{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '18:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                              ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="time" data-day='mardi'>Mardi</td>
                    <td class="drop" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '08:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '09:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '10:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '11:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '12:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '13:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '14:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '15:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach

                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '17:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '18:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="time" data-day='mercredi'>Mercredi</td>
                    <td class="drop "data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '08:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '09:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '10:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '11:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '12:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '13:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '14:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '15:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '17:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '18:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="time" data-day='jeudi'>Jeudi</td>
                    <td class="drop"  data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '08:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '09:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '10:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '11:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '12:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '13:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '14:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '15:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '17:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '18:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>

                    <td class="time" data-day='vendredi'>Vendredi</td>


                    <td class="drop vers" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '08:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>

                    <td class="drop " data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '09:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop " data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '10:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '11:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '12:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '13:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '14:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '15:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '17:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '18:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>



                </tr>
                <tr>
                    <td class="time" data-day='samedi'>Samedi</td>
                    <!--<td class="lunch" colspan="6">Lunch</td>-->
                    <td class="drop" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '08:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '09:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '10:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '11:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '12:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '13:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '14:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '15:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '17:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '18:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="position: static;background-color:{{ $t->color }}
                                        ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection
@section('jquery')
    <script src="{{ asset('css/easyui/jquery.easyui.min.js') }}"></script>
    <script>
        $(function(){


            $('td > div.item').click(function(){
              var id =  $(this).attr('value');
                $(this).fadeOut();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('TimesheetsController@del')}}',
                    data: 'id=' + id +
                    '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data){

                    }
                });

            });
            $('td > div.item').hover(function(){
                $(this).css('cursor','pointer');
            });







            $('.left .item').draggable({
                revert:true,
                proxy:'clone'
            });
            $('.right td.drop').droppable({
                onDragEnter:function(){
                    $(this).addClass('over');
                },
                onDragLeave:function(){
                    $(this).removeClass('over');
                },
                onDrop:function(e,source){
                    $(this).removeClass('over');
                    if ($(source).hasClass('assigned')){
                        $(this).append(source);
                    } else {
                        var c = $(source).clone().addClass('assigned');
                        $(this).append(c);
                        c.draggable({
                            revert:true
                        });
                    }
                }
            });
            $('.left').droppable({
                accept:'.assigned',
                onDragEnter:function(e,source){
                    $(source).addClass('trash');
                },
                onDragLeave:function(e,source){
                    $(source).removeClass('trash');
                },
                onDrop:function(e,source){
                    $(source).remove();
                }
            });
        });
        $(function(){
            $('.left .item2').draggable({
                revert:true,
                proxy:'clone'
            });
            $('.right td.drop').droppable({
                onDragEnter:function(){
                    $(this).addClass('over');
                },
                onDragLeave:function(){
                    $(this).removeClass('over');
                },
                onDrop:function(e,source){
                    $(this).removeClass('over');
                    if ($(source).hasClass('assigned')){
                       var text = $(source).text();
                        var day =$(this).append(source);
                        var color = $(source).attr('color');
                        var dayname =  day.closest('tr').find('td[data-day]').attr('data-day');
                        var time = $(this).attr('data-time');
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '{{  URL::action('TimesheetsController@enregistrer')}}',
                            data: 'time=' + time +  '&dayname=' + dayname  + + '&cr_id=' + '{{ $ts->classroom_id  }}' +
                           '&matiere=' +  text  + '&color=' + color +  '&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data){

                            }
                        });

                    } else {
                       var text = $(source).text();
                        $(this).removeClass('over');
                        var c = $(source).clone().addClass('assigned');
                        var color = $(source).attr('color');
                        var day = $(this).append(c);
                        var time = $(this).attr('data-time');
                        var dayname =   day.closest('tr').find('td[data-day]').attr('data-day');



                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '{{  URL::action('TimesheetsController@enregistrer')}}',
                            data: 'time=' + time +  '&dayname=' + dayname  + '&cr_id=' + '{{ $ts->classroom_id  }}'
                            +  '&matiere='  + text + '&color='+ color +  '&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data) {

                            }
                        });

                        c.draggable({
                            revert:true
                        });
                    }
                }
            });
            $('.left').droppable({
                accept:'.assigned',
                onDragEnter:function(e,source){
                    $(source).addClass('trash');
                },
                onDragLeave:function(e,source){
                    $(source).removeClass('trash');
                },
                onDrop:function(e,source){
                    $(source).remove();
                }
            });
        });
    </script>


@stop