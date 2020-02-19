<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractEntreprise;
use App\Utils\Constantes;

class Entreprise extends AbstractEntreprise
{
    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /*
     * Nom des colonnes dans la base de donnees
     */
    // Attributs obligatoire
    const COL_NOM      = 'nom';
    const COL_ADRESSE  = 'adresse';
    const COL_VILLE    = 'ville';
    const COL_PAYS     = 'pays';

    // Attributs optionnels
    const COL_ADRESSE2 = 'adresse2';
    const COL_CP       = 'cp';
    const COL_REGION   = 'region';

    /**
     * @var string Nom de la table associe au modele 'Entreprise'
     */
    const NOM_TABLE = 'entreprises';

    /**
     * @var string Nom de la table associee au modele 'Entreprise'.
     */
    protected $table = self::NOM_TABLE;

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     *
     * @var bool Gestion des timestamps.
     */
    public $timestamps = false;


    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'Entreprise'.
     *
     * @var array[string]string
     */
    protected $attributes = [
        self::COL_NOM      => Constantes::STRING_VIDE,
        self::COL_ADRESSE  => Constantes::STRING_VIDE,
        self::COL_ADRESSE2 => Constantes::STRING_VIDE,
        self::COL_CP       => Constantes::STRING_VIDE,
        self::COL_VILLE    => Constantes::STRING_VIDE,
        self::COL_REGION   => Constantes::STRING_VIDE,
        self::COL_PAYS     => Constantes::STRING_VIDE,
    ];

    /**
     * Renvoie la liste des stages associes a l'entreprise
     * @var array[App\Modeles\Stage]
     */
    public function stages()
    {
        return $this->hasMany(Stage::class, Stage::COL_ENTREPRISE_ID);
    }
}
