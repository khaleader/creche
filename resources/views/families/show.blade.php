@extends('layouts.default')




@section('content')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="Photo_profile">
                        <img class="pdp" src="{{  $family->photo? asset('uploads/'.$family->photo):asset('images/no_avatar.jpg')  }}" alt=""/>
                    </div>
                    <div class="nom">
                        @if($family->responsable == 0)
                                <span>{{  $family->nom_mere }}</span>
                            @else
                            <span>{{ $family->nom_pere }}</span>
                        @endif
                    </div>


                </div>
              <!--  <div class="age_date">
                    <div class="age"><span>46 ans</span><div class="age_sep_date"></div></div>
                    <div class="date"><span>09-04-1973</span></div>

                </div> -->
            </section>

            @foreach($family->children as $child)
                @unless($child->deleted_at)
            <section class="panel" >
                <a href="{{  action('BillsController@show',[$child->id]) }}" >
                    <?php
                   $status = App\Bill::where('child_id',$child->id)
                           ->where('user_id',\Auth::user()->id)
                           ->first();
                        ?>
                         @unless($status->deleted_at)
                        @if($status->status == 1)
                            <div class="panel-body paimenent_fiche_enfant">
                                <i class="fa fa-money"></i><span>Paiement effectué </span>
                            </div>
                            @else
                            <div class="panel-body paimenent_fiche_enfant" style="background-color:#d3423e">
                                <i class="fa fa-money"></i><span>Paiement non effectué</span>
                            </div>
                         @endif
                          @endunless


                </a>
            </section>
                @endunless
               @endforeach


        </div>
        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>
                    <a class="delete-family" href="{{ action('FamiliesController@delete',[$family->id]) }}"><div class="btn_supprimer">Supprimer</div></a>
                    <a href="{{ action('FamiliesController@archive',[$family->id]) }}"><div class="btn_archiver">Archiver</div></a>
                    <a href="{{ action('FamiliesController@edit',[$family->id]) }}"><div class="btn_archiver">modifier</div></a>

                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">


                        <tbody>
                        <tr>
                            @if($family->responsable == 0)
                          <!--  <td><i class="fa fa-female"></i></td> -->
                            <td><span><strong>Nom de la femme (responsable) :</strong> {{ $family->nom_mere }}</span></td>

                            @else
                             <!--   <td><i class="fa fa-male"></i></td> -->
                                <td><span><strong>Nom de l'homme (responsable) :</strong> {{ $family->nom_pere }}</span></td>

                             @endif
                        </tr>
                        <tr>
                            @if($family->responsable == 0)
                              <!--  <td><i class="fa fa-male"></i></td>  -->
                                <td><span><strong>Nom de l'homme : </strong> {{ $family->nom_pere }}</span></td>
                            @else
                             <!--   <td><i class="fa fa-female"></i></td> -->
                                <td><span><strong>Nom de la femme :</strong> {{ $family->nom_mere }}</span></td>
                            @endif
                        </tr>


                        <tr>
                          <!--  <td><i class="fa fa-group"></i></td> -->
                            <td><span><strong>Nombre d'élèves inscrits : </strong> {{ $family->children->count() }} </span></td>
                        </tr>
                        <tr>
                          <!--  <td><i class="fa fa-group"></i></td> -->
                            <td>
                                <span><strong>Nom d'élèves inscrits :</strong></span>
                                    @foreach($family->children as $child)
                                        @if($child->deleted_at)
                                            {{ "Archivé pour le Moment" }}
                                            @else
                               <a href="{{ action('ChildrenController@show',[$child->id])  }}">{{ $child->nom_enfant  }}</a> -
                                    @endif
                                    @endforeach
                            </td>
                        </tr>
                        <tr>
                      <!--      <td><i class="fa fa-envelope"></i></td> -->
                            <td><span><strong>Email :</strong> {{ $family->email_responsable }}</span></td>
                        </tr>
                        <tr>
                          <!--  <td><i class="fa fa-phone"></i></td> -->
                            <td><span><strong>Num fix :</strong> {{ $family->numero_fixe }} </span></td>
                        </tr>
                        <tr>
                          <!--  <td><i class="fa fa-mobile"></i></td> -->
                            <td><span><strong>Num portable :</strong> {{ $family->numero_portable }} </span></td>
                        </tr>
                        <tr>
                         <!--   <td><i class="fa fa-map-marker"></i></td> -->
                            <td><span><strong>Adresse :</strong> {{  $family->adresse }} </span></td>
                        </tr>
                        <tr>
                       <!--    <td><i class="fa fa-credit-card"></i></td> -->
                            <td><span><strong>CIN :</strong> {{ strtoupper($family->cin)  }} </span></td>
                        </tr>
                        <tr>
                          <!--  <td><i class="fa fa-calendar-o"></i></td> -->
                            <td><span><strong>Date d'inscription :</strong> {{  $family->created_at->format('d-m-Y') }} </span></td>
                        </tr>
                        </tbody>
                        </table>

              </div>
            </section>
            </div>
        </div>




    @endsection

@section('jquery')
<script>
    $('body').on('click','.delete-family',function(e){
        e.preventDefault();
        var href = this.href;
        alertify.dialog('confirm')
                .set({
                    'labels':{ok:'Oui', cancel:'Non'},
                    'message': 'voulez vous vraiment supprimer ? ',
                    'transition': 'fade',
                    'onok': function(){
                        window.location.href = href;
                        alertify.success('bien supprimé!');
                    },
                    'oncancel': function(){
                        alertify.error('Pas supprimé :)');
                    }
                }).show();
    });



</script>
@stop