@extends('layouts.app')

@section('titre', $titre)

@section('sidebar')
@endsection

@section('contenu')
<div>
    @if ( isset($entreprise) )
    Formulaire d'édition d'un entreprise
    @else
    Formulaire de creation d'un entreprise
    @endif
</div>
<div>
    <a href="{{ route('entreprises.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($entreprise) )
<form method="POST" action="{{ route('entreprises.update', [$entreprise->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('entreprises.store') }}">
@endif
    @csrf

    @include('includes.form.input.text', [
        'attribut' => 'nom',
        'intitule' => 'Nom (*)',
        'valeur'   => $entreprise->nom ?? old('nom')
    ])
    <br/>

    @include('includes.form.textarea', [
        'attribut' => 'adresse',
        'intitule' => 'Adresse (*)',
        'valeur'   => $entreprise->adresse ?? old('adresse')
    ])
    <br/>

    @include('includes.form.textarea', [
        'attribut' => 'adresse2',
        'intitule' => 'Adresse secondaire / Complement d\'adresse',
        'valeur'   => $entreprise->adresse2 ?? old('adresse2')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'cp',
        'intitule' => 'Code postal',
        'valeur'   => $entreprise->cp ?? old('cp')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'ville',
        'intitule' => 'Ville (*)',
        'valeur'   => $entreprise->ville ?? old('ville')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'pays',
        'intitule' => 'Pays (*)',
        'valeur'   => $entreprise->pays ?? old('pays')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'region',
        'intitule' => 'Region',
        'valeur'   => $entreprise->region ?? old('region')
    ])
    <br/>

    @if ( isset($entreprise) )
    <button type="submit"> Modifier l'entreprise</button>
    @else
    <button type="submit"> Créer l'entreprise</button>
    @endif
</form>

@endsection