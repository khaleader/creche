<?php
session_start();
 ?>
@extends('layouts.default')
<script>
    localStorage.classe ='';
</script>
@section('css')


    <link rel="stylesheet" href="{{ asset('js\codrops\Notification-Styles-Inspiration\css\ns-default.css') }}">
    <link rel="stylesheet" href="{{ asset('js\codrops\Notification-Styles-Inspiration\css\ns-style-attached.css') }}">


@stop
@section('content')

    @if(\Auth::user()->isAdmin() && \Auth::user()->typeCompte == 0)
    <div class="row">
        <div class="col-md-12">
            <section class="panel bloc3" id="mydiv">
                <div class="panel-body" >

                    <div class="bloc_info"><p><strong id="date-container">6 j : 21 h : 36 min : 42 sec</strong> qui vous restent pour tester la globalité de nos fonctionnalités.</br>Si vous voulez activer votre compte officiel contactez-nous sur :&nbsp; <strong> 06 10 15 85 99</strong> ou bien sur <strong>oblivius.contact@gmail.com</strong></p></div>
                    <a href="#" onclick="$('#mydiv').hide()"><img src="images/close.png"></a>
                </div>
            </section>
        </div>
    </div>
@endif


<div class="row">
    @if(Auth::user() && Auth::user()->isOblivius())
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="#">
                        <div class="bloc_info"><img src="{{ asset('images/ecole.png') }}" >
                            <span class="count">{{ App\User::where('type','ecole')->count() }}</span><p>Écoles inscrits</p>
                        </div>
                    </a></div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="factures.html">
                        <div class="bloc_info"><img src="images/factures.png" >
                            <span class="count">11</span><p>Factures non réglées</p>
                        </div>
                    </a>
                </div>
            </section>
        </div>
    @endif
        @if(Auth::user() && Auth::user()->isFamily())
            <div class="col-md-4">
                <section class="panel bloc">
                    <div class="panel-body">
                        <a href="{{ action('ChildrenController@indexef') }}">
                            <div class="bloc_info"><img src="images/enfants.png" ><span class="count">
                                    {{  App\Child::where('f_id',\Auth::user()->id)->count() }}
                                </span><p>Enfants inscrits</p></div>
                        </a></div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel bloc">
                    <div class="panel-body">
                        <a href="{{ action('BillsController@indexef') }}">


                          <div class="bloc_info"><img src="images/factures.png" >
                              <span class="count">
                                      <?php
                                        echo   App\Bill::where('f_id',\Auth::user()->id)->where('status',0)->count();
                                  ?>
                              </span><p>Factures non réglées</p></div>
                        </a>
                    </div>
                </section>
            </div>

        @endif



@if(Auth::user() && Auth::user()->isAdmin()  )
    <div class="col-md-4">

        <section class="panel bloc">
            <div class="panel-body">
                <a href="{{ action('ChildrenController@index') }}">
                    <div class="bloc_info"><img src="{{  asset('images/enfants.png') }}" ><span class="count">
                            {{   App\Child::where('user_id',\Auth::user()->id)->count() }}
                        </span><p>Elèves inscrits</p></div>
                </a></div>
        </section>
    </div>
    <div class="col-md-4">
        <section class="panel bloc">
            <div class="panel-body">
                <a href="{{ action('AttendancesController@absenceToday') }}">
                    <div class="bloc_info"><img src="{{ asset('images/pointages.png') }}" ><span class="count">
                                {{ $count }}
                        </span><p>Absents aujourd'hui</p></div></a>
            </div>
        </section>
    </div>
    @endif
    <div class="col-md-4">
        <section class="panel bloc horloge">
            <div class="panel-body">
                <?php
               // setlocale(LC_TIME, 'fra_fra');
                $day = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
                $month = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
                $date = explode('|', date("w|d|n|Y"));
                $timestamp = time();
                $date = explode('|', date( "w|d|n|Y", $timestamp ));
                /* $user = new App\User();
                 $user->name = 'oblivius';
                 $user->email = 'khaleader4@gmail.com';
                 $user->password = Hash::make('123456');
                 $user->save();
               //App\Bill::onlyTrashed()->find(2)->restore();*/
                ?>
                <h2 id="horloge_jour"><?php echo $day[$date[0]].' '.$date[1] ;   ?></h2>
                <h3 id="horloge_mois"><?php echo ucfirst($month[$date[2]-1]).' '.ucfirst(strftime('%Y'));   ?></h3>
                <span id="horloge_time"><?php echo strftime('%H : %M');   ?></span>
            </div>
        </section>
    </div>
