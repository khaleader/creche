@extends('layouts.default')


@section('content')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="Photo_profile" >
                        <img class="pdp" src="{{  $child->photo? asset('uploads/'.$child->photo): asset('images/avatar4.jpg')  }}" alt=""/>
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

                <a href="{{  action('BillsController@showef',[$child->id]) }}">
                    <?php  $status =  App\Bill::where('child_id',$child->id)->first();  ?>
                    @if($status->status ==  1)
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
                <a href="{{  action('AttendancesController@showef',[$child->id]) }}">
                    <div class="panel-body absence_fiche_enfant">
                        <i class="fa fa-calendar"></i><span>Pointages</span>
                    </div></a>
            </section>
            @foreach($child->classrooms as $cr)
            <section class="panel">
                <a href="{{  action('ClassroomsController@showef',[$cr]) }}">
                    <div class="panel-body absence_fiche_enfant" style="background-color:#337180">
                        <i class="fa fa-calendar"></i><span>Emploi du temps</span>
                    </div></a>
            </section>
                @endforeach
        </div>

        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>
                            <td><i class="fa fa-male"></i></td>
                            <td><span><strong>Nom Père :</strong> {{  $child->family->nom_pere }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-female"></i></td>
                            <td><span><strong>Nom Mère :</strong> {{  $child->family->nom_mere }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-envelope"></i></td>
                            <td><span><strong>Email :</strong> {{ $child->family->email_responsable  }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-phone"></i></td>
                            <td><span><strong>Num fix :</strong> {{ $child->family->numero_fixe }}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-mobile"></i></td>
                            <td><span><strong>Num portable :</strong> {{ $child->family->numero_portable }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-map-marker"></i></td>
                            <td><span><strong>Adresse :</strong> {{ $child->family->adresse }} </span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-credit-card"></i></td>
                            <td><span><strong>CIN Père:</strong> {{  strtoupper($child->family->cin) }} </span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>


            </section>
        </div>
    </div>
    <div class="row"></div>



@endsection