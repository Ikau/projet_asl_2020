<?php 

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractOption;
use App\Utils\Constantes;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;

class Option extends AbstractOption
{

    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_DEPARTEMENT_ID = 'departement_id';

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_INTITULE = 'intitule';

    /**
     * @var string Nom de la table associe au modele 'option'
     */
    const NOM_TABLE = 'options';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Option'
     */
    protected $table = Option::NOM_TABLE;

    /**
     * Valeurs par defaut des colonnes du modele 'Option'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        Option::COL_INTITULE => Constantes::STRING_VIDE
    ];

    /**
     * Renvoie le departement auquel est rattache l'option
     * @var App\Modeles\Departement
     */
    public function departement()
    {
        return $this->belongsTo('App\Modeles\Departement', Option::COL_DEPARTEMENT_ID);
    }

    /**
     * Renvoie les etudiants appartenant a l'option
     * @var array[App\Modeles\Etudiant]
     */
    public function etudiants()
    {
        return $this->hasMany('App\Modeles\Etudiant', Etudiant::COL_OPTION_ID);
    }

    /**
     * Renvoie l'enseignant responsable de l'option
     * @var App\Modeles\Enseignant
     */
    public function responsable()
    {
        return $this->hasOne('App\Modeles\Enseignant', Enseignant::COL_RESPONSABLE_OPTION_ID);
    }
}