@extends('layouts.default')
@section('content')


    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="Photo_profile" >
                        <img class="pdp" src="{{ $teacher->photo ? asset('uploads/'.$teacher->photo) : asset('images/no_avatar.jpg') }}" alt=""/>
                    </div>
                    <div class="nom">
                        <span>{{  $teacher->nom_teacher }}</span>
                    </div>


                </div>
                <div class="age_date">
                    <div class="age"><span>{{ $teacher->date_naissance->diffInYears(\Carbon\Carbon::now()) }} Ans</span><div class="age_sep_date"></div></div>
                    <div class="date"><span>{{ $teacher->date_naissance->format('d-m-Y') }}</span></div>

                </div>
            </section>
          <!--  <section class="panel">
                <a href="">
                    <div class="panel-body paimenent_fiche_enfant">
                        <i class="fa fa-money"></i><span>Paiement effectué</span>
                    </div></a>
            </section>
            <section class="panel">
                <a href="">
                    <div class="panel-body absence_fiche_enfant">
                        <i class="fa fa-calendar"></i><span>Pointages</span>
                    </div></a>
            </section> -->
        </div>
        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a href="{{ action('TeachersController@delete',[$teacher]) }}"><div class="btn_supprimer">Supprimer</div></a>
                    <a href="{{ action('TeachersController@archive',[$teacher]) }}"><div class="btn_archiver">Archiver</div></a>
                    <a href="{{ action('TeachersController@edit',[$teacher->id]) }}"><div class="btn_archiver">modifier</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>
                          <!--  <td><i class="fa fa-book"></i></td> -->
                            <td><span><strong>Matière :</strong> {{ $teacher->poste }}</span></td>
                        </tr>
                        <tr>
                         <!--   <td><i class="fa fa-group"></i></td> -->
                            <td><span><strong>Nombre de classe :</strong> 4 </span></td>
                        </tr>
                        <tr>
                           <!-- <td><i class="fa fa-envelope"></i></td>-->
                            <td><span><strong>Email :</strong> {{ $teacher->email }} </span></td>
                        </tr>
                        <tr>
                         <!--   <td><i class="fa fa-phone"></i></td> -->
                            <td><span><strong>Num fix :</strong> {{ $teacher->num_fix }} </span></td>
                        </tr>
                        <tr>
                            <!--<td><i class="fa fa-mobile"></i></td>-->
                            <td><span><strong>Num portable :</strong> {{ $teacher->num_portable }} </span></td>
                        </tr>
                        <tr>
                          <!--  <td><i class="fa fa-map-marker"></i></td>-->
                            <td><span><strong>Adresse :</strong> {{ $teacher->adresse }} </span></td>
                        </tr>
                        <tr>
                           <!-- <td><i class="fa fa-credit-card"></i></td>-->
                            <td><span><strong>CIN :</strong> {{ $teacher->cin }} </span></td>
                        </tr>
                        <tr>
                          <!--  <td><i class="fa fa-dollar"></i></td>-->
                            <td><span><strong>Salaire:</strong> {{ $teacher->salaire }} Dhs</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </section>
        </div>
    </div>
    <div class="row"></div>




@endsection