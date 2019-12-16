@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    @if ( isset($enseignant) )
    Formulaire d'édition d'un enseignant
    @else
    Formulaire de creation d'un enseignant
    @endif
</div>
<div>
    <a href="{{ route('enseignants.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($enseignant) )
<form method="POST" action="{{ route('enseignants.update', [$id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('enseignants.store') }}">
@endif
    @csrf

    <label for="nom">Nom (*)</label>
    <input id="nom" name="nom" type="text" value="{{ $enseignant->nom ?? old('nom') }}">
    @error('nom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="prenom">Prenom (*)</label>
    <input id="prenom" name="prenom" type="text" value="{{ $enseignant->prenom ?? old('prenom') }}" >
    @error('prenom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="email">Mail (*)</label>
    <input id="email" name="email" type="text" value="{{ $enseignant->email ?? old('email') }}" >
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="responsable_option">Responsable d'option ? (*)</label>
    <select name="responsable_option" id="responsable_option" value="{{ $enseignant->responsable_option ?? old('responsable_option') }}" >
        @foreach($options as $nomOption => $option)
        <optgroup label="{{ $nomOption }}">
            @foreach($option as $key => $value)
            <option value="{{ $value }}">{{ $key }}</option>
            @endforeach
        </optgroup>
        @endforeach
    </select>
    @error('responsable_option')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="responsable_departement">Responsable de département ? (*)</label>
    <select name="responsable_departement" id="responsable_departement" value="{{ $enseignant->responsable_departement ?? old('responsable_departement') }}" >
        @foreach($departements as $key => $value)
        <option value="{{ $value }}">{{ $key }}</option>
        @endforeach
    </select>
    @error('responsable_departement')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    @if ( isset($enseignant))
    <button type="submit"> Modifier le enseignant</button>
    @else
    <button type="submit"> Créer le enseignant</button>
    @endif
</form>

@endsection