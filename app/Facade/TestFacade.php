<?php

namespace App\Facade;

use App\Interfaces\CreationTests;
use App\Modeles\Etudiant;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Stage;
use App\User;
use Faker\Factory as Faker;

class TestFacade implements CreationTests
{
    /* ====================================================================
     *                      INTERFACE 'CreationTests'
     * ====================================================================
     */

    public static function creerStagePourEnseignant(User $userEnseignant) : Stage
    {
        // Creation d'un etudiant
        $etudiant = factory(Etudiant::class)->create();

        // Creation du stage
        $stage = factory(Stage::class)->create([
            Stage::COL_REFERENT_ID => $userEnseignant->identite->id,
            Stage::COL_ETUDIANT_ID => $etudiant->id
        ]);

        // Creation des fiches associees
        factory(FicheRapport::class)->create([
            FicheRapport::COL_MODELE_ID => self::getIdModeleNotationRecent(),
            FicheRapport::COL_STAGE_ID  => $stage->id,
            FicheRapport::COL_CONTENU   => self::genereContenuModeleRaport()
        ]);

        return $stage;
    }

    public static function creerStageNonAffecte(): Stage
    {
        // Creation du stage
        $stage = factory(Stage::class)->create();
        $stage->referent()->dissociate();
        $stage->save();

        // Creation des fiches associees
        FicheFacade::creerFiches($stage->id);
    }


    /* ====================================================================
     *                          FONCTIONS PRIVEES
     * ====================================================================
     */
    /**
     * @return int Id du modele de notation de rapport le plus recent
     */
    private static function getIdModeleNotationRecent()
    {
        $modele = ModeleNotation::where(ModeleNotation::COL_TYPE, '=', ModeleNotation::VAL_RAPPORT)
            ->orderBy(ModeleNotation::COL_VERSION, 'desc')
            ->first();

        return $modele->id;
    }

    private static function genereContenuModeleRaport()
    {
        $faker   = Faker::create();
        $contenu = [
            0 => [$faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3])
            ],
            1 => [$faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3])
            ],
            2 => [$faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3])
            ],
        ];

        return $contenu;
    }
}
