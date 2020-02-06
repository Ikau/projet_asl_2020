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
    @include('includes.entete-fiche', [
        'stage' => $stage
    ])
@endsection
