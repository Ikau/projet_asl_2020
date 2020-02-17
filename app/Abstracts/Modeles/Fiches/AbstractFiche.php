<?php

namespace App\Abstracts\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;

abstract class AbstractFiche extends Model
{

    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    public const VAL_STATUT_NOUVELLE = 0;
    public const VAL_STATUT_EN_COURS = 1;
    public const VAL_STATUT_COMPLETE = 2;


    /* ====================================================================
     *                            FONCTIONS
     * ====================================================================
     */
    /**
     * Renvoie la note finale de la fiche
     * @return float
     */
    abstract public function getNote() : float;

    /**
     * Renvoie l'etat de la fiche
     * @return int
     */
    abstract public function getStatut() : int;
}

