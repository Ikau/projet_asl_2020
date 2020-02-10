<?php

namespace App\Modeles\Fiches;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\Fiches\AbstractFiche;
use App\Utils\Constantes;

class FicheEntreprise extends AbstractFiche
{
    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_CONTACT_INSA_ID = 'contact_insa_id';
    const COL_SYNTHESE_ID     = 'synthese_id';
    const COL_STAGE_ID        = 'stage_id';

    /**
     * @var string Nom de la table associe au modele 'FicheEntreprise'
     */
    const NOM_TABLE = 'fiches_entreprise';

    /**
     * @var string Nom de la table associee au modele 'FicheEntreprise'.
     */
    protected $table = FicheEntreprise::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'FicheEntreprise'.
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modeles
        'signature'           => FALSE,
        'date_limite'         => Constantes::DATE_VIDE,
        'fonction_signataire' => Constantes::STRING_VIDE,
        'date'                => Constantes::DATE_VIDE,
        'appreciation'        => Constantes::STRING_VIDE,
        'note_entreprise'     => Constantes::FLOAT_VIDE,
        'note_tuteur'         => Constantes::FLOAT_VIDE,

        // Clefs etrangeres
        FicheEntreprise::COL_CONTACT_INSA_ID => Constantes::ID_VIDE,
        FicheEntreprise::COL_STAGE_ID        => Constantes::ID_VIDE,
        FicheEntreprise::COL_SYNTHESE_ID     => Constantes::ID_VIDE,
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
     * Renvoie le contact INSA qui s'occupe des fiches entreprises.
     * @var App\Modeles\Contact
     */
    public function contact_insa()
    {
        return $this->belongsTo('App\Modeles\Contact', FicheEntreprise::COL_CONTACT_INSA_ID);
    }

    /**
     * Renvoie la fiche synthese liee a cette fiche entreprise
     * @var App\Modeles\FicheSynthese
     */
    public function synthese()
    {
        return $this->belongsTo('App\Modeles\FicheSynthese', FicheEntreprise::COL_SYNTHESE_ID);
    }

    /**
     * Renvoie le stage associe a cette fiche entreprise
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->belongsTo('App\Modeles\Stage', FicheEntreprise::COL_STAGE_ID);
    }
}
