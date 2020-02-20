<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Contact;
use App\Utils\Constantes;
use Tests\TestCase;

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
            Contact::COL_CIVILITE  => Contact::VAL_CIVILITE_VIDE,
            Contact::COL_TYPE      => Contact::VAL_TYPE_VIDE,
            Contact::COL_EMAIL     => Constantes::STRING_VIDE,
            Contact::COL_TELEPHONE => Constantes::STRING_VIDE,
            Contact::COL_ADRESSE   => Constantes::STRING_VIDE
        ];

        // Verification du constructeur
        $this->verifieIntegriteConstructeurEloquent($attributsTests, $contact, Contact::NOM_TABLE);
    }
}
