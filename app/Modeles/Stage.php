<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Utils\Constantes;

class Stage extends Model
{
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au model 'Stage'.
     */
    protected $table = 'stages';

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'Stage'.
     */
    protected $attributes = [
        'annee_etudiant'                => Constantes::INT_VIDE,
        'date_debut'                    => Constantes::DATE_VIDE,
        'date_fin'                      => Constantes::DATE_VIDE,
        'sujet'                         => Constantes::STRING_VIDE,
        'convention_envoyee_entreprise' => FALSE,
        'retour_convention_signee'      => FALSE,
        'gratification'                 => Constantes::FLOAT_VIDE,
        'nombre_de_semaines'            => Constantes::INT_VIDE,
        'moyen_recherche_stage'         => Constantes::STRING_VIDE
    ];
}
