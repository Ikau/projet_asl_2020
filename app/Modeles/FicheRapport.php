<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractFiche;
use App\Utils\Constantes;

class FicheRapport extends AbstractFiche
{
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
     * @var string Nom de la table associee au modele 'FicheRapport'.
     */
    protected $table = FicheRapport::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'FicheRapport'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        'appreciation' => Constantes::STRING_VIDE,
        'note'         => Constantes::FLOAT_VIDE,

        // Clefs etrangeres
        FicheRapport::COL_SYNTHESE_ID => Constantes::ID_VIDE,
        FicheRapport::COL_STAGE_ID    => Constantes::ID_VIDE,
    ];

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
