<?php

namespace App\Utils;

/**
 * Classe contenant toutes les constantes utilisées par le projet.
 * 
 * Pour l'instant, les constantes sont écrites en dur.
 * Il faudra implémenter une fonction qui charge les constantes depuis un fichier externe.
 * Le fichier externe devra être humainement visible (.txt, .csv, .cfg, .yaml...).
 */
class Constantes
{

    /*
     * Valeurs par defaut lorsque vide
     */
    const FLOAT_VIDE  = 0.0;
    const INT_VIDE    = 0;
    const STRING_VIDE = '';
    const DATE_VIDE   = '2000-01-01';
    const HEURE_VIDE  = '00:00:00';

    /**
     * @var array[string]string Indique la civilite du contact
     */
    const CIVILITE = [
        'vide'     => '',
        'madame'   => 'madame',
        'monsieur' => 'monsieur'
    ];

    /**
     * @var array[string]string Diplome prepare par l'etudiant
     */
    const DIPLOME = [
        'vide' => '',
        'STI'  => 'STI',
        'MRI'  => 'MRI'
    ];

    /**
     * @var array[string]string Formation suivie par l'etudiant
     */
    const FORMATION = [
        'vide' => '',
        'STI'  => 'STI',
        'MRI'  => 'MRI'
    ];

    /**
     * @var array[string]string Master suivie par l'etudiant
     */
    const MASTER = [
        'vide'    => '',
        'aucun'   => 'aucun',
        'master1' => 'master1'
    ];

    /**
     * @var array[string]string Nationnalite de l'etudiant
     */
    const NATIONALITE = [
        'vide'      => '',
        'francaise' => 'francaise'
    ];

    /**
     * @var array[string]string Option suivie par l'etudiant
     */
    const OPTION = [
        'vide' => '',
        'MRI'  => [
            'opt1' => 'opt1',
            'opt2' => 'opt2'
        ],
        'STI'  => [
            '2SU' => '2SU',
            '4AS' => '4AS',
            'ASL' => 'ASL'
        ]
    ];

    /**
     * @var array[string]string Indique le type de contact
     */
    const TYPE_CONTACT = [
        'vide'                => '',
        'administration_insa' => 'administration_insa',
        'entreprise'          => 'entreprise',
        'maitre_de_stage'     => 'maitre_de_stage'
    ];
}
