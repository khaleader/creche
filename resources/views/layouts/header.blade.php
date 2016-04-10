<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">

        <img src="{{ asset('images/logo2.png') }}" id="logo">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->



    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="menu">
            <li><a style="color: #687b8c" href="{{ url('/')  }}"><img src="{{ asset('images/tableau_de_bord.png') }}" style="border-radius:0%;width:auto;margin-right:10px;">Tableau de bord</a></li>
            @if(Auth::user() && Auth::user()->isAdmin())
            <li><a style="color: #687b8c" href="{{ action('PlansController@index')  }}"><img src="{{ asset('images/planning.png') }}" style="border-radius:0%;width:auto;margin-right:10px;">Planning</a></li>

              @endif
        </ul>
        <ul class="nav pull-right top-menu">
            <?php
            $ynow = \Carbon\Carbon::now()->year;
            $ynext = \Carbon\Carbon::now()->year + 1;
            $both =$ynow.'-'.$ynext;
            $month = \Carbon\Carbon::now()->month;
            $result = \Auth::user()->schoolyears()->where('ann_scol',$both)->first();
             $current = \Auth::user()->schoolyears()->where('current',1)->first();
                if($current)
               $fyears = explode('-',$current->ann_scol);
            ?>

                @if(Auth::user() && Auth::user()->isAdmin())
                <li>
                <a data-toggle="dropdown" href="#" class="inscription btn btn-default dropdown-toggle"
                   style="padding: 7px 15px;color:
                   #555555;background-color:#f1c435;font-weight:bold;color:#fff;
                   border-color:#f1c435;font-size: 13px;">Inscription  </a>
                    <ul role="menu" class="dropdown-menu dropdown_inscription" style="margin-left: -126px;">
                        @if($current)
                        <li><a href="{{ action('ChildrenController@create') }}">Inscription {{ $fyears[0].'/'.$fyears[1] }}</a></li>
                        @endif
                        @if($month  >= 1 &&  $month < 7 && $result)
                        <li><a href="{{ action('EarlySubscriptionsController@create') }}">Inscription {{ $ynow.'/'.$ynext}}</a></li>
                        @endif
                    </ul>

                </li>








                   @elseif(Auth::user() && Auth::user()->isOblivius())
                       <li>
                     <a href="{{ action('SchoolsController@create') }}" class="inscription"
                       style="padding: 7px 15px;color:
                   #555555;background-color:#f1c435;font-weight:bold;color:#fff;
                   border-color:#f1c435;font-size: 13px;">Ajouter une école
                     </a>
                     </li>

                @endif

            @if(Auth::user() && Auth::user()->isAdmin())
            <li>
                {!! Form::open(['url' => action('FamiliesController@search'),'method'=> 'get']) !!}
                <input name="terms" type="text" class="form-control search" placeholder="Chercher un élève, une famille ...">
                {!! Form::close() !!}
            </li>
            @endif

            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{ \Auth::user()->photo ? asset('uploads/'.\Auth::user()->photo ):asset('images/user.png') }}">
                    <span  class="username">{{ \Auth::user()->name }}</span>

                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout" style="margin: 1px 0px 0;">
                    @if(\Auth::user() && Auth::user()->isAdmin())
                        <li><a href="{{ action('SchoolsController@profile',[\Auth::user()->id]) }}">
                                <img class="dorpdown_icons" src="{{ asset('images/profil.png') }}">
                                Profil</a></li>
                    @elseif(\Auth::user() && Auth::user()->isFamily())
                        <li><a href="#"><img class="dorpdown_icons" src="{{ asset('images/profil.png') }}">Profil</a></li>
                     @endif

                    @if(\Auth::user() && Auth::user()->isAdmin())
                    <li><a href="{{ action('SchoolsController@edit',[\Auth::user()->id]) }}">
                            <img class="dorpdown_icons" src="{{ asset('images/parametres.png') }}">Paramètres</a></li>
                   <li><a id="gestion-utilis" href="{{ action('SchoolsController@gestion_users',[\Auth::user()->id]) }}">
                           <img class="dorpdown_icons" src="{{ asset('images/users.png') }}">Gestion utilisateurs</a></li>
                    <li><a href="{{ action('OccasionsController@show',[\Auth::user()->id]) }}">
                            <img class="dorpdown_icons" src="{{ asset('images/days.png') }}">Événements</a></li>
                        <li><a href="{{  action('SchoolsController@promotion',[\Auth::user()->id]) }}">
                                <img class="dorpdown_icons" src="{{ asset('images/promo.png') }}">Promotions</a></li>
                    @elseif(\Auth::user() && Auth::user()->isFamily())
                        <li><a href="{{ action('SchoolsController@editef',[\Auth::user()->id]) }}">
                                <img class="dorpdown_icons" src="{{ asset('images/parametres.png') }}">Paramètres</a></li>
                    @endif

                     <li><a href="{{ url('help') }}"><img class="dorpdown_icons" src="{{ asset('images/help.png') }}">Besoin d'aide</a></li>
                    <li><a href="{{  action('Auth\AuthController@getLogout') }}">
                            <img class="dorpdown_icons" src="{{ asset('images/logout.png') }}">Déconnexion</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>