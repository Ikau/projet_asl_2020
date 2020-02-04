<?php

namespace App\Facade;

use App\Interfaces\CreationFiches;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Fiches\ModeleNotation;

class FicheFacade implements CreationFiches
{
    public static function creerFiches(int $idStage)
    {
        self::creerRapport($idStage);
        self::creerEntreprise($idStage);
        self::creerSoutenance($idStage);
        self::creerSynthese($idStage);
    }

    static function creerEntreprise(int $stageId)
    {
        // TODO: Implement creerEntreprise() method.
    }

    static function creerRapport(int $idStage)
    {
        // Recuperation de la derniere version du modele
        $modele = ModeleNotation::where(ModeleNotation::COL_TYPE, '=', ModeleNotation::VAL_RAPPORT)
            ->orderBy(ModeleNotation::COL_VERSION, 'desc')
            ->take(1)
            ->first();

        if( null !== $modele )
        {
            $ficheRapport = new FicheRapport();

            $ficheRapport->fill([
                FicheRapport::COL_MODELE_ID   => $modele->id,
                FicheRapport::COL_STAGE_ID    => $idStage
            ]);

            $ficheRapport->save();
        }
    }

    static function creerSoutenance(int $stageId)
    {
        // TODO: Implement creerSoutenance() method.
    }

    static function creerSynthese(int $stageId)
    {
        // TODO: Implement creerSoutenance() method.
    }
}
