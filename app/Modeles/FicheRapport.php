<?php

namespace App\Modeles;

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
    const COL_VERSION      = 'version';

    /*
     * Nom des colonnes des clefs etrangeres
     */
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
        'appreciation' => Constantes::STRING_VIDE,
        'note'         => Constantes::FLOAT_VIDE,

        // Clefs etrangeres_
        FicheRapport::COL_SYNTHESE_ID => Constantes::ID_VIDE,
        FicheRapport::COL_STAGE_ID    => Constantes::ID_VIDE,
    ];

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
