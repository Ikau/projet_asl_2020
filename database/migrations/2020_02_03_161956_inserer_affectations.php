<?php

use App\Facade\FicheFacade;
use App\Modeles\Fiches\FicheRapport;
use App\Notifications\AffectationAssignee;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use App\Modeles\Stage;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;

class InsererAffectations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Stages precis
        $this->insertAffectationsBernardTichaud();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Recuperation de l'enseignant Bernard Tichaud
        $bernardTichaud = Enseignant::where(Enseignant::COL_EMAIL, '=', 'bernard.tichaud@exemple.fr')->first();
        $userTichaud    = User::where([
            [User::COL_POLY_MODELE_ID  , '=', $bernardTichaud->id],
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class]
        ])->first();

        // Recuperation des id de stage de Bernard Tichau
        $idStages = Stage::where(Stage::COL_REFERENT_ID, '=', $bernardTichaud->id)->get('id');

        // TEMP : suppression manuelle des fiches
        // il faudrait implementer une methode specifique dans l'un des modeles
        DB::table(FicheRapport::NOM_TABLE)->whereIn(FicheRapport::COL_STAGE_ID, $idStages)->delete();

        // Suppression des stages
        DB::table(Stage::NOM_TABLE)->where(Stage::COL_REFERENT_ID, '=', $bernardTichaud->id)->delete();
    }

    /**
     * Cree des affectations de stage pour l'enseignant Bernard Tichaud
     *
     * @return void
     */
    private function insertAffectationsBernardTichaud()
    {
        // Init du faker
        $faker = Faker::create();

        // Recuperation de l'enseignant Bernard Tichaud
        $bernardTichaud = Enseignant::where(Enseignant::COL_EMAIL, '=', 'bernard.tichaud@exemple.fr')->first();
        $userTichaud    = User::where([
            [User::COL_POLY_MODELE_ID  , '=', $bernardTichaud->id],
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class]
        ])->first();

        // Nous allons inserer 5 stages temoins + 1 stage complet + 1 stage en cours
        $nbStages = 5;
        for($i=0; $i<$nbStages; $i++)
        {
            // Creation du stage
            $etudiant  = factory(Etudiant::class)->create();
            $stage     = factory(Stage::class)->create([
                Stage::COL_REFERENT_ID         => $bernardTichaud->id,
                Stage::COL_ETUDIANT_ID         => $etudiant->id,
                Stage::COL_AFFECTATION_VALIDEE => TRUE
            ]);

            // Envoie des notifications de creation
            $userTichaud->notify(new AffectationAssignee($stage->id));

            // Creation des fiches
            FicheFacade::creerFiches($stage->id);
        }

        // Stage complet
        $etudiant = factory(Etudiant::class)->create();
        $stage    = factory(Stage::class)->create([
            Stage::COL_REFERENT_ID         => $bernardTichaud->id,
            Stage::COL_ETUDIANT_ID         => $etudiant->id,
            Stage::COL_AFFECTATION_VALIDEE => TRUE
        ]);
        FicheFacade::creerFiches($stage->id);

        $fiche = $stage->fiche_rapport;
        $fiche->contenu = [
            0 => [$faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3])],
            1 => [$faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3])],
            2 => [$faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3])]
        ];
        $fiche->statut = FicheRapport::VAL_STATUT_COMPLETE;
        $fiche->save();
        $stage->save();
        $userTichaud->notify(new AffectationAssignee($stage->id));

        // Stage en cours
        $etudiant = factory(Etudiant::class)->create();
        $stage    = factory(Stage::class)->create([
            Stage::COL_REFERENT_ID         => $bernardTichaud->id,
            Stage::COL_ETUDIANT_ID         => $etudiant->id,
            Stage::COL_AFFECTATION_VALIDEE => TRUE
        ]);
        FicheFacade::creerFiches($stage->id);

        $fiche = $stage->fiche_rapport;
        $fiche->contenu = [
            0 => [-1, $faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3])],
            1 => [$faker->randomElement([0,1,2,3]), -1, $faker->randomElement([0,1,2,3]), $faker->randomElement([0,1,2,3])],
            2 => [-1, $faker->randomElement([0,1,2,3])]
        ];
        $fiche->statut = FicheRapport::VAL_STATUT_EN_COURS;
        $fiche->save();
        $stage->save();
        $userTichaud->notify(new AffectationAssignee($stage->id));
    }
}