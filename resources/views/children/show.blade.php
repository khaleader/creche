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
            <a href="{{ action('BillsController@show',[$child->id]) }}">
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
        <section class="panel">
            <a href="{{  action('AttendancesController@show',[$child->id]) }}">
                <div class="panel-body absence_fiche_enfant">
                    <i class="fa fa-calendar"></i><span>Pointages</span>
                </div></a>
        </section>
        </div>

    <div class="col-sm-9">
        <section class="panel">
            <header class="panel-heading wht-bg">
                <h4 class="gen-case"> Informations générales </h4>



                <div class="btn-group dropdown_actions">
                    <button class="btn btn-white" type="button">Actions</button>
                    <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                    <ul role="menu" class="dropdown-menu" style="left: 0;">
                        <li><a  href="{{ action('ChildrenController@edit',[$child->id]) }}">Modifier</a></li>
                        <li><a class="delete-child" href="{{ action('ChildrenController@delete',[$child->id]) }}">Supprimer</a></li>
                        <li><a  href="{{ action('ChildrenController@changeClasse',[$child->id]) }}">Changer La Classe</a></li>
                    </ul>
                </div>

            </header>
            <div class="panel-body informations_general">
                <table class="table  table-hover general-table table_informations ">


                    <tbody>
                    <tr>
                      <!--  <td><i class="fa fa-male"></i></td>
         -->               <td><span><strong>Nom Père :</strong> {{  $child->family->nom_pere }} </span></td>
                    </tr>
                    <tr>
                     <!--   <td><i class="fa fa-female"></i></td>
      -->                  <td><span><strong>Nom Mère :</strong> {{  $child->family->nom_mere }} </span></td>
                    </tr>
                    <tr>
                        <!--   <td><i class="fa fa-female"></i></td>
         -->                  <td><span><strong>Date d'inscription</strong> {{  $child->created_at->format('d-m-Y') }} </span></td>
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

                    <tr>
                    <td><span><strong>Email :</strong> {{ $child->family->email_responsable  }} </span></td>
                    </tr>
                    <tr>
                    <!--    <td><i class="fa fa-phone"></i></td>
      -->                  <td><span><strong>Num fixe :</strong> {{ $child->family->numero_fixe }}</span></td>
                    </tr>
                    <tr>
                      <!--  <td><i class="fa fa-mobile"></i></td>
       -->                 <td><span><strong>Num portable :</strong> {{ $child->family->numero_portable }} </span></td>
                    </tr>
                    <tr>
                     <!--   <td><i class="fa fa-map-marker"></i></td>
  -->                      <td><span><strong>Adresse :</strong> {{ $child->family->adresse }} </span></td>
                    </tr>
                    <tr>
                    <!--    <td><i class="fa fa-credit-card"></i></td>
-->                        <td><span><strong>CIN Père:</strong> {{  strtoupper($child->family->cin) }} </span></td>
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