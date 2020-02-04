<?php

namespace App\Abstracts\Modeles\Fiches;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModeleNotation extends Model
{
    /**
     * Renvoie la liste des sections (avec leur questions) composant le modele de la fiche
     * @return Section
     */
    abstract public function sections();
}
