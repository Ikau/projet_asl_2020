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
        $attributs = $this->getAttributsModele();
        $etudiants = Etudiant::all();

        return view('etudiant.index', [
            'titre'     => EtudiantController::TITRE_INDEX,
            'attributs' => $attributs,
            'etudiants' => $etudiants,
        ]);
    }

    public function create()
    {
        $attributs    = $this->getAttributsModele();
        $options      = Option::all();
        $departements = Departement::all();

        return view('etudiant.form', [
            'titre'        => EtudiantController::TITRE_CREATE,
            'attributs'    => $attributs,
            'options'      => $options,
            'departements' => $departements
        ]);
    }

    public function store(Request $request)
    {
        $this->validerForm($request);

        $etudiant = new Etudiant();
        $etudiant->fill($request->all());
        $etudiant->save();

        return redirect()->route('etudiants.index');
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
                $this->normaliseInputsOptionnels($request);
                // Si des attributs sont optionnels, il faut check le resultat
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $etudiant = $this->validerModele($request->id);
                if(null === $etudiant) abort('404');
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
        // Aucun input optionnel
    }

    /**
     * Fonction qui se charge de valider tous les inputs issus d'un POST, PATCH, PUT
     */
    protected function validerForm(Request $request)
    {
        $idsDepartement = Departement::all()->pluck('id');
        $idsOption      = Option::all()->pluck('id');

        $validation = $request->validate([
            Etudiant::COL_NOM            => ['required', 'string'],
            Etudiant::COL_PRENOM         => ['required', 'string'],
            Etudiant::COL_EMAIL          => ['required', 'email'],
            Etudiant::COL_ANNEE          => ['required', Rule::in([4, 5])],
            Etudiant::COL_MOBILITE       => ['required', 'boolean'],
            Etudiant::COL_DEPARTEMENT_ID => ['required', Rule::in($idsDepartement)],
            Etudiant::COL_OPTION_ID      => ['required', Rule::in($idsOption)],
        ]);

        $this->normaliseInputsOptionnels($request);
    }

    /**
     * Fonction qui valide la validite de l'id donnee et renvoie un etudiants le cas echeant
     */
    protected function validerModele($id)
    {
        if(null === $id
        || ! is_numeric($id))
        {
            return null;
        }

        return Etudiant::find($id);
    }

    /**
     * Renvoie tous les attributs du modele 'Etudiant'
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Etudiant::NOM_TABLE);
    }

}
