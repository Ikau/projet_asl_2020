<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Enseignant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Utils\Constantes;

class EnseignantController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des enseignants';
    const TITRE_CREATE = 'Creer un enseignant';
    const TITRE_SHOW   = 'Details du enseignant';
    const TITRE_EDIT   = 'Editer un enseignant';


    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */

    public function index()
    {
        $enseignants = Enseignant::all();

        return view('enseignant.index', [
            'titre'       => EnseignantController::TITRE_INDEX,
            'enseignants' => $enseignants,
        ]);
    }

    public function create()
    {
        return view('enseignant.form', [
            'titre'        => EnseignantController::TITRE_CREATE,
            'options'      => Option::all(),
            'departements' => Departement::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validerForm($request);

        $enseignant = new Enseignant();
        $enseignant->fill($request->all());
        $enseignant->save();

        return redirect()->route('enseignants.index');
    }

    public function show($id)
    {
        $enseignant = $this->validerModele($id);
        if(null === $enseignant)
        {
            abort('404');
        }

        return view('enseignant.show', [
            'titre'      => EnseignantController::TITRE_SHOW,
            'enseignant' => $enseignant
        ]);
    }

    public function edit($id)
    {
        $enseignant = $this->validerModele($id);
        if(null === $enseignant)
        {
            abort('404');
        }

        return view('enseignant.form', [
            'titre'        => EnseignantController::TITRE_EDIT,
            'enseignant'   => $enseignant,
            'options'      => Option::all(),
            'departements' => Departement::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validerForm($request);
        $enseignant = $this->validerModele($id);
        if(null === $enseignant)
        {
            abort('404');
        }

        $enseignant->update($request->all());
        $enseignant->save();

        return redirect()->route('enseignants.index');
    }

    public function destroy($id)
    {
        $enseignant = $this->validerModele($id);
        if(null === $enseignant) abort('404');
        $enseignant->delete();
    }

    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);
                if(null === $request->stages) abort('404');
                if(null === $request->soutenances_referent) abort('404');
                if(null === $request->soutenances_candide ) abort('404');
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $enseignant = $this->validerModele($request->id);
                if(null === $enseignant) abort('404');
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
        if(null === $request->stages
        || ! $request->stages instanceof Collection)
            $request->stages = new Collection();

        if(null === $request->soutenances_referent
        || ! $request->soutenances_referent instanceof Collection)
            $request->soutenances_referent = new Collection();

        if(null === $request->soutenances_candide
        || ! $request->soutenances_candide instanceof Collection)
            $request->soutenances_candide = new Collection();
    }

    /**
     * Fonction qui se charge de valider tous les inputs issus d'un POST, PATCH, PUT
     */
    protected function validerForm(Request $request)
    {
        $validation = $request->validate([
            Enseignant::COL_NOM    => ['required', 'string'],
            Enseignant::COL_PRENOM => ['required', 'string'],
            Enseignant::COL_EMAIL  => ['required', 'email'],
            Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => [
                'required', 
                'integer',
                Rule::in(Departement::all()->pluck('id'))
            ],
            Enseignant::COL_RESPONSABLE_OPTION_ID => [
                'required',
                'integer',
                Rule::in(Option::all()->pluck('id'))
            ]
        ]);
        
        $this->normaliseInputsOptionnels($request);
    }

    /**
     * Fonction qui valide la validite de l'id donnee et renvoie un enseignant le cas echeant
     */
    protected function validerModele($id)
    {
        if(null === $id
        || ! is_numeric($id))
        {
            return null;
        }

        return Enseignant::find($id);
    }

    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Enseignant::NOM_TABLE);
    }
}
