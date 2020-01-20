{{-- 
    Page d'accueil (tableau de bord) pour l'espace commune a tous les enseignants.

    Variables a definir depuis la vue appelante :
        'titre'  : string   Le titre de l'onglet
        'user'   : App\User Le compte de l'enseignant authentifie
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
        <a href="{{ route('referents.affectations') }}">Mes affectations</a>
    </div>
@endsection