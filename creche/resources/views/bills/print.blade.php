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


</head>
<body>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <div class="panel-body invoice">
                <div class="invoice-header">
                    <div class="invoice-title col-md-3 col-xs-2">
                        <h1>Facture</h1>

                    </div>
                    <div class="invoice-info col-md-9 col-xs-10">

                        <div class="pull-right">
                            <div class="col-md-6 col-sm-6 pull-left">
                                <p><strong>Ecole {{ Auth::user()->name }}</strong><br>
                                    {{ Auth::user()->adresse }}</p>
                            </div>
                            <div class="col-md-6 col-sm-6 pull-right">
                                <p>Tél: {{ Auth::user()->tel_fixe }} <br>
                                    Email : {{ Auth::user()->email }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row invoice-to">
                    <div class="col-md-4 col-sm-4 pull-left">

                        @if($bill->child->family->responsable == 0)
                            <h2>{{  $bill->child->family->nom_mere  }}</h2>
                        @else
                            <h2>{{  $bill->child->family->nom_pere  }}</h2>
                        @endif

                        <p>
                            {{ $bill->child->family->adresse   }}<br>

                            Tél: {{  $bill->child->family->numero_portable }}<br>
                            Email : {{  $bill->child->family->email_responsable  }}
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-5 pull-right">
                        <div class="row">
                            <div class="col-md-4 col-sm-5 inv-label">N° Facture :</div>
                            <div class="col-md-8 col-sm-7">{{  $bill->id }}</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-sm-5 inv-label">Date :</div>
                            <div class="col-md-8 col-sm-7">{{  $bill->start->toFormattedDateString() }}</div>
                        </div>
                        <br>



                    </div>
                </div>
                <table class="table table-invoice" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom enfant</th>
                        <th class="text-center">depuis</th>
                        <th class="text-center">jusqu'au</th>
                        <th class="text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <h4>{{  $bill->child->nom_enfant }}</h4>

                        </td>
                        <td class="text-center">{{  $bill->start->format('d-m-Y') }}</td>
                        <td class="text-center">{{  $bill->end->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $bill->somme }} Dhs</td>
                    </tr>

                    </tbody>
                </table>
                <div class="row">

                    <div class="col-md-4 col-xs-5 invoice-block pull-right">
                        <ul class="unstyled amounts">

                            <li class="grand-total">Grand Total :{{ $bill->somme  }} Dhs</li>
                        </ul>
                    </div>
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