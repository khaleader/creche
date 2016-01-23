@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Liste des emplois du temps
                </header>


                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                             <th>Nom Elève</th>
                            <th>Classe</th>
                            <th>Branche</th>
                            <th></th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($children as $child)
                            @foreach($child->classrooms as $ts)
                            <tr>
                                <td>{{ $child->nom_enfant }}</td>
                                <td>{{ $ts->nom_classe }}</td>
                                <td>{{ $ts->branche }}</td>
                                <td><a href="{{ action('ClassroomsController@showef',[$ts]) }}">
                                        <div  class="btn_details">Détails</div></a></td>

                            </tr>
                                @endforeach
                        @endforeach
                        </tbody>
                    </table>
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
                            'message': 'voulez vous vraiment supprimer la classe et l\'emploi du temps associé ? ',
                            'transition': 'fade',
                            'onok': function(){
                                window.location.href = href;
                                alertify.success('bien Supprimé!');
                            },
                            'oncancel': function(){
                                alertify.error('Pas Supprimé :)');
                            }
                        }).show();

            });


            $('#delete-ts').click(function(){
                var boxes;
                var status;
                $("input[name='select[]']").each(function(){
                    if($(this).is(':checked'))
                    {
                        status = true;
                        var valeur = $(this).val();
                        $(this).val(valeur).closest('tr').fadeOut();
                        boxes = $(this).val() + ',';
                        $('#boxes').append(boxes);
                    }
                });
                if($('#boxes').text() ===  null)
                {
                    alert('check please');
                    return false;
                }
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('TimesheetsController@supprimer')}}',
                    data: 'boxes=' + $('#boxes').text() + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        console.log(data);
                    }
                });
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