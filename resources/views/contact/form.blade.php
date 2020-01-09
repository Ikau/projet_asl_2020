@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    @if ( isset($contact))
    Formulaire d'édition d'un contact
    @else
    Formulaire de creation d'un contact
    @endif
</div>
<div>
    <a href="{{ route('contacts.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($contact) )
<form method="POST" action="{{ route('contacts.update', [$contact->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('contacts.store') }}">
@endif
    @csrf

    @include('includes.form.input.text', [
        'attribut' => 'nom',
        'intitule' => 'Nom (*)',
        'valeur'   => $contact->nom ?? old('nom')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'prenom',
        'intitule' => 'Prenom (*)',
        'valeur'   => $contact->prenom ?? old('prenom')
    ])
    <br/>

    <label for="type">Type (*)</label>
    <select name="type" id="type" value="{{ $contact->type ?? old('type') }}" >
        @foreach($type as $key => $value)
        <option value="{{ $value }}">{{ $key }}</option>
        @endforeach
    </select>
    @error('type')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>


    @include('includes.form.input.text', [
        'attribut' => 'email',
        'intitule' => 'Courriel (*)',
        'valeur'   => $contact->email ?? old('email')
    ])
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

    @include('includes.form.input.text', [
        'attribut' => 'telephone',
        'intitule' => 'Telephone',
        'valeur'   => $contact->telephone ?? old('telephone')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'adresse',
        'intitule' => 'Adresse',
        'valeur'   => $contact->adresse ?? old('adresse')
    ])
    <br/>

    @if ( isset($contact))
    <button type="submit"> Modifier le contact</button>
    @else
    <button type="submit"> Créer le contact</button>
    @endif
</form>

@endsection