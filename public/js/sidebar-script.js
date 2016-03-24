$(document).ready(function(){

    $('ul.sidebar-menu  a').each(function(){
    if(localStorage.classe == $(this).attr('class'))
    {
        $(this).parent().addClass('active-for-sidebar');
    }
    });


    $('.sub-menu a').each(function(){
        if(localStorage.link === $(this).attr('href'))
        {
            $(this).parent('li').parent('ul').parent('li').addClass('active-for-sidebar');
        }
    });

    $('.sub-menu a').click(function(){
        localStorage.classe = '';
        localStorage.link ='';
        localStorage.link =$(this).attr('href');

        $(this).parent().addClass('active-for-sidebar');

    });





    $('ul.sidebar-menu > li > a').click(function(e){
        localStorage.link ='';
        localStorage.classe ='';
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
        $('.sub-menu-gestion').css('z-index','999999999');
       $('.sub-menu-gestion').show();
    });

    $('.sidebar-teacher').hover(function(){
        $('.sub-menu-gestion').hide();
        $('#main-content').css({
            'position':'static',
            'z-index': '0'
        });
    });
    $('.sidebar-pointage').hover(function(){
        $('.sub-menu-gestion').hide();
        $('#main-content').css({
            'position':'static',
            'z-index': '0'
        });
    });


    $('.sub-menu-gestion').mouseleave(function(){
        $('.sub-menu-gestion').hide();
        $('#main-content').css({
            'position':'static',
            'z-index': '0'
        });
    });



    /**********************statistics******************************/

    $('.sidebar-statistiques').hover(function(){
        $('#main-content').css({
            'position':'relative',
            'z-index': '-25'
        });
        $('.sub-menu-stats').css('z-index','999999999');
        $('.sub-menu-stats').show();
    });

    $('.sidebar-factures').hover(function(){
        $('.sub-menu-stats').hide();
        $('#main-content').css({
            'position':'static',
            'z-index': '0'
        });
    });

    $('.sub-menu-stats').mouseleave(function(){
        $('.sub-menu-stats').hide();
        $('#main-content').css({
            'position':'static',
            'z-index': '0'
        });
    });

});