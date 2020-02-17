{{--
    Page des stages d'un referent. Affiche toutes les stages que possede un enseignant.

    Variables a definir depuis la vue appelante :
        'titre'   : string                        Le titre de l'onglet
        'user'    : App\User                      Le compte de l'enseignant authentifie
        'entetes' : array(String)                 Array des entetes du tableau
        'stages'  : Collection(App\Modeles\Stage) Collection des stages affectes a l'enseignant
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
    <div>
        <h1>Zone enseignant</h1>
    </div>

    <div>
        Bienvenue {{$user->prenom}} {{$user->nom}}
    </div>

    <div>
        <h1>Mes affectations de stage</h1>
    </div>

    <div>
        <table class="table table-hover">
            <thead class="thead-light">
                {{-- Structure du tableau
                    Liens | Nom etudiant | Prenom etudiant |
                    | Annee | Promotion | Departement | Sujet
                    | Entreprise | Rapport | Soutenance | Synthese  --}}
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
                    <td>{{ $stage->etudiant->departement->intitule }}</td>
                    <td>{{ $stage->etudiant->promotion }}</td>
                    <td>{{ $stage->intitule }}</td>
                    <td> Vide </td>
                    <td>
                        @if($stage->fiche_rapport->statut === 0)
                            <a class="text-danger font-weight-bold font-weight-light" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><u>Vide</u></a>
                        @elseif($stage->fiche_rapport->statut === 1)
                            <a class="text-info font-weight-bold font-weight-light" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><u>En cours</u></a>
                        @else
                            <a class="text-success font-weight-bold font-weight-light" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><u>Remplie</u></a>
                        @endif
                    </td>
                    <td> Vide </td>
                    <td> Vide </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
