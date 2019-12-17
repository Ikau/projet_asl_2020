<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->assertEquals(Constantes::STRING_VIDE, $enseignant->nom);
        $this->assertEquals(Constantes::STRING_VIDE, $enseignant->prenom);
        $this->assertEquals(Constantes::STRING_VIDE, $enseignant->email);
        $this->assertEquals(null, $enseignant->responsable_departement);
        $this->assertEquals(null, $enseignant->responsable_option);
        $this->assertEquals(new Collection, $enseignant->soutenances_candide);
        $this->assertEquals(new Collection, $enseignant->soutenances_referent);
        $this->assertEquals(new Collection, $enseignant->stages);
    }
}
