{{-- 
    Page d'accueil (tableau de bord) pour l'espace commune a tous les enseignants.

    Variables a definir depuis la vue appelante :
        'titre'  : string   Le titre de l'onglet

--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
    <div>
        <h1>Zone enseignant</h1>
    </div>

    <div>
        Bienvenue {{Auth::user()->identite->prenom}} {{Auth::user()->identite->nom}}
    </div>
    <div>
        <a href="{{ route('referents.affectations') }}">Mes affectations</a>

        @if( Auth::user()->estResponsableOption() || Auth::user()->estResponsableDepartement() )
        <a href="{{ route('responsables.affectations.get') }}">Proposer une affectation</a>
        @endif
    </div>
@endsection