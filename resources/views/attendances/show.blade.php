@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('js\timepicki\timepicki.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('js/fullcalendar/bootstrap-fullcalendar.css') }}"> -->
   <link rel="stylesheet" href="{{ asset('js/fullcalendar/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ asset('js/fullcalendar/fullcalendar.print.css') }}" media="print">
    <!--<link rel="stylesheet" href="{{-- asset('js/fullcalendar/scheduler.css') --}}">-->




@stop


@section('content')
    <section class="panel">
        <header class="panel-heading">
            Pointage calendrier de <strong> {{ $child->nom_enfant }}</strong>
        </header>
        <div class="panel-body">
            <!-- page start-->
            <div class="row">
                <section class="col-lg-9">
                    <div id="calendar"  class="has-toolbar"></div>
                </section>
         <!-- <aside class="col-lg-3">
                    <h4 class="drg-event-title">Les raisons d'absence</h4>
                    <div id='external-events'>
                        <div valeur="Normal" class='external-event label label-primary'>Justifiée</div>
                        <div valeur="Maladie" class='external-event label label-info'>Non Justifiée</div>

                    </div>
                </aside>-->

                <aside class="col-lg-3">
                    <h4 class="drg-event-title">Détails du pointage</h4>
                    <form action="#" >
                        <ul class="informations_general pointages_raisons" style="margin-top: 5px;">
                          <!--  <li class="datepicker "><span><strong>Raison : </strong></span>
                                <select class="datetimepicker" >
                                    <option valeur="Normal">Absence justifiée</option>
                                    <option valeur="Maladie">Absence non justifiée</option>
                                    <option>Retard</option>
                                </select>

                            </li>-->
                            <li class="datepicker "><span><strong>De : </strong></span><input id="start" data-format="hh:mm:ss" type="text" class="datetimepicker timepicker"></li>
                            <li class="datepicker"><span id="pickertime2"><strong>à : </strong></span><input id="fin" data-format="hh:mm:ss" type="text" class="datetimepicker timepicker"></li>
                          <!--  <button class="btn_pointage" type="submit">Confirmer</button>-->
                        </ul>

                    </form>
                    <div id='external-events'>
                        <div valeur="Normal" class='external-event label just'>Justifiée</div>
                        <div valeur="Maladie" class='external-event label non_just'>Non Justifiée</div>
                        <div valeur="Retard" class='external-event label retard'>Retard</div>

                    </div>
                </aside>
            </div>
            <!-- page end-->
        </div>
    </section>

@endsection



@section('jquery')

    <script src="{{  asset('js/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{  asset('js/fullcalendar/fr.js')  }}"></script>
<!--<srcipt src="{{  asset('js/external-dragging-calendar.js') }}"></srcipt> -->
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js\timepicki\timepicki.js') }}"></script>
   <!-- <script src="{{-- asset('js\fullcalendar\scheduler.js') --}}"></script>-->
 <script>
   $(function(){



        $('#external-events .external-event').each(function(){
            // store data so the calendar knows to render an event upon drop
         /*   $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });*/

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).attr('valeur')) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);



            // make the event draggable using jQuery UI
           $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });


        });


       var depart = '';
       var finale = '';
       var ledepart ='';
       var lefinal = '';

       $('#calendar').fullCalendar({
           //selectOverlap:false,
           header: {
               left: 'prev,next today',
               center: 'title',
              right: 'month,basicWeek,basicDay'
              // right: 'month,agendaWeek,agendaDay'
           },

           editable: true,
           eventLimit: true,
           views: {
               agenda: {
                   eventLimit: 6 // adjust to 6 only for agendaWeek/agendaDay
               }
           },
           droppable: true ,// this allows things to be dropped onto the calendar
                   events : <?php echo ($resultat) ? $resultat: "" ?>,



           drop: function(date, allDay) { // this function is called when something is dropped
              depart = $('#start').val();
               finale = $('#fin').val();

               if(depart.length == 0 || finale.length == 0)
               {
                   alertify.alert('vous devez choisir le temps de départ et fin');
                   return false;
               }
               var depart_heure = $.trim(depart.substr(0,2));
               var depart_minute = $.trim(depart.substr(5,2));
               var finale_heure = $.trim(finale.substr(0,2));
               var finale_minute = $.trim(finale.substr(5,2));


               var originalEventObject = $(this).data('eventObject');
               var copiedEventObject = $.extend({}, originalEventObject);
               var start =  copiedEventObject.start = date;
               var start = moment(start).format("YYYY-MM-DD");

               ledepart = start + ' ' + depart_heure+':'+depart_minute+':'+'00';
               lefinal = start + ' ' + finale_heure+':'+finale_minute+':'+'00';


           // console.log(date._d);
               // retrieve the dropped element's stored Event Object
             //  var originalEventObject = $(this).data('eventObject');

               // we need to copy it, so that multiple events don't have a reference to the same object
            //   var copiedEventObject = $.extend({}, originalEventObject);

               // assign it the date that was reported
           //  var start =  copiedEventObject.start = date;
              // var start = moment(start).format("YYYY-MM-DD HH:mm:ss");


             //var allDay = copiedEventObject.allDay = allDay;
             var allDay = false;
               var child_id = '{{  $child->id }}';
               var title =  copiedEventObject.title;
               var color;
               if(title == 'Normal')
               {
                   color = '#84e07b';
               }else if(title =='Maladie'){
                   color ='#d9434e';
               }else{
                   color = '#0FB4D2';
               }
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   url: '{{ action('AttendancesController@pointage')  }}',

                   data: 'title=' + title + '&start=' + ledepart + '&end=' + lefinal  + '&_token=' + CSRF_TOKEN
                   + '&color=' + color +  '&allDay=' + allDay +  '&child_id=' + child_id,
                   type: 'post',
                   success: function (response) {
                       alertify.success("Succès de l'opération");
                       $('#start').val('');
                       $('#fin').val('');
                   }
               });




               // render the event on the calendar
               // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
               $('#calendar').fullCalendar('renderEvent', {
                   title: copiedEventObject.title == 'Normal' ? 'Justifiée':
                   copiedEventObject.title == 'Maladie'? 'Non Justifiée': 'Retard',
                   start: ledepart,
                   end: lefinal,
                   color:color
               }, true);

               // is the "remove after drop" checkbox checked?
               if ($('#drop-remove').is(':checked')) {
                   // if so, remove the element from the "Draggable Events" list
                   $(this).remove();
               }

           },
           eventRender: function(event, element) {
               element.append("<span  style='display: inline-block' class='closeon'>X</span>");
           },
           // delete event
           eventClick: function (calEvent, jsEvent, view) {
               $('#calendar').fullCalendar('removeEvents', calEvent._id);
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   url: '{{  action('AttendancesController@delatt') }}',
                   data: {'id': calEvent._id, '_token': CSRF_TOKEN},
                   method: 'post',
                   success:function(json){
                       alertify.success('Bien enlevé');

                   }
               });
           },
       });

       $('#start').timepicki({
           show_meridian:false,
           increase_direction:'up',
           start_time: ["08", "00", "AM"],
           min_hour_value:0,
           max_hour_value:23,
       });
       $('#fin').timepicki({
           show_meridian:false,
           increase_direction:'up',
           start_time: ["09", "00", "AM"],
           min_hour_value:0,
           max_hour_value:23,
       });
   });


    </script>






 @stop