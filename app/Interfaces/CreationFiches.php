<?php

namespace App\Interfaces;

/**
 * Implemente toutes les fonctions liees a la fiche de rapport
 *
 * Interface CreationFiches
 * @package App\Interfaces
 */
interface CreationFiches
{
    public static function creerFiches(int $idStage,
                                       int $versionEntreprise = null,
                                       int $versionRapport    = null,
                                       int $versionSoutenance = null,
                                       int $versionSynthese   = null
    );

    static function creerEntreprise(int $stageId, int $version = null);
    static function creerRapport(   int $stageId, int $version = null);
    static function creerSoutenance(int $stageId, int $version = null);
    static function creerSynthese(  int $stageId, int $version = null);
}
