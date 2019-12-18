<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use App\Modeles\Etudiant;
use App\Modeles\Option;
use App\ModeleS\Departement;
use App\Utils\Constantes;

class EtudiantTest extends TestCase
{
    /**
     * Test du constructeur du modele
     * 
     * @return void
     */
    public function testConstructeur()
    {
        $etudiant = new Etudiant();

        $this->assertEquals(Constantes::STRING_VIDE, $etudiant[Etudiant::COL_NOM]);
        $this->assertEquals(Constantes::STRING_VIDE, $etudiant[Etudiant::COL_PRENOM]);
        $this->assertEquals(Constantes::STRING_VIDE, $etudiant[Etudiant::COL_EMAIL]);
        $this->assertEquals(Constantes::INT_VIDE, $etudiant[Etudiant::COL_ANNEE]);
        $this->assertEquals(FALSE, $etudiant[Etudiant::COL_MOBILITE]);
        $this->assertEquals(Constantes::ID_VIDE, $etudiant[Etudiant::COL_DEPARTEMENT_ID]);
        $this->assertEquals(Constantes::ID_VIDE, $etudiant[Etudiant::COL_OPTION_ID]);
    }
}
