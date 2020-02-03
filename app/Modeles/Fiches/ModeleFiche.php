<?php

namespace App\Modeles\Fiches;

use App\Abstracts\Modeles\Fiches\AbstractModeleFiche;
use App\Utils\Constantes;

class ModeleFiche extends AbstractModeleFiche
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
     * @var string Nom de la table associe au modele 'ModeleFiche'
     */
    const NOM_TABLE = 'modeles_fiches';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = ModeleFiche::NOM_TABLE;

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
        self::COL_TYPE             => Constantes::STRING_VIDE,
        self::COL_VERSION          => Constantes::INT_VIDE,
        self::COL_POLY_MODELE_ID   => Constantes::ID_VIDE,
        self::COL_POLY_MODELE_TYPE => Constantes::STRING_VIDE,
    ];

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
    /**
     * Renvoie la fiche liee a cette section via une relation Many-to-One polymorphique
     * @return FicheEntreprise|FicheRapport|FicheSoutenance|FicheSynthese
     */
    public function fiche()
    {
        return $this->morphTo();
    }

    /**
     * Renvoie la liste des sections (avec leur questions) composant le modele de la fiche
     * @return Section
     */
    public function sections()
    {
        return $this->hasMany(Section::class, Section::COL_MODELE_ID);
    }

}
