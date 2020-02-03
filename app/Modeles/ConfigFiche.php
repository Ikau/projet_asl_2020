<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractConfigFiche;
use App\Utils\Constantes;

class ConfigFiche extends AbstractConfigFiche
{
    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_ENTREPRISE = 'entreprise';
    const VAL_RAPPORT    = 'rapport';
    const VAL_SOUTENANCE = 'soutenance';
    const VAL_SYNTHESE   = 'synthese';

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associe au modele 'ConfigFiche'
     */
    const NOM_TABLE = 'configs_fiches';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = ConfigFiche::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_TYPE      = 'type';
    const COL_VERSION   = 'version';

    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'FicheRapport'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_TYPE     => Constantes::STRING_VIDE,
        self::COL_VERSION  => Constantes::INT_VIDE,
    ];

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */

}
