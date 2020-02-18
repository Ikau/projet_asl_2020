<?php

namespace App\Http\Controllers\CRUD;

use App\Abstracts\Controllers\AbstractControllerCRUD;
use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des utilisateurs';
    const TITRE_CREATE = 'ajouter un utilisateur';
    const TITRE_SHOW   = 'Details de l\'utilisateur';
    const TITRE_EDIT   = 'Editer un utilisateur';


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
                /* Il n'y a pas de champs optionnels pour l'instant
                if(...)
                {
                    abort('404');
                }
                */
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $user = $this->validerModele($request->id);
                if(null === $user)
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
        $users = User::all();

        return view('admin.modeles.user.index', [
            'titre'     => UserController::TITRE_INDEX,
            'attributs' => $this->getAttributsModele(),
            'users'     => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enseignants   = Enseignant::all()->sortBy(Enseignant::COL_NOM);
        $contacts_insa = Contact::where(Contact::COL_TYPE, '=', Contact::VAL_TYPE_INSA)
        ->orderBy(Contact::COL_NOM)
        ->get();

        return view('admin.modeles.user.form', [
            'titre'         => UserController::TITRE_CREATE,
            'classe'        => User::class,
            'contacts_insa' => $contacts_insa,
            'enseignants'   => $enseignants,
            'type'          => Contact::VAL_TYPE_INSA
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

        $user = new User;

        // Recuperation de l'identite
        $email    = $request->input(User::COL_EMAIL);
        $identite = $this->getIdentite($email);

        $user->identite()->associate($identite);
        $user[User::COL_EMAIL] = $email;

        /*
         * Il faudra inclure le mot de passe dans l'email de verification
         * Pour l'instant, le mot de passe est 'azerty'
         */
        //$password = Hash::make(Str::random(8));
        $password = 'azerty';
        $user[User::COL_HASH_PASSWORD] = Hash::make($password);

        $user->save();

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->validerModele($id);
        if(null === $user)
        {
            abort('404');
        }

        return view('admin.modeles.user.show', [
            'titre'     => UserController::TITRE_SHOW,
            'attributs' => $this->getAttributsModele(),
            'user'      => $user
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
        $user = $this->validerModele($id);
        if(null === $user)
        {
            abort('404');
        }

        $enseignants   = Enseignant::all()->sortBy(Enseignant::COL_NOM);
        $contacts_insa = Contact::where(Contact::COL_TYPE, '=', Contact::VAL_TYPE_INSA)
        ->orderBy(Contact::COL_NOM)
        ->get();

        return view('admin.modeles.user.form', [
            'titre'         => UserController::TITRE_EDIT,
            'classe'        => User::class,
            'contacts_insa' => $contacts_insa,
            'enseignants'   => $enseignants,
            'type'          => Contact::VAL_TYPE_INSA,
            'user'          => $user
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
        $user = $this->validerModele($id);
        if(null === $user)
        {
            abort('404');
        }

        // Recuperation de l'existant
        $email    = $request->input(User::COL_EMAIL);
        $identite = $this->getIdentite($email);

        // MaJ de la liaison
        $user->identite()->dissociate();
        $user->identite()->associate($identite);

        // MaJ de l'email + confirmation nouvel email
        $user[User::COL_EMAIL] = $identite->email;
        $user[User::COL_EMAIL_VERIFIE_LE] = null;

        /* TODO
         * Renvoyer un nouvel email pour la confirmation de l'email
         */

        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->validerModele($id);
        if(null === $user)
        {
            abort('404');
        }

        $user->delete();
        return redirect()->route('users.index');
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
        // Il n'y a pas de champs optionnels pour l'instant
    }

    /**
     * Fonction qui doit faire la logique de validation des inputs d'une requete entrante.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerForm(Request $request)
    {
        $request->validate([
            User::COL_EMAIL => [
                'required',
                'email',
                'unique:' . User::NOM_TABLE,
                // L'email doit exister pour un enseignant ou contact INSA
                // [DOC] https://laravel.com/docs/5.7/validation#using-closures
                function($attribute, $value, $fail) {
                    if(null === Enseignant::where(Enseignant::COL_EMAIL, '=', $value)->first()
                    && null === Contact::where([
                            [Contact::COL_TYPE, '=', Contact::VAL_TYPE_INSA],
                            [Contact::COL_EMAIL, '=', $value]
                        ])->first()
                    )
                    {
                        $fail("L'email ne correspond a aucun membre de l'INSA");
                    }
                }
            ]
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

        return User::find($id);
    }

    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     *
     * @return void
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(User::NOM_TABLE);
    }

    /**
     * Renvoie le Contact INSA ou l'Enseignant associe a l'email donne.
     * La fonction ne devrait pas renvoyer null car la methode de validation du form verifie deja la nullite
     *
     * @param  string $email L'email dont on recherche le proprietaire.
     *
     * @return App\Modeles\Enseignant|App\Modeles\Contact
     */
    protected function getIdentite(string $email)
    {
        $identite = null;

        // On recherche chez les contacts
        $identite = Contact::where([
            [Contact::COL_TYPE, '=', Contact::VAL_TYPE_INSA],
            [Contact::COL_EMAIL, '=', $email]
        ])->first();

        if(null === $identite)
        {
            // On renvoie le resultat chez les enseignants
            return $identite = Enseignant::where(Enseignant::COL_EMAIL, '=', $email)->first();
        }
        else
        {
            // OK : un contact insa existe bien
            return $identite;
        }
    }
}
