@extends('layouts.app')

@section('titre', $titre)


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

    @include('includes.form.input.text', [
        'attribut' => 'nom',
        'intitule' => 'Nom (*)',
        'valeur'   => $etudiant->nom ?? old('nom')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'prenom',
        'intitule' => 'Prenom (*)',
        'valeur'   => $etudiant->prenom ?? old('prenom')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'email',
        'intitule' => 'Courriel (*)',
        'valeur'   => $etudiant->email ?? old('email')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'promotion',
        'intitule' => 'Promotion (*)',
        'valeur'   => $etudiant->email ?? old('promotion')
    ])
    <br/>

    @include('includes.form.input.select.annee', [
        'attribut' => 'annee',
        'intitule' => 'Année suivie (*)',
        'valeur'   => $etudiant->annee ?? old('annee')
    ])
    <br/>

    @include('includes.form.input.checkbox', [
        'attribut' => 'mobilite',
        'intitule' => 'Mobilitée validée ? (*)',
        'valeur'   => $etudiant->mobilite ?? old('mobilite')
    ])
    <br/>

    @include('includes.form.input.select.options', [
        'attribut'     => 'option_id',
        'intitule'     => 'Option (*)',
        'valeur'       => $etudiant->option_id ?? old('option_id'),
        'departements' => $departements,
        'options'      => $options
    ])
    <br/>

    @include('includes.form.input.select.departements', [
        'attribut'     => 'departement_id',
        'intitule'     => 'Département (*)',
        'valeur'       => $etudiant->departement_id ?? old('departement_id'),
        'departements' => $departements
    ])
    <br/>

    @if ( isset($etudiant) )
    <button type="submit"> Modifier l'etudiant</button>
    @else
    <button type="submit"> Créer l'etudiant</button>
    @endif
</form>

@endsection