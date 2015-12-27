<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
              @if(Auth::user()->isAdmin())
                <li>
                    <a class="active" href="{{  action('ChildrenController@index') }}">
                        <img src="{{  asset('images/enfants.png') }}" class="sidebar_icons">
                        <span>Enfants</span>
                        <img src="{{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                    </a>
                </li>
                <li >
                    <a href="{{ action('FamiliesController@index') }}">
                        <img src="{{  asset('images/familles.png') }}" class="sidebar_icons">
                        <span>Familles</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a href="{{ action('TeachersController@index') }}">
                        <img src="{{ asset('images/professeurs.png') }}" class="sidebar_icons">
                        <span>Professeurs et RH</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a href="{{  action('ChildrenController@create') }}">
                        <img src="{{  asset('images/inscription.png') }}" class="sidebar_icons">
                        <span>Inscription</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a href="{{  action('AttendancesController@index')  }}">
                        <img src=" {{ asset('images/pointages.png')  }}" class="sidebar_icons">
                        <span>Pointages</span>
                        <img src=" {{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a href="{{  action('BillsController@index') }}">
                        <img src="{{  asset('images/factures.png') }}" class="sidebar_icons">
                        <span>Factures</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>

                </li>
                <li>
                    <a href="">
                        <img src="{{  asset('images/statistiques.png') }}" class="sidebar_icons">
                        <span>Statistiques</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>

                @endif
                  @if(Auth::user() and Auth::user()->isOblivius())
                          <li>
                              <a href="{{ action('SchoolsController@index') }}">
                                  <img src="{{  asset('images/ecole.png') }}" class="sidebar_icons">
                                  <span>Ecoles</span>
                                  <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                              </a>
                          </li>
                      <li>
                          <a href="{{ action('SchoolsController@boite') }}">
                              <img src="{{  asset('images/demandes_test.png') }}" class="sidebar_icons">
                              <span>Demandes {{--    '('.$unread.')' --}} </span>
                              <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                          </a>
                      </li>

                  @endif

                @if(Auth::user() and Auth::user()->isFamily())
                    <li>
                        <a class="active" href="{{  action('ChildrenController@indexef') }}">
                            <img src="{{  asset('images/enfants.png') }}" class="sidebar_icons">
                            <span>Enfants</span>
                            <img src="{{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                        </a>
                    </li>
                      <li>
                          <a href="{{  '#' }}">
                              <img src=" {{ asset('images/pointages.png')  }}" class="sidebar_icons">
                              <span>absences</span>
                              <img src=" {{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                          </a>
                      </li>
                      <li>
                          <a href="{{  action('BillsController@indexef') }}">
                              <img src="{{  asset('images/factures.png') }}" class="sidebar_icons">
                              <span>Factures</span>
                              <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                          </a>

                      </li>
                @endif




            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>