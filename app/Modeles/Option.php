<?php 

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractOption;
use App\Utils\Constantes;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;

class Option extends AbstractOption
{
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
    protected $table = Departement::NOM_TABLE;

    /**
     * Valeurs par defaut des colonnes du modele 'Option'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        'intitule' => Constantes::STRING_VIDE
    ];

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