<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Utils\Constantes;

class Entreprise extends Model
{
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps.
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Entreprise'.
     */
    protected $table = 'entreprises';

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'Entreprise'.
     * 
     * @var array[string]string
     */
    protected $attributes = [
        'nom'      => Constantes::STRING_VIDE,
        'adresse'  => Constantes::STRING_VIDE,
        'adresse2' => Constantes::STRING_VIDE,
        'cp'       => Constantes::STRING_VIDE,
        'ville'    => Constantes::STRING_VIDE,
        'region'   => Constantes::STRING_VIDE,
        'pays'     => Constantes::STRING_VIDE,
    ];

    /**
     * Renvoie la liste des stages associes a l'entreprise
     * @var array[App\Modeles\Stage]
     */
    public function stages()
    {
        return $this->hasMany('App\Modeles\Stage', Stage::COL_ENTREPRISE_ID);
    }
}
