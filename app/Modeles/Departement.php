<?php

namespace App\Modeles;

use App\Interfaces\ArrayValeurs;
use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractDepartement;
use App\Utils\Constantes;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;

class Departement extends AbstractDepartement implements ArrayValeurs
{
    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_AUCUN = 'Aucun';
    const VAL_MRI   = 'MRI';
    const VAL_STI   = 'STI';

    /**
     * @inheritDoc
     */
    public static function getValeurs()
    {
        return [
            self::VAL_AUCUN,
            self::VAL_MRI,
            self::VAL_STI
        ];
    }

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_INTITULE = 'intitule';

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
    protected $table = self::NOM_TABLE;

    /**
     * Valeurs par defaut des colonnes du modele 'Contact'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        self::COL_INTITULE => Constantes::STRING_VIDE
    ];

    /**
     * Renvoie les etudiants appartenant au departement
     * @var array[App\Modeles\Etudiant]
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, Etudiant::COL_DEPARTEMENT_ID);
    }

    /**
     * Renvoie l'enseignant responsable du departement
     * @var \App\Modeles\Enseignant
     */
    public function responsable()
    {
        return $this->hasOne(Enseignant::class, Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID);
    }
}
