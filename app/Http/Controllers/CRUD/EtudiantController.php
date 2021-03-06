<?php

namespace App\Http\Controllers\CRUD;

use App\Abstracts\Controllers\AbstractControllerCRUD;
use App\Modeles\Departement;
use App\Modeles\Etudiant;
use App\Modeles\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

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
        $attributs = Schema::getColumnListing(Etudiant::NOM_TABLE);
        $etudiants = Etudiant::all();

        return view('admin.modeles.etudiant.index', [
            'titre'     => EtudiantController::TITRE_INDEX,
            'attributs' => $attributs,
            'etudiants' => $etudiants,
        ]);
    }

    public function create()
    {
        $attributs    = Schema::getColumnListing(Etudiant::NOM_TABLE);
        $options      = Option::all();
        $departements = Departement::all();

        return view('admin.modeles.etudiant.form', [
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
        $etudiant = $this->validerModele($id);
        if(null === $etudiant)
        {
            abort('404');
        }

        return view('admin.modeles.etudiant.show', [
            'titre'    => EtudiantController::TITRE_SHOW,
            'etudiant' => $etudiant
        ]);
    }

    public function edit($id)
    {
        $etudiant = $this->validerModele($id);
        if(null === $etudiant)
        {
            abort('404');
        }

        $departements = Departement::all();
        $options      = Option::all();

        return view('admin.modeles.etudiant.form', [
            'titre'        => EtudiantController::TITRE_EDIT,
            'etudiant'     => $etudiant,
            'departements' => $departements,
            'options'      => $options
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validerForm($request);
        $etudiant = $this->validerModele($id);
        if(null === $etudiant)
        {
            abort('404');
        }

        $etudiant->update($request->all());
        $etudiant->save();

        return redirect()->route('etudiants.index');
    }

    public function destroy($id)
    {
        $etudiant = $this->validerModele($id);
        if(null === $etudiant)
        {
            abort('404');
        }

        $etudiant->delete();
        return redirect()->route('etudiants.index');
    }

    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);

                if(null === $request[Etudiant::COL_MOBILITE]
                || ! is_bool($request[Etudiant::COL_MOBILITE]))
                {
                    abort('404');
                }
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
        if($request->missing(Etudiant::COL_MOBILITE)
        || null === $request[Etudiant::COL_MOBILITE])
        {
            $request[Etudiant::COL_MOBILITE] = FALSE;
        }
        else if('on' === $request[Etudiant::COL_MOBILITE])
        {
            $request[Etudiant::COL_MOBILITE] = TRUE;
        }
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
            Etudiant::COL_DEPARTEMENT_ID => ['required', Rule::in($idsDepartement)],
            Etudiant::COL_OPTION_ID      => ['required', Rule::in($idsOption)],
            Etudiant::COL_PROMOTION      => ['required', 'string'],

            // Ce n'est pas elegant mais je n'ai pas trouve mieux pour les boolean
            Etudiant::COL_MOBILITE => ['nullable', Rule::in(['on', FALSE, TRUE, 0, 1])],
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

}
