<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractFiche;
use App\Utils\Constantes;

class FicheRapport extends AbstractFiche
{
    /**
     * @var string Nom de la table associee au modele 'FicheRapport'.
     */
    protected $table = 'fiches_rapport';

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
        'appreciation' => Constantes::STRING_VIDE,
        'note'         => Constantes::FLOAT_VIDE
    ];
}
