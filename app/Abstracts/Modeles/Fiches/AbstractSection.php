<?php

namespace App\Abstracts\Modeles\Fiches;

use App\Modeles\Fiches\FicheEntreprise;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSoutenance;
use App\Modeles\Fiches\FicheSynthese;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractSection extends Model
{
    /**
     * Renvoie la liste des questions liees a cette section via une relation One-to-Many
     * @return mixed Collection de Question
     */
    abstract public function questions();

    /**
     * Renvoie la fiche liee a cette section via une relation Many-to-One polymorphique
     * @return FicheEntreprise|FicheRapport|FicheSoutenance|FicheSynthese
     */
    abstract public function fiche();
}
