<?php

namespace App\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\Fiches\AbstractFiche;
use App\Utils\Constantes;

class FicheSynthese extends AbstractFiche
{

    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_STAGE_ID = 'stage_id';

    /**
     * @var string Nom de la table associe au modele 'FicheSynthese'
     */
    const NOM_TABLE = 'fiches_synthese';

    /**
     * @var string Nom de la table associee au modele 'FicheSynthese'.
     */
    protected $table = FicheSynthese::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'FicheSynthese'.
     *
     * @var array[string]float
     */
    protected $attributes = [
        // Attributs propres au modele
        'total_points' => Constantes::FLOAT_VIDE,
        'modifieur'    => Constantes::FLOAT_VIDE,
        'note_brute'   => Constantes::FLOAT_VIDE,
        'note_finale'  => Constantes::FLOAT_VIDE,

        // Clefs etrangeres
        FicheSynthese::COL_STAGE_ID => Constantes::ID_VIDE,
    ];

    /**
     * Renvoie le stage associe a cette fiche synthese
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->belongsTo('App\Modeles\Stage', FicheSynthese::COL_STAGE_ID);
    }

    /**
     * Renvoie la fiche d'evaluation entreprise liee a cette synthese
     * @var App\Modeles\FicheEntreprise
     */
    public function fiche_entreprise()
    {
        return $this->hasOne('App\Modeles\FicheEntreprise', FicheEntreprise::COL_SYNTHESE_ID);
    }

    /**
     * Renvoie la fiche d'evaluation rapport liee a cette synthese
     * @var App\Modeles\FicheRapport
     */
    public function fiche_rapport()
    {
        return $this->hasOne('App\Modeles\FicheRapport', FicheRapport::COL_SYNTHESE_ID);
    }

    /**
     * Renvoie la fiche d'evaluation soutenance liee a cette synthese
     * @var App\Modeles\FicheSoutenance
     */
    public function fiche_soutenance()
    {
        return $this->hasOne('App\Modeles\FicheSoutenance', FicheSoutenance::COL_SYNTHESE_ID);
    }
}
