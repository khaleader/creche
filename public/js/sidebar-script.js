$(document).ready(function(){
    $('ul.sidebar-menu a').each(function(){

    if(localStorage.classe == $(this).attr('class'))
    {
        $(this).parent().addClass('active-for-sidebar');
    }
    });



    $('ul.sidebar-menu li a').click(function(e){

        localStorage.classe =  $(this).attr('class');
        var ul = $(this).parent().parent();
       // ul.children('li').not(this).removeClass('active-for-sidebar');
        $(this).parent().addClass('active-for-sidebar');

    });


    $('.sidebar-gestion').hover(function(){
        $('#main-content').css({
           'position':'relative',
            'z-index': '-25'
        });
        $('.sub-menu').css('z-index','999999999');
       $('.sub-menu').show();

       $('.sidebar-teacher').hover(function(){
           $('.sub-menu').hide();
           $('#main-content').css({
               'position':'static',
               'z-index': '0'
           });
       });
        $('.sidebar-pointage').hover(function(){
            $('.sub-menu').hide();
            $('#main-content').css({
                'position':'static',
                'z-index': '0'
            });
        });

    });
    $('.sub-menu').mouseleave(function(){
        $('.sub-menu').hide();
        $('#main-content').css({
            'position':'static',
            'z-index': '0'
        });
    });

});