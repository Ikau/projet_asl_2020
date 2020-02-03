<?php

namespace App\Abstracts\Modeles\Fiches;

use App\Modeles\Fiches\ModeleFiche;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractSection extends Model
{
    /**
     * Renvoie la liste des questions liees a cette section via une relation One-to-Many
     * @return mixed Collection de Critere
     */
    abstract public function criteres();

    /**
     * Renvoie le modele de la fiche auquel est lie cette section
     * @return ModeleFiche
     */
    abstract public function modeleFiche();
}
