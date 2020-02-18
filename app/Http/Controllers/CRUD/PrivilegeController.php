<?php

namespace App\Http\Controllers\CRUD;

use App\Abstracts\Controllers\AbstractControllerCRUD;
use App\Modeles\Privilege;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PrivilegeController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des privileges';
    const TITRE_CREATE = 'ajouter un privilege';
    const TITRE_SHOW   = 'Details du privilege';
    const TITRE_EDIT   = 'Editer un privilege';


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

                // Aucun argument optionnel pour l'instant
                if(FALSE)
                {
                    abort('404');
                }
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $privilege = $this->validerModele($request->id);
                if(null === $privilege)
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
        $privileges = Privilege::all();
        $attributs  = $this->getAttributsModele();

        return view('admin.modeles.privilege.index', [
            'titre'      => PrivilegeController::TITRE_INDEX,
            'attributs'  => $attributs,
            'privileges' => $privileges
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

        return view('admin.modeles.privilege.form', [
            'titre'     => PrivilegeController::TITRE_CREATE,
            'attributs' => $attributs
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

        $privilege = new Privilege;
        $privilege->fill($request->all());
        $privilege->save();

        return redirect()->route('privileges.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $privilege = $this->validerModele($id);
        if(null === $privilege)
        {
            abort('404');
        }

        return view('admin.modeles.privilege.show', [
            'titre'     => PrivilegeController::TITRE_SHOW,
            'privilege' => $privilege
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
        $privilege = $this->validerModele($id);
        if(null === $privilege)
        {
            abort('404');
        }

        return view('admin.modeles.privilege.form', [
            'titre' => PrivilegeController::TITRE_EDIT,
            'privilege' => $privilege,
            'attributs' => $this->getAttributsModele()
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
        $this->validerForm($request);

        $privilege = Privilege::find($id);
        if(null === $privilege)
        {
            abort('404');
        }

        $privilege->update($request->all());
        $privilege->save();

        return redirect()->route('privileges.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $privilege = $this->validerModele($id);
        if(null === $privilege)
        {
            abort('404');
        }

        // Suppression du role chez les utilisateurs
        $users = User::has('privileges')->get();
        foreach($users as $user)
        {
            $user->privileges()->detach($privilege->id);
            $user->save();
        }

        // Suppression du privilege
        $privilege->delete();

        return redirect()->route('privileges.index');
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
        // Aucun argument optionnel pour l'instant
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
            Privilege::COL_INTITULE => ['required', 'string'],
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
        return Privilege::find($id);
    }


    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     *
     * @return void
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Privilege::NOM_TABLE);
    }
}
