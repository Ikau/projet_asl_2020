{{--
    Page des stages d'un referent. Affiche toutes les stages que possede un enseignant.

    Variables a definir depuis la vue appelante :
        'titre'   : string        Le titre de l'onglet
        'entetes' : array(String) Array des entetes du tableau
        'stages'  : array(Stage)  Array de stages que le responsable peut modifier
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
    <div>
        <h1>Zone responsable</h1>
    </div>

    <div>
        Bienvenue {{Auth::user()->identite->prenom}} {{Auth::user()->identite->nom}}
    </div>

    <div>
        <h1>Liste des affectations</h1>
    </div>

    <div>
        <table class="table table-hover">
            <thead class="thead-light">
            {{-- Structure du tableau
                 Liens | Nom etudiant | Prenom etudiant | Annee | Promotion | Option
                 | Etat de l'affectation | Etat du stage | Enseignant referent | Entreprise | Lieu
             --}}
            <tr>
                @foreach($entetes as $entete)
                    <th>{{$entete}}</th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @foreach($stages as $stage)
                <tr>
                    <td><a class="btn btn-lg bg-info text-white" href="{{ route('stages.show', $stage->id) }}">Détails</a></td>
                    <td>{{ $stage->etudiant->nom }}</td>
                    <td>{{ $stage->etudiant->prenom }}</td>
                    <td>{{ $stage->annee_etudiant }}A</td>
                    <td>{{ $stage->etudiant->promotion }}</td>
                    <td>{{ $stage->etudiant->option->intitule }}</td>
                    <td>
                        @if($stage->affectation_validee === 1)
                            <span style="text-decoration-color: #1f6fb2">À valider</span>
                            <span class="text-primary">À valider</span>
                        @else
                            @else
                                <span style="text-decoration-color: #1d643b">Validée</span>
                                <span class="text-success">Validée</span>
                            @endif
                    </td>
                    <td>
                        @if($stage->convention_envoyee === 1 && $stage->convention_envoyee === 1)
                            <span class="text-primary">En attente</span>
                        @else
                            <span class="text-success">Validée</span>
                        @endif
                        @endif
                    </td>
                    <td>{{ $stage->referent->prenom }} {{ $stage->referent->nom }}</td>
                    <td> WIP </td>
                    <td>{{ $stage->lieu }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
