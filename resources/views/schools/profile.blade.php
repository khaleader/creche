@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="Photo_profile" >
                        <?php  $user = \Auth::user(); ?>
                        <img class="pdp" src="{{  $user->photo? asset('uploads/'.$user->photo ):asset('images/no_avatar.jpg')  }}" alt=""/>
                    </div>



                </div>

            </section>


        </div>
        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <div class="btn-group dropdown_actions">
                        <button class="btn btn-white" type="button">Actions</button>
                        <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                        <ul role="menu" class="dropdown-menu" style="left: 0;">
                            <li><a href="{{ action('SchoolsController@editer',[\Auth::user()->id]) }}">Modifier</a></li>
                        </ul>
                    </div>
                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>

                            <td><span><strong>Nom de l'école :</strong> {{ \Auth::user()->name }}</span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Nom du responsable :</strong> {{ \Auth::user()->nom_responsable }}  </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Téléphone fixe :</strong>  {{ \Auth::user()->tel_fixe }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Téléphone portable :</strong>  {{ \Auth::user()->tel_portable }}</span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Email :</strong>  {{ \Auth::user()->email }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Adresse :</strong>{{ \Auth::user()->adresse }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Ville :</strong>{{ \Auth::user()->ville }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Site web :</strong></span><a href="#"> {{ \Auth::user()->profile->site_web ? :''  }} </a></td>
                        </tr>
                        <tr>
                            <td><span><strong>Page facebook :</strong></span><a href="#"> {{ \Auth::user()->profile->page_facebook ?:''}} </a></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Informations administratives

                    </h4></header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">
                        <tbody>
                        <tr>
                            <td><span><strong>Patente :</strong> {{ \Auth::user()->profile->patente }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Registre du commerce :</strong> {{ \Auth::user()->profile->registre_du_commerce }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Identification fiscale :</strong> {{ \Auth::user()->profile->identification_fiscale }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>CNSS :</strong> {{ \Auth::user()->profile->cnss }} </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>RIB :</strong> {{ \Auth::user()->profile->rib }} </span></td>

                        </tr>
                        <tr>
                            <td><span><strong>ICE :</strong> {{ \Auth::user()->profile->ice }} </span></td>

                        </tr>
                        </tbody>
                    </table>
                </div>



            </section>

        </div>
    </div>
    <div class="row"></div>



@endsection


@section('jquery')

    <script>

        localStorage.classe = '';


    </script>


@endsection