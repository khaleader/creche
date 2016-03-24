@extends('layouts.default')
<script>
    localStorage.classe ='';
    localStorage.link = '';
</script>
@section('css')
    <link rel="stylesheet" href="{{ asset('js\bootstrap-datepicker\css\bootstrap-datetimepicker.css')  }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('js/fullcalendar/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{ asset('js/fullcalendar/fullcalendar.print.css') }}" media="print">

    <style>
a.fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end{
    height:15px;
}
a.fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-not-end{
    height:15px;
}
a.fc-day-grid-event.fc-h-event.fc-event.fc-not-start.fc-end{
    height:15px;
}
#title, #start, #fin{
    padding-left: 10px;
}
        .occ-timepicker{
            width:98%;
            margin-right: 5%;
        }
        .text-primary{
            color: #007AFF;
        }

        .text-purple {
            color: #DD5A82;
        }

        .text-green {
            color: #1FBBA6;
        }

        .text-info {
            color:#31708f;
        }

        .text-orange {
            color: #cc601c;
        }

        .text-yellow {
            color: #FFB848;
        }
    </style>


@stop

@section('right-sidebar')

    <div id="right-sidebar" class="right-sidebar" style="z-index: 99999;">
        <ul class="right-side-accordion ">
            <form action="{{ action('OccasionsController@insertOcc') }}" method="post" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">


            <aside class="col-sm-12">


                    <ul class="informations_general pointages_raisons" style="border:none;margin-top: 5px;">
                        <!--  <li class="datepicker "><span><strong>Raison : </strong></span>
                              <select class="datetimepicker" >
                                  <option valeur="Normal">Absence justifiée</option>
                                  <option valeur="Maladie">Absence non justifiée</option>
                                  <option>Retard</option>
                              </select>

                          </li>-->
                        <strong>Titre </strong>

                        <li class="datepicker ">
                            <span></span>
                            <input id="title" name="title" placeholder="Le Titre de L'événement"
                                   type="text" class="datetimepicker    occ-timepicker"></li>

                        <strong>De : </strong>

                        <li class="datepicker "><span>

                            </span><input id="start" name="start" placeholder="Date de Départ"
                                          type="text" class="datetimepicker timepicker   occ-timepicker"></li>
                        <strong>à : </strong>
                        <li class="datepicker"><span id="pickertime2"></span>
                            <input placeholder="Date de Fin" name="end" id="fin" data-format="hh:mm:ss" type="text" class="datetimepicker timepicker occ-timepicker"></li>
                        <!--  <button class="btn_pointage" type="submit">Confirmer</button>-->
                    </ul>


            </aside>
            </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="radio clip-radio radio-primary">
                                <input checked type="radio" value="#007AFF" id="job"  name="optionsCategory" value="job" class="event-categories">
                                <label for="job">
                                    <span class="fa fa-circle text-primary"></span> Travail
                                </label>
                            </div>
                            <div class="radio clip-radio radio-primary">
                                <input value="#DD5A82" type="radio" id="home" name="optionsCategory" value="home" class="event-categories">
                                <label for="home">
                                    <span class="fa fa-circle text-purple"></span> Maison
                                </label>
                            </div>
                            <div class="radio clip-radio radio-primary">
                                <input value="#1FBBA6" type="radio" id="off-site-work" name="optionsCategory" value="off-site-work" class="event-categories">
                                <label for="off-site-work">
                                    <span class="fa fa-circle text-green"></span> Scolaire
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="radio clip-radio radio-primary">
                                <input type="radio" value="#FFB848" id="cancelled" name="optionsCategory" value="cancelled" class="event-categories">
                                <label for="cancelled">
                                    <span class="fa fa-circle text-yellow"></span> Annulé
                                </label>
                            </div>
                            <div class="radio clip-radio radio-primary">
                                <input value="#31708f" type="radio" id="generic" name="optionsCategory" value="generic" class="event-categories">
                                <label for="generic">
                                    <span class="fa fa-circle text-info"></span> Général
                                </label>
                            </div>
                            <div class="radio clip-radio radio-primary">
                                <input value="#FF6600" type="radio" id="to-do" name="optionsCategory" value="to-do" class="event-categories">
                                <label for="to-do">
                                    <span class="fa fa-circle text-orange"></span> A faire
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-left: -30px;padding-right: 10px">
                        <button class="btn btn-danger btn-o hide-event">
                            Cacher
                        </button>
                        <button class="btn btn-primary btn-o save-event" type="submit">
                            Enregistrer
                        </button>
                    </div>
            </form>





        </ul>
    </div>


