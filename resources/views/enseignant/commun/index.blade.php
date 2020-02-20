{{--
    Page d'accueil (tableau de bord) pour l'espace commune a tous les enseignants.

    Variables a definir depuis la vue appelante :
        'titre'  : string   Le titre de l'onglet
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card-header text-white bg-secondary">
                    <h3>Accès rapides</h3>
                </div>
                <div class="card-body">
                    <a class="btn btn-lg btn-success" href="{{ route('referents.affectations') }}">🎓 Mes affectations</a>

                    @if( Auth::user()->estResponsableOption() || Auth::user()->estResponsableDepartement() )
                        <a class="btn btn-lg text-white" style="background-color: #6e6254" href="{{ route('responsables.affectations.index', Auth::user()->identite->id) }}">🗂️ Liste des affectations</a>
                        <a class="btn btn-lg btn-primary" href="{{ route('responsables.affectations.create') }}">➕ Proposer une affectation</a>
                    @endif
                </div>

                <div class="card-header bg-primary text-white">
                    <h3>Mes derniers évènements</h3>
                </div>

                <div class="card-body">
                    @foreach(Auth::user()->notifications()->limit(5)->get() as $notification)
                        <div class="card-header border h4">
                            <span class="badge badge-secondary">{{ $notification->created_at->format('d-m-yy') }}</span>
                            <span class="badge badge-info text-white">{{ \App\Facade\NotificationFacade::getTypeEvenement($notification) }}</span>
                            <span>{{ \App\Facade\NotificationFacade::getTitre($notification) }}</span>
                        </div>
                        <div class="card-body border">
                            {!! \App\Facade\NotificationFacade::getMessage($notification) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
