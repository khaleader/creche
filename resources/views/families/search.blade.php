@extends('layouts.default')







@section('content')

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                   Le Resultat de la recherche des Elèves
                </header>
                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants" id="filterByAlpha">
                        <thead>
                        <tr>
                            <th></th>
                            <th> Nom complet</th>
                            <th class="hidden-phone">Date d'inscription</th>
                            <th>Classe</th>
                            <th>Statut de paiement</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($child))

                        @foreach($child as $c)

                            <tr id="{{  ucwords($c->nom_enfant) }}">
                                <td><img class="avatar" src=" {{ $c->photo ? asset('uploads/'.$c->photo): asset('images/avatar4.jpg')  }}"></td>

                                <td>{{  ucwords($c->nom_enfant) }}</td>
                                <td>{{  \Carbon\Carbon::parse($c->created_at)->format('d-m-Y')  }} </td>

                                <td>
                                    @foreach($c->classrooms as $cr)
                                        {{  $cr->nom_classe }}
                                    @endforeach
                                </td>

                                <td>
                                    <?php  $counter =  App\Bill::where('child_id',$c->id)->where('status',0)->count(); ?>
                                      <span class="label {{ $counter == 0 ? 'label-success' : 'label-danger' }} label-mini">
                                    <i class="fa fa-money"></i></span>

                                </td>
                                <td>
                                    <a  class="delete-child"   href="{{ action('ChildrenController@delete',[$c->id]) }}" class="actions_icons">
                                        <i class="fa fa-trash-o liste_icons"></i></a>
                                  <!--  <a class="archive-child" href="{{  action('ChildrenController@archive',[$c->id]) }}"><i class="fa fa-archive liste_icons"></i>
                                    </a> -->
                                </td>

                                <td><a href="{{ action('ChildrenController@show',[$c->id])  }}"><div  class="btn_details">Détails</div></a></td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

     <!--   Families -->
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Le Resultat de la recherche pour les familles
                </header>
                <div class="panel-body">
                    <table class="table  table-hover general-table table_enfants">
                        <thead>
                        <tr>
                            <th></th>
                            <th> Nom du responsable</th>
                            <th class="hidden-phone">Nombre d'enfants</th>
                            <th>Statut de paiement</th>
                            <th>Actions</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($family))
                        @foreach($family as $f)
                            <tr>

                                <td><img class="avatar" src="{{ $f->photo ?  asset('uploads/'.$f->photo) : asset('images/no_avatar.jpg') }}"></td>
                                <td>
                                    @if($f->responsable == 0)
                                        {{  $f->nom_mere }}
                                    @else
                                        {{  $f->nom_pere  }}
                                    @endif
                                </td>
                                <td> {{  $f->children->count() }}</td>

                                <td>
                                    <?php
                                    foreach ($f->children as $c )
                                    {
                                        foreach($c->bills as $b)
                                        {
                                            if($b->status == 0)
                                            {
                                                echo  '<span class="label label-danger label-mini"><i class="fa fa-money"></i></span>';
                                                break;
                                            }
                                            else
                                            {
                                                echo  '<span class="label label-success label-mini"><i class="fa fa-money"></i></span>';
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a  href="{{  action('FamiliesController@delete',[$f->id]) }}" class="actions_icons delete-family">
                                        <i class="fa fa-trash-o liste_icons"></i></a>
                                    <!--<a class="archive-family" href="{{  action('FamiliesController@archive',[$f->id]) }}"><i class="fa fa-archive liste_icons"></i>
                                    </a>-->
                                </td>

                                <td><a href="{{ action('FamiliesController@show',[$f->id])  }}"><div  class="btn_details">Détails</div></a></td>
                            </tr>
                             @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>





@endsection


@section('jquery')
    <script>
        $(function(){
            $('.delete-child').click(function(){
                var answer =   confirm('voulez vous vraiment supprimer ?');
                if(answer)
                    return true;
                else
                    return false;


            });
            $('.archive-child').click(function(){
                var answer =   confirm('voulez vous vraiment archiver ?');
                if(answer)
                    return true;
                else
                    return false;
            });


             // families
            $('.delete-family').click(function(){
                var answer =   confirm('voulez vous vraiment supprimer ?');
                if(answer)
                    return true;
                else
                    return false;


            });
            $('.archive-family').click(function(){
                var answer =   confirm('voulez vous vraiment archiver ?');
                if(answer)
                    return true;
                else
                    return false;
            });







        });

    </script>

    @stop