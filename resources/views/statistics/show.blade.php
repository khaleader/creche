@extends('layouts.default')


@section('content')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="Photo_profile" >

                        <img class="pdp" src="{{  $child->photo? asset('uploads/'.$child->photo):asset('images/no_avatar.jpg')  }}" alt=""/>
                    </div>
                    <div class="nom">
                        <span>{{  $child->nom_enfant }}</span>
                    </div>
                </div>
                <div class="age_date">

                    <div class="age"><span>{{ $child->date_naissance->diffInYears(Carbon\Carbon::now())  }} ans</span><div class="age_sep_date"></div></div>
                    <div class="date"><span>{{  $child->date_naissance->format('d-m-Y') }}</span></div>

                </div>
            </section>

            <section class="panel">
                <a href="{{ action('StatisticsController@edit',[$child->id]) }}">
                    <?php
                    $status = App\Bill::where('child_id',$child->id)->first();
                    ?>
                    @if($status->status == 1)
                        <div class="panel-body paimenent_fiche_enfant">
                            <i class="fa fa-money"></i><span>Paiement effectué</span>
                        </div>
                    @else
                        <div class="panel-body paimenent_fiche_enfant" style="background-color:#d3423e">
                            <i class="fa fa-money"></i><span>Paiement non effectué</span>
                        </div>

                    @endif
                </a>
            </section>

        </div>

        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales </h4>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                         <td><span><strong>Nom Père :</strong> {{  $child->family->nom_pere }} </span></td>
                        </tr>
                        <tr>

                         <td><span><strong>Nom Mère :</strong> {{  $child->family->nom_mere }} </span></td>
                        </tr>
                        <tr>

                      <td><span><strong>Date d'inscription</strong> {{  $child->created_at->format('d-m-Y') }} </span></td>
                        </tr>

                        <tr>
                            @foreach($child->classrooms as $cr)
                                <td><span><strong> Classe :</strong> {{  $cr->nom_classe }} </span></td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach($child->classrooms as $cr)
                                @foreach($cr->branches as $br)
                                    <td><span><strong> Branche :</strong> {{  $br->nom_branche }} </span></td>
                                @endforeach
                            @endforeach
                        </tr>

                        <tr>
                            @foreach($child->classrooms as $cr)
                                @foreach($cr->levels as $level)
                                    <td><span><strong> Niveau :</strong> {{  $level->niveau }} </span></td>
                                @endforeach
                            @endforeach
                            @foreach($child->classrooms as $cr)
                                @foreach($cr->lesNiveaux as $level)
                                    <td><span><strong> Niveau :</strong> {{  $level->niveau }} </span></td>
                                @endforeach
                            @endforeach

                        </tr>

                        <tr>
                            <td><span><strong>Sexe :</strong> {{ $child->sexe  }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Nationalité :</strong> {{ $child->nationalite  }} </span></td>
                        </tr>

                        </tbody>
                    </table>
                </div>


            </section>
        </div>
    </div>
    <div class="row"></div>



@endsection

@section('jquery')


    <script>

        $('body').on('click','.delete-child',function(e){
            e.preventDefault();
            var href = this.href;
            alertify.dialog('confirm')
                    .set({
                        'labels':{ok:'Oui', cancel:'Non'},
                        'message': 'voulez vous vraiment supprimer cet élément ? ',
                        'transition': 'fade',
                        'onok': function(){
                            window.location.href = href;
                            alertify.success('bien Supprimé!');
                        },
                        'oncancel': function(){

                        }
                    }).show();

        });

    </script>




@stop