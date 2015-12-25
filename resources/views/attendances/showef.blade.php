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
                        <div class='external-event label label-primary'>Absence</div>
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
                editable: false,
                droppable: false ,// this allows things to be dropped onto the calendar
                events : <?php echo ($resultat) ? $resultat: "" ?>,

          


            });













        });





    </script>






@stop