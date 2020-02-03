<?php

namespace App\Abstracts\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractFiche extends Model
{
    /**
     * Renvoie la note finale de la fiche
     * @return float
     */
    abstract public function getNote() : float;
}

