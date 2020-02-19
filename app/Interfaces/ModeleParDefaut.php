<?php 

namespace App\Interfaces;

interface BaseDeDonnees
{
    /**
     * Recupere le modele 'par defaut' present dans la table du modele
     *
     * @return void
     */
    public static function getModeleDefaut();
}
