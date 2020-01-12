@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    @if ( isset($user) )
    Formulaire d'édition d'un utilisateur
    @else
    Formulaire de creation d'un utilisateur
    @endif
</div>
<div>
    <a href="{{ route('users.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($user) )
<form method="POST" action="{{ route('users.update', [$user->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('users.store') }}">
@endif
    @csrf

    @include('includes.form.input.select.email-et-identite', [
        'attribut'      => $classe::COL_EMAIL,
        'enseignants'   => $enseignants,
        'contacts_insa' => $contacts_insa,
        'type'          => $type,
        'intitule'      => 'Email de l\'utilisateur (*)',
        'valeur'        => $user->intitule ?? old($classe::COL_EMAIL)
    ])
    <br/> 

    @if ( isset($user) )
    <button type="submit"> Modifier l'utilisateur</button>
    @else
    <button type="submit"> Créer l'utilisateur</button>
    @endif
</form>

@endsection