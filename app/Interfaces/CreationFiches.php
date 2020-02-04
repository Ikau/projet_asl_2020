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
    public static function creerFiches(int $stageId);

    static function creerEntreprise(int $stageId);
    static function creerRapport(int $stageId, int $idSynthese);
    static function creerSoutenance(int $stageId);
    static function creerSynthese(int $stageId) : int;
}
