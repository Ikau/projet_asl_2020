{{--
    Formulaire de creation d'un stage / d'une affectation de stage

    Variables a definir depuis la vue appelante :
        'campus'      => 'Bourges'|'Blois'   Le campus ou se trouve la fiche
        'stage'       => $stage              Le stage lie a la fiche de rapport
        'titre'       => string              Le titre de l'onglet
        'sections'    => Collection(Section) Ensemble des sections de la fiche
        'classeFiche' => FicheRapport::class La classe FicheRapport
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('inclusionHead')
    <script type="text/javascript" src="{{ asset('js/fiches/edit-rapport-modele-v1.js') }}"></script>
@endsection

@section('contenu')
<div class="container">

    @include('includes.entete-fiche', [
        'campus' => $campus,
        'numero' => 2,
        'stage'  => $stage
    ])

    <form class="my-4" method="POST" action="{{ route('fiches.rapport.update', $stage->fiche_rapport->id) }}">
        @method('PATCH')
        @csrf

        {{-- Quelques informations cacheess --}}
        @include('includes.form.input.hidden', [
            'attribut' => \App\Modeles\Fiches\FicheRapport::COL_MODELE_ID,
            'valeur'   => $stage->fiche_rapport->modele->id ?? old(\App\Modeles\Fiches\FicheRapport::COL_MODELE_ID)
        ])

        <div id="container-sections">
            {{-- Inclusion de toutes les sections --}}
            @include('includes.form.sections', [
                'contenu'  => $stage->fiche_rapport->contenu,
                'sections' => $sections,
            ])
        </div>

        {{-- TextArea pour l'appreciation --}}
        <div class="row">
            <div class="col">
                @include('includes.form.textarea', [
                    'attribut' => \App\Modeles\Fiches\FicheRapport::COL_APPRECIATION,
                    'intitule' => 'Appréciation globale :',
                    'valeur'   => $stage->fiche_rapport->appreciation ?? old(\App\Modeles\Fiches\FicheRapport::COL_APPRECIATION)
                ])
            </div>
        </div>

        {{-- Affichage automatique de la note --}}
        <div class="row my-5">
            <div class="col border border-primary">
                <h1>Note du rapport de stage</h1>
            </div>
            <div class="col-2 border border-primary text-right">
                <h1><span id="spanNote">{{ $stage->fiche_rapport->getNote() }}</span> / 20</h1>
            </div>
        </div>

        <div class="row">
            <div class="col text-right">
                {{-- Bouton de retour --}}
                <a class="btn btn-lg btn-danger" href="{{ route('fiches.rapport.show', $stage->fiche_rapport->id) }}"><i class="fas fa-times"></i> Quitter sans modifier</a>

                {{-- Bouton d'enregistrement --}}
                <button class="btn btn-lg btn-success" type="submit"><i class="fas fa-check"></i> Enregistrer les modifications</button>
            </div>
        </div>

    </form>
</div>
@endsection
