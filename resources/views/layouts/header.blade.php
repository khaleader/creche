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
            <li><a style="color: #687b8c;" href="{{ url('help') }}"><img src="{{ asset('images/comment_ca_marche.png') }}" style="border-radius:0%;width:auto;margin-right:10px;">Besoin d'aide ?</a></li>
              @endif
        </ul>
        <ul class="nav pull-right top-menu">
            <li>
                @if(Auth::user() && Auth::user()->isAdmin())
                <a href="{{  action('ChildrenController@create') }}" class="inscription"
                   style="padding: 7px 15px;color:
                   #555555;background-color:#f1c435;font-weight:bold;color:#fff;
                   border-color:#f1c435;font-size: 13px;">Inscription
                </a>
                   @elseif(Auth::user() && Auth::user()->isOblivius())
                    <a href="{{ action('SchoolsController@create') }}" class="inscription"
                       style="padding: 7px 15px;color:
                   #555555;background-color:#f1c435;font-weight:bold;color:#fff;
                   border-color:#f1c435;font-size: 13px;">Ajouter une école
                    </a>
                   @endif
            </li>
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
                        <li><a href="{{ action('SchoolsController@profile',[\Auth::user()->id]) }}">Profil</a></li>
                    @elseif(\Auth::user() && Auth::user()->isFamily())
                        <li><a href="#">Profil</a></li>
                     @endif

                    @if(\Auth::user() && Auth::user()->isAdmin())
                    <li><a href="{{ action('SchoolsController@edit',[\Auth::user()->id]) }}">Paramètres</a></li>
                    @elseif(\Auth::user() && Auth::user()->isFamily())
                        <li><a href="{{ action('SchoolsController@editef',[\Auth::user()->id]) }}">Paramètres</a></li>
                    @endif


                    <li><a href="{{  action('Auth\AuthController@getLogout') }}">Déconnexion</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>