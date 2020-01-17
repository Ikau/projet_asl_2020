<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

use App\Abstracts\Controllers\AbstractControllerCRUD;
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
        $attributs   = $this->getAttributsModele();
        $enseignants = Enseignant::all();

        return view('admin.modeles.enseignant.index', [
            'titre'       => EnseignantController::TITRE_INDEX,
            'attributs'   => $attributs,
            'enseignants' => $enseignants,
        ]);
    }

    public function create()
    {
        return view('admin.modeles.enseignant.form', [
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

        return view('admin.modeles.enseignant.show', [
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

        return view('admin.modeles.enseignant.form', [
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
        if(null === $enseignant) 
        {
            abort('404');
        }

        $enseignant->delete();

        return redirect()->route('enseignants.index');
    }

    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);

                if(! is_numeric($request[Enseignant::COL_RESPONSABLE_OPTION_ID])
                || ! is_numeric($request[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID]))
                {
                    abort('404');
                }
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

        // Departement
        $idsDepartement       = Departement::all()->pluck('id');
        $idDepartementRequest = $request[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID];
        if($request->missing(Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID)
        || null === $idDepartementRequest
        || ! is_numeric($idDepartementRequest)
        || ! $idsDepartement->contains($idDepartementRequest))
        {
            $idAucunDepartement = Departement::where(Departement::COL_INTITULE, 'Aucun')->first()->id;
            $request[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID] = $idAucunDepartement;
        }

        // Option
        $idsOption       = Option::all()->pluck('id');
        $idOptionRequest = $request[Enseignant::COL_RESPONSABLE_OPTION_ID];
        if($request->missing(Enseignant::COL_RESPONSABLE_OPTION_ID)
        || null === $idOptionRequest
        || ! is_numeric($idOptionRequest)
        || ! $idsOption->contains($idOptionRequest))
        {
            $idAucuneOption = Option::where(Option::COL_INTITULE, 'Aucune')->first()->id;
            $request[Enseignant::COL_RESPONSABLE_OPTION_ID] = $idAucuneOption;
        }
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
                'nullable',
                'integer',
                Rule::in(Departement::all()->pluck('id'))
            ],
            Enseignant::COL_RESPONSABLE_OPTION_ID => [
                'nullable',
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

    /**
     * Renvoie tous les attributs du modele 'Enseignant'
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Enseignant::NOM_TABLE);
    }
}
