<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->assertEquals(Constantes::STRING_VIDE, $contact->nom);
        $this->assertEquals(Constantes::STRING_VIDE, $contact->prenom);
        $this->assertEquals(Constantes::CIVILITE['vide'], $contact->civilite);
        $this->assertEquals(Constantes::TYPE_CONTACT['vide'], $contact->type);
        $this->assertEquals(Constantes::STRING_VIDE, $contact->email);
        $this->assertEquals(Constantes::STRING_VIDE, $contact->telephone);
        $this->assertEquals(Constantes::STRING_VIDE, $contact->adresse);
    }
}
