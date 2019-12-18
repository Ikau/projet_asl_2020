<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Contact;
use App\Http\Controllers\CRUD\ContactController;
use App\Utils\Constantes;

class ContactControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

    /**
     * Test de la fonction 'normaliseInputsOptionnels'
     * 
     * @dataProvider normaliseInputsOptionnelsProvider
     */
    public function testNormaliseOptionnels(string $clefModifiee, $nouvelleValeur)
    {
        $contact                = factory(Contact::class)->make();
        $contact['test']        = 'normaliseInputsOptionnels';
        $contact[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('contacts.tests'))
        ->post(route('contacts.tests'), $contact->toArray())
        ->assertRedirect('/');

    }

    public function normaliseInputsOptionnelsProvider()
    {
        //[string $clefModifiee, $nouvelleValeur]
        return [
            'Adresse null'   => [Contact::COL_ADRESSE, null],
            'Civilite null'  => [Contact::COL_CIVILITE, null],
            'Telephone null' => [Contact::COL_TELEPHONE, null],

            'Adresse invalide'   => [Contact::COL_ADRESSE, -1],
            'Civilite invalide'  => [Contact::COL_CIVILITE, -1],
            'Telephone invalide' => [Contact::COL_TELEPHONE, -1],

            'Civilite non numerique' => [Contact::COL_CIVILITE, '']
        ];
    }
    
    /**
     * Test de la fonction de validation POST, PUT et PATCH d'un contact
     * 
     * @depends testNormaliseOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $contact                = factory(Contact::class)->make();
        $contact['test']        = 'validerForm';
        $contact[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('contacts.tests');
        $response    = $this->from($routeSource)
        ->post(route('contacts.tests'), $contact->toArray());

        if($possedeErreur)
        {
            $response->assertSessionHasErrors($clefModifiee)
            ->assertRedirect($routeSource);
        }
        else
        {
            $response->assertSessionHasNoErrors()
            ->assertRedirect('/');
        }
    }

    public function validerFormProvider()
    {
        //[bool $possedeErreur, string $clefModifiee, $nouvelleValeur]
        return [
            // Succes
            'Nom valide'    => [FALSE, Contact::COL_NOM, 'nom'],
            'Prenom valide' => [FALSE, Contact::COL_PRENOM, 'prenom'],
            'Type valide'   => [FALSE, Contact::COL_TYPE, Constantes::TYPE_CONTACT['vide']],
            'Mail valide'   => [FALSE, Contact::COL_EMAIL, 'valide@example.com'],

            'Civilite null'  => [FALSE, Contact::COL_CIVILITE, null],
            'Telephone null' => [FALSE, Contact::COL_TELEPHONE, null],
            'Adresse null'   => [FALSE, Contact::COL_ADRESSE, null],

            // Echecs
            'Nom null'    => [TRUE, Contact::COL_NOM, null],
            'Prenom null' => [TRUE, Contact::COL_PRENOM, null],
            'Type null'   => [TRUE, Contact::COL_TYPE, null],
            'Mail null'   => [TRUE, Contact::COL_EMAIL, null],

            'Nom invalide'       => [TRUE, Contact::COL_NOM, -1],
            'Prenom invalide'    => [TRUE, Contact::COL_PRENOM, -1],
            'Type invalide'      => [TRUE, Contact::COL_TYPE, -1],
            'Mail invalide'      => [TRUE, Contact::COL_EMAIL, 'invalideEmail'],
            'Civilite invalide'  => [TRUE, Contact::COL_CIVILITE, -1],
            'Telephone invalide' => [TRUE, Contact::COL_TELEPHONE, -1],
            'Adresse invalide'   => [TRUE, Contact::COL_ADRESSE, -1],

            'Type non numerique' => [TRUE, Contact::COL_TYPE, ''],
        ];
    }

    /**
     * Test de la methode 'validerModele'
     * 
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCas, int $statutAttendu)
    {
        $contact = factory(Contact::class)->create();
        $id;
        switch($idCas)
        {
            case 0:
                $id = $contact->id;
            break;

            case 1:
                $id = "$contact->id";
            break;

            case 2:
                $id = -1;
            break;

            case 3:
                $id = null;
            break;
        }

        $response = $this->post(route('contacts.tests'), [
            'test' => 'validerModele',
            'id'   => $id,
        ])->assertStatus($statutAttendu);
    }

    public function validerModeleProvider()
    {
        //[int $idCas, bool $statutAttendu]
        return [
            'Id valide'     => [0, 302],
            'Id numerique'  => [1, 302],
            'Id invalide'   => [2, 404],
            'Id null'       => [3, 404],
        ];
    }


    /* ====================================================================
     *                           TESTS RESOURCES
     * ====================================================================
     */

    /**
     * Test de la requete GET d'index
     */
    public function testIndex()
    {
        $response = $this->get(route('contacts.index'))
        ->assertOK()
        ->assertViewIs('contact.index')
        ->assertSee(ContactController::TITRE_INDEX);
    }

    /**
     * Test de la requete GET du formulaire de creation
     */
    public function testCreate()
    {
        $response = $this->get(route('contacts.create'))
        ->assertOk()
        ->assertViewIs('contact.form')
        ->assertSee(ContactController::TITRE_CREATE);
    }

    /**
     * Test de la requete POST de sauvegarde d'un formulaire
     * 
     * @depends testValiderForm
     * @return void
     */
    public function testStore()
    {
        $contactSource = factory(Contact::class)->make();

        $response = $this->from(route('contacts.create'))
            ->post(route('contacts.store'), $contactSource->toArray())
            ->assertRedirect(route('contacts.index'));

        // Arguments pour la clause 'where'
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $arrayWhere[] = [$attribut, '=', $contactSource[$attribut]];
            }
        }
        
        $contact = Contact::where($arrayWhere)->first();
        $this->assertNotNull($contact);
        foreach($this->getAttributsModele() as $attribut)
        {
            $this->assertEquals($contactSource[$attribut], $contact[$attribut]);
        }
    }

    /**
     * 
     * @depends testValiderModele
     * @return void
     */
    public function testShow($idCas)
    {
        $contact = factory(Contact::class)->create();

        $response = $this->get(route('contacts.show', $contact->id))
        ->assertOK()
        ->assertViewIs('contact.show')
        ->assertSee(ContactController::TITRE_SHOW);
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($contact["$attribut"]);
        }
    }

    /**
     * 
     * @depends testValiderForm
     * @depends testValiderModele
     * @return void
     */
    public function testEdit()
    {
        $contact = factory(Contact::class)->create();

        $response = $this->get(route('contacts.edit', $contact->id))
        ->assertOK()
        ->assertViewIs('contact.form')
        ->assertSee(ContactController::TITRE_EDIT);
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($contact[$attribut]);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     * @return void
     */
    public function testUpdate($clefModifiee, $nouvelleValeur)
    {
        $contactSource = factory(Contact::class)->create();
        $contactsource[$clefModifiee] = $nouvelleValeur;
        
        // Mise a jour et redirection OK
        $response = $this->from(route('contacts.edit', $contactSource->id))
        ->patch(route('contacts.update', $contactSource->id), $contactSource->toArray())
        ->assertRedirect(route('contacts.index'));

        // Verification de la MAJ
        $contactMaj = Contact::find($contactSource->id);
        $this->assertEquals($contactSource->id, $contactMaj->id);
        foreach($this->getAttributsModele() as $attribut)
        {
            $this->assertEquals($contactSource[$attribut], $contactMaj[$attribut]);
        }

    }

    public function updateProvider()
    {
        return [
            'Nom valide'       => ['nom', 'nouveau'],
            'Prenom valide'    => ['prenom', 'nouveau'],
            'Civilite valide'  => ['civilite', Constantes::CIVILITE['vide']],
            'Type valide'      => ['type', Constantes::TYPE_CONTACT['vide']],
            'Mail valide'      => ['email', 'nouveau@example.com'],
            'Telephone valide' => ['telephone', 'nouveau'],
            'Adresse valide'   => ['adresse', 'nouveau'],

            'Civilite null'    => ['civilite', null],
            'Telephone null'   => ['telephone', null],
            'Adresse null'     => ['adresse', null],
        ];
    }

    /**
     * @depends testValiderModele
     * @return void
     */
    public function testDestroy()
    {
        $idSource = factory(Contact::class)->create()->id;

        // Verification redirection
        $response = $this->from('contacts.index')
        ->delete(route('contacts.destroy', $idSource))
        ->assertRedirect(route('contacts.index'));

        // Verification suppression
        $contact = Contact::find($idSource);
        $this->assertNull($contact);
    }

    
    /* ====================================================================
     *                       FONCTIONS UTILITAIRES
     * ====================================================================
     */

    /**
     * Fonction auxiliaire facilitant la recuperation des attributs du modele a tester
     */
    private function getAttributsModele()
    {
        return Schema::getColumnListing(Contact::NOM_TABLE);
    }
}