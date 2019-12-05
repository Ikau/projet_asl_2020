<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Utils\Constantes;

class Contact extends Model
{
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Contact'
     */
    protected $table = 'contacts';

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = ['type'];

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
}
