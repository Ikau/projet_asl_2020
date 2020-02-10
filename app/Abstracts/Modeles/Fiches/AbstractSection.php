<?php

namespace App\Abstracts\Modeles\Fiches;

use App\Modeles\Fiches\ModeleNotation;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractSection extends Model
{
    /**
     * Renvoie le nombre de points obtenables dans la section
     * @return float
     */
    abstract public function getBareme() : float;

    /**
     * Renvoie la note totale de la section
     * @param $notation array Array de notation conforme au format de la section
     * @return float
     */
    abstract public function getNoteSection(array $notation) : float;

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
