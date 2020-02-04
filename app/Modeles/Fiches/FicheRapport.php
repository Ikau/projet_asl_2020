<?php

namespace App\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\Fiches\AbstractFiche;
use App\Utils\Constantes;

class FicheRapport extends AbstractFiche
{

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_APPRECIATION = 'appreciation';
    const COL_CONTENU      = 'contenu';

    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_MODELE_ID   = 'modele_id';
    const COL_STAGE_ID    = 'stage_id';
    const COL_SYNTHESE_ID = 'synthese_id';

    /**
     * @var string Nom de la table associe au modele 'FicheRapport'
     */
    const NOM_TABLE = 'fiches_rapport';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom
     * @var string Nom de la table associee au modele 'FicheRapport'.
     */
    protected $table = FicheRapport::NOM_TABLE;


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

        // Clefs etrangeres_
        self::COL_MODELE_ID   => Constantes::ID_VIDE,
        self::COL_SYNTHESE_ID => Constantes::ID_VIDE,
        self::COL_STAGE_ID    => Constantes::ID_VIDE,
    ];

    /* ====================================================================
     *                            OVERRIDES
     * ====================================================================
     */
    /**
     * Renvoie la note finale de la fiche
     * @return float
     */
    public function getNote(): float
    {
        // TODO: Implement getNote() method.
    }

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
    /**
     * Renvoie la fiche synthese liee a cette fiche rapport
     * @var App\Modeles\FicheSynthese
     */
    public function synthese()
    {
        return $this->belongsTo('App\Modeles\FicheSynthese', FicheRapport::COL_SYNTHESE_ID);
    }

    /**
     * Renvoie le stage associe a cette fiche soutenance
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->belongsTo('App\Modeles\Stage', FicheRapport::COL_STAGE_ID);
    }
}
