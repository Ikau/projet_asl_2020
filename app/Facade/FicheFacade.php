<?php

namespace App\Facade;

use App\Abstracts\Modeles\Fiches\AbstractFiche;
use App\Interfaces\CreationFiches;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Fiches\Section;

class FicheFacade implements CreationFiches
{

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

    static function creerEntreprise(int $stageId, int $version = null)
    {
        // TODO: Implement creerEntreprise() method.
    }

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

            // Donnees par defaut vide
            $donnees = [];

            $ficheRapport->fill([
                FicheRapport::COL_CONTENU     => self::creerContenuVide($modele),
                FicheRapport::COL_MODELE_ID   => $modele->id,
                FicheRapport::COL_STAGE_ID    => $idStage,
                FicheRapport::COL_STATUT      => FicheRapport::VAL_STATUT_NOUVELLE
            ]);

            $ficheRapport->save();
        }
    }

    static function creerSoutenance(int $stageId, int $version = null)
    {
        // TODO: Implement creerSoutenance() method.
    }

    static function creerSynthese(int $stageId, int $version = null)
    {
        // TODO: Implement creerSoutenance() method.
    }

    /* ====================================================================
     *                         FONCTIONS PRIVEES
     * ====================================================================
     */
    /**
     * Creer un contenu vide a partir d'un modele de notation
     * @param ModeleNotation $modeleNotation
     * @return array
     */
    private static function creerContenuVide(ModeleNotation $modeleNotation)
    {
        $contenuVide = [];
        foreach($modeleNotation->sections as $section)
        {
            $sectionVide = [];
            for($i=0; $i<count($section->choix); $i++)
            {
                $sectionVide[] = -1;
            }
            $contenuVide[$section->ordre] = $sectionVide;
        }
        return $contenuVide;
    }
}
