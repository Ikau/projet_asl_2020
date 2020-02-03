<?php

namespace App\Modeles\Fiches;

use App\Abstracts\Modeles\Fiches\AbstractSection;
use App\Utils\Constantes;

class Section extends AbstractSection
{
    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associee au modele 'Section'
     */
    const NOM_TABLE = 'sections';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = self::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_INTITULE = 'intitule';

    /*
     * Nom des colonnes polymorphiques
     */
    const COL_POLY_MODELE      = 'fiche';
    const COL_POLY_MODELE_ID   = 'fiche_id';
    const COL_POLY_MODELE_TYPE = 'fiche_type';

    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'ModeleFiche'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_INTITULE         => Constantes::STRING_VIDE,
        self::COL_POLY_MODELE_ID   => Constantes::ID_VIDE,
        self::COL_POLY_MODELE_TYPE => Constantes::STRING_VIDE
    ];


    /**
     * @inheritDoc
     */
    public function questions()
    {
        // TODO: Implement questions() method.
    }

    /**
     * @inheritDoc
     */
    public function fiche()
    {
        // TODO: Implement fiche() method.
    }

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
}
