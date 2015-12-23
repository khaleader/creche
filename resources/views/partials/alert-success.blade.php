<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-9">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 5px">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{ Session::get('success') }} !</strong>
            </div>

        @endif
    </div>
</div>
<script>
    $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
        $(".alert-success").alert('close');
        $('#loader-to').hide();
    });
</script>