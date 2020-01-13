@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
    <div>
        <h1>Zone administrateur</h1>
    </div>

    <div>
        <a href="{{ route('contacts.index') }}">Contacts</a>
        <a href="{{ route('enseignants.index') }}">Enseignants</a>
        <a href="{{ route('entreprises.index') }}">Entreprises</a>
        <a href="{{ route('etudiants.index') }}">Etudiants</a>
        <a href="{{ route('stages.index') }}">Stages</a>
        <a href="{{ route('soutenances.index') }}">Soutenances</a>
        <a href="{{ route('privileges.index') }}">Privileges</a>
        <a href="{{ route('users.index') }}">Users</a>
    </div>
@endsection