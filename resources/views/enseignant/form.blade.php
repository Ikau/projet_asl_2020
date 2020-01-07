@extends('layouts.app')

@section('titre', $titre)


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
<form method="POST" action="{{ route('enseignants.update', [$enseignant->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('enseignants.store') }}">
@endif
    @csrf

    @include('includes.form.input.text', [
        'attribut' => 'nom',
        'intitule' => 'Nom (*)',
        'valeur'   => $enseignant->nom ?? old('nom')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'prenom',
        'intitule' => 'Prenom (*)',
        'valeur'   => $enseignant->prenom ?? old('prenom')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'email',
        'intitule' => 'Courriel (*)',
        'valeur'   => $enseignant->email ?? old('email')
    ])
    <br/>

    @include('includes.form.input.select.options', [
        'attribut'     => 'option_id',
        'intitule'     => 'Responsable d\'option ?',
        'valeur'       => $enseignant->option_id ?? old('option_id'),
        'departements' => $departements,
        'options'      => $options
    ])
    <br/>

    @include('includes.form.input.select.departements', [
        'attribut'     => 'departement_id',
        'intitule'     => 'Responsable de département ?',
        'valeur'       => $enseignant->departement_id ?? old('departement_id'),
        'departements' => $departements
    ])
    <br/>

    @if ( isset($enseignant))
    <button type="submit"> Modifier le enseignant</button>
    @else
    <button type="submit"> Créer le enseignant</button>
    @endif
</form>

@endsection