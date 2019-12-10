@extends('layouts.app')

@section('title', 'Contact - Create')

@section('sidebar')
@endsection

@section('content')
<div>
    @if ( ! isset($contact))
    Formulaire de creation d'un contact
    @else
    Formulaire d'édition d'un contact
    @endif
</div>
<div>
    <a href="{{ route('contacts.index') }}">Retour</a>
</div>

@if ( ! isset($contact) )
<form method="POST" action="{{ route('contacts.store') }}">
@else
<form method="POST" action="{{ route('contacts.update', [$id ?? -1]) }}">
@method('PATCH')
@endif
    @csrf

    <label for="nom">Nom</label>
    <input id="nom" name="nom" type="text" value="{{ $contact->nom ?? old('nom') }}">
    @error('nom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="prenom">Prenom</label>
    <input id="prenom" name="prenom" type="text" value="{{ $contact->prenom ?? old('prenom') }}" >
    @error('prenom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="civilite">Civilite</label>
    <select name="civilite" id="civilite" value="{{ $contact->civilite ?? old('civilite') }}" >
        @foreach($civilite as $key => $value)
        <option value="{{ $value }}">{{ $key }}</option>
        @endforeach
    </select>
    @error('civilite')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="type">Type</label>
    <select name="type" id="type" value="{{ $contact->type ?? old('type') }}" >
        @foreach($type as $key => $value)
        <option value="{{ $value }}">{{ $key }}</option>
        @endforeach
    </select>
    @error('type')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="mail">Mail</label>
    <input id="mail" name="mail" type="text" value="{{ $contact->mail ?? old('mail') }}" >
    @error('mail')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="telephone">Telephone</label>
    <input id="telephone" name="telephone" type="text" value="{{ $contact->telephone ?? old('telephone') }}" >
    @error('telephone')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    <label for="adresse">Adresse</label>
    <input id="adresse" name="adresse" type="text" value="{{ $contact->adresse ?? old('adresse') }}" >
    @error('adresse')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    @if ( ! isset($contact))
    <button type="submit"> Créer le contact</button>
    @else
    <button type="submit"> Modifier le contact</button>
    @endif
</form>

@endsection