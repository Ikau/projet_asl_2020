<?php

namespace App\Abstracts\Modeles\Fiches;

use App\Modeles\Fiches\ModeleNotation;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractSection extends Model
{
    /**
     * Renvoie la liste des questions liees a cette section via une relation One-to-Many
     * @return mixed Collection de Critere
     */
    abstract public function criteres();

    /**
     * Renvoie la note totale de la section
     * @return float
     */
    abstract public function getPoints(int $indexChoix) : float ;

    /**
     * Renvoie le modele de la fiche auquel est lie cette section
     * @return ModeleNotation
     */
    abstract public function modeleNotation();

}
