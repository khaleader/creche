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
        ul.children('li').not(this).removeClass('active-for-sidebar');
        $(this).parent().addClass('active-for-sidebar');

    });

});