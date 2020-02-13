{{--
    Affichage de la page d'accueil de l'espace enseignant

    Variables a definir depuis la vue appelante :
            'titre'         => string                               Le titre de la page
            'notifications' => Colleciton(InformationsNotification) Les notifications recents implementant l'interface InformationsNotifications
--}}
@extends('layouts.app')

@section('contenu')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Bienvenue {{ Auth::user()->identite->prenom }} {{ Auth::user()->identite->nom }}</p>
                </div>
                <div class="card-header text-white bg-secondary">
                    <h3>🏗️ Liens utiles 🚧</h3>
                </div>
                <div class="card-body">
                    <a class="btn btn-lg btn-primary" href="{{ route('admin.index') }}">Espace administrateur</a>
                    <a class="btn btn-lg btn-primary" href="{{ route('referents.index') }}">Espace enseignant</a>
                    <a class="btn btn-lg btn-primary" href="{{ route('scolarite.index') }}">Espace scolarite</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
