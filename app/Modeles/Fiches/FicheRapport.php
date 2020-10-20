<?php

namespace App\Modeles\Fiches;

use App\Abstracts\Modeles\Fiches\AbstractFiche;
use App\Modeles\Stage;
use App\Traits\NotationFiches;
use App\Utils\Constantes;

class FicheRapport extends AbstractFiche
{
    use NotationFiches;

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_APPRECIATION = 'appreciation';
    const COL_CONTENU      = 'contenu';
    const COL_STATUT       = 'statut';

    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_MODELE_ID   = 'modele_id';
    const COL_STAGE_ID    = 'stage_id';

    /**
     * @var string Nom de la table associe au modele 'FicheRapport'
     */
    const NOM_TABLE = 'fiches_rapport';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom
     * @var string Nom de la table associee au modele 'FicheRapport'.
     */
    protected $table = self::NOM_TABLE;


    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

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
        self::COL_APPRECIATION => Constantes::STRING_VIDE,
        self::COL_CONTENU      => Constantes::STRING_VIDE,
        self::COL_STATUT       => self::VAL_STATUT_NOUVELLE,

        // Clefs etrangeres_
        self::COL_MODELE_ID   => Constantes::ID_VIDE,
        self::COL_STAGE_ID    => Constantes::ID_VIDE,
    ];

    /**
     * Indique a Laravel quelles proprietes sont a caster vers des types utilisables
     * @var array
     */
    protected $casts = [
        self::COL_CONTENU => 'array',
    ];

    /* ====================================================================
     *                            OVERRIDES
     * ====================================================================
     */

    /*
     * Implementees dans le trait 'NotationFiches'
     */
    //abstract public function getNote() : float;
    //abstract public function getStatut() : int;


    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
    /**
     * Renvoie le modele de notation sur lequel est basee la fiche
     * @return App\Modeles\Fiches\ModeleNotation
     */
    public function modele()
    {
        return $this->belongsTo(ModeleNotation::class, self::COL_MODELE_ID);
    }

    /**
     * Renvoie le stage associe a cette fiche soutenance
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->belongsTo(Stage::class, self::COL_STAGE_ID);
    }
}
