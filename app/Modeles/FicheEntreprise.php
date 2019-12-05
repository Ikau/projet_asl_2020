<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractFiche;
use App\Utils\Constantes;

class FicheEntreprise extends AbstractFiche
{
    /**
     * @var string Nom de la table associee au modele 'FicheEntreprise'.
     */
    protected $table = 'fiches_entreprise';

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
        'signature'            => FALSE,
        'date_limite'         => Constantes::DATE_VIDE,
        'fonction_signataire' => Constantes::STRING_VIDE,
        'date'                => Constantes::DATE_VIDE,
        'appreciation'        => Constantes::STRING_VIDE,
        'note_entreprise'     => Constantes::FLOAT_VIDE,
        'note_tuteur'         => Constantes::FLOAT_VIDE
    ];
}
