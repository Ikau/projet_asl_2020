<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/* Template a remplir
use App\Modeles\Template;
use App\Http\Controllers\CRUD\TemplateController;
use App\Utils\Constantes;
*/

class ReferentControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    public function testIndex()
    {
        $this->assertTrue(TRUE);
    }
}