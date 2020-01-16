<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractFiche;
use App\Utils\Constantes;

class FicheSoutenance extends AbstractFiche
{
    /*
     * Nom des colonnes des clefs etrangeres 
     */
    const COL_SOUTENANCE_ID = 'soutenance_id';
    const COL_STAGE_ID      = 'stage_id';
    const COL_SYNTHESE_ID   = 'synthese_id';

    /**
     * @var string Nom de la table associe au modele 'FicheSoutenance'
     */
    const NOM_TABLE = 'fiches_soutenance';

    /**
     * @var string Nom de la table associee au model 'FicheSoutenance'
     */
    protected $table = FicheSoutenance::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'FicheSoutenance'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        'malus'        => Constantes::FLOAT_VIDE,
        'note'         => Constantes::FLOAT_VIDE,
        'appreciation' => Constantes::STRING_VIDE,

        // Clefs etrangeres
        FicheSoutenance::COL_SOUTENANCE_ID => Constantes::ID_VIDE,
        FicheSoutenance::COL_STAGE_ID      => Constantes::ID_VIDE,
        FicheSoutenance::COL_SYNTHESE_ID   => Constantes::ID_VIDE,
    ];

    /**
     * Renvoie la soutenance associe a cette fiche de soutenance
     * @var App\Modeles\Soutenance
     */
    public function soutenance()
    {
        return $this->belongsTo('App\Modeles\Soutenance', FicheSoutenance::COL_SOUTENANCE_ID);
    }

    /**
     * Renvoie la fiche synthese liee a cette fiche soutenance
     * @var App\Modeles\FicheSynthese
     */
    public function synthese()
    {
        return $this->belongsTo('App\Modeles\FicheSynthese', FicheSoutenance::COL_SYNTHESE_ID);
    }

    /**
     * Renvoie le stage associe a cette fiche soutenance
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->belongsTo('App\Modeles\Stage', FicheSoutenance::COL_STAGE_ID);
    }

}
