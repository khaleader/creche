@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <div class="form-group last">
                        {{-- Form::model($school,['url'=>action('SchoolsController@update',[\Auth::user()->id]),'method'=>'put','files'=>true]) --}}


                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new  Photo_profile" >
                                <img class="pdp" src="{{ asset('images/no_avatar.jpg') }}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail " ></div>
                            <div class="btn_upload">
                                                   <span class="btn btn-white btn-file">
                                                   <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Selectionner une image</span>
                                                   <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                                   <input type="file" class="default" name="photo" disabled />
                                                   </span>

                            </div>
                        </div>


                    </div>
                </div>
            </section>

        </div>
        @include('partials.alert-errors')
        @include('partials.alert-success')
        <div class="col-sm-9">
            <section class="panel">

                <header class="panel-heading tab-bg-dark-navy-blue">
                    <ul class="nav nav-tabs nav-justified ">
                        <li>
                            <a data-toggle="tab" href="#password">
                                Changer le mot de passe
                            </a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content tasi-tab">
                        <div id="password" class="tab-pane">
                            {!! Form::open(['url' => action('SchoolsController@updatepassef')]) !!}
                            <div class="form_champ">
                                <label for="cname" class="control-label col-lg-3">Mot de passe actuel</label>
                                <div class="form_ajout">
                                    <input type="password" name="actualpass" class="form_ajout_input" placeholder="Entrez le mot de passe actuel">

                                </div>
                            </div>
                            <div id="password" class="tab-pane">
                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Le nouveau mot de passe</label>
                                    <div class="form_ajout">
                                        <input type="password" name="password" class="form_ajout_input" placeholder="Entrez le nouveau mot de passe">

                                    </div>
                                </div>
                            </div>
                            <div id="password" class="tab-pane">
                                <div class="form_champ">
                                    <label for="cname" class="control-label col-lg-3">Saisir à nouveau</label>
                                    <div class="form_ajout">
                                        <input type="password" name="password_confirmation" class="form_ajout_input" placeholder="Confirmer le nouveau mot de passe">

                                    </div>
                                </div>
                            </div>
                            <button class="btn_form" type="submit">Enregistrer</button>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </section>
            </tbody>
        </div>

    </div>


@endsection