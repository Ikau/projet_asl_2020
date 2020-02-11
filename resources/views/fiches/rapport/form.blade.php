{{--
    Formulaire de creation d'un stage / d'une affectation de stage

    Variables a definir depuis la vue appelante :
        'campus'   => 'Bourges'|'Blois'   Le campus ou se trouve la fiche
        'stage'    => $stage              Le stage lie a la fiche de rapport
        'titre'    => string              Le titre de l'onglet
        'sections' => Collection(Section) Ensemble des sections de la fiche
--}}

@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
<div class="container">
    <div class="row">
        <a class="btn btn-primary" href="{{ route('referents.affectations') }}">Retour à mes affectations</a>
    </div>

    @include('includes.entete-fiche', [
        'campus' => $campus,
        'numero' => 2,
        'stage'  => $stage
    ])

    <form class="my-4" method="POST" action="{{ route('fiches.rapport.update', $stage->id) }}">
        @csrf

        {{-- Inclusion de toutes les sections --}}
        @include('includes.form.sections', [
            'sections' => $sections
        ])

        {{-- TextArea pour l'appreciation --}}
        <div class="row">
            <div class="col">
                @include('includes.form.textarea', [
                    'attribut' => 'appreciation',
                    'intitule' => 'Appréciation globale :',
                    'valeur'   => ""
                ])
            </div>
        </div>

        {{-- Affichage automatique de la note --}}
        <div class="row my-5">
            <div class="col border border-primary">
                <h1>Note du rapport de stage</h1>
            </div>
            <div class="col-2 border border-primary text-right">
                <h1>... / 20</h1>
            </div>
        </div>

        {{-- Bouton d'enregistrement --}}
        <div class="row">
            <div class="col text-right">
                <button class="btn btn-success" type="submit">Enregistrer les modifications</button>
            </div>
        </div>

    </form>
</div>
@endsection
