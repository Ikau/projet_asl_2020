<?php

namespace App\Modeles\Fiches;

use App\Abstracts\Modeles\Fiches\AbstractSection;
use App\Utils\Constantes;

class Section extends AbstractSection
{
    /* ====================================================================
     *                          VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_INDEX_CRITERE_POINTS   = 0;
    const VAL_INDEX_CRITERE_INTITULE = 1;


    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associee au modele 'Section'
     */
    const NOM_TABLE = 'sections';

    /**
     * On indique explicitement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = self::NOM_TABLE;

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_CHOIX    = 'choix';
    const COL_CRITERES = 'criteres';
    const COL_INTITULE = 'intitule';
    const COL_ORDRE    = 'ordre';

    /*
     * Nom des colonnes des clefs etrangeres de Section
     */
    const COL_MODELE_ID = 'modele_id';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     */
    public $timestamps = false;

    /* ====================================================================
     *                            PROPRIETES
     * ====================================================================
     */
    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Indique a Laravel quelles proprietes sont a caster vers des types utilisables
     * @var array
     */
    protected $casts = [
        self::COL_CHOIX    => 'array',
        self::COL_CRITERES => 'array'
    ];

    /**
     * Valeurs par defaut des colonnes du modele 'ModeleNotation'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_CHOIX     => Constantes::STRING_VIDE,
        self::COL_CRITERES  => Constantes::STRING_VIDE,
        self::COL_INTITULE  => Constantes::STRING_VIDE,
        self::COL_MODELE_ID => Constantes::ID_VIDE,
        self::COL_ORDRE     => Constantes::INT_VIDE
    ];

    /* ====================================================================
     *                       FONCTIONS AUXILIAIRES
     * ====================================================================
     */
    /**
     * Renvoie le nombre de points obtenables dans la section
     * @return float
     */
    public function getBareme() : float
    {
        // Recuperation des donnees
        $criteres  = $this->criteres;
        $maxPoints = $this->getMaxPointsParCriteres();

        return $maxPoints * count($criteres);
    }

    /**
     * Renvoie la note totale de la section
     *
     * L'array de notation devrait etre de la meme taille que l'array 'criteres'
     * et contient l'index des choix effectues pour chaque critere :
     * $notation === [index, ..., index]
     *
     * @param $notation array Array de notation conforme au format de la section
     * @return float Le nombre total de points obtenues dans la section
     */
    public function getNoteSection(array $notation) : float
    {
        // Recuperation des donnees
        $choix = $this->choix;

        // Calcul
        $noteSection = 0.0;
        foreach($notation as $index)
        {
            if(-1 !== $index)
            {
                $noteSection += $choix[$index][self::VAL_INDEX_CRITERE_POINTS];
            }
        }

        return $noteSection;
    }

    /**
     * Renvoie l'intitule du choix a l'index indiquee
     * @param int $indexChoix L'index du choix dont on cherche l'intitule
     * @return string
     */
    public function getIntitule(int $indexChoix) : string
    {
        // Recuperation de l'array
        $choix = $this->choix;

        return $choix[$indexChoix][self::VAL_INDEX_CRITERE_INTITULE];
    }

    /**
     * Renvoie le nombre de points associe à l'index du critere en argument
     *
     * @param int $indexChoix L'index du choix des points
     * @return float Le nombre de points attribues
     */
    public function getPoints(int $indexChoix): float
    {
        // Recuperation de l'array
        $choix = $this->choix;

        return $choix[$indexChoix][self::VAL_INDEX_CRITERE_POINTS];
    }

    /* ====================================================================
     *                            RELATIONS
     * ====================================================================
     */
    /**
     * Renvoie le modele de la fiche auquel est lie cette section
     */
    public function modeleNotation()
    {
        return $this->belongsTo(ModeleNotation::class, Section::COL);
    }

    /* ====================================================================
     *                         FONCTIONS PRIVEES
     * ====================================================================
     */
    /**
     * Itere sur l'ensemble des points obtenables et renvoie la plus haute
     * valeur attribuable
     *
     * @return float Nom de points maximal par criteres
     */
    private function getMaxPointsParCriteres() : float
    {
        // Recuperation des choix
        $choix = $this->choix;

        // Iteration pour trouver le max
        $max = 0.0;
        foreach($choix as $index => $array)
        {
            $valeurCourante = $array[self::VAL_INDEX_CRITERE_POINTS];
            if($valeurCourante > $max)
            {
                $max = $valeurCourante;
            }
        }

        return $max;
    }
}
