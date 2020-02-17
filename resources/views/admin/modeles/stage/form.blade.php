{{--
    Formulaire de creation d'un stage / d'une affectation de stage

    Variables a definir depuis la vue appelante :
        'titre'       => string Le titre de l'onglet
        'enseignant'  => En cas d'edit : l'enseignant concerne
        'enseignants' => Collection de App\Modeles\Enseignant
        'etudiant'    => En cas d'edit : l'etudiant concerne
        'etudiants'   => Collection de App\Modeles\Etudiant
--}}

@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    @if ( isset($stage) )
        <h1>Formulaire d'édition d'une affectation de stage</h1>
    @else
        <h1>Formulaire de creation d'une affectation de stage</h1>
    @endif
</div>
<div>
    @if(null !== Auth::user()
    && (Auth::user()->estResponsableOption() || Auth::user()->estResponsableDepartement()))
    <a class="btn btn-danger" href="{{ route('referents.index') }}">Retour</a>
    @else
    <a class="btn btn-danger" href="{{ route('stages.index') }}">Retour</a>
    @endif
</div>
<div>
    <a>(*) : Champs obligatoires</a>
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

    @include('includes.form.input.date', [
        'attribut' => 'date_debut',
        'intitule' => 'Date de debut du stage (*)',
        'valeur'   => $stage->date_debut ?? old('date_debut')
    ])
    <br/>

    @include('includes.form.input.date', [
        'attribut' => 'date_fin',
        'intitule' => 'Date de fin du stage (*)',
        'valeur'   => $stage->date_fin ?? old('date_fin')
    ])
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

    <button class="btn btn-primary" type="submit">{{ isset($stage) ? 'Modifier le stage' : 'Créer le stage' }}</button>
</form>

@endsection
