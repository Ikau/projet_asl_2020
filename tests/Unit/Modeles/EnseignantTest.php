<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\ModeleS\Departement;
use App\Utils\Constantes;

class EnseignantTest extends TestCase
{
    /**
     * Test du constructeur du modele
     *
     * @return void
     */
    public function testConstructeur()
    {
        $enseignant = new Enseignant();

        $attributsTests = [
            Enseignant::COL_NOM                        => Constantes::STRING_VIDE,
            Enseignant::COL_PRENOM                     => Constantes::STRING_VIDE,
            Enseignant::COL_EMAIL                      => Constantes::STRING_VIDE,

            Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => Constantes::ID_VIDE,
            Enseignant::COL_RESPONSABLE_OPTION_ID      => Constantes::ID_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $enseignant, Enseignant::NOM_TABLE);
    }
}
