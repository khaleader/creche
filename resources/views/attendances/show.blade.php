@extends('layouts.default')

@section('css')

  <!-- <link rel="stylesheet" href="{{ asset('js/fullcalendar/bootstrap-fullcalendar.css') }}"> -->
   <link rel="stylesheet" href="{{ asset('js/fullcalendar/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ asset('js/fullcalendar/fullcalendar.print.css') }}" media="print">


@stop


@section('content')



    <section class="panel">
        <header class="panel-heading">
            Pointage calendrier
        </header>
        <div class="panel-body">
            <!-- page start-->
            <div class="row">
                <section class="col-lg-9">
                    <div id="calendar"  class="has-toolbar"></div>
                </section>
          <aside class="col-lg-3">
                    <h4 class="drg-event-title">Les raisons d'absence</h4>
                    <div id='external-events'>
                        <div class='external-event label label-primary'>Normale</div>
                        <div class='external-event label label-info'>Maladie</div>

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
                title: $.trim($(this).text()) // use the element's text as the event title
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


       $('#calendar').fullCalendar({
           header: {
               left: 'prev,next today',
               center: 'title',
               right: 'month,basicWeek,basicDay'
           },
           editable: true,
           droppable: true ,// this allows things to be dropped onto the calendar
                   events : <?php echo ($resultat) ? $resultat: "" ?>,

           drop: function(date, allDay) { // this function is called when something is dropped

               // retrieve the dropped element's stored Event Object
               var originalEventObject = $(this).data('eventObject');

               // we need to copy it, so that multiple events don't have a reference to the same object
               var copiedEventObject = $.extend({}, originalEventObject);

               // assign it the date that was reported
             var start =  copiedEventObject.start = date;
               var start = moment(start).format("YYYY-MM-DD HH:mm:ss");
              var allDay = copiedEventObject.allDay = allDay;
               var allDay = true;
               var child_id = '{{  $child->id }}';
               var title =  copiedEventObject.title;
               var color;
               if(title == 'Normale')
               {
                   color = '#7f64b5';
               }else{
                   color ='#f1c435';
               }
               var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   url: '{{ action('AttendancesController@pointage')  }}',

                   data: 'title=' + title + '&start=' + start + '&end=' + null  + '&_token=' + CSRF_TOKEN
                   + '&color=' + color +  '&allDay=' + allDay +  '&child_id=' + child_id,


                   type: 'post',
                   success: function (response) {
                       alert("Succès de l'opération");
                   }
               });




               // render the event on the calendar
               // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
               $('#calendar').fullCalendar('renderEvent', {
                   title: copiedEventObject.title,
                   start: copiedEventObject.start,
                   color:color,
                   allDay:copiedEventObject.allDay
               }, true);

               // is the "remove after drop" checkbox checked?
               if ($('#drop-remove').is(':checked')) {
                   // if so, remove the element from the "Draggable Events" list
                   $(this).remove();
               }

           },
           eventRender: function(event, element) {
               element.append("<span class='closeon'>X</span>");
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
                        alert('Bien enlevé');
                   }


               });

           }



       });













   });





    </script>






 @stop