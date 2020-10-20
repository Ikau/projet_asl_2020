<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractDepartement;
use App\Interfaces\ArrayValeurs;
use App\Utils\Constantes;

class Departement extends AbstractDepartement implements ArrayValeurs
{
    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_MRI = 'MRI';
    const VAL_STI = 'STI';

    /**
     * @inheritDoc
     */
    public static function getValeurs()
    {
        return [
            self::VAL_MRI,
            self::VAL_STI
        ];
    }

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associe au modele 'Departement'
     */
    const NOM_TABLE = 'departements';

    /**
     * @var string Nom de la table associee au modele 'Contact'
     */
    protected $table = self::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_INTITULE = 'intitule';

    /*
     * Nom des clefs etrangeres dans la base de donnees
     */
    const COL_RESPONSABLE_ID = 'responsable_id';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;


    /**
     * Valeurs par defaut des colonnes du modele 'Contact'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        self::COL_INTITULE       => Constantes::STRING_VIDE,
        self::COL_RESPONSABLE_ID => null
    ];

    /* ====================================================================
     *                          RELATIONS ELOQUENT
     * ====================================================================
     */
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
        return $this->belongsTo(Enseignant::class, self::COL_RESPONSABLE_ID);
    }
}
