<?php

namespace App\Modeles\Fiches;

use App\Abstracts\Modeles\Fiches\AbstractModeleNotation;
use App\Utils\Constantes;

class ModeleNotation extends AbstractModeleNotation
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
     * @var string Nom de la table associe au modele 'ModeleNotation'
     */
    const NOM_TABLE = 'modeles_notation';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = ModeleNotation::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_TYPE      = 'type';
    const COL_VERSION   = 'version';

    /*
     * Nom des colonnes polymorphiques
     */
    const COL_POLY_MODELE      = 'fiche';
    const COL_POLY_MODELE_ID   = 'fiche_id';
    const COL_POLY_MODELE_TYPE = 'fiche_type';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     */
    public $timestamps = false;

    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'ModeleNotation'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_TYPE             => Constantes::STRING_VIDE,
        self::COL_VERSION          => Constantes::INT_VIDE,
    ];

    /* ====================================================================
     *                           CONSTRUCTEUR
     * ====================================================================
     */
    /**
     * Constructeur de la classe ModeleNotation
     *
     * @param string $type Le type de modele a creer
     * @param int $id L'ID de la fiche liee a ce modele
     * @param int $version
     */
    public function ModeleNotation(string $type, int $id, int $version)
    {
        switch ($type)
        {
            case self::VAL_ENTREPRISE:
                break;

            case self::VAL_RAPPORT:
                break;

            case self::VAL_SOUTENANCE:
                break;

            case self::VAL_SYNTHESE:
                break;
        }
    }

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
    /**
     * Renvoie la liste des sections (avec leur questions) composant le modele de la fiche
     * @return Section
     */
    public function sections()
    {
        return $this->hasMany(Section::class, Section::COL_MODELE_ID);
    }
}
