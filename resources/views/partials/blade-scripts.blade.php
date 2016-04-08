
<script>
    $(document).ready(function() {

        setInterval(function(){
            $.removeCookie('reglercookie');
        },1800000);

        $('#gestion-utilis').on('click',function(e){
            e.preventDefault();
            <?php  $admin=\Auth::user()->teachers()->where('fonction','Administrateur')
            ->whereNotNull('pass')->first(); ?>
        @if($admin)
          alertify.prompt("Entrez La Clé d'utilisation", '', function (e, value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('SchoolsController@check_gestion_users')}}',
                    data: 'pass=' + value + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        if (data == 'oui') {
                          window.location = $('#gestion-utilis').attr('href');
                            $.cookie('admin',5);
                            {{ Session::put('adminExistsWithPass',1)  }}
                        }
                        if(data == 'no')
                        {
                            alertify.alert("La Clé d'utilisation est incorrect ");
                        }
                    }
                });

            }).set({
                'type': 'password',
                'labels': {ok: 'Oui', cancel: 'Non'},
            });
        });





        @endif
   });


</script>





