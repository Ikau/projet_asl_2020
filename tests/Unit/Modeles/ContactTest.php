<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Contact;
use App\Utils\Constantes;

class ContactTest extends TestCase
{
    /**
     * Test du constructeur du modele
     *
     * @return void
     */
    public function testConstructeur()
    {
        $contact = new Contact();

        $attributsTests = [
            Contact::COL_NOM       => Constantes::STRING_VIDE,
            Contact::COL_PRENOM    => Constantes::STRING_VIDE,
            Contact::COL_CIVILITE  => Constantes::CIVILITE['vide'],
            Contact::COL_TYPE      => Constantes::TYPE_CONTACT['vide'],
            Contact::COL_EMAIL     => Constantes::STRING_VIDE,
            Contact::COL_TELEPHONE => Constantes::STRING_VIDE,
            Contact::COL_ADRESSE   => Constantes::STRING_VIDE
        ];

        // Verification du constructeur
        $this->verifieIntegriteConstructeurEloquent($attributsTests, $contact, Contact::NOM_TABLE);
    }
}
