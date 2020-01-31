{{-- 
    Page des stages d'un referent. Affiche toutes les stages que possede un enseignant.

    Variables a definir depuis la vue appelante :
        'titre'       => string Le titre de l'onglet
        'enseignant'  => En cas d'edit : l'enseignant concerne
        'enseignants' => Collection de App\Modeles\Enseignant
        'etudiant'    => En cas d'edit : l'etudiant concerne
        'etudiants'   => Collection de App\Modeles\Etudiant
        'classeStage' => Stage  Stage::class
--}}
@extends('layouts.app')

@section('titre', $titre)

@section('contenu')
<div>
    Formulaire de creation d'une affectation
</div>
<div>
    <a href="{{ route('referents.index') }}">Retour</a>
</div>
<div>
    (*) : Champs obligatoires
</div>

<form method="POST" action="{{ route('responsables.affectations.store') }}">
    @csrf

    @include('includes.form.input.select.etudiants', [
        'attribut'  => $classeStage::COL_ETUDIANT_ID,
        'etudiants' => $etudiants,
        'intitule'  => 'Etudiant(e) (*)',
        'valeur'    => $etudiant->id ?? old('etudiant')
    ])

    @include('includes.form.input.select.enseignants', [
        'attribut'    => $classeStage::COL_REFERENT_ID,
        'enseignants' => $enseignants,
        'intitule'    => 'Referent(e) (*)'
        'valeur'      => $enseignant->id ?? old('ensiegnant')
    ])

    
</form>
@endsection