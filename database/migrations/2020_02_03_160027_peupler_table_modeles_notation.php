<?php

use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Fiches\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeuplerTableModelesNotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->insereModeleRapport();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(ModeleNotation::NOM_TABLE)->delete();
    }

    /* ====================================================================
     *                        FONCTION AUXILIAIRES
     * ====================================================================
     */
    /**
     * Insere le modele de la fiche de notation du rapport de stage
     */
    private function insereModeleRapport()
    {
        // Creation du modele
        $modeleRapport = new ModeleNotation();
        $modeleRapport->fill([
            ModeleNotation::COL_VERSION => 1,
            ModeleNotation::COL_TYPE    => ModeleNotation::VAL_RAPPORT
        ]);
        $modeleRapport->save();

        // Insertion des sections avec leurs criteres
        $this->insereSection1Rapport($modeleRapport->id);
        $this->insereSection2Rapport($modeleRapport->id);
        $this->insereSection3Rapport($modeleRapport->id);

    }

    private function insereSection1Rapport(int $idModele)
    {
        // Creation de la section
        $section = new Section();

        // Creation des criteres
        $criteres = [
            "Présenter le rapport de façon conforme (respect des consignes de présentation, mise en page, utilisé des annexes)",

            "S'exprimer de manière correcte en français (orthographe, syntaxe, fluidité de l'expression écrite",

            "Présenter le rapport de façon didactique et illustrer la réflexion par des figures lisibles et légendées"
        ];

        // Creation des choix communs
        $choix = [
            0 => [2.0, "Très bien"],
            1 => [1.5, "Bien"],
            2 => [1.0, "Moyen"],
            3 => [0.5, "Insuffisant"]
        ];

        // Sauvegarde de la section
        $section->fill([
            Section::COL_CHOIX     => $choix,
            Section::COL_INTITULE  => 'RÉDIGER DE MANIERE PROFESSIONNELLE',
            Section::COL_ORDRE     => 0,
            Section::COL_CRITERES  => $criteres,
            Section::COL_MODELE_ID => $idModele
        ])->save();
    }

    private function insereSection2Rapport(int $idModele)
    {
        // Creation de la section
        $section = new Section();

        // Creation des criteres
        $criteres = [
            "Pertinence (préblématique bien cernée",

            "Exhaustivité (le contexte, les objectifs, la démarche et les résultats du stage",

            "Exactitude (précision du vocabulaire scientifique et technique",

            "Structure (le rapport suit une progression cohérente"
        ];

        // Creation des choix communs
        $choix = [
            0 => [2.0, "Très bien"],
            1 => [1.5, "Bien"],
            2 => [1.0, "Moyen"],
            3 => [0.5, "Insuffisant"]
        ];

        // Sauvegarde de la section
        $section->fill([
            Section::COL_CHOIX     => $choix,
            Section::COL_INTITULE  => 'RENDRE COMPTE DE LA MISSION',
            Section::COL_ORDRE     => 1,
            Section::COL_CRITERES  => $criteres,
            Section::COL_MODELE_ID => $idModele
        ])->save();
    }

    private function insereSection3Rapport(int $idModele)
    {
        // Creation de la section
        $section = new Section();

        // Creation des criteres
        $criteres = [
            "Être capable de s'autoévaluer",

            "Montrer l'apport du stage"
        ];

        // Creation des choix communs
        $choix = [
            0 => [3.0, "Très bien"],
            1 => [2.0, "Bien"],
            2 => [1.0, "Moyen"],
            3 => [0.5, "Insuffisant"]
        ];

        // Sauvegarde de la section
        $section->fill([
            Section::COL_CHOIX     => $choix,
            Section::COL_CRITERES  => $criteres,
            Section::COL_INTITULE  => "REALISER UN RETOUR D'EXPERIENCE",
            Section::COL_ORDRE     => 2,
            Section::COL_MODELE_ID => $idModele
        ])->save();
    }
}
