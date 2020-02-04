<?php

namespace App\Modeles\Fiches;

use App\Interfaces\Fiche;
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
        self::COL_STAGE_ID    => Constantes::ID_VIDE,
    ];

    /* ====================================================================
     *                            OVERRIDES
     * ====================================================================
     */
    /**
     * @return float La note finale de la fiche
     */
    public function getNote() : float
    {
        // Verification basique
        $note = 0.0;
        if(null === $this->contenu)
        {
            return $note;
        }

        // Recuperation du json
        $notation = json_decode($this->contenu);
        if(null == $notation)
        {
            return $note;
        }

        // Calcule de la note
        $sections = $this->modele->sections()->orderBy(Section::COL_ORDRE)->get();
        foreach($notation as $indexSection => $criteres)
        {
            $section = $sections->get($indexSection);
            foreach($criteres as $indexPoints)
            {
                $note += $section->getPoints($indexPoints);
            }
        }

        return $note;
    }

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
        return $this->belongsTo(ModeleNotation::class, FicheRapport::COL_MODELE_ID);
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
