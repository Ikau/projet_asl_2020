<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractContact;
use App\Utils\Constantes;

class Contact extends AbstractContact
{
    /**
     * @var string Nom de la table associe au modele 'Contact'
     */
    const NOM_TABLE = 'contacts';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Contact'
     */
    protected $table = Contact::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'Contact'
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        'nom'       => Constantes::STRING_VIDE,
        'prenom'    => Constantes::STRING_VIDE,
        'civilite'  => Constantes::CIVILITE['vide'],
        'type'      => Constantes::TYPE_CONTACT['vide'],
        'mail'      => Constantes::STRING_VIDE,
        'telephone' => Constantes::STRING_VIDE,
        'adresse'   => Constantes::STRING_VIDE        
    ];

    /**
     * Renvoie la liste des soutenances ou le contact est la scolarite INSA
     * @var array[App\Modeles\FicheEntreprise]
     */
    public function fiches_entreprise()
    {
        return $this->hasMany('App\Modeles\FicheEntreprise', FicheEntreprise::COL_CONTACT_INSA_ID);
    }

    /**
     * Remplace les valeurs 'null' par les valeurs par défaut le cas echeant.
     * @return void
     */
    public function nullToDefault() : void
    {
        if($this->nom       === null) { $this->nom       = Constantes::STRING_VIDE;}
        if($this->prenom    === null) { $this->prenom    = Constantes::STRING_VIDE;}
        if($this->civilite  === null) { $this->civilite  = Constantes::CIVILITE['vide'];}
        if($this->type      === null) { $this->type      = Constantes::TYPE_CONTACT['vide'];}
        if($this->mail      === null) { $this->mail      = Constantes::STRING_VIDE;}
        if($this->telephone === null) { $this->telephone = Constantes::STRING_VIDE;}
        if($this->adresse   === null) { $this->adresse   = Constantes::STRING_VIDE ;}
    }

    /**
     * Renvoie la liste des soutenances ou le contact est maitre de stage
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_mds()
    {
        return $this->hasMany('App\Modeles\Soutenance', Soutenance::COL_CONTACT_ENTREPRISE_ID);
    }

    /**
     * Renvoie la liste des stages ou le contact est maitre de stage
     * @var array[App\Modeles\Stage]
     */
    public function stages_mds()
    {
        return $this->hasMany('App\Modeles\Stage', Stage::COL_MDS_ID);
    }
    
}
