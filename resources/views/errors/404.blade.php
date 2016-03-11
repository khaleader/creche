<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>404</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href=" {{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->


    <style>
        .body-404 {
            background: #9f81dd;
            color:#fff;
        }
        .error-head {
            background:#fff;
            height:280px;
        }
        .error-wrapper {
            text-align:center;
        }
        .error-wrapper h1 {
            font-size:90px;
            font-weight:300;
            margin:-141px 0 0 0;
            text-align:center;
        }
        .error-wrapper h2 {
            font-size:58px;
            font-weight:300;
            margin:0;
            text-transform:uppercase;
        }
        .error-desk {
            background:rgba(0,0,0,0.05);
            margin-top:-27px;
            padding:30px 0;
        }
        .error-wrapper p,.error-wrapper p a {
            font-size:18px;
            font-weight:300;
            margin:0;
        }
        .error-wrapper p.nrml-txt {
            color: #ffffff;
            font-size:40px;
            margin:0;
        }
        .back-btn{
            text-decoration: none;
        }

        .back-btn,.back-btn:hover {
            border:1px solid rgba(255,255,255,.5);
            padding:10px 15px;
            margin-top:100px;
            display:inline-block;
            border-radius:5px;
            -webkit-border-radius:5px;
            color:#fff;
            font-size:16px;
            font-weight:300;
        }
        .back-btn:hover {
            background:#fff;
            color: #9f81dd;
        }


    </style>
</head>




<body class="body-404">

<div class="error-head"> </div>

<div class="container ">

    <section class="error-wrapper text-center">
        <h1><img src="{{ asset('images/404.png') }}" alt=""></h1>
        <div class="error-desk">
            <h2>page introuvable</h2>
            <p class="nrml-txt">Nous n'avons pas pu trouver cette page</p>
        </div>
        <a href="{{ url('/') }}" class="back-btn"><i class="fa fa-home"></i> Tableau De Bord</a>
    </section>

</div>


</body>
</html>
