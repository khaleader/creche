@extends('layouts.default')


@section('content')
    <div class="row">

        <div class="col-sm-6">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Contactez-nous

                    </h4>
                    <p id="help">Vous avez des questions à propos d’Oblivius Petite Enfance ? Souhaitez-vous une démonstration personnalisée ? N'hésitez pas à appeler le service après-vente.</p>
                </header>
                <div class="panel-body informations_general">
                    <table class="table  table-hover general-table table_informations ">

                        <tbody>
                        <tr>
                            <td><span><strong>Numéro France :</strong> +33 06 85 97 86 88 </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Numéro Maroc :</strong> +212 06 10 15 85 99 </span></td>
                        </tr>
                        <tr>
                            <td><span><strong>Email :</strong> oblivius.contact@gmail.com </span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>




            </section>

        </div>
        <div class="col-sm-6">
            <section class="panel sav">
                <div class="panel-body">




                </div>

            </section>


        </div>
    </div>
    <div class="row"></div>



@endsection

@section('jquery')
    <script>
        localStorage.classe = '';


    </script>

@stop