<?php 

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractDepartement;
use App\Utils\Constantes;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;

class Departement extends AbstractDepartement
{
    /**
     * @var string Nom de la table associe au modele 'Departement'
     */
    const NOM_TABLE = 'departements';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Contact'
     */
    protected $table = Departement::NOM_TABLE;

    /**
     * Valeurs par defaut des colonnes du modele 'Contact'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        'intitule' => Constantes::STRING_VIDE
    ];

    /**
     * Renvoie les etudiants appartenant au departement
     * @var array[App\Modeles\Etudiant]
     */
    public function etudiants()
    {
        return $this->hasMany('App\Modeles\Etudiant', Etudiant::COL_DEPARTEMENT_ID);
    }

    /**
     * Renvoie l'enseignant responsable du departement
     * @var App\Modeles\Enseignant
     */
    public function responsable()
    {
        return $this->hasOne('App\Modeles\Enseignant', Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID);
    }
}