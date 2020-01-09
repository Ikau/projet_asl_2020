@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    @if ( isset($stage) )
    Formulaire d'édition d'un stage
    @else
    Formulaire de creation d'un stage
    @endif
</div>
<div>
    <a href="{{ route('stages.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($stage) )
<form method="POST" action="{{ route('stages.update', [$stage->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('stages.store') }}">
@endif
    @csrf

    @include('includes.form.input.text', [
        'attribut' => 'intitule',
        'intitule' => 'Intitule du stage (*)',
        'valeur'   => $stage->intitule ?? old('intitule')
    ])
    <br/> 

    @include('includes.form.input.select.etudiants', [
        'attribut'  => 'etudiant_id',
        'etudiants' => $etudiants,
        'intitule'  => 'Etudiant(e) (*)',
        'valeur'    => $stage->etudiant_id ?? old('etudiant_id')
    ])
    <br/>

    @include('includes.form.input.select.annee', [
        'attribut' => 'annee_etudiant',
        'intitule' => 'Année de l\'etudiant(e) (*)',
        'valeur'   => $stage->annee_etudiant ?? old('annee_etudiant')
    ])
    <br/>

    @include('includes.form.input.select.enseignants', [
        'attribut'    => 'referent_id',
        'enseignants' => $enseignants,
        'intitule'    => 'Referent(e)',
        'valeur'      => $stage->referent_id ?? old('referent_id')
    ])
    <br/>

    @include('includes.form.textarea', [
        'attribut' => 'resume',
        'intitule' => 'Resume du stage (*)',
        'valeur'   => $stage->resume ?? old('resume')
    ])
    <br/>

    {{-- WIP Choix de la date debut desactivee pour l'instant --}}
    <label for="date_debut">Date de debut du stage (*)</label>
    <select name="date_debut" id="date_debut">
        <option value="{{ $stage->date_debut ?? $wip_debut ?? old('date_debut') }}" selected>{{ $stage->date_debut ?? $wip_debut ?? ''}}</option>
    </select>
    @error('date_debut')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    {{-- WIP Choix de la date fin desactivee pour l'instant --}}
    <label for="date_fin">Date de fin du stage (*)</label>
    <select name="date_fin" id="date_fin">
        <option value="{{ $stage->date_fin ?? $wip_fin ?? old('date_fin') }}" selected>{{ $stage->date_fin ?? $wip_fin ?? ''}}</option>
    </select>
    @error('date_fin')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'duree_semaines',
        'intitule' => 'Duree du stage (en semaines, *)',
        'valeur'   => $stage->duree_semaines ?? old('duree_semaines')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'gratification',
        'intitule' => 'Montant de la gratification (*)',
        'valeur'   => $stage->gratification ?? old('gratification')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'lieu',
        'intitule' => 'Lieu du stage ? (*)',
        'valeur'   => $stage->lieu ?? old('lieu')
    ])
    <br/>

    @include('includes.form.input.checkbox', [
        'attribut' => 'convention_envoyee',
        'intitule' => 'Convention envoyee a l\'entreprise ?',
        'valeur'   => $stage->convention_envoyee ?? old('convention_envoyee')
    ])
    <br/>

    @include('includes.form.input.checkbox', [
        'attribut' => 'convention_signee',
        'intitule' => 'Convention retournee signee ?',
        'valeur'   => $stage->convention_signee ?? old('convention_signee')
    ])
    <br/>

    @include('includes.form.input.text', [
        'attribut' => 'moyen_recherche',
        'intitule' => 'Moyen de recherche du stage',
        'valeur'   => $stage->moyen_recherche ?? old('moyen_recherche')
    ])
    <br/>

    @if ( isset($stage) )
    <button type="submit"> Modifier le stage</button>
    @else
    <button type="submit"> Créer le stage</button>
    @endif
</form>

@endsection