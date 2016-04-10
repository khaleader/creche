@extends('layouts.default')

<script>
    localStorage.classe ='';
    localStorage.link ='';
</script>
@section('css')
    <link rel="stylesheet" href="{{ asset('css\bootstrap-switch.css')}}" />
    <link rel="stylesheet" href="{{ asset('js\bootstrap-datepicker\css\b-datepicker.css')  }}" type="text/css">

    <style>
        .has-switch label{
            background: none;
        }
        .promo_periode{
            height:5px;
        }

    </style>

@stop
@section('content')
    @include('partials.alert-success')
    @include('partials.alert-errors')



    <div class="row">
        <div class="col-sm-3">

        </div>
        <div class="col-sm-9" style="margin-bottom: 10px">
            <header class="panel-heading">

                <div style="height: 28px;display: inline-block" class="switch-on switch-animate">
                    <span class="switch-left switch-success"></span>
                    <span class="switch-right switch-warning"></span>
                    <input type="checkbox" id="global-on-off" checked  data-on="success" data-off="warning">

                </div>
               &nbsp;&nbsp; <h3 style="display: inline-block;
margin: 0;
    position: relative;
    top: 4px;">Gestion des promotions</h3>
            </header>

        </div>


    </div>

    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-9">
            <section class="panel panel-1 ">


                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">
                    </h4>
                    <div class="btn-group dropdown_actions">
                        <div style="height: 28px" class="switch-animate switch-on"><span class="switch-left"></span>
                            <label>&nbsp;</label><span class="switch-right"></span>
                            <input type="checkbox"  id="on-off">
                        </div>
                    </div>

                </header>


                <div class="panel-body informations_general dis-one">
                    <label class="categorie_label label_promo">Promotion sur le paiement à l'avance :</label>
                    <p>Cette partie est développée pour vous permettre de gérer et créer des
                        promotions afin d'encourager vos clients à payer leurs factures à l'avance,
                        si vous voulez activer ce système de promotion n'hésitez pas à remplir les champs en dessous :
                    </p>
                    {!!  Form::open(['url' => action('PromotionAdvancesController@store'),'method'=>'post']) !!}


                        <div class="form_champ" style="margin-top: 15px">
                            <label for="cname" class="control-label col-lg-3">Type de période</label>
                           <div class="form_ajout">
                                <select name="type_adv" class="form_ajout_input" placeholder="Sélectionnez une période">
                                    <option selected>Selectionnez le type de période</option>
                                    <option value="3">Trimestrielle (3 Mois)</option>
                                    <option value="6">Semestrielle (6 Mois)</option>
                                    <option value="{{ $total }}">Annuelle {{ '('.$total.' Mois)'  }}</option>

                                </select>

                            </div>


                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">le prix de la promotion</label>
                            <div class="form_ajout">
                                <input required data-mask="0000000000000"  type="text" name="prix_adv" class="form_ajout_input" placeholder="Entrez le prix de la promotion">

                            </div>
                         </div>
                        <div>
                            <button id="submit-adv" class="btn_form" type="submit">Enregistrer</button>

                        </div>
                    {!!  Form::close() !!}

                  </div>
            </section>

                    <!-- separator -->
                  <!--  <div class="form_paiement_sep"></div> -->
                  <section class="panel  panel-2 ">
                      <header class="panel-heading wht-bg">
                          <h4 class="gen-case">
                          </h4>
                          <div class="btn-group dropdown_actions">
                              <div style="height: 28px" class="switch-animate switch-on"><span class="switch-left"></span>
                                  <label>&nbsp;</label><span class="switch-right"></span>
                                  <input type="checkbox"  id="on-off2">
                              </div>
                          </div>

                      </header>
                <div class="panel-body informations_general dis-two">

                    <label class="categorie_label label_promo">Promotion sur une période exceptionnelle :</label>
                    <p>Pour se démarquer des autres concurrents vous avez déjà pensé à faire des promotions
                        sur les nouvelles inscriptions pour des périodes exceptionnelles au cours de l'année ?
                        Ce module est développé pour vous faciliter la tâche,
                        il suffit de remplir les champs en dessous pour lancer votre promotion.</p>


                    {!!  Form::open(['url' => action('PromotionExceptionalsController@store'),'method'=>'post']) !!}

                    <div class="form_champ promo_periode">
                            <div class="">
                                <label for="cname" class="control-label col-lg-3">Définissez la période</label>
                                <div class="type_choice">
                                    <span><strong>de : </strong></span>
                                    <input required name="start" data-format="hh:mm:ss" type="text" class="calendarpicker2 calpicker">
                                </div>
                                <div class="type_choice">
                                    <span><strong>à : </strong></span>
                                    <input required name="end" data-format="hh:mm:ss" type="text"  class="calendarpicker2 calpicker">
                                </div>
                            </div>

                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Entrez la promotion</label>
                            <div class="form_ajout" style="margin-top: 15px">

                                <input required data-mask="0000000000000" type="text" name="prix_exc" class="form_ajout_input" placeholder="Entrez le prix de la promotion">

                            </div>
                        </div>


                <button id="submit-exc" class="btn_form" type="submit">Enregistrer</button>
                {!!  Form::close() !!}
                    </div>

            </section>
        </div>
    </div>
    <div class="row"></div>




@endsection
@section('jquery')
    <script src="{{ asset('js\bootstrap-datepicker\js\moment.js') }}"></script>
    <script src="{{ asset('js\bootstrap-datepicker\js\b-datepicker.js') }}"></script>
    <script src="{{ asset('js\jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js\promotion-js.js') }}"></script>
    <script>

        $(function(){
             var g_status;
            $('#on-off').bootstrapSwitch();
            $('#on-off2').bootstrapSwitch();
            $('#global-on-off').bootstrapSwitch();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{  URL::action('PromotionStatusesController@checkglobal')}}',
                data:  '_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                       if(data == 'off')
                       {
                           $.ajax({
                               url: '{{  URL::action('PromotionStatusesController@resetallblocks')}}',
                               data:   '_token=' + CSRF_TOKEN,
                               type: 'post',
                               success: function (data) {

                               }
                           });

                           $('#global-on-off').bootstrapSwitch('setState',false);
                           $('#on-off').bootstrapSwitch('setState',false);
                           $('#on-off2').bootstrapSwitch('setState',false);
                           $('.panel-1').css({
                               "pointer-events":"none",
                           });
                           $('.panel-2').css({
                               "pointer-events":"none",
                           });
                       }
                      if(data == 'on')
                      {
                          $.ajax({
                              url: '{{  URL::action('PromotionStatusesController@checkbloc1')}}',
                              data:   '_token=' + CSRF_TOKEN,
                              type: 'post',
                              success: function (data) {
                                  if(data == 'on')
                                  {
                                      $('#on-off').bootstrapSwitch('setState',true);
                                      $('#on-off2').bootstrapSwitch('setState',false);
                                  }
                                  $('.panel-1').css({
                                      "pointer-events":"unset",
                                  });
                                  $('.panel-2').css({
                                      "pointer-events":"none",
                                  });
                              }
                          });

                          // second bloc
                          $.ajax({
                              url: '{{  URL::action('PromotionStatusesController@checkbloc2')}}',
                              data:   '_token=' + CSRF_TOKEN,
                              type: 'post',
                              success: function (data) {
                                  if(data == 'on')
                                  {
                                      $('#on-off').bootstrapSwitch('setState',false);
                                      $('#on-off2').bootstrapSwitch('setState',true);
                                  }
                                  $('.panel-1').css({
                                      "pointer-events":"none",
                                  });
                                  $('.panel-2').css({
                                      "pointer-events":"unset",
                                  });
                              }
                          });



                      }


                }
            });

             var user_id = '{{  \Auth::user()->id }}';
            $.ajax({
                url: '{{  URL::action('PromotionExceptionalsController@getData')}}',
                data:   'user_id='+ user_id +'&_token=' + CSRF_TOKEN,
                type: 'post',
                success: function (data) {
                    var json = JSON.parse(data);
                    if(json)
                    {
                        $('input[name=prix_exc]').val(json['price']);
                        if(json['start'] !== null && json['end'] !== null)
                        {
                            $('input[name=start]').val(moment(json['start']).format('DD-MM-YYYY'));
                            $('input[name=end]').val(moment(json['end']).format('DD-MM-YYYY'));
                        }
                        if(data == '[]')
                        {
                            $('input[name=prix_exc]').val('');
                            $('input[name=start]').val('');
                            $('input[name=end]').val('');
                        }

                    }

                }
            });

            $('#global-on-off').on('switch-change', function (e, data) {
                if(data.value == true)
                {
                    $.ajax({
                        url: '{{  URL::action('PromotionStatusesController@setGlobal')}}',
                        data:   'getGlobal='+ 1 +'&_token=' + CSRF_TOKEN,
                        type: 'post',
                        success: function (data) {
                            $('#on-off').bootstrapSwitch('setState',true);
                            $('#on-off2').bootstrapSwitch('setState',false);
                            $('.panel-1').css({
                                "pointer-events":"unset",
                            });
                            $('.panel-2').css({
                                "pointer-events":"none",
                            });
                        }
                    });


                }else{
                    $.ajax({
                        url: '{{  URL::action('PromotionStatusesController@setGlobal')}}',
                        data:   'getGlobal='+ 0 +'&_token=' + CSRF_TOKEN,
                        type: 'post',
                        success: function (data) {
                            $.ajax({
                                url: '{{  URL::action('PromotionStatusesController@resetallblocks')}}',
                                data:   '_token=' + CSRF_TOKEN,
                                type: 'post',
                                success: function (data) {

                                }
                            });

                            $('#on-off').bootstrapSwitch('setState',false);
                            $('#on-off2').bootstrapSwitch('setState',false);
                            $('.panel-1').css({
                                "pointer-events":"none",
                            });
                            $('.panel-2').css({
                                "pointer-events":"none",
                            });

                        }
                    });

                }
            });

            $('#on-off').on('switch-change', function (e, data) {
                if($('#global-on-off').bootstrapSwitch('state') == true)
                {
                    var bloc1_status = data.value;
                    if(bloc1_status ==  true)
                    {
                        $.ajax({
                            url: '{{  URL::action('PromotionStatusesController@setbloc1')}}',
                            data:   'bloc1status='+ 1 +'&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data) {
                                $('#on-off').bootstrapSwitch('setState',true);
                                $('#on-off2').bootstrapSwitch('setState',false);
                                $('.panel-1').css({
                                    "pointer-events":"unset",
                                });
                                $('.panel-2').css({
                                    "pointer-events":"none",
                                });
                            }
                        });
                    }else{
                        $.ajax({
                            url: '{{  URL::action('PromotionStatusesController@setbloc1')}}',
                            data:   'bloc1status='+ 0 +'&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data) {
                                $('#on-off').bootstrapSwitch('setState',false);
                                $('#on-off2').bootstrapSwitch('setState',true);
                                $('.panel-1').css({
                                    "pointer-events":"none",
                                });
                                $('.panel-2').css({
                                    "pointer-events":"unset",
                                });
                            }
                        });
                }

                }

            });






            $('#on-off2').on('switch-change', function (e, data) {
                if($('#global-on-off').bootstrapSwitch('state') == true)
                {
                    var bloc2_status = data.value;
                    if(bloc2_status ==  true)
                    {
                        $.ajax({
                            url: '{{  URL::action('PromotionStatusesController@setbloc2')}}',
                            data:   'bloc2status='+ 1 +'&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data) {
                                $('#on-off').bootstrapSwitch('setState',false);
                                $('#on-off2').bootstrapSwitch('setState',true);
                                $('.panel-1').css({
                                    "pointer-events":"none",
                                });
                                $('.panel-2').css({
                                    "pointer-events":"unset",
                                });
                            }
                        });
                    }else{
                        $.ajax({
                            url: '{{  URL::action('PromotionStatusesController@setbloc2')}}',
                            data:   'bloc2status='+ 0 +'&_token=' + CSRF_TOKEN,
                            type: 'post',
                            success: function (data) {
                                $('#on-off').bootstrapSwitch('setState',true);
                                $('#on-off2').bootstrapSwitch('setState',false);
                                $('.panel-1').css({
                                    "pointer-events":"unset",
                                });
                                $('.panel-2').css({
                                    "pointer-events":"none",
                                });
                            }
                        });
                    }
                }


            });


            $('select[name=type_adv]').change(function(){
               var type_valeur = $(this).val();
                $.ajax({
                    url: '{{  URL::action('PromotionAdvancesController@showPriceOfPromotion')}}',
                    data:   'type_valeur='+ type_valeur +'&_token=' + CSRF_TOKEN,
                    type: 'post',
                    success: function (data) {
                            var json = JSON.parse(data);
                              if(json)
                              {
                                  $('input[name=prix_adv]').val(json['prix']);
                              }


                    }
                });
            });







            $('input[name=start]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left top',
                language: 'fr'
            });
            $('input[name=end]').datepicker({
                format: 'dd-mm-yyyy',
                orientation: 'left top',
                language: 'fr'
            });



            $('#submit-adv').click(function(){
               if(!$.isNumeric($('select[name=type_adv]').val()))
               {
                   alertify.alert('veuillez séléctionner un type de période');
                   return false;
               }
            });

            $(".alert-success").fadeTo(10000, 500).slideUp(500, function(){
                $(".alert-danger").alert('close');
                $('#loader-to').hide();
            });

        });





    </script>

@stop
