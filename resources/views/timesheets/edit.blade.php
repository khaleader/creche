@extends('layouts.default')
@section('css')
    <style>

        .mat div{
            margin-bottom: 10px;
        }
        .forrooms tr div{
            margin-bottom: 10px;
        }
        .left td{
            background: none;
        }

        @page {
            size: auto;   /* auto is the initial value */
            margin:  0 auto;  /* this affects the margin in the printer settings */
        }
        @media print {

          div.left.droppable{
              display: none;
          }
            .item{
                -webkit-print-color-adjust: exact !important;
            }
            div.item {
                width: 50px !important;
                text-align: center !important;
                background: #fafafa !important;
                color: #fff !important;
                border-radius: 3px !important;
                padding-bottom: 5px !important;
                padding-top: 5px !important;
                position: relative !important;
                margin-left:15px !important;
                margin-bottom:2px !important;

            }




            tbody td.title{
                padding-left:15px  !important;
                background-color: #eeeeee !important;
            }
            .blank{
                background-color: #eeeeee !important;
            }

            td.time{
                padding-left:15px  !important;
                background-color: #eeeeee !important;
            }
            div.assigned{
                display: inline-block !important;
                margin-top: 10px !important;
            }


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
<section class="panel">
    <header class="panel-heading">
        Emploi du temps : {{ $cr->nom_classe }}
        <div class="actions_btn">
            <ul>
                <li><a id="imprimer" href="#"><img  src="{{ asset('images/imprimer.png')  }}">Imprimer</a></li>

            </ul>
        </div>
    </header>
    <div class="panel-body">

    <div style="width:700px;" >
        <div class="left" style="width: 80px;">
            <table>
                <?php
                $matieres = \Auth::user()->matters()->get();
                    $salles = \App\Room::where('user_id',\Auth::user()->id)->get();
                ?>
                @foreach($cr->matters as $mat)
                <tr class="mat">
                    <td>
                        <div data-id="{{ $mat->id }}" color="{{ $mat->color }}" class="item francais" style="background-color:{{ $mat->color }};width:50px">{{ $mat->code_matiere }}</div>
                    </td>
                </tr>
                 @endforeach
            </table>
            <table class="classes forrooms">
                @foreach($salles as $s)
                <tr>
                    <td><div data-salle-id="{{ $s->id }}" color="{{ $s->color }}" style="color:white;  background-color:{{ $s->color }} !important;width:50px " class="item2">{{ $s->nom_salle }}</div></td>
                </tr>
                @endforeach


            </table>
        </div>
        <div id="emploi-du-temps" class="right " style="width: 616px;">
            <table class="planning" style="width: 880px">
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
                $kda = App\Timesheet::where('classroom_id',$ts->classroom_id)
                        ->CurrentYear()
                        ->where('user_id',\Auth::user()->id)->get();
                ?>
                <tr>
                    <td class="time"  data-day='lundi' >Lundi</td>
                    <td class="drop" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '08:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif

                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '09:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '10:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '11:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '12:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '13:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00"  >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '14:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '15:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '16:00:00')
                                <div class="item  assigned" value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                              ">{{ $t->matiere }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '17:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->lundi == 'lundi' && $t->time == '18:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="time" data-day='mardi'>Mardi</td>
                    <td class="drop" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '08:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '09:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '10:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '11:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '12:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '13:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>
                            @endif

                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '14:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>
                            @endif

                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '15:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>

                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '16:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>
                            @endif

                        @endforeach

                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '17:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>
                            @endif

                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->mardi == 'mardi' && $t->time == '18:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}
                                </div>

                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="time" data-day='mercredi'>Mercredi</td>
                    <td class="drop "data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '08:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '09:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '10:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '11:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '12:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '13:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '14:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '15:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '16:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '17:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->mercredi == 'mercredi' && $t->time == '18:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="time" data-day='jeudi'>Jeudi</td>
                    <td class="drop"  data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '08:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '09:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '10:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '11:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '12:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '13:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '14:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '15:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '16:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '17:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop"  data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->jeudi == 'jeudi' && $t->time == '18:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>

                    <td class="time" data-day='vendredi'>Vendredi</td>


                    <td class="drop vers" data-time="08:00">
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '08:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>

                    <td class="drop " data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '09:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop " data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '10:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '11:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '12:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '13:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '14:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '15:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '16:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '17:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->vendredi == 'vendredi' && $t->time == '18:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
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
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="09:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '09:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="10:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '10:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="11:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '11:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="12:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '12:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="13:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '13:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="14:00">
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '14:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="15:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '15:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="16:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '16:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="17:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '17:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                    <td class="drop" data-time="18:00" >
                        @foreach($kda as $t)
                            @if($t->samedi == 'samedi' && $t->time == '18:00:00')
                                <div class="item  assigned"
                                     value="{{ $t->id }}" style="width:50px;position: static;background-color:{{ $t->color }} !important;
                                        ">
                                    {{ $t->matter_id !== 0 ? \Auth::user()->matters()
                                    ->where('id',$t->matter_id)
                                    ->first()->code_matiere: \Auth::user()->rooms()
                                    ->where('id',$t->room_id)
                                    ->first()->nom_salle }}</div>
                            @endif
                        @endforeach
                    </td>
                </tr>

            </table>
        </div>
    </div>
        </div>
    </section>
@endsection
@section('jquery')
    <script src="{{ asset('css/easyui/jquery.easyui.min.js') }}"></script>
    <script src="{{ asset('js\printme\jQuery.print.js') }}"></script>

    <script>
        $(function(){

            $('#imprimer').click(function(){
                $(document).find('table.planning').print
                ({
                    globalStyles: true,
                    mediaPrint: false,
                    stylesheet:null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: '<h3 style="width: 100%;height:50px;line-height: 50px !important;' +
                    ' text-align:center !important;border-radius:' +
                    ' 40px !important;background-color: #e9f1f3 !important;' +
                    'color:#6b519d !important ;">L\'emploi du Temps de La {{ $cr->nom_classe }}</h3>',
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: "l'emploi du Temps de {{ $cr->nom_classe }} ",
                    doctype: '<!doctype html>'
                });

            });




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

                    var matiere_id = $(source).attr('data-id'); // id de la matiere
                    var salle_id = $(source).attr('data-salle-id');
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
                            data: 'time=' + time +  '&dayname=' + dayname  +  '&cr_id=' + '{{ $ts->classroom_id  }}' +
                           '&matiere=' +  text  + '&color=' + color +
                            '&matiere_id=' + matiere_id +  '&salle_id=' + salle_id +
                            '&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data){
                                if(data == 'no')
                                {
                                    alert('vous devez ajouter une salle à une matière');
                                }
                            }
                        });

                    } else {
                        var matiere_id = $(source).attr('data-id'); // id de la matiere
                        var salle_id = $(source).attr('data-salle-id');
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
                            +  '&matiere='  + text + '&color='+
                            color + '&matiere_id=' + matiere_id +  '&salle_id=' + salle_id +
                            '&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data) {
                                if(data == 'no')
                                {
                                    alert('vous devez ajouter une salle à une matière');
                                    return false;
                                }
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