{{--
    Liste toutes les affectations de stage existants pour tous les departements et options

    Variables a definir depuis la vue appelante :
        'entetes'  => $entetes array(string)                Tableau des entetes des tableaux
        'stages'   => $stages  array(departement => stages) Tableau associatif contenant tous les stages
        'titre'    => $titre   string                       Le titre de la page
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
    @foreach(['mri', 'sti'] as $departement)
    <div>
    @if('mri' === $departement)
        <h1>Affectations MRI</h1>
    @else
        <h1>Affectations STI</h1>
    @endif
    </div>
    <div>
        <table class="table table-hover" id="table-{{ $departement }}">
            <thead class="thead-light">

            {{-- Structure de la table --}}
            {{-- (bouton details)
                 Annee etudiante, stagiaire, Promotion
                 Referent, Fiche Entreprise, Fiche Rapport, Fiche Soutenance, Fiche Synthese--}}
            <th></th>{{-- Vide pour les boutons ou icones --}}
            @foreach($entetes as $entete)
                <th>{{ $entete }}</th>
            @endforeach
            </thead>

            <tbody>
            @foreach($stages[$departement] as $stage)
                <tr>
                    <td><a class="btn btn-lg btn-info text-white" href="{{ route('stages.show', $stage->id) }}">Détails</a></td>
                    <td>{{ $stage->annee_etudiant }}</td>
                    <td><span class="text-uppercase">{{ $stage->etudiant->nom }}</span> {{ $stage->etudiant->prenom }}</td>
                    <td>{{ $stage->etudiant->promotion }}</td>
                    <td><span class="text-uppercase">{{ $stage->referent->nom }}</span> {{ $stage->referent->prenom }}</td>
                    <td>...</td>
                    <td>
                        @include('includes.table.fiche', [
                            'statut' => $stage->fiche_rapport->statut,
                            'route'  => route('fiches.rapport.show', $stage->fiche_rapport->id)
                        ])
                    </td>
                    <td>...</td>
                    <td>...</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
@endsection
