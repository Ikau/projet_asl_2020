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
    /**
     * Creer toutes les fiches liees (vides) a un stage avec les versions appropriees le cas echeant.
     *
     * Par defaut, la fonction devrait automatiquement prendre la version de modele la plus recente.
     *
     * @param int $idStage
     * @param int|null $versionEntreprise
     * @param int|null $versionRapport
     * @param int|null $versionSoutenance
     * @param int|null $versionSynthese
     * @return mixed
     */
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
