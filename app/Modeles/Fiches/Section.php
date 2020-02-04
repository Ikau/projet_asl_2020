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
    const COL_CRITERES = 'criteres';
    const COL_INTITULE = 'intitule';
    const COL_ORDRE    = 'ordre';

    /*
     * Nom des colonnes des clefs etrangeres de Section
     */
    const COL_MODELE_ID = 'modele_id';

    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    protected $casts = [
        self::COL_CRITERES => 'array'
    ];

    /**
     * Valeurs par defaut des colonnes du modele 'ModeleNotation'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_CRITERES  => Constantes::STRING_VIDE,
        self::COL_INTITULE  => Constantes::STRING_VIDE,
        self::COL_MODELE_ID => Constantes::ID_VIDE,
        self::COL_ORDRE     => Constantes::INT_VIDE
    ];

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */

    /**
     * Renvoie la liste des criteres liees a cette section via une relation One-to-Many
     * @return mixed Collection de Critere
     */
    public function criteres()
    {
        return $this->hasMany(Critere::class, Critere::COL_SECTION_ID);
    }

    /**
     * Renvoie le modele de la fiche auquel est lie cette section
     */
    public function modeleNotation()
    {
        return $this->belongsTo(ModeleNotation::class, Section::COL);
    }
}
