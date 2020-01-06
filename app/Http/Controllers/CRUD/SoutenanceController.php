<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Modeles\Soutenance;
use App\Utils\Constantes;

class SoutenanceController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des soutenances';
    const TITRE_CREATE = 'ajouter une soutenance';
    const TITRE_SHOW   = 'Details de la soutenance';
    const TITRE_EDIT   = 'Editer une soutenance';


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
                if( ! is_string($request[Soutenance::COL_COMMENTAIRE]) 
                ||  ! is_string($request[Soutenance::COL_INVITES])
                ||  ! is_bool($request[Soutenance::COL_CONFIDENTIELLE])
                ||  ! is_numeric($request[Soutenance::COL_NB_REPAS]))
                {
                    abort('404');
                }
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $soutenance = $this->validerModele($request->id);
                if(null === $soutenance)
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
        $soutenances = Soutenance::all();

        return view('soutenance.index', [
            'titre'       => SoutenanceController::TITRE_INDEX,
            'attributs'   => $attributs,
            'soutenances' => $soutenances
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributs    = $this->getAttributsModele();
        $enseignants  = Enseignant::all();
        $etudiants    = Etudiant::all();
        $departements = Departement::all();
        $options      = Option::all();
        $soutenanceTemp = factory(Soutenance::class)->make();

        return view('soutenance.form.admin', [
            'titre'        => SoutenanceController::TITRE_CREATE,
            'classe'       => Soutenance::class,
            'enseignants'  => $enseignants,
            'etudiants'    => $etudiants,
            'departements' => $departements,
            'options'      => $options,
            'wip_date'     => $soutenanceTemp->date,
            'wip_heure'    => $soutenanceTemp->heure,
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

        $soutenance = new Soutenance();
        $soutenance->fill($request->all());
        $soutenance->save();

        return redirect(route('soutenances.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort('404');
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
        // Commentaire
        $commentaire = $request[Soutenance::COL_COMMENTAIRE];
        if($request->missing(Soutenance::COL_COMMENTAIRE)
        || null == $commentaire
        || ! is_string($commentaire))
        {
            $request[Soutenance::COL_COMMENTAIRE] = Constantes::STRING_VIDE;
        }

        // Confidentielle
        $confidentielle = $request[Soutenance::COL_CONFIDENTIELLE];
        if($request->missing(Soutenance::COL_CONFIDENTIELLE)
        || null == $confidentielle
        || ! is_bool($confidentielle))
        {
            $request[Soutenance::COL_CONFIDENTIELLE] = FALSE;
        }
        else if ('on' === $confidentielle)
        {
            $request[Soutenance::COL_CONFIDENTIELLE] = TRUE;
        }

        // Invites
        $invites = $request[Soutenance::COL_INVITES];
        if($request->missing(Soutenance::COL_INVITES)
        || null == $invites
        || ! is_string($invites))
        {
            $request[Soutenance::COL_INVITES] = Constantes::STRING_VIDE;
        }

        // Nombre de repas
        $nbRepas = $request[Soutenance::COL_NB_REPAS];
        if($request->missing(Soutenance::COL_NB_REPAS)
        || null == $nbRepas
        || ! is_integer($nbRepas))
        {
            $request[Soutenance::COL_NB_REPAS] = Constantes::INT_VIDE;
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
            Soutenance::COL_ANNEE_ETUDIANT  => ['required', Rule::in([4,5])],
            Soutenance::COL_CAMPUS          => ['required', Rule::in(['Blois', 'Bourges'])],
            Soutenance::COL_DATE            => ['required', 'date', 'after:'.date('Y-m-d', strtotime('now'))],
            Soutenance::COL_HEURE           => ['required', 'date_format:H:i:00'],
            Soutenance::COL_SALLE           => ['required', 'string'],
            
            Soutenance::COL_CONFIDENTIELLE  => ['sometimes', 'nullable', Rule::in(['on', FALSE, TRUE, 0, 1])],
            Soutenance::COL_COMMENTAIRE     => ['sometimes', 'nullable', 'string'],
            Soutenance::COL_INVITES         => ['sometimes', 'nullable', 'string'],
            Soutenance::COL_NB_REPAS        => ['sometimes', 'nullable', 'integer', 'min:0'],

            // Clefs etrangeres
            Soutenance::COL_CANDIDE_ID             => ['required', 'exists:enseignants,id'],
            //Soutenance::COL_CONTACT_ENTREPRISE_ID  => ['required'],
            Soutenance::COL_DEPARTEMENT_ID         => ['required', 'exists:departements,id'],
            Soutenance::COL_ETUDIANT_ID            => ['required', 'exists:etudiants,id'],
            Soutenance::COL_OPTION_ID              => ['required', 'exists:options,id'],
            Soutenance::COL_REFERENT_ID            => ['required', 'exists:enseignants,id'],
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

        return Soutenance::find($id);
    }

    
    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     * 
     * @return void
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Soutenance::NOM_TABLE);
    }
}
