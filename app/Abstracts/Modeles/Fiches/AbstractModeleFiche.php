<?php

namespace App\Abstracts\Modeles\Fiches;

use App\Modeles\Fiches\FicheEntreprise;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSoutenance;
use App\Modeles\Fiches\FicheSynthese;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModeleFiche extends Model
{
    /**
     * Renvoie la fiche liee a cette section via une relation Many-to-One polymorphique
     * @return FicheEntreprise|FicheRapport|FicheSoutenance|FicheSynthese
     */
    abstract public function fiche();

    /**
     * Renvoie la liste des sections (avec leur questions) composant le modele de la fiche
     * @return Section
     */
    abstract public function sections();
}
