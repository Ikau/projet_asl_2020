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
        $this->assertEquals(Constantes::STRING_VIDE, $contact->mail);
        $this->assertEquals(Constantes::STRING_VIDE, $contact->telephone);
        $this->assertEquals(Constantes::STRING_VIDE, $contact->adresse);
    }

    /**
     * Test de la methode 'nullToDefault'
     *
     * @dataProvider nullToDefaultProvider
     * @return void
     */
    public function testNullToDefault(array $donnee, array $attente)
    {
        $contact = new Contact();
        $contact->fill($donnee);
        $contact->nullToDefault();

        $arrayContact = $contact->toArray();
        foreach($arrayContact as $key => $value)
        {
            $this->assertEquals($attente[$key], $arrayContact[$key]);
        }
    }

    public function nullToDefaultProvider()
    {
        $arrayValide = array(
            'nom'       => 'nom',
            'prenom'    => 'prenom',
            'civilite'  => Constantes::CIVILITE['vide'], 
            'type'      => Constantes::TYPE_CONTACT['vide'],
            'mail'      => 'test@test.com',
            'telephone' => '(+33)123456789)',
            'adresse'   => 'adresse'
        );

        $nomNull          = $arrayValide;
        $nomValide        = $arrayValide;
        $nomNull['nom']   = null;
        $nomValide['nom'] = Constantes::STRING_VIDE;

        $prenomNull             = $arrayValide;
        $prenomValide           = $arrayValide;
        $prenomNull['prenom']   = null;
        $prenomValide['prenom'] = Constantes::STRING_VIDE;

        $civiliteNull               = $arrayValide;
        $civiliteValide             = $arrayValide;
        $civiliteNull['civilite']   = null;
        $civiliteValide['civilite'] = Constantes::CIVILITE['vide'];

        $typeNull           = $arrayValide;
        $typeValide         = $arrayValide;
        $typeNull['type']   = null;
        $typeValide['type'] = Constantes::TYPE_CONTACT['vide'];

        $mailNull           = $arrayValide;
        $mailValide         = $arrayValide;
        $mailNull['mail']   = null;
        $mailValide['mail'] = Constantes::STRING_VIDE;

        $telephoneNull                = $arrayValide;
        $telephoneValide              = $arrayValide;
        $telephoneNull['telephone']   = null;
        $telephoneValide['telephone'] = Constantes::STRING_VIDE;

        $adresseNull              = $arrayValide;
        $adresseValide            = $arrayValide;
        $adresseNull['adresse']   = null;
        $adresseValide['adresse'] = Constantes::STRING_VIDE;

        return[
            'Donnees valides' => [$arrayValide, $arrayValide],
            'Nom null'        => [$nomNull, $nomValide],
            'Prenom null'     => [$prenomNull, $prenomValide],
            'Civilite null'   => [$civiliteNull, $civiliteValide],
            'Type null'       => [$typeNull, $typeValide],
            'Mail null'       => [$mailNull, $mailValide],
            'Telephone null'  => [$telephoneNull, $telephoneValide],
            'Adresse null'    => [$adresseNull, $adresseValide]
        ];
    }
}