@endsection
@section('content')
    <section class="panel">
        <header class="panel-heading">

            <a href="#" class="btn btn-primary btn-o add-event"><i class="fa fa-plus"></i> Ajouter un évenement</a>
        </header>
        <div class="panel-body">
            <!-- page start-->
            <div class="row">
                <section class="col-lg-12">
                    <div id="calendar"  class="has-toolbar"></div>
                </section>
                </div>
            </div>
        </section>

@endsection

@section('jquery')
    <script src="{{ asset('js\bootstrap-datepicker\js\moment.js') }}"></script>
    <script src="{{ asset('js\bootstrap-datepicker\js\bootstrap-datetimepicker.js') }}"></script>
    <script src="{{  asset('js/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{  asset('js/fullcalendar/fr.js')  }}"></script>

    <script>

$(function(){
         //right sidebar
            var startInput = $('#start');
            var endInput =  $('#fin');

            startInput.datetimepicker({
                toolbarPlacement: 'top',
                showClose: true,
                locale:'fr',
                format: 'Y-M-D HH:mm',
                widgetPositioning :{
                    horizontal:'right'
                }
               // sideBySide: true
            });
            endInput.datetimepicker({
                toolbarPlacement: 'top',
                showClose: true,
                locale: 'fr',
                format: 'Y-M-D HH:mm',
                widgetPositioning :{
                    horizontal:'right'
                }
            });

    $('.hide-event').click(function(e){
        e.preventDefault();
        $('#right-sidebar').css({
            "right":"-300px",
            "-webkit-transition":"all .3s ease-in-out",
            " -moz-transition":"all .3s ease-in-out",
            "-o-transition":"all .3s ease-in-out",
            "transition":"all .3s ease-in-out"
        });
    });
    $('.add-event').click(function(){
        $('#right-sidebar').css({
            "right":"0px",
            "-webkit-transition":"all .3s ease-in-out",
            " -moz-transition":"all .3s ease-in-out",
            "-o-transition":"all .3s ease-in-out",
            "transition":"all .3s ease-in-out"
        });



    });


    // calendar
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
            // right: 'month,agendaWeek,agendaDay'
        },
        eventLimit : true,
        events : <?php echo ($resultat) ? $resultat: "" ?>,
        eventRender: function(event, element) {
            element.append("<span  style='display: inline-block' class='closeon'>X</span>");
        },
        // delete event
        eventClick: function (calEvent, jsEvent, view) {
            $('#calendar').fullCalendar('removeEvents', calEvent._id);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  action('OccasionsController@delOcc') }}',
                data: {'id': calEvent._id, '_token': CSRF_TOKEN},
                method: 'post',
                success:function(json){
                    alertify.success('Bien enlevé');

                }
            });
        }
    });


$('.save-event').click(function(e){
   if($('#title').val().length == 0)
   {
       alertify.alert('saisissez le titre');
       return false;
   }
    if($('#start').val().length == 0)
    {
        alertify.alert('il faut insérer une date mm');
        return false;
    }
    if($('#fin').val().length == 0)
    {
        alertify.alert('il faut insérer une date ');
        return false;
    }


        if(!$('input[name=optionsCategory]').is(':checked')) {
            alertify.alert('cocher un couleur ');
            return false;
        }



    var title = $('#title').val();
    var start = $('#start').val();
    var end = $('#fin').val();
    var color = $('input[name=optionsCategory]').attr('data-color');

    //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
   /* $.ajax({

        url: '{{  action('OccasionsController@insertOcc') }}',
        data: {
            data: 'title=' + title + '&start=' + start + '&end=' + end  + '&color=' + color +
            '&_token=' + '{{  csrf_token() }}'

        },
        method: 'post',
        success:function(json){
            $('#title').val('')
            $('#start').val('');
            $('#fin').val('');
        }
    });*/


});




});




    </script>

@stop