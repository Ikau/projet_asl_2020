<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Etudiant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Utils\Constantes;

class EtudiantController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des etudiants';
    const TITRE_CREATE = 'Creer un etudiants';
    const TITRE_SHOW   = 'Details du etudiants';
    const TITRE_EDIT   = 'Editer un etudiants';


    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */

    public function index()
    {
        $etudiants = Etudiant::all();

        $attributs = Schema::getColumnListing(Etudiant::NOM_TABLE);
        return view('etudiant.index', [
            'titre'     => EtudiantController::TITRE_INDEX,
            'attributs' => $attributs,
            'etudiants' => $etudiants,
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
            return redirect('/');

            case 'validerForm':
            return redirect('/');

            case 'validerModele':
            return redirect('/');

            default:
                abort('404');
            break;
        }
    }

    /* ====================================================================
     *                             AUXILIAIRES
     * ====================================================================
     */

    /**
     * Fonction qui remplace les valeurs optionnels null par des valeurs par defaut
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
    }

    /**
     * Fonction qui se charge de valider tous les inputs issus d'un POST, PATCH, PUT
     */
    protected function validerForm(Request $request)
    {
    }

    /**
     * Fonction qui valide la validite de l'id donnee et renvoie un etudiants le cas echeant
     */
    protected function validerModele($id)
    {
    }

}
