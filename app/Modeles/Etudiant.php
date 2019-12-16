<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractEtudiant;
use App\Utils\Constantes;

class Etudiant extends AbstractEtudiant
{
    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_DEPARTEMENT_ID = 'departement_id';
    const COL_OPTION_ID      = 'option_id';

    /**
     * @var string Nom de la table associe au modele 'Etudiant'
     */
    const NOM_TABLE = 'etudiants';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;
    
    /**
     * @var string Nom de la table associee au modele 'Etudiant'
     */
    protected $table = Etudiant::NOM_TABLE;

    /**
     * #WIP
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'Etudiant'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        'matricule'   => Constantes::STRING_VIDE, 
        'nom'         => Constantes::STRING_VIDE,
        'prenom'      => Constantes::STRING_VIDE,
        'email'       => Constantes::STRING_VIDE,
        'civilite'    => Constantes::CIVILITE['vide'],
        'inscription' => Constantes::DATE_VIDE,
        'nationalite' => Constantes::NATIONALITE['vide'],
        'formation'   => Constantes::FORMATION['vide'],
        'master'      => Constantes::MASTER['vide'],
        'diplome'     => Constantes::DIPLOME['vide'],
        'annee'       => Constantes::INT_VIDE,
        'mobilite'    => FALSE
    ];

    /**
     * Renvoie le departement auquel appartient l'etudiant
     * @var App\Modeles\Departement
     */
    public function departement()
    {
        return $this->belongsTo('App\Modeles\Departement', Etudiant::COL_DEPARTEMENT_ID);
    }

    /**
     * Renvoie l'option auquel appartient l'etudiant
     * @var App\Modeles\Option
     */
    public function option()
    {
        return $this->belongsTo('App\Modeles\Option', Etudiant::COL_OPTION_ID);
    }

    /**
     * Renvoie la soutenance que l'etudiant doit passer
     * @var App\Modeles\Soutenance
     */
    public function soutenances()
    {
        return $this->hasMany('App\Modeles\Soutenance', Soutenance::COL_ETUDIANT_ID);
    }

    /**
     * Renvoie la liste des stages de l'etudiants
     * @var App\Modeles\Stage
     */
    public function stages()
    {
        return $this->hasMany('App\Modeles\Stage', Stage::COL_ETUDIANT_ID);
    }
}
