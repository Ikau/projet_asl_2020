@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    @if ( isset($privilege) )
    Formulaire d'édition d'un privilege
    @else
    Formulaire de creation d'un privilege
    @endif
</div>
<div>
    <a href="{{ route('privileges.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($privilege) )
<form method="POST" action="{{ route('privileges.update', [$privilege->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('privileges.store') }}">
@endif
    @csrf

    @include('includes.form.input.text', [
        'attribut' => 'intitule',
        'intitule' => 'Intitule du privilege (*)',
        'valeur'   => $privilege->intitule ?? old('intitule')
    ])
    <br/> 

    @if ( isset($privilege) )
    <button type="submit"> Modifier le privilege</button>
    @else
    <button type="submit"> Créer le privilege</button>
    @endif
</form>

@endsection