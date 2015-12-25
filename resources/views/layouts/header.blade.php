
  <div class="head fixed-top">
    <div class="logo">
        <a href="{{  url('/') }}">
        <img src="{{    asset('images/logo.png')}}" alt="logo">

        </a>
    </div>
    <ul class="menu_header">
        <li class="menu_li">
            <img src="{{ asset('images/tableau_de_bord.png')  }}" alt="">
            <a href="{{ url('/') }}">
                Tableau de bord</a>
        </li>
        <li class="menu_li"> <img src="{{ asset('images/qui_sommes_nous.png')  }}" alt="" id="qui_sommes_nous"><a href="">Qui sommes nous ?</a></li>
        <li class="menu_li"> <img src="{{ asset('images/contactez_nous.png')  }}" alt="" id="contactez_nous"><a href="" >Contactez-nous</a></li>
        <li class="menu_li"> <img src="{{ asset('images/comment_ca_marche.png')  }}" alt="" id="comment_ca_marche"><a href="" >Comment Ca marche</a></li>
    </ul>
    <div class="account" id="account">

         @if(\Auth::user() && Auth::user()->isAdmin())
            <a href="{{ action('SchoolsController@edit',[\Auth::user()->id]) }}">
          @elseif(\Auth::user() && Auth::user()->isFamily())
            <a href="{{ action('SchoolsController@editef',[\Auth::user()->id]) }}">
           @endif



         @if(Auth::user() && Auth::user()->isFamily())
                <?php

               $resp = \App\Family::where('email_responsable',Auth::user()->email)->first();
                    if($resp->responsable == 0)
                        {
                            echo 'Bienvenue '.$resp->nom_mere;
                        }else{
                        echo 'Bienvenue '.$resp->nom_pere;
                    }


                  ?>
             @else

             {{ 'Bienvenue '. \Auth::user()->name  }}


            @endif
        </a>
       <img src="{{  asset('images/user.png') }}" alt="user">


    </div>
    <a class="deconnect" href="{{  action('Auth\AuthController@getLogout') }}"><img src="{{  asset('images/logout.png') }}"></a>
</div>
<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
           {{--Route::current()->getUri()  --}}
        @if(Route::current()->getUri() == '/')
            <h2>{{  'Tableau de bord' }}</h2>
        @elseif(Route::current()->getUri() == 'schools' or Request::is('schools/*'))
            <h2>{{  'Ecoles' }}</h2>
        @elseif(Route::current()->getUri() == 'schools/boite')
            <h2>{{  "Demandes D'essai" }}</h2>
        @elseif(Route::current()->getUri() == 'children/create' or Route::current()->getUri() == 'ajouter_enfant' )
            <h2>{{  "inscription" }}</h2>
        @elseif(Route::current()->getUri() == 'children' or Request::is('children/*'))
            <h2>{{  "enfants" }}</h2>
        @elseif(Route::current()->getUri() == 'families' or Request::is('families/*') )
            <h2>{{  "familles" }}</h2>
        @elseif(Route::current()->getUri() == 'teachers'   or Request::is('teachers/*'))
            <h2>{{  "professeur" }}</h2>
        @elseif(Route::current()->getUri() == 'attendances' or Request::is('attendances/*'))
            <h2>{{  "pointages" }}</h2>
        @elseif(Route::current()->getUri() == 'bills' or Request::is('bills/*') )
            <h2>{{  "factures" }}</h2>
        @else
            <h2>{{ 'unknown' }}</h2>
        @endif

        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    @if(Auth::user() && Auth::user()->isOblivius())
        <a class="bt_ajouter" href="{{ action('SchoolsController@create') }}">
            <img src="{{ asset('images/plus.png') }}" id="icon_plus">
            <span>Ajouter une école</span>
        </a>



    @endif

  @if(Auth::user() && Auth::user()->isAdmin())
    <a class="bt_ajouter" href="{{  action('ChildrenController@create_enfant') }}">
        <img src="{{  asset('images/plus.png') }}" id="icon_plus">
        <span>Ajouter un enfant</span>
    </a>
    <div class="search-form">
       {!! Form::open(['url' => action('FamiliesController@search'),'method'=> 'get']) !!}
            <input type="text" name="terms" class="search-input" placeholder="Cherchez un enfant, une famille ...">
            <button type="submit">
                <div class="fa fa-search"></div>
            </button>
       {!! Form::close() !!}
    </div>
    @endif
    <div class="top-nav clearfix">
        <!--search & user info start-->

        <!--search & user info end-->
    </div>
</header>
