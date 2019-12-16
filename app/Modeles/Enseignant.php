<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractEnseignant;
use App\Utils\Constantes;

class Enseignant extends AbstractEnseignant
{
    /**
     * @var string Nom de la table associe au modele 'Enseignant'
     */
    const NOM_TABLE = 'enseignants';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Enseignant'
     */
    protected $table = Enseignant::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = [
        'id', 
        'stages', 
        'soutenances_referent',
        'soutenances_candide'
    ];

    /**
     * Valeurs par defaut des colonnes du modele 'Enseignant'
     * 
     * @var array[string]string
     */
    protected $attributes = [
        'nom'                     => Constantes::STRING_VIDE,
        'prenom'                  => Constantes::STRING_VIDE,
        'email'                   => Constantes::STRING_VIDE,
        'responsable_option'      => Constantes::OPTION['vide'],
        'responsable_departement' => Constantes::DEPARTEMENT['vide']
    ];

    /**
     * Renvoie la liste des soutenances dont l'enseignant est candide.
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_candide()
    {
        return $this->hasMany('App\Modeles\Soutenance', Soutenance::COL_CANDIDE_ID);
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
     * Renvoie la liste des stages dont l'enseignant est referent.
     * @var array[App\Modeles\Stage]
     */
    public function stages()
    {
        return $this->hasMany('App\Modeles\Stage', Stage::COL_REFERENT_ID);
    }
}
