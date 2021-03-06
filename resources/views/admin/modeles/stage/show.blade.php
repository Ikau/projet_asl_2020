{{--
Page d'affichage detaillee d'un stage
Variables a definir depuis la vue appelante :
'titre'    : string    Le titre de l'onglet
'stage'    : Stage     Le stage a afficher
'etudiant' : Etudiant  L'etudiant lie a ce stage
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
    <div>
        <div class="container">

            <div class="card-header text-white bg-success border">
                <h2 style="text-decoration: underline">Informations sur un stage</h2>
                <h3>{{ $etudiant->prenom }} {{ $etudiant->nom }}</h3>
            </div>

            <div class="card-body border">
                @foreach($stage->toArray() as $key => $value)
                    <div class="row">
                        <span><strong>{{ $key }}</strong> : {{ $value }}</span>
                    </div>
                @endforeach
            </div>

            <div class="card-footer border">
                @if($stage->affectation_validee === 1)
                    <button class="btn btn-lg btn-success" style="cursor: default" disabled><i class="fas fa-check"></i> Affectation validée</button>
                @elseif(Auth::user() !== null && Auth::user()->can('validerAffectation', $stage))
                    <form method="POST" action="{{ route('responsables.affectations.valider', $stage->id) }}">
                        @csrf
                        <button class="btn btn-lag bg-primary text-white" type="submit">Valider l'affectation</button>
                    </form>
                @else
                    <button class="btn btn-lg btn-info text-white" style="cursor: default" disabled><i class="far fa-clock"></i> Affectation en attente de validation</button>
                @endif
            </div>
        </div>
    </div>
@endsection
