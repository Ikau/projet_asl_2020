<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractFiche;
use App\Utils\Constantes;

class FicheSoutenance extends AbstractFiche
{
    /**
     * @var string Nom de la table associee au model 'FicheSoutenance'
     */
    protected $table = "fiches_soutenance";

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
        'malus'        => Constantes::FLOAT_VIDE,
        'note'         => Constantes::FLOAT_VIDE,
        'appreciation' => Constantes::STRING_VIDE
    ];

}
