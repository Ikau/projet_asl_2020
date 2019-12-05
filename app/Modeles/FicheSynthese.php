<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractFiche;
use App\Utils\Constantes;

class FicheSynthese extends AbstractFiche
{
    /**
     * @var string Nom de la table associee au modele 'FicheSynthese'.
     */
    protected $table = 'fiches_synthese';

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
        'total_points' => Constantes::FLOAT_VIDE,
        'modifieur'    => Constantes::FLOAT_VIDE,
        'note_brute'   => Constantes::FLOAT_VIDE,
        'note_finale'  => Constantes::FLOAT_VIDE
    ];
}
