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
{{-- Entete de toutes les fiches --}}
@include('includes.entete-fiche', [
    'campus' => 'Bourges',
    'numero' => 2,
    'stage'  => $stage,
])
{{-- Contenu des sections --}}
@include('includes.foreach.sections', [
    'contenu'  => $fiche->contenu,
    'sections' => $fiche->modele->sections
])
{{-- Appreciation globale --}}
<div class="row">
    <div class="col">
        <p>Appréciation globale :</p>
    </div>
    <div class="col">
        <p>{{$fiche->appreciation}}</p>
    </div>
</div>

{{-- Note finale / 20 --}}
<div class="row">
    <div class="col">
        <p>{{ $fiche->getNote() }} / 20</p>
    </div>
</div>
@endsection
