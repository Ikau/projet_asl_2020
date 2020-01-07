<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Entreprise;
use App\Utils\Constantes;

class EntrepriseController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des entreprises';
    const TITRE_CREATE = 'Ajouter une entreprise';
    const TITRE_SHOW   = 'Details de l\'entreprise';
    const TITRE_EDIT   = 'Editer une entreprise';


    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */
    

    /**
     * Route de tests pour les fonctions auxiliaires.
     *
     * @return \Illuminate\Http\Response
     */
    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);
                if( ! is_string($request[Entreprise::COL_ADRESSE2])
                ||  ! is_string($request[Entreprise::COL_CP])
                ||  ! is_string($request[Entreprise::COL_REGION]))
                {
                    abort('404');
                }
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $entreprise = $this->validerModele($request->id);
                if(null === $entreprise)
                {
                    abort('404');
                }
            return redirect('/');

            default:
                abort('404');
            break;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributs   = $this->getAttributsModele();
        $entreprises = Entreprise::all();
        
        return view('entreprise.index', [
            'attributs'   => $attributs,
            'entreprises' => $entreprises,
            'titre'       => EntrepriseController::TITRE_INDEX,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributs = $this->getAttributsModele();

        return view('entreprise.form', [
            'titre' => EntrepriseController::TITRE_CREATE
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validerForm($request);

        $entreprise = new Entreprise();
        $entreprise->fill($request->all());
        $entreprise->save();

        return redirect()->route('entreprises.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entreprise = $this->validerModele($id);
        if(null === $entreprise)
        {
            abort('404');
        }

        return view('entreprise.show', [
            'titre'      => EntrepriseController::TITRE_SHOW,
            'entreprise' => $entreprise
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entreprise = $this->validerModele($id);
        if(null === $entreprise)
        {
            abort('404');
        }

        $attributs = $this->getAttributsModele();
        return view('entreprise.form', [
            'titre'      => EntrepriseController::TITRE_EDIT,
            'entreprise' => $entreprise,
            'attributs'  => $attributs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort('404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort('404');
    }

    /* ====================================================================
     *                             AUXILIAIRES
     * ====================================================================
     */

    /**
     * Normalise les inputs utilisateur qui sont null
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
        // Adresse2
        if($request->missing(Entreprise::COL_ADRESSE2)
        || null === $request[Entreprise::COL_ADRESSE2]
        || ! is_string($request[Entreprise::COL_ADRESSE2]))
        {
            $request[Entreprise::COL_ADRESSE2] = Constantes::STRING_VIDE;
        }

        // CP
        if($request->missing(Entreprise::COL_CP)
        || null === $request[Entreprise::COL_CP]
        || ! is_string($request[Entreprise::COL_CP]))
        {
            $request[Entreprise::COL_CP] = Constantes::STRING_VIDE;
        }

        // Region
        if($request->missing(Entreprise::COL_REGION)
        || null === $request[Entreprise::COL_REGION]
        || ! is_string($request[Entreprise::COL_REGION]))
        {
            $request[Entreprise::COL_REGION] = Constantes::STRING_VIDE;
        }
    }

    /**
     * Fonction qui doit faire la logique de validation des inputs d'une requete entrante.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerForm(Request $request)
    {
        $validation = $request->validate([
            Entreprise::COL_NOM     => ['required', 'string'],
            Entreprise::COL_ADRESSE => ['required', 'string'],
            Entreprise::COL_VILLE   => ['required', 'string'],
            Entreprise::COL_PAYS    => ['required', 'string'],

            Entreprise::COL_ADRESSE2 => ['sometimes', 'nullable', 'string'],
            Entreprise::COL_CP       => ['sometimes', 'nullable', 'string'],
            Entreprise::COL_REGION   => ['sometimes', 'nullable', 'string']

        ]);

        $this->normaliseInputsOptionnels($request);
    }

    /**
     * Fonction qui doit faire la logique de validation de l'id
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerModele($id)
    {
        if(null === $id
        || ! is_numeric($id))
        {
            return null;
        }

        return Entreprise::find($id);
    }

    
    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     * 
     * @return void
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Entreprise::NOM_TABLE);
    }
}
