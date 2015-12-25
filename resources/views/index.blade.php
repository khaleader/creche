<?php
session_start();
 ?>
@extends('layouts.default')

@section('content')
        <!--mini statistics start-->
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
                        <a href="{{ action('Childrecontroller@indexef') }}">
                            <div class="bloc_info"><img src="images/enfants.png" ><span class="count">
                                    {{  App\Child::where('f_id',\Auth::user()->id)->count() }}
                                </span><p>Enfants inscrits</p></div>
                        </a></div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel bloc">
                    <div class="panel-body">
                        <a href="factures.html">
                            <div class="bloc_info"><img src="images/factures.png" ><span class="count">11</span><p>Factures non réglées</p></div>
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
                        </span><p>Enfants inscrits</p></div>
                </a></div>
        </section>
    </div>
    <div class="col-md-4">
        <section class="panel bloc">
            <div class="panel-body">
                <a href="{{ action('AttendancesController@index') }}">
                    <div class="bloc_info"><img src="images/pointages.png" ><span class="count">

                         <?php
                           $c = App\Child::where('user_id',\Auth::user()->id)->get();
                            if(!$c->isEmpty())
                                {
                                    echo  App\Attendance::where('title','Absence')->whereRaw('EXTRACT(DAY FROM start) = ?',[\Carbon\Carbon::now()->day])
                                            ->whereRaw('EXTRACT(YEAR FROM start) = ?',[\Carbon\Carbon::now()->year])->count();
                                }

                            ?>
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
                <span id="horloge_time"><?php echo strftime('%H %M');   ?></span>
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
                <a href="{{ action('BillsController@index') }}">

                    <div class="bloc_info"><img src="images/factures.png" ><span class="count">  <?php echo  App\Bill::where('status',0)->where('user_id',\Auth::user()->id)->count()  ?></span><p>Factures non réglées</p></div>
                </a></div>
        </section>
    </div>
</div>
@endif


@endsection

@section('jquery')

    <script>
            var date = new Date();
      //  $('#horloge_time').text( date.getHours() + ':' + date.getMinutes());

    </script>


@stop