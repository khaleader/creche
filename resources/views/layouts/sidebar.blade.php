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
                <li  style="position: relative;">
                    <a class="sidebar-gestion" href="{{  action('StatisticsController@gestion') }}">
                        <img src="{{  asset('images/inscription.png') }}" class="sidebar_icons">
                        <span>Gestion</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                    <ul class="sub-menu sub-menu-gestion" style="display: none">
                        <li class="nav-item start">
                            <a href="{{ action('MattersController@index') }}" class="nav-link ">
                                <span class="title">Matières</span>
                                <span style="background-color: #0FB4D2" class="badge badge-success">
                                    {{ \Auth::user()->matters()->count() }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="{{ action('LevelsController@index') }}" class="nav-link ">

                                <span class="title">Niveaux</span>
                                <span style="background-color: #84E07B" class="badge badge-success">
                                            {{ \Auth::user()->leslevels()->where('school_year_id',\App\SchoolYear::getSchoolYearId())->count() }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="{{ action ('BranchesController@index') }}" class="nav-link ">

                                <span class="title">Branches</span>
                                <span style="background-color: #FF809B" class="badge badge-success">
                                            {{ \Auth::user()->branches()
                                            ->where('school_year_id',\App\SchoolYear::getSchoolYearId())->count() }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="{{ action('ClassroomsController@index') }}" class="nav-link ">

                                <span class="title">Classes</span>
                                <span style="background-color: #D9434E" class="badge badge-success">
                                           {{ \Auth::user()->classrooms()->CurrentYear()->count() }}

                                </span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="{{ action('RoomsController@index') }}" class="nav-link ">

                                <span class="title">Salles</span>
                                <span style="background-color:#F59B43 " class="badge badge-success">
                                            {{ \Auth::user()->rooms()->count() }}
                                </span>
                            </a>
                        </li>
                    </ul>
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
                    <a class="sidebar-statistiques" href="{{  action('StatisticsController@statistics') }}">
                        <img src="{{  asset('images/statistiques.png') }}" class="sidebar_icons">
                        <span>Statistiques</span>
                        <img src="{{  asset('images/sidebar_plus.png') }}" class="sidebar_plus">
                    </a>
                    <ul class="sub-menu sub-menu-stats" style="display: none" >
                        <li class="nav-item start">
                            <a href="{{ action('StatisticsController@index') }}" class="nav-link ">
                                <span class="title">Chiffres</span>
                                <span style="background-color: #0FB4D2" class="badge">
                            <img src="{{ asset('images\statistiques-icon.png') }}" alt="chart icon">
                                </span>
                            </a>
                        </li>
                        <li class="nav-item start ">
                            <a href="{{ action('StatisticsController@graphs') }}" class="nav-link ">

                                <span class="title">Rapports</span>
                                <span class="badge">
                                      <img src="{{ asset('images\chart-icon.png') }}" alt="chart icon">
                                </span>
                            </a>
                        </li>
                        </ul>
                </li>

                    <li>
                        <a  class="sidebar-archive" href="{{  action('StatisticsController@archive')  }}">
                            <img src=" {{ asset('images/archivestats.png')  }}" class="sidebar_icons">
                            <span>Archive</span>
                            <img src=" {{ asset('images/sidebar_plus.png')  }}" class="sidebar_plus">
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






