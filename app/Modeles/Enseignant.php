<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Utils\Constantes;

class Enseignant extends Model
{
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Enseignant'
     */
    protected $table = 'enseignants';

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = ['responsable_option'];

    /**
     * Valeurs par defaut des colonnes du modele 'Enseignant'
     * 
     * @var array[string]string
     */
    protected $attributes = [
        'nom'                => Constantes::STRING_VIDE,
        'prenom'             => Constantes::STRING_VIDE,
        'email'              => Constantes::STRING_VIDE,
        'responsable_option' => Constantes::STRING_VIDE,
    ];


    /**
     * Renvoie la liste des stages dont l'enseignant est referent.
     * @var array[App\Modeles\Stage]
     */
    public function stages()
    {
        return $this->hasMany('App\Modeles\Stage', Stage::COL_REFERENT_ID);
    }

    /**
     * Renvoie la liste des soutenances dont l'enseignant est referent.
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_referent()
    {
        return $this->hasMany('App\Modeles\Soutenance', Soutenance::COL_REFERENT_ID);
    }

    /**
     * Renvoie la liste des soutenances dont l'enseignant est candide.
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_candide()
    {
        return $this->hasMany('App\Modeles\Soutenance', Soutenance::COL_CANDIDE_ID);
    }
}
