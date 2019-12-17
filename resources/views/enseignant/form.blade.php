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

    <label for="option_id">Responsable d'option ? (*)</label>
    <select name="option_id" id="option_id" value="{{ $enseignant->option_id ?? old('option_id') }}" >
        @foreach($departements as $d)
        <optgroup label="{{ $d->intitule }}">
            @foreach($options as $o)
                @if($d->id === $o->departement_id)
                <option value="{{ $o->id }}">{{ $o->intitule }}</option>
                @endif
            @endforeach
        </optgroup>
        @endforeach
    </select>
    @error('option_id')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="departement_id">Responsable de département ? (*)</label>
    <select name="departement_id" id="departement_id" value="{{ $enseignant->departement_id ?? old('departement_id') }}" >
        @foreach($departements as $d)
        <option value="{{ $d->id }}">{{ $d->intitule }}</option>
        @endforeach
    </select>
    @error('departement_id')
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