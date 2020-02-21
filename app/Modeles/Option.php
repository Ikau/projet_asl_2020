<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractOption;
use App\Interfaces\ArrayValeurs;
use App\Utils\Constantes;

class Option extends AbstractOption implements ArrayValeurs
{
    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_AUCUN    = 'Aucune';

    const VAL_STI_2SU  = '2SU';
    const VAL_STI_4AS  = '4AS';
    const VAL_STI_ASL  = 'ASL';

    const VAL_MRI_RAI  = 'RAI';
    const VAL_MRI_RE   = 'RE';
    const VAL_MRI_RSI  = 'RSI';
    const VAL_MRI_SFEN = 'SFEN';
    const VAL_MRI_STLR = 'STLR';

    /**
     * @inheritDoc
     */
    public static function getValeurs()
    {
        return [
            self::VAL_AUCUN,
            self::VAL_STI_2SU,
            self::VAL_STI_4AS,
            self::VAL_STI_ASL,
            self::VAL_MRI_RAI,
            self::VAL_MRI_RE,
            self::VAL_MRI_RSI,
            self::VAL_MRI_SFEN,
            self::VAL_MRI_STLR,
        ];
    }


    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associe au modele 'option'
     */
    const NOM_TABLE = 'options';

    /**
     * @var string Nom de la table associee au modele 'Option'
     */
    protected $table = self::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_INTITULE = 'intitule';

    /*
     * Nom des clefs etrangeres dans la base de donnees
     */
    const COL_DEPARTEMENT_ID = 'departement_id';
    const COL_RESPONSABLE_ID = 'responsable_id';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * Valeurs par defaut des colonnes du modele 'Option'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        self::COL_INTITULE       => Constantes::STRING_VIDE,
        self::COL_DEPARTEMENT_ID => Constantes::ID_VIDE
    ];

    /**
     * Renvoie le departement auquel est rattache l'option
     * @var App\Modeles\Departement
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class, self::COL_DEPARTEMENT_ID);
    }

    /**
     * Renvoie les etudiants appartenant a l'option
     * @var array[App\Modeles\Etudiant]
     */
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, Etudiant::COL_OPTION_ID);
    }

    /**
     * Renvoie l'enseignant responsable de l'option
     * @var App\Modeles\Enseignant
     */
    public function responsable()
    {
        return $this->belongsTo(Enseignant::class, self::COL_RESPONSABLE_ID);
    }
}
