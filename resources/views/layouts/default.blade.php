<!DOCTYPE html>
<html lang="fr">
@include('partials.head')

<body>
@yield('loader')
<section id="container">

    <!--right sidebar start-->
  @yield('right-sidebar')
    <!--right sidebar end-->

    <!--header start-->
   @include('layouts.header')
    <!--header end-->


    <!--sidebar start-->
    @include('layouts.sidebar')
    <!--sidebar end-->


    <!--main content start-->
    <section id="main-content">


        <section class="wrapper">
            @yield('content')
        </section>
    </section>
    <!--main content end-->

</section>

@yield('calendar')

@include('partials.javascript-bottom')
@yield('jquery')
</body>
<script type="text/javascript">
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });



</script>
</html>