<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractEtudiant;
use App\Utils\Constantes;

class Etudiant extends AbstractEtudiant
{
    /*
     * Nom des colonnes dans la base de donnees
     */
    //const COL_MATRICULE = 'matricule';
    const COL_NOM       = 'nom';
    const COL_PRENOM    = 'prenom';
    const COL_EMAIL     = 'email';
    //const COL_CIVILITE  = 'civilite';
    //const COL_INSCRIPTION = 'inscription';
    //const COL_NATIONALITE = 'nationalite';
    //const COL_FORMATION   = 'formation';
    //const COL_MASTER = 'master';
    //const COL_DIPLOME  = 'diplome';
    const COL_ANNEE    = 'annee';
    const COL_MOBILITE = 'mobilite';

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
        //Etudiant::COL_MATRICULE     => Constantes::STRING_VIDE, 
        Etudiant::COL_NOM           => Constantes::STRING_VIDE,
        Etudiant::COL_PRENOM        => Constantes::STRING_VIDE,
        Etudiant::COL_EMAIL         => Constantes::STRING_VIDE,
        //Etudiant::COL_CIVILITE      => Constantes::CIVILITE['vide'],
        //Etudiant::COL_INSCRIPTION   => Constantes::DATE_VIDE,
        //Etudiant::COL_NATIONALITE   => Constantes::NATIONALITE['vide'],
        //Etudiant::COL_FORMATION     => Constantes::FORMATION['vide'],
        //Etudiant::COL_MASTER        => Constantes::MASTER['vide'],
        //Etudiant::COL_DIPLOME       => Constantes::DIPLOME['vide'],
        Etudiant::COL_ANNEE         => Constantes::INT_VIDE,
        Etudiant::COL_MOBILITE      => FALSE,
        
        Etudiant::COL_DEPARTEMENT_ID => Constantes::ID_VIDE,
        Etudiant::COL_OPTION_ID      => Constantes::ID_VIDE
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
