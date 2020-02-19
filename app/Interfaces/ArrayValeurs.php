<?php

namespace App\Interfaces;

/**
 * Interface pour récupérer rapidement toutes les valeurs possible d'un modele.
 *
 * Pour l'instant, l'utilisation de l'interface se restraint aux tests unitaires.
 * L'interface permet en effet de garantir l'integrite des attributs d'un modele.
 * On pourrait l'utiliser dans d'autres contextes mais ces cas ne sont pour l'instant par couverts par l'applciation.
 *
 * @package App\Interfaces
 */
interface ArrayValeurs
{
    /**
     * Fonctione auxiliaire pour renvoyer la liste de toutes les valeurs possibles par le modele
     *
     * @return array(string)
     */
    public static function getValeurs();
}
