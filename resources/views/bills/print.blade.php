<!doctype html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <title>Print</title>
    <link rel="stylesheet" href="{{  asset('css/invoice-print.css') }}">
    <link href=" {{  asset('bs3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href=" {{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css')  }}" rel="stylesheet">
    <link href="{{ asset('css/style-responsive.css')  }}" rel="stylesheet"/>
    <script src="{{ asset('js\moment\moment-with-locales.min.js') }}"></script>

    <style type="text/css">
        @media print{
        @page {
            size: auto;   /* auto is the initial value */
            margin: 0;  /* this affects the margin in the printer settings */
        }
        img{
            width:250px !important;
            height:142px !important;
        }
        .table-invoice thead tr th {
            background: #e8e9f0 !important;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            vertical-align: middle;
            -webkit-print-color-adjust:exact;
        }
        .table-invoice tbody tr td {
            background: #f5f6f9 !important;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            vertical-align: middle;
            -webkit-print-color-adjust:exact;
        }
        .table-invoice {
            margin-top: 30px !important;
            border-spacing: 5px !important;
            border-collapse: separate !important;
        }
        ul.amounts li.grand-total{
            -webkit-print-color-adjust:exact;
            background: #7f64b5 !important;
            color: #fff !important;
            font-weight: bold !important;
        }

            .invoice-to h2 {
                margin:0;
                font-size:24px;
                color:#73737b !important;
                font-weight:600;
                -webkit-print-color-adjust:exact;

            }
        }


    </style>

</head>
<body>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <div class="panel-body invoice">
                <div class="invoice-header" style="height: 182px;">
                    <div class="invoice-title col-md-3 col-xs-2">
                        <!--<h1>Facture</h1>-->
                        @if(\Auth::user()->profile->logo)
                            <img height="142" width="300" src="{{ asset('uploads/'.Auth::user()->profile->logo) }}">
                        @else
                            <img height="142" width="300" src="{{ asset('images/no_logo.png') }}">
                        @endif

                    </div>
                    <div class="invoice-info col-md-9 col-xs-10">

                        <div class="pull-right">
                            <div class="col-md-6 col-sm-6 pull-left school_name">
                                <p><strong>Ecole {{ Auth::user()->name }}</strong><br>
                                    {{ Auth::user()->adresse }}</p>
                            </div>
                            <div class="col-md-6 col-sm-6 pull-right">
                                <p>Tél: {{ Auth::user()->tel_portable }} <br>
                                    {{ Auth::user()->email }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row invoice-to">
                    <div class="col-md-4 col-sm-4  col-lg-4 pull-left destinataire">
                        @if($bill->child->family->responsable == 0)
                            <h2>{{  $bill->child->family->nom_mere  }}</h2>
                        @else
                            <h2>{{  $bill->child->family->nom_pere  }} </h2>
                        @endif
                        <p>
                            {{ $bill->child->family->adresse   }}<br>

                            Tél: {{  $bill->child->family->numero_portable }}<br>
                            Email : {{  $bill->child->family->email_responsable  }}
                        </p>


                    </div>

                    <div class="col-md-4 col-sm-5 pull-right putInsideRight">
                        <div class="row">
                            <div class="col-md-4 col-sm-5 inv-label">N° Facture :{{  $bill->id }}</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 inv-label">Date : <script>
                                    moment.locale('fr');
                                    var ok =  '{{ $bill->start }}';

                                    document.write(moment(ok).format('LL'));
                                </script>
                            </div>
                        </div>
                        @if($bill->status == 1)
                            <div class="row">
                                <div class="col-md-4 col-sm-5 inv-reglee"><div class="icone_reglee"></div><span>Réglée</span></div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-4 col-sm-5 inv-non-reglee"><div class="icone_non_reglee"></div><span>Non réglée</span></div>
                            </div>
                        @endif
                        <br>
                    </div>




                </div>
                <div id="invoice_object"><p>Cher
                        @if($bill->child->family->responsable == 0)
                            {{  $bill->child->family->nom_mere  }}
                        @else
                            {{  $bill->child->family->nom_pere  }}
                        @endif


                        ,</br>Par la présente nous vous informons que la facture de votre enfant {{ $bill->child->nom_enfant }}, inscrit dans notre établissement, décrite ci dessous de la date {{  $bill->start->format('d-m-Y') }} au {{  $bill->end->format('d-m-Y') }} est désormais disponible.</p></div>
                <table class="table table-invoice" >
                    <thead>
                    <tr>
                        <th >Ref.</th>
                        <th >Description</th>
                        <th class="text-center">Montant</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Adhésion</td>
                        <td>
                            @foreach($bill->child->classrooms as $cr)
                                {{  $cr->nom_classe }}
                            @endforeach


                        </td>
                        <td class="text-center">
                            @foreach($bill->child->levels as $level)
                                {{ \App\PriceBill::getNiveauPrice($level->id) * $bill->nbrMois }}
                            @endforeach
                            Dhs</td>
                    </tr>
                    @if($bill->child->transport == 1)
                        <tr>
                            <td>Transport</td>
                            <td>Inscription au transport de l'école</td>
                            <td class="text-center">{{ \Auth::user()->transport()->first()->somme  * $bill->nbrMois }} Dhs</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Réduction</td>
                        <td>Spéciale réduction</td>
                        <td class="text-center"> {{  $bill->reductionPrix * $bill->nbrMois }} Dhs</td>
                    </tr>

                    </tbody>
                </table>
                <div class="row">
                    <span id="MP">Mode de paiement :</br> {{ $bill->mode }}</span>
                    <div class="col-md-3 col-xs-5 invoice-block pull-right">
                        <ul class="unstyled amounts">

                            <li class="grand-total text-center">Total à payer: {{ $bill->somme }} Dhs</li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="invoice_remarque">
                        <h3>Remarque :</h3>
                        <p>Nous vous rappelons que vous pouvez accéder à l'historique de vos factures et faire le suivi de votre enfant à partir de votre compte <strong>Oblivius School</strong>.</br> Connectez-vous dès maintenant sur : <strong>www.school.oblivius.fr</strong></p></div></div>

                <div class="row">
                    <div class="invoice_remarque">
                        <h3>Merci beaucoup !</h3>
                        <p>école {{ \Auth::user()->name }}</p></div></div>

            </div>


            <div class="row">
                <div id="invoice_footer">
                    <ul>
                        <li>Tél : {{ Auth::user()->tel_fixe }}</li>
                        <li>Email : {{ Auth::user()->email }}</li>

                    </ul>

                    <ul>
                        <li>Patente : {{ Auth::user()->profile->patente }}</li>
                        <li>RC : {{ Auth::user()->profile->registre_du_commerce }}</li>
                        <li>IF : {{ Auth::user()->profile->identification_fiscale }}</li>
                        <li>CNSS : {{ Auth::user()->profile->cnss }}</li>
                        <li>ICE :  {{ Auth::user()->profile->ice }}</li>


                    </ul>



                </div>


            </div>
        </section>
    </div>

</div>




<script src="{{  asset('js/jquery.js') }}"></script>
<script>

window.print();
</script>
</body>




</html>