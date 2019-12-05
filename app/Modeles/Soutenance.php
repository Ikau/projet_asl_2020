<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Utils\Constantes;

class Soutenance extends Model
{
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps.
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Soutenance'.
     */
    protected $table = 'soutenances';

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];
    
    /**
     * Valeurs par defaut des colonnes du modele 'Soutenance'.
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        'commentaire'           => Constantes::STRING_VIDE,
        'invites'               => Constantes::STRING_VIDE,
        'repas'                 => Constantes::INT_VIDE,
        'salle'                 => Constantes::STRING_VIDE,
        'heure'                 => Constantes::HEURE_VIDE,
        'date'                  => Constantes::DATE_VIDE,
        'departement_ou_option' => Constantes::STRING_VIDE,
        'nom_entreprise'        => Constantes::STRING_VIDE,
        'annee_etudiant'        => Constante::INT_VIDE,
        'campus'                => Constantes::STRING_VIDE,
        'confidentielle'        => FALSE
    ];
}
