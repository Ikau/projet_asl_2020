<?php

namespace Tests\Feature\CRUD;

use Tests\TestCase;

/* Template a remplir
use App\Modeles\Template;
use App\Http\Controllers\CRUD\TemplateController;
use App\Utils\Constantes;
*/

class TemplateControllerTest extends TestCase
{
    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

    public function testNormaliseInputsOptionnels()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testNormaliseInputsOptionnels
     */
    public function testValiderForm()
    {
        $this->assertTrue(TRUE);
    }

    public function testValiderModele()
    {
        $this->assertTrue(TRUE);
    }

    /* ====================================================================
     *                           TESTS RESOURCES
     * ====================================================================
     */

    public function testIndex()
    {
        $this->assertTrue(TRUE);
    }

    public function testCreate()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testUpdate()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        $this->assertTrue(TRUE);
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
        // return Schema::getColumnListing(Template::NOM_TABLE);
    }
}
