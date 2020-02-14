{{--
Page d'affichage detaillee d'un stage
Variables a definir depuis la vue appelante :
'titre'    : string    Le titre de l'onglet
'stage'    : Stage     Le stage a afficher
'etudiant' : Etudiant  L'etudiant lie a ce stage
--}}
@extends('layouts.app')
@extends('layouts.app')


@section('titre', $titre)
@section('titre', $titre)




@section('contenu')
@section('contenu')
    <div>
        <div class="container">
            Information sur un stage
        </div>


        @foreach($stage->toArray() as $key => $value)
            <div class="card-header text-white bg-success border">
                <div>
                    <h1>{{ $etudiant->prenom }} {{ $etudiant->nom }}</h1>
                    {{ $key }} : {{ $value }}
                </div>
            </div>

        @endforeach
        <div class="card-body border">
            <div>
                @foreach($stage->toArray() as $key => $value)
                    <div class="row">
                        <span><strong>{{ $key }}</strong> : {{ $value }}</span>
                    </div>
                @endforeach
            </div>

            <div class="card-footer border">
                @if($stage->affectation_validee === 1)
                    <button class="btn btn-lg btn-success" style="cursor: default" disabled><i class="fas fa-check"></i> Affectation validée</button>
                @else
                    <form method="POST" action="{{ route('responsables.affectations.valider', $stage->id) }}">
                        @csrf
                        <button class="btn btn-lag bg-primary text-white" type="submit">Valider l'affectation</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
@endsection
