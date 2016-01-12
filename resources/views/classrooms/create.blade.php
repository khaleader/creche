@extends('layouts.default')

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <header class="panel-heading">
                    Matières

                </header>
                <div class="panel-body">

                    <table class="table  table-hover general-table">


                        <tbody>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div>
                                <span><strong>SVT</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Mathématique</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Physique</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Arabe</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Français</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Histoire géographie</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Sport</strong></span></td>
                        </tr>
                        <tr>

                            <td><div class="checkbox_liste2 ">
                                    <input type="checkbox" >
                                </div><span><strong>Anglais</strong></span></td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </section>
        </div>








        <div class="col-sm-9">
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case"> Informations générales

                    </h4>

                    <a href=""><div class="btn2">Emploi du temps</div></a>

                </header>
                <div class="panel-body informations_general">
                    <form action="#" >
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Nom de la classe</label>
                            <div class="form_ajout">
                                <input type="text" name="search" class="form_ajout_input" placeholder="Entrez le nom de la classe">

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Code de la classe</label>
                            <div class="form_ajout">
                                <input type="text" name="search" class="form_ajout_input" placeholder="Entrez le code de la classe">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Capacité de salle</label>
                            <div class="form_ajout">
                                <input type="text" name="search" class="form_ajout_input" placeholder="Entrez le nombre des élèves maximum">

                            </div>
                        </div>

                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Niveau</label>
                            <div class="form_ajout">
                                <select class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option>1 ère année bac</option>
                                    <option>2 ème année bac</option>

                                </select>

                            </div>
                        </div>
                        <div class="form_champ">
                            <label for="cname" class="control-label col-lg-3">Branche</label>
                            <div class="form_ajout">
                                <select class="form_ajout_input" placeholder="Choisissez le responsable">
                                    <option>Science physique</option>
                                    <option>littéraire</option>

                                </select>

                            </div>
                        </div>


                        <button class="btn_form" type="submit">Enregistrer</button>
                    </form>
                </div>

            </section>
        </div>
    </div>
    <div class="row"></div>




@endsection

@section('jquery')
    <script>

        $(".alert-danger").fadeTo(10000, 500).slideUp(500, function(){
            $(".alert-danger").alert('close');
            $('#loader-to').hide();
        });
        $(".alert-success").fadeTo(3000, 500).slideUp(500, function(){
            $(".alert-success").alert('close');

        });

    </script>


@stop