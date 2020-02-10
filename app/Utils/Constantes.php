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
    const ID_VIDE     = -1;
    const FLOAT_VIDE  = 0.0;
    const INT_VIDE    = 0;
    const STRING_VIDE = '';
    const DATE_VIDE   = '2000-01-01';
    const HEURE_VIDE  = '00:00:00';

    /*
     * Valeurs des gates pour l'utilisation des differents regles
     * Pour rappel : les gates sont enregistres dans App\Provider\AuthServiceProvider
     */
    const GATE_ROLE_RESPONSABLE = 'role-responsable';
    const GATE_ROLE_ENSEIGNANT  = 'role-enseignant';

    /*
     * Valeurs des classes sans modele cree par l'Eloquent Factory (utiliser ->raw() )
     */
    const FACTORY_CHOIX_SECTION     = 'ChoixSection';
    const FACTORY_CRITERES_SECTION  = 'CritereSection';

    /**
     * @var array[string]int Contient les index minimaux des constantes
     */
    const MIN = [
        'civilite'     => 0,
        'diplome'      => 0,
        'type_contact' => 0,
    ];

    /**
     * @var array[string]int Contient les index minimaux des constantes
     */
    const MAX = [
        'civilite'     => 2,
        'diplome'      => 2,
        'type_contact' => 3,
    ];

    /**
     * @var array[string]string Indique la civilite du contact
     */
    const CIVILITE = [
        'vide'     => 0,
        'Madame'   => 1,
        'Monsieur' => 2,
    ];

    /**
     * @var array[string]string Diplome prepare par l'etudiant
     */
    const DIPLOME = [
        'vide' => 0,
        'STI'  => 1,
        'MRI'  => 2
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
        'francaise' => 'française'
    ];

    /**
     * @var array[string]string Indique le type de contact
     */
    const TYPE_CONTACT = [
        'vide'            => 0,
        'insa'            => 1,
        'entreprise'      => 2,
        'maitre_de_stage' => 3,
    ];
}
