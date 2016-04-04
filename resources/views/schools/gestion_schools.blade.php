@extends('layouts.default')
<script>
    localStorage.classe ='';
    localStorage.link ='';
</script>
@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')

<div class="row">

        <div class="col-sm-3">
            <section class="panel">
                <header class="panel-heading">
                    La liste des utilisateurs

                </header>
                <div class="panel-body">

                    <table class="table  table-hover general-table">


                        <tbody>
                        @foreach(\Auth::user()->teachers()->
                                     whereIn('fonction',['rh'])
                                     ->whereNotNull('pass')->get() as $ok)
                        <tr>

                            <td>

                                <img class="avatar"
                                     src="{{ $ok->photo ? asset('uploads/'.$ok->photo) : asset('images/no_avatar.jpg') }}">

                            </td>
                            <td>{{ $ok->nom_teacher }}</td>
                            <td>
                                <a valeur="{{ $ok->id }}" id="ok" href="#" class="actions_icons">
                                    <i class="fa fa-trash-o liste_icons"></i></a>
                                </a>
                            </td>
                        </tr>
                            @endforeach




                        </tbody>
                    </table>


                </div>
            </section>
        </div>







        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Gestion des utilisateurs

                    </h4>



                </header>
                <div class="panel-body informations_general">
                   {!!  Form::open(['url'=> action('SchoolsController@gestion_users'),'method'=>'post']) !!}
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Utilisateur</label>
                            <div class="form_ajout">
                                <select name="rh" class="form_ajout_input" placeholder="Choisissez le responsable">
                                     @foreach(\Auth::user()->teachers()->
                                     whereIn('fonction',['rh','Administrateur'])->get() as $rh)
                                         @if($rh->fonction == 'Administrateur')
                                            <option value="{{ $rh->id }}">{{ $rh->fonction }}</option>
                                        @else
                                            <option value="{{ $rh->id }}">{{ $rh->nom_teacher }}</option>
                                        @endif
                                     @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Clé d'utilisation</label>
                            <div class="form_ajout">
                                <input type="password" name="pass" class="form_ajout_input" placeholder="Entrez la clé d'utilisation">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Confirmez la clé d'utilisation</label>
                            <div class="form_ajout">
                                <input type="password" name="pass_confirmation" class="form_ajout_input" placeholder="Confirmez la clé d'utilisation">

                            </div>
                        </div>



                        <button class="btn_form" type="submit">Enregistrer</button>
                    {!!  Form::close() !!}
                </div>






            </section>
        </div>
    </div>
<div class="row"></div>


@endsection

@section('jquery')
    <script>
        $(function(){

            $('#ok').click(function(){
                var id_rh = $(this).attr('valeur');
               $(this).parent().parent().fadeOut();

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{  URL::action('SchoolsController@check_gestion_users')}}',
                    data: 'id_rh=' + id_rh + '&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                        if(data == 'deleted')
                        {
                            location.reload();
                        }

                    }
                });
            });


        });
        $(window).unload(function(){
            $.removeCookie('admin');
        });




    </script>

    @stop