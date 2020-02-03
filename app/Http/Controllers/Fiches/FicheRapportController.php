<?php

namespace App\Http\Controllers\Enseignant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Abstracts\Controllers\Fiches\AbstractFicheRapportController;

use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Stage;

use App\Utils\Constantes;

class FicheRapportController extends AbstractFicheRapportController
{

    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */
    public function show($idProjet, $id)
    {
        // TODO: Implement show() method.
    }

    public function store($idProjet, $id)
    {
        // TODO: Implement show() method.
    }

    public function edit($idProjet, $id)
    {
        // TODO: Implement edit() method.
    }

    public function update($idProjet, $id)
    {
        // TODO: Implement update() method.
    }

    public function tests($request)
    {
        // TODO: Implement tests() method.
    }
}