</div>

@if(Auth::user() && Auth::user()->isOblivius())
    <div class="row">
        <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="#">
                        <div class="bloc_info"><img src="images/demandes_test.png" ><span class="count">
                                <?php
                                if(isset($_GET['code']))
                                {
                                $client->authenticate($_GET['code']);
                                $_SESSION['access_token'] = $client->getAccessToken();
                               // $url = $client->createAuthUrl();
                                $url = 'http://laravel.dev:8000/schools/boite';
                                header('Location: '.filter_var($url,FILTER_VALIDATE_URL));
                                }

                                if(isset($_SESSION['access_token']))
                                {
                                  try{
                                $client->setAccessToken($_SESSION['access_token']);
                                echo $service->users_labels->get('me','UNREAD')->getMessagesUnread();

                                  }catch(Google_Auth_Exception $google){
                                   $loginurl = $client->createAuthUrl();
                                      echo 'Votre session a expiré <a href="'.$loginurl.'">cliquer ici </a>pour se connecter';
                                }

                                 }
                                else{
                                   $loginurl = $client->createAuthUrl();
                                  echo '<a href="'.$loginurl.'">cliquer ici</a> pour se connecter';
                                }
                                ?>
                            </span><p>Demandes d'essais</p></div>
                    </a>
                </div>
            </section>
        </div>
    </div>
@endif


@if(Auth::user() && Auth::user()->isAdmin())
                <div class="row">
                    <div class="col-md-4">
            <section class="panel bloc">
                <div class="panel-body">
                    <a href="{{ action('BillsController@indexnr') }}">

                        <div class="bloc_info"><img src="{{ asset('images/factures.png') }}" >
                            <span class="count">
                                <?php echo  App\Bill::where('status',0)
                                        ->where('user_id',\Auth::user()->id)->count()  ?>
                            </span><p>Factures non réglées</p></div>
                    </a></div>
            </section>
        </div>
                    <div class="col-md-4">
                        <section class="panel bloc">
                            <div class="panel-body">
                                <a href="#">
                                    <div class="bloc_info"><img src="{{ asset('images/anniversary.png') }}" >
                                        <?php
                        $annv =  \App\Child::where('user_id',\Auth::user()->id)
                                  ->whereRaw('EXTRACT(month from date_naissance) = ?', [\Carbon\Carbon::now()->month])
                                  ->whereRaw('EXTRACT(day from date_naissance) = ?', [\Carbon\Carbon::now()->day])
                                    ->count();

                                        ?>
                                        <span class="count">{{ $annv }}</span><p>Anniversaires</p></div>
                                </a></div>
                        </section>
                    </div>




                </div>

<script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\modernizr.custom.js') }}"></script>
<script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\classie.js') }}"></script>
<script src="{{ asset('js\codrops\Notification-Styles-Inspiration\js\notificationFx.js') }}"></script>
@endif

    @if($errors->any())
      <!--  <script>




            var notification = new NotificationFx({
                message : '<a href="{{  url('/') }}"> <img src="{{--    asset('images/logo.png')--}}" alt="logo"> </a>' ,
                layout : 'attached',
                effect : 'bouncyflip',
                type : 'notice', // notice, warning or error
                onClose : function() {

                }
            });
          //  notification.show();


        </script>-->
    @endif


@endsection

@section('jquery')

    <script src="{{ asset('js\countdown\jquery.countdown.js') }}"></script>

    <script>

  $('#date-container').countdown({
           date: "{{ \Auth::user()->created_at->addDays(7)  }}"
       });

  localStorage.classe = '';


    </script>

@stop