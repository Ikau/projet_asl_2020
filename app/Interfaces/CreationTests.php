<?php

namespace App\Interfaces;

use App\Modeles\Stage;
use App\User;

/**
 * Contrat d'implementation pour toutes les fonctions auxiliaires de test
 *
 * Les classes implementant cette interface ne devraient renvoyer que des
 * objets naifs sans aucune fonctionnalite business.
 *
 * Interface CreationTests
 * @package App\Interfaces
 */
interface CreationTests
{
    /**
     * Cree un stage dont le referent est le compte utilisateur donne en argument
     *
     * @param User $userEnseignant
     * @return Stage
     */
    public static function creerStagePourEnseignant(User $userEnseignant) : Stage;

    /**
     * Cree un stage sans enseignant referent affecte
     *
     * @return Stage
     */
    public static function creerStageNonAffecte() : Stage;
}
