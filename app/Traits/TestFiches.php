<?php

namespace App\Traits;

use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Stage;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Schema;

/**
 * Trait utilitaire contenant du code souvent reutilise lors des tests.
 *
 * Trait TestFiches
 * @package App\Traits
 */
trait TestFiches
{
    /**
     * Verifie que les deux fiches entrees en argument sont les meme (par rapport au contenu
     *
     * @param FicheRapport $ficheTemoin
     * @param FicheRapport $ficheTest
     */
    function assertFichesRapportEgales(FicheRapport $ficheTemoin, FicheRapport $ficheTest)
    {
        $attributs = Schema::getColumnListing(FicheRapport::NOM_TABLE);
        foreach($attributs as $attribut)
        {
            $this->assertEquals($ficheTemoin[$attribut], $ficheTest[$attribut]);
        }
    }

    /**
     * Permet de verifier que l'entete des fichiers apparait completement
     *
     * @param TestResponse $reponse Resultat d'un test de reponse vers la page de la fiche souhaitee
     * @param Stage $stage
     */
    function assertVoitEnteteFiches(TestResponse $reponse, Stage $stage)
    {
        // Integrite du stagiaire
        $reponse->assertSee($stage->etudiant->nom)
            ->assertSee($stage->etudiant->prenom)
            ->assertSee($stage->etudiant->departement->intitule)
            ->assertSee($stage->etudiant->option->intitule);

        // Integrite du referent
        $reponse->assertSee($stage->referent->nom)
            ->assertSee($stage->referent->prenom);

        // Integrite de l'entreprise
        // TODO

        // Integrite du maitre de stage
        // TODO
    }

    /**
     * Permet de verifier que les sections et les choix soient bien presents dans la page
     *
     * @param TestResponse $reponse Resultat d'un test de reponse vers la page de la fiche souhaitee
     * @param $sections
     */
    function assertSectionsEtCriteresIntegres(TestResponse $reponse, $sections)
    {
        foreach($sections as $section)
        {
            $reponse->assertSee(e($section->intitule));
            for($i=0; $i<count($section->criteres); $i++)
            {
                $reponse->assertSee(e($section->getIntitule($i)))
                    ->assertSee(e($section->getPoints($i)));
            }
        }
    }

    /* ====================================================================
     *                        GETTERS UTILITAIRES
     * ====================================================================
     */

    function getPlusRecentModeleRapport() : ModeleNotation
    {
        return ModeleNotation::where(ModeleNotation::COL_TYPE, '=', ModeleNotation::VAL_RAPPORT)
            ->orderBy(ModeleNotation::COL_VERSION, 'desc')
            ->limit(1)
            ->first();
    }
}
