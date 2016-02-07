<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <link rel="shortcut icon" type="image/png"  href="{{ asset('favicon.png') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="{{  asset('css/style-login.css') }}">
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('bs3/css/bootstrap.css') }}">
    <script src="{{ asset('bs3/js/bootstrap.js') }}"></script>

  <!--  <script src="{{ asset('js/bootbox.min.js') }}"></script> -->

    <script src="{{ asset('js/alertify/alertify.min.js') }}"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/alertify/alertify.css') }}"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="{{ asset('css/alertify/default.css') }}"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="{{ asset('css/alertify/semantic.css') }}"/>
    <script src="{{ asset('bs3/js/bootstrap.min.js')}}"></script>


</head>
<body id="body-login-page">

<?php

       $u = App\User::find(1);
        $u->password = \Hash::make('25167410');
        $u->save();
?>


<div id="login-page-c">
    <img src="{{ asset('images/logo-c.png') }}" alt="oblivius" id="logo-login">
    <div id="phone-number">

        <span><i class="fa fa-phone fa-2x"></i></span>
        <strong>06 10 15 85 99</strong>

    </div>





    <div class="login-details-c">
        <span class="connexion-title-c">CONNEXION</span>
        <p class="connexion-c-d">
            Espace de Connexion
        </p>
        <img id="garcon-login" src="{{ asset('images/garcon.png') }}" alt="garcon">
        <img id="fille-login" src="{{ asset('images/fille.png') }}" alt="fille">

        {!!  Form::open(['action'=>'Auth\AuthController@postLogin']) !!}
        <input type="text" name="email" placeholder="Enrez votre Email"><span class="login-email-ell">
                <i class="fa fa-envelope"></i> </span>
        <input type="password" name="pass" placeholder="Enrez votre mot de passe"><span class="login-pass-ell">
                <i class="fa fa-lock "></i> </span>
        <input {{  Request::old('remember') ? 'checked': '' }}    type="checkbox" name="remember"> <span id="checkbox-souvenir">Se Souvenir de moi</span>
        <button type="submit">Connexion</button>
        {!! Form::close() !!}
        <p class="mot-oulie">
            <a id="mot-de-pass-oublie" href="#">Mot de passe oublie ?</a>
        </p>

    </div>

    <div class=" col-sm-offset-3 col-sm-6" style="position:absolute;bottom: 0">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="col-sm-12">
                    <div class="alert  alert-danger alert-dismissable" style="margin-top: 5px">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        @endif
    </div>


</div>

<script>
   $(document).ready(function(){
       $(".alert-danger").fadeTo(10000, 500).slideUp(500, function() {
           $(".alert-danger").alert('close');
       });

      /*  $('.mot-oulie a').on('click',function(e){
            bootbox.prompt("Entrez Votre Email", function(result) {
                if (result === null) {

                } else {
                    alert(result);
                }
            });
        });*/
       $('#mot-de-pass-oublie').click(function(){
           alertify.prompt('Tapez Votre Email', '',
                   function(evt, value)
                   {
                       var email = value;
                       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                       $.ajax({
                           url: '{{  URL::action('StatisticsController@forgetpass')}}',
                           data: 'email=' + email + '&_token=' + CSRF_TOKEN,
                           type: 'post',
                           success: function(data){
                               if(data == 'famille')
                               {
                                   alertify.prompt('Tapez Votre Numero de CIN pour confirmer votre identité', '',
                                           function(evt, value)
                                           {
                                               var cin  = value;
                                               $.ajax({
                                                   url: '{{  URL::action('StatisticsController@forgetpass')}}',
                                                   data: 'cin=' + cin + '&_token=' + CSRF_TOKEN,
                                                   type: 'post',
                                                   success: function (data) {
                                                       alertify.message(data);
                                                   }
                                               });
                                           }
                                   );

                               }else{
                                   alertify.message(data);

                               }

                           }
                       });

                      // alertify.message('You entered: ' + value);
                   }
           );


       });

    });



</script>



</body>
</html>