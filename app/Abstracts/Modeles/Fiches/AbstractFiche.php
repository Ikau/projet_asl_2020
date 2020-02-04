<?php

namespace App\Abstracts\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;

abstract class AbstractFiche extends Model
{
    /**
     * Renvoie le contenu de la fiche sous forme d'un array associatie
     *
     * La structure de l'array devrait etre sous le format :
     * array(
     *    index_section => array_criteres
     * )
     *
     * @return Array
     */
    //abstract public function getContenuArray() : Array;

    /**
     * Renvoie la note finale de la fiche
     * @return float
     */
    abstract public function getNote() : float;
}

