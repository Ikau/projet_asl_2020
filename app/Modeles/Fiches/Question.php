<?php

namespace App\Modeles\Fiches;

use App\Abstracts\Modeles\Fiches\AbstractQuestion;
use App\Utils\Constantes;

class Question extends AbstractQuestion
{

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associe au modele 'Question'
     */
    const NOM_TABLE = 'questions';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = self::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_CHOIX    = 'choix';
    const COL_INTITULE = 'intitule';

    /*
     * Nom des colonnes des clefs etrangeres de Question
     */
    // Element obligatoire
    const COL_SECTION_ID = 'section_id';

    /**
     * Indique a Laravel d'automatiquement caster vers des types PHP
     *
     * @var array
     */
    protected $casts = [
        self::COL_CHOIX => 'array',
    ];


    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'Question'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        self::COL_CHOIX      => Constantes::STRING_VIDE,
        self::COL_INTITULE   => Constantes::STRING_VIDE,
        self::COL_SECTION_ID => Constantes::ID_VIDE
    ];

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
    /**
     * Renvoie la section a cette question et ses choix via une relation Many-to-One
     */
    public function section()
    {
        return $this->belongsTo(Section::class, Question::COL_SECTION_ID);
    }
}
