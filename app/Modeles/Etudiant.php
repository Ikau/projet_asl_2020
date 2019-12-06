<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractEtudiant;
use App\Utils\Constantes;

class Etudiant extends AbstractEtudiant
{
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;
    
    /**
     * @var string Nom de la table associee au modele 'Etudiant'
     */
    protected $table = 'etudiants';

    /**
     * #WIP
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = ['matricule', 'inscription', 'mobilite'];

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
        'option'      => Constantes::OPTION['vide'],
        'master'      => Constantes::MASTER['vide'],
        'diplome'     => Constantes::DIPLOME['vide'],
        'annee'       => Constantes::INT_VIDE,
        'mobilite'    => FALSE
    ];


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
