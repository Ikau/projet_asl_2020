<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractEnseignant;
use App\Interfaces\BaseDeDonnees;
use App\Utils\Constantes;

class Enseignant extends AbstractEnseignant implements BaseDeDonnees
{
    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_NOM    = 'nom';
    const COL_PRENOM = 'prenom';
    const COL_EMAIL  = 'email';

    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_RESPONSABLE_DEPARTEMENT_ID = 'departement_id';
    const COL_RESPONSABLE_OPTION_ID      = 'option_id';

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
    ];

    /**
     * Valeurs par defaut des colonnes du modele 'Enseignant'
     * 
     * @var array[string]string
     */
    protected $attributes = [
        Enseignant::COL_NOM                        => Constantes::STRING_VIDE,
        Enseignant::COL_PRENOM                     => Constantes::STRING_VIDE,
        Enseignant::COL_EMAIL                      => Constantes::STRING_VIDE,
        
        Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => Constantes::ID_VIDE,
        Enseignant::COL_RESPONSABLE_OPTION_ID      => Constantes::ID_VIDE
    ];

    /* ====================================================================
     *                            INTERFACE
     * ====================================================================
     */
    public static function getModeleDefaut()
    {
        $clauseWhere = [
            ['nom', '=', ''],
            ['prenom', '=', 'Aucun'],
            ['email', '=', 'aucun@null.com']
        ];

        return Enseignant::where($clauseWhere)->first();
    }

    /* ====================================================================
     *                             RELATIONS
     * ====================================================================
     */

    /**
     * Renvoie l'option dont l'enseignant est responsable
     * @var array[App\Modeles\Option]
     */
    public function responsable_option()
    {
        return $this->belongsTo('App\Modeles\Option', Enseignant::COL_RESPONSABLE_OPTION_ID);
    }

    /**
     * Renvoie le departement dont l'enseignant est responsable
     * @var array[App\Modeles\Departement]
     */
    public function responsable_departement()
    {
        return $this->belongsTo('App\Modeles\Departement', Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID);
    }

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
