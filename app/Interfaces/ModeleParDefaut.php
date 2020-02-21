<?php

namespace App\Interfaces;

/**
 * L'interface proposee indique que le modele possede une modele par defaut.
 *
 * Dans l'architecture actuelle, il est necessaire d'avoir des champs "vide".
 *
 * @package App\Interfaces
 */
interface ModeleParDefaut
{
    /**
     * Recupere le modele 'par defaut' present dans la table du modele
     *
     * @return void
     */
    public static function getModeleDefaut();
}
