@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    @if ( isset($etudiant) )
    Formulaire d'édition d'un etudiant
    @else
    Formulaire de creation d'un etudiant
    @endif
</div>
<div>
    <a href="{{ route('etudiants.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($etudiant) )
<form method="POST" action="{{ route('etudiants.update', [$etudiant->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('etudiants.store') }}">
@endif
    @csrf

    <label for="nom">Nom (*)</label>
    <input id="nom" name="nom" type="text" value="{{ $etudiant->nom ?? old('nom') }}">
    @error('nom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="prenom">Prenom (*)</label>
    <input id="prenom" name="prenom" type="text" value="{{ $etudiant->prenom ?? old('prenom') }}" >
    @error('prenom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="email">Mail (*)</label>
    <input id="email" name="email" type="text" value="{{ $etudiant->email ?? old('email') }}" >
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="annee">Année suivie (*)</label>
    <select name="annee" id="annee" value="{{ $etudiant->annee ?? old('annee') }}">
        <option value="4">4e année</option>
        <option value="5">5e année</option>
    </select>
    @error('annee')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="mobilite">Mobilitée validée ? (*)</label>
    <input id="mobilite" name="mobilite" type="checkbox" value="{{ $etudiant->mobilite ?? old('mobilite') }}">
    @error('mobilite')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="option_id">Option (*)</label>
    <select name="option_id" id="option_id" value="{{ $etudiant->option_id ?? old('option_id') }}" >
        {{-- Liste les options de departement existants --}}
        @include('includes.liste.options', [
            'departements' => $departements,
            'options'      => $options
        ])
    </select>
    @error('option_id')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="departement_id">Département (*)</label>
    <select name="departement_id" id="departement_id" value="{{ $etudiant->departement_id ?? old('departement_id') }}" >
        {{-- Liste les departements existants --}}
        @include('includes.liste.departements', [
            'departements' => $departements
        ])
    </select>
    @error('departement_id')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    @if ( isset($etudiant) )
    <button type="submit"> Modifier l'etudiant</button>
    @else
    <button type="submit"> Créer l'etudiant</button>
    @endif
</form>

@endsection