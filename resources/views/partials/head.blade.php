<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">

    <title>Oblivius Petite Enfance </title>
    <!--Core CSS -->
    <link rel="shortcut icon" type="image/png"  href="{{ asset('favicon.png') }}">
    <link href=" {{  asset('bs3/css/bootstrap.css') }}" rel="stylesheet">
    <script src="{{  asset('js/moment.min.js') }}"></script>
    <link href="{{  asset('js/jquery-ui/jquery-ui-1.10.1.custom.css') }}" rel="stylesheet">
    <link href=" {{  asset('css/bootstrap-reset.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <link rel="stylesheet" href="{{ asset('js/bootstrap-fileupload/bootstrap-fileupload.css') }}">
     <!-- <script src="{{  asset('js/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script> -->
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" href="{{ asset('css/msc-style.css') }}" />
    <script src="{{   asset('js/msc-script.js') }}"></script>
            <link rel="stylesheet" href="{{ asset('css/clndr.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" />





    <!--/************** alertify alert ***********/-->
    <!-- JavaScript -->
    <script src="{{ asset('js/alertify/alertify.min.js') }}"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/alertify/alertify.css') }}"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="{{ asset('css/alertify/default.css') }}"/>
  <!--  <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.5.0/css/themes/default.min.css"/> -->
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="{{ asset('css/alertify/semantic.css') }}"/>
    <!-- Bootstrap theme -->
   <!--  <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.5.0/css/themes/bootstrap.min.css"/> -->
    <!--/************** alertify alert ***********/-->

    <link rel="stylesheet" href="{{ asset('js\codrops\tooltip\tooltip-classic.css') }}">



    <link href=" {{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('js/jvector-map/jquery-jvectormap-1.2.2.css')  }}" rel="stylesheet">
    <link href="{{ asset('css/clndr.css')  }}" rel="stylesheet">
    <!--clock css-->
    <link href="{{ asset('js/css3clock/css/style.css')  }}" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('js/morris-chart/morris.css')  }}">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css')  }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/style-responsive.css')  }}" rel="stylesheet"/>
    <link href="{{ asset('css/animate.min.css')  }}" rel="stylesheet">
    <link href="{{ asset('css/set2.css')  }}" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="{{  asset('js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->
    @yield('css')
    <style>

        #calendar {
            max-width: 100%;
        }
    </style>


</head>