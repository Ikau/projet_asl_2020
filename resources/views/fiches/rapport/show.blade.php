{{--
    Affiche les informations contenues dans une fiche de rapport de stage

    Variables a definir depuis le controller appelant :
        'titre' => string        Le titre de l'onglet
        'fiche' => FicheRapport  Le model Eloquent FicheRapport a afficher
        'stage' => Stage         Le stage lie a la fiche de rapport
--}}
@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div class="container">
    {{-- Entete de toutes les fiches --}}
    @include('includes.entete-fiche', [
        'campus' => 'Bourges',
        'numero' => 2,
        'stage'  => $stage,
    ])

    <div class="m-5"></div>

    {{-- Contenu des sections --}}
    @include('includes.foreach.sections', [
        'contenu'  => $fiche->contenu,
        'sections' => $fiche->modele->sections
    ])

    {{-- Appreciation globale --}}
    <div class="row">
        <h4>Appréciation globale :</h4>
    </div>
    <div class="row">
        <p>{{$fiche->appreciation}}</p>
    </div>

    {{-- Note finale / 20 --}}
    <div class="row my-4">
        <div class="col border border-primary">
            <h1>Note du rapport de stage</h1>
        </div>
        <div class="col-2 border border-primary text-right">
            <h1>{{ $fiche->getNote() }} / 20</h1>
        </div>
    </div>

    {{-- Bouton pour modifier --}}
    <div class="row">
        <div class="col text-right">
            <a class="btn btn-lg btn-success" href="{{route('fiches.rapport.edit', $fiche->id)}}">📝 Modifier la fiche</a>
        </div>
    </div>
</div>
@endsection
