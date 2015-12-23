<div class="row">

    <div class="col-md-12">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="col-md-4">
                    <div class="alert  alert-danger alert-dismissable" style="margin-top: 5px">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        {{ $error }}
                        <i class="fa fa-info-circle"></i>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


<script>
    $(function(){
        $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert-danger").alert('close');
            $('#loader-to').hide();
        });
    });

</script>