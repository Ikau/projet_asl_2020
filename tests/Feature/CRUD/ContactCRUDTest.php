<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Modeles\Contact;
use App\Http\Controllers\CRUD\ContactController;
use App\Utils\Constantes;

class ContactControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /**
     * Attributs sur lesquels effectuer les tests
     */
    private $attributs = [
        'nom', 
        'prenom',
        'civilite',
        'type',
        'email',
        'telephone',
        'adresse'
    ];

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

    /**
     * Test de la fonction 'normaliseInputsOptionnels'
     * 
     * @dataProvider normaliseInputsOptionnelsProvider
     */
    public function testNormaliseOptionnels($clefModifiee)
    {
        $donnee                = factory(Contact::class)->make()->toArray();
        $donnee['test']        = 'normaliseInputsOptionnels';
        $donnee[$clefModifiee] = null;

        $response = $this->from(route('contacts.tests'))
        ->post(route('contacts.tests'), $donnee)
        ->assertRedirect('/');

    }

    public function normaliseInputsOptionnelsProvider()
    {
        return [
            'Civilite null' => ['civilite'],
            'Telephone null' => ['telephone'],
            'Adresse null' => ['adresse'],
        ];
    }
    
    /**
     * Test de la fonction de validation POST, PUT et PATCH d'un contact
     * 
     * @depends testNormaliseOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm($routeAttendue, $possedeErreur, $clefErreurAttendue, $donnee)
    {
        $routeSource = route('contacts.tests');

        $response = $this->from($routeSource)
        ->post(route('contacts.tests'), $donnee);

        if($possedeErreur)
        {
            $response->assertSessionHasErrors($clefErreurAttendue);
        }
        else
        {
            $response->assertSessionHasNoErrors();
        }
        $response->assertRedirect($routeAttendue);
    }

    public function validerFormProvider()
    {
        $this->refreshApplication();
        $arrayValide         = factory(Contact::class)->make()->toArray();
        $arrayValide['test'] = 'validerForm';

        /* Rappel : les affectations d'array sont par defaut des copies profondes */
        $nomNull            = $arrayValide;
        $nomInvalide        = $arrayValide;
        $nomNull['nom']     = null;
        $nomInvalide['nom'] = 42;

        $prenomNull               = $arrayValide;
        $prenomInvalide           = $arrayValide;
        $prenomNull['prenom']     = null;
        $prenomInvalide['prenom'] = 42;

        $civiliteNull                    = $arrayValide;
        $civiliteInvalideSup             = $arrayValide;
        $civiliteInvalideInf             = $arrayValide;
        $civiliteNull['civilite']        = null;
        $civiliteInvalideInf['civilite'] = Constantes::MIN['civilite'] - 1;
        $civiliteInvalideSup['civilite'] = Constantes::MAX['civilite'] + 1;

        $typeNull                = $arrayValide;
        $typeInvalideSup         = $arrayValide;
        $typeInvalideInf         = $arrayValide;
        $typeNull['type']        = null;
        $typeInvalideInf['type'] = Constantes::MIN['type_contact'] - 1;
        $typeInvalideSup['type'] = Constantes::MAX['type_contact'] + 1;

        $mailNull             = $arrayValide;
        $mailInvalide         = $arrayValide;
        $mailNull['email']     = null;
        $mailInvalide['email'] = Constantes::STRING_VIDE;

        $telephoneNull                = $arrayValide;
        $telephoneNull['telephone']   = null;

        $adresseNull              = $arrayValide;
        $adresseNull['adresse']   = null;

        //[$routeAttendue, $possedeErreur, $clefErreurAttendue, $donnee]
        return [
            'Formulaire valide'  => ['/', FALSE, null, $arrayValide],

            'Nom null'       => [route('contacts.tests'), TRUE, 'nom', $nomNull],
            'Prenom null'    => [route('contacts.tests'), TRUE, 'prenom', $prenomNull],
            'Type null'      => [route('contacts.tests'), TRUE, 'type', $typeNull],
            'Mail null'      => [route('contacts.tests'), TRUE, 'email', $mailNull],
            'Civilite null'  => ['/', FALSE, null, $civiliteNull],
            'Telephone null' => ['/', FALSE, null, $telephoneNull],
            'Adresse null'   => ['/', FALSE, null, $adresseNull],

            'Nom invalide'           => [route('contacts.tests'), TRUE, 'nom',  $nomInvalide],
            'Prenom invalide'        => [route('contacts.tests'), TRUE, 'prenom',  $prenomInvalide],
            'Type invalide sup'      => [route('contacts.tests'), TRUE, 'type',  $typeInvalideSup],
            'Type invalide inf'      => [route('contacts.tests'), TRUE, 'type', $typeInvalideInf],
            'Mail invalide'          => [route('contacts.tests'), TRUE, 'email',  $mailInvalide],
            'Civilite invalide sup'  => [route('contacts.tests'), TRUE, 'civilite', $civiliteInvalideSup],
            'Civilite invalide inf'  => [route('contacts.tests'), TRUE, 'civilite', $civiliteInvalideInf]
        ];
    }

    /**
     * Test de la methode 'validerModele'
     * 
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele($idCas, $statutAttendu)
    {
        $id;
        switch($idCas)
        {
            case 'valide':
                $id = factory(Contact::class)->create()->id;
            break;

            case 'string_numerique':
                $idTemp = factory(Contact::class)->create()->id;
                $id = "$idTemp";
            break;

            case 'inexistant':
                $id = -1;
            break;

            case 'non_int_ni_numerique':
                $id = '';
            break;

            case 'null':
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
        //[string $casId, int $statutAttendu]
        return [
            'Id valide'           => ['valide', 302],
            'Id string numerique' => ['string_numerique', 302],
            'Id inexistant'       => ['inexistant', 404],
            'Id non int'          => ['non_int_ni_numerique', 404],
            'Id null'             => ['null', 404],
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
        $arrayWhere = [];
        foreach($this->attributs as $attribut)
        {
            $arrayWhere[] = [$attribut, '=', $contactSource[$attribut]];
        }
        
        $contact = Contact::where($arrayWhere)->first();
        $this->assertNotNull($contact);
        foreach($this->attributs as $attribut)
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
        foreach($this->attributs as $attribut)
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
        foreach($this->attributs as $attribut)
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
        ->patch(route('contacts.update', $contactSource->id), [$clefModifiee => $nouvelleValeur])
        ->assertRedirect(route('contacts.edit', $contactSource->id));

        // Verification de la MAJ
        $contactMaj = Contact::find($contactSource->id);
        $this->assertEquals($contactSource->id, $contactMaj->id);
        foreach($this->attributs as $attribut)
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
}