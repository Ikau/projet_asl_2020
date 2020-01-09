@extends('layouts.app')

@section('titre', $titre)


@section('contenu')
<div>
    @if ( isset($soutenance) )
    Formulaire d'édition d'unz soutenance
    @else
    Formulaire de creation d'une soutenance
    @endif
</div>
<div>
    <a href="{{ route('soutenances.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

@if ( isset($soutenance) )
<form method="POST" action="{{ route('soutenances.update', [$soutenance->id ?? -1]) }}">
@method('PATCH')
@else
<form method="POST" action="{{ route('soutenances.store') }}">
@endif
    @csrf

    @include('includes.form.input.select.annee', [
        'attribut' => $classe::COL_ANNEE_ETUDIANT,
        'intitule' => 'Annee d\'etude du candidat (*)',
        'valeur'   => $soutenance[$classe::COL_ANNEE_ETUDIANT] ?? old($classe::COL_ANNEE_ETUDIANT)
    ])
    <br/>

    @include('includes.form.input.select.campus', [
        'attribut' => $classe::COL_CAMPUS,
        'intitule' => 'Campus de la soutenance (*)',
        'valeur'   => $soutenance[$classe::COL_CAMPUS] ?? old($classe::COL_CAMPUS)
    ])
    <br/>

    @include('includes.form.textarea', [
        'attribut' => $classe::COL_COMMENTAIRE,
        'intitule' => 'Commentaires',
        'valeur'   => $soutenance[$classe::COL_COMMENTAIRE] ?? old($classe::COL_COMMENTAIRE)
    ])
    <br/>

    @include('includes.form.input.checkbox', [
        'attribut' => $classe::COL_CONFIDENTIELLE,
        'intitule' => 'Soutenance confidentielle ?',
        'valeur'   => $soutenance[$classe::COL_CONFIDENTIELLE] ?? old($classe::COL_CONFIDENTIELLE)
    ])
    <br/>

    {{-- WIP Choix de la date desactivee pour l'instant --}}
    <label for="{{ $classe::COL_DATE }}">Date de la soutenance (*)</label>
    <select name="{{ $classe::COL_DATE }}" id="{{ $classe::COL_DATE }}">
        <option value="{{ $soutenance[$classe::COL_DATE] ?? $wip_date ?? old($classe::COL_DATE) }}" selected>{{ $soutenance[$classe::COL_DATE] ?? $wip_date ?? ''}}</option>
    </select>
    @error($classe::COL_DATE)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    {{-- WIP Choix de la date fin desactivee pour l'instant --}}
    <label for="{{ $classe::COL_HEURE }}">Heure de la soutenance (*)</label>
    <select name="{{ $classe::COL_HEURE }}" id="{{ $classe::COL_HEURE }}">
        <option value="{{ $soutenance[$classe::COL_HEURE] ?? $wip_heure ?? old($classe::COL_HEURE) }}" selected>{{ $soutenance[$classe::COL_HEURE] ?? $wip_heure ?? ''}}</option>
    </select>
    @error($classe::COL_HEURE)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br/>

    @include('includes.form.textarea', [
        'attribut' => $classe::COL_INVITES,
        'intitule' => 'Invites presents',
        'valeur'   => $soutenance[$classe::COL_INVITES] ?? old($classe::COL_INVITES)
    ])
    <br/>

    @include('includes.form.input.number', [
        'attribut' => $classe::COL_NB_REPAS,
        'intitule' => 'Nombre de repas',
        'valeur'   => $soutenance[$classe::COL_NB_REPAS] ?? old($classe::COL_NB_REPAS),
        'max'      => 10
    ])
    <br/>

    @include('includes.form.input.select.salles', [
        'attribut' => $classe::COL_SALLE,
        'intitule' => 'Salle de la soutenance',
        'valeur'   => $soutenance[$classe::COL_SALLE] ?? old($classe::COL_SALLE)
    ])
    <br/>

    @include('includes.form.input.select.enseignants', [
        'attribut'   => $classe::COL_CANDIDE_ID,
        'enseignant' => $enseignants,
        'intitule'   => 'Enseignant candide',
        'valeur'     => $soutenance[$classe::COL_CANDIDE_ID] ?? old($classe::COL_CANDIDE_ID)
    ])
    <br/>

    <!-- Contact de la soutenance


        
    TODO -->

    @include('includes.form.input.select.etudiants', [
        'attribut'  => $classe::COL_ETUDIANT_ID,
        'etudiants' => $etudiants,
        'intitule'  => 'Etudiant(e)',
        'valeur'    => $soutenance[$classe::COL_CANDIDE_ID] ?? old($classe::COL_CANDIDE_ID)
    ])
    <br/>

    @include('includes.form.input.select.departements', [
        'attribut'     => $classe::COL_DEPARTEMENT_ID,
        'intitule'     => 'Departement',
        'valeur'       => $soutenance[$classe::COL_DEPARTEMENT_ID] ?? old($classe::COL_DEPARTEMENT_ID),
        'departements' => $departements
    ])
    <br/>

    @include('includes.form.input.select.options', [
        'attribut'     => $classe::COL_OPTION_ID,
        'intitule'     => 'Option',
        'valeur'       => $soutenance[$classe::COL_OPTION_ID] ?? old($classe::COL_OPTION_ID),
        'departements' => $departements,
        'options'      => $options
    ])
    <br/>

    @include('includes.form.input.select.enseignants', [
        'attribut'   => $classe::COL_REFERENT_ID,
        'enseignant' => $enseignants,
        'intitule'   => 'Enseignant referent',
        'valeur'     => $soutenance[$classe::COL_REFERENT_ID] ?? old($classe::COL_REFERENT_ID)
    ])
    <br/>

    @if ( isset($soutenance) )
    <button type="submit"> Modifier la soutenance</button>
    @else
    <button type="submit"> Créer la soutenance</button>
    @endif

</form>

@endsection