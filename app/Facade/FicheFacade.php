<?php

namespace App\Facade;

use App\Interfaces\CreationFiches;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\ModeleNotation;
use App\Utils\Constantes;

class FicheFacade implements CreationFiches
{
    /* ====================================================================
     *                 FONCTIONS DE CREATION DES FICHES
     * ====================================================================
     */
    /**
     * Cree de nouvelles fiches vides avec la versions demandee le cas echant pour le stage donne
     *
     * Si aucune version n'est demandee, recupere la derniere version en date
     *
     * @param int $idStage
     * @param int|null $versionEntreprise
     * @param int|null $versionRapport
     * @param int|null $versionSoutenance
     * @param int|null $versionSynthese
     */
    public static function creerFiches(int $idStage,
                                       int $versionEntreprise = null,
                                       int $versionRapport    = null,
                                       int $versionSoutenance = null,
                                       int $versionSynthese   = null)
    {
        self::creerEntreprise($idStage, $versionEntreprise);
        self::creerRapport($idStage, $versionRapport);
        self::creerSoutenance($idStage, $versionSoutenance);
        self::creerSynthese($idStage, $versionSynthese);
    }

    /**
     * Cree une nouevelle fiche de notation entreprise avec la version demandee pour le stage donne
     *
     * @param int $stageId
     * @param int|null $version
     */
    static function creerEntreprise(int $stageId, int $version = null)
    {
        // TODO: Implement creerEntreprise() method.
    }

    /**
     * Cree une nouvelle fiche de notation de rapport avec la version demandee pour le stage donne
     *
     * @param int $idStage
     * @param int|null $version
     */
    static function creerRapport(int $idStage, int $version = null)
    {
        // Clause where
        $clauseWhere = [[ModeleNotation::COL_TYPE, '=', ModeleNotation::VAL_RAPPORT]];
        if(null !== $version)
        {
            $clauseWhere[] = [ModeleNotation::COL_VERSION, '=', $version];
        }

        // Recuperation du modele avec la derniere version ou celle souhaitee
        $modele = ModeleNotation::where($clauseWhere)
            ->orderBy(ModeleNotation::COL_VERSION, 'desc')
            ->take(1)
            ->first();

        // Creation de la fiche de rapport
        if( null !== $modele )
        {
            $ficheRapport = new FicheRapport();

            $ficheRapport->fill([
                FicheRapport::COL_CONTENU     => self::creerContenuVide($modele),
                FicheRapport::COL_MODELE_ID   => $modele->id,
                FicheRapport::COL_STAGE_ID    => $idStage,
                FicheRapport::COL_STATUT      => FicheRapport::VAL_STATUT_NOUVELLE
            ]);

            $ficheRapport->save();
        }
    }

    /**
     * Cree une nouvelle fiche de notation de soutenance avec la version demandee pour le stage donne
     *
     * @param int $stageId
     * @param int|null $version
     */
    static function creerSoutenance(int $stageId, int $version = null)
    {
        // TODO: Implement creerSoutenance() method.
    }

    static function creerSynthese(int $stageId, int $version = null)
    {
        // TODO: Implement creerSoutenance() method.
    }

    /* ====================================================================
     *                        FONCTIONS UTILITAIRE
     * ====================================================================
     */
    /**
     * Creer un contenu vide a partir d'un modele de notation
     *
     * @param ModeleNotation $modeleNotation
     * @return array
     */
    public static function creerContenuVide(ModeleNotation $modeleNotation)
    {
        $contenuVide = [];
        foreach($modeleNotation->sections as $section)
        {
            $sectionVide = [];
            for($i=0; $i<count($section->criteres); $i++)
            {
                $sectionVide[] = Constantes::INDEX_CHOIX_VIDE;
            }
            $contenuVide[$section->ordre] = $sectionVide;
        }
        return $contenuVide;
    }
}
