<?php

namespace App\Interfaces\Permissions;

use App\Modeles\Enseignant;

/**
 * Interface fournissant toutes les fonctions pour gerer les roles des utilisateurs.
 *
 * @package App\Interfaces
 */
interface GestionResponsable
{
    /**
     * Recupere l'enseignant et l'associe en tant que responsable du departement entre
     *
     * @param string $intituleDepartement
     * @param Enseignant $enseignant
     * @return bool TRUE si succes, FALSE sinon
     */
    public static function remplaceResponsableDepartement(string $intituleDepartement, Enseignant $enseignant) : bool;

    /**
     * Recupere l'enseignant et l'associe en tant que responsable de l'option entree
     *
     * @param string $intituleOption
     * @param Enseignant $enseignant
     * @return bool TRUE si succes, FALSE sinon
     */
    public static function remplaceResponsableOption(string $intituleOption, Enseignant $enseignant) : bool;

    /**
     * Supprime le responsable courant du departement donne
     *
     * @param string $intituleDepartement
     * @param Enseignant $enseignant
     * @return bool
     */
    public static function supprimeResponsableDepartement(string $intituleDepartement) : bool;

    /**
     * Supprime le responsable courant de l'option donnee
     *
     * @param string $intituleOption
     * @param Enseignant $enseignant
     * @return bool
     */
    public static function supprimeResponsableOption(string $intituleOption) : bool;

}
