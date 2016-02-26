<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
              @if(Auth::user()->isAdmin())
                <li>
                    <a class="sidebar-eleve" href="{{  action('ChildrenController@index') }}">
                        <img src="{{  asset('images/enfants.png') }}" class="sidebar_icons">
                        <span>Elèves</span>
                        <img src="{{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                    </a>
                </li>
                <li >
                    <a class="sidebar-famille" href="{{ action('FamiliesController@index') }}">
                        <img src="{{  asset('images/familles.png') }}" class="sidebar_icons">
                        <span>Familles</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a class="sidebar-teacher" href="{{ action('TeachersController@index') }}">
                        <img src="{{ asset('images/professeurs.png') }}" class="sidebar_icons">
                        <span>Professeurs et RH</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a class="sidebar-gestion" href="{{  action('StatisticsController@gestion') }}">
                        <img src="{{  asset('images/inscription.png') }}" class="sidebar_icons">
                        <span>Gestion</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a  class="sidebar-pointage" href="{{  action('AttendancesController@index')  }}">
                        <img src=" {{ asset('images/pointages.png')  }}" class="sidebar_icons">
                        <span>Pointages</span>
                        <img src=" {{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                    </a>
                </li>
                <li>
                    <a class="sidebar-factures" href="{{  action('BillsController@index') }}">
                        <img src="{{  asset('images/factures.png') }}" class="sidebar_icons">
                        <span>Factures</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>

                </li>
                <li>
                    <a class="sidebar-statistiques" href="{{  action('StatisticsController@index') }}">
                        <img src="{{  asset('images/statistiques.png') }}" class="sidebar_icons">
                        <span>Statistiques</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                </li>

                @endif
                  @if(Auth::user() and Auth::user()->isOblivius())
                          <li>
                              <a class="sidebar-ob-index" href="{{ action('SchoolsController@index') }}">
                                  <img src="{{  asset('images/ecole.png') }}" class="sidebar_icons">
                                  <span>Ecoles</span>
                                  <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                              </a>
                          </li>
                      <li>
                          <a class="sidebar-ob-demandes" href="{{ action('SchoolsController@boite') }}">
                              <img src="{{  asset('images/demandes_test.png') }}" class="sidebar_icons">
                              <span>Demandes {{--    '('.$unread.')' --}} </span>
                              <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                          </a>
                      </li>

                  @endif

                @if(Auth::user() and Auth::user()->isFamily())
                    <li>
                        <a class="sidebar-f-eleve" href="{{  action('ChildrenController@indexef') }}">
                            <img src="{{  asset('images/enfants.png') }}" class="sidebar_icons">
                            <span>Elèves</span>
                            <img src="{{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                        </a>
                    </li>
                      <li>
                          <a class="sidebar-f-att" href="{{  action('AttendancesController@indexef') }}">
                              <img src=" {{ asset('images/pointages.png')  }}" class="sidebar_icons">
                              <span>Absences</span>
                              <img src=" {{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
                          </a>
                      </li>
                      <li>
                          <a class="sidebar-f-classes" href="{{  action('ClassroomsController@indexef') }}">
                              <img src="{{  asset('images/emplois.png') }}" class="sidebar_icons">
                              <span>Emplois du Temps</span>
                              <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                          </a>

                      </li>
                      <li>
                          <a class="sidebar-f-bills" href="{{  action('BillsController@indexef') }}">
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






