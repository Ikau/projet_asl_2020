<?php

namespace App\Http\Controllers\CRUD;

use App\Abstracts\Controllers\AbstractControllerCRUD;
use App\Modeles\Contact;
use App\Utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends AbstractControllerCRUD
{
    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des contacts';
    const TITRE_CREATE = 'Creer un contact';
    const TITRE_SHOW   = 'Details du contact';
    const TITRE_EDIT   = 'Editer un contact';

    /**
     * Valeur de la classe d'erreur affichee dans le blade
     */
    const CSS_ERREUR = 'alert alert-danger';

    public function index()
    {
        $contacts = Contact::all();

        return view('admin.modeles.contact.index', [
            'titre'    => ContactController::TITRE_INDEX,
            'contacts' => $contacts,
        ]);
    }

    public function create()
    {
        return view('admin.modeles.contact.form', [
            'titre'    => ContactController::TITRE_CREATE,
            'type'     => Constantes::TYPE_CONTACT,
            'civilite' => Constantes::CIVILITE
        ]);
    }

    public function store(Request $request)
    {
        $this->validerForm($request);

        $requestContact = new Contact();
        $requestContact->fill($request->all());
        $requestContact->save();

        return redirect()->route('contacts.index');
    }

    public function show($id)
    {
        $contact = $this->validerModele($id);
        if(null === $contact) abort('404');

        return view('admin.modeles.contact.show', [
            'titre'   => ContactController::TITRE_SHOW,
            'contact' => $contact,
        ]);
    }

    public function edit($id)
    {
        $contact = Contact::find($id);
        if(null === $contact) abort('404');

        return view('admin.modeles.contact.form', [
            'id'       => $id,
            'contact'  => $contact,
            'type'     => Constantes::TYPE_CONTACT,
            'civilite' => Constantes::CIVILITE,
            'titre'    => ContactController::TITRE_EDIT
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validerForm($request);
        $contact = $this->validerModele($id);
        if(null === $contact) abort ('404');

        $contact->update($request->all());
        $contact->save();

        return redirect()->route('contacts.index');
    }

    public function destroy($id)
    {
        $contact = $this->validerModele($id);
        if(null === $contact) abort('404');

        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);

                if(! in_array($request[Contact::COL_CIVILITE], Constantes::CIVILITE)
                || ! is_string($request[Contact::COL_TELEPHONE])
                || ! is_string($request[Contact::COL_ADRESSE]))
                {
                    abort('404');
                }
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $contact = $this->validerModele($request->id);
                if( null === $contact ) abort('404');
            return redirect('/');

            default:
                abort('404');
            break;
        }
    }

    /**
     * Fonction qui remplace les valeurs optionnels null par des valeurs par defaut
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
        // Civilite
        $civilite = $request[Contact::COL_CIVILITE];
        if($request->missing(Contact::COL_CIVILITE)
        || null === $civilite
        || ! in_array($civilite, Constantes::CIVILITE))
        {
            $request[Contact::COL_CIVILITE] = Contact::VAL_CIVILITE_VIDE;
        }

        // Telephone
        $telephone = $request[Contact::COL_TELEPHONE];
        if($request->missing(Contact::COL_CIVILITE)
        || null === $telephone
        || ! is_string($telephone))
        {
            $request[Contact::COL_TELEPHONE] = Constantes::STRING_VIDE;
        }

        // Adresse
        $adresse = $request[Contact::COL_ADRESSE];
        if($request->missing(Contact::COL_ADRESSE)
        || null === $adresse
        || ! is_string($adresse))
        {
            $request[Contact::COL_ADRESSE] = Constantes::STRING_VIDE;
        }
    }

    /**
     * Fonction qui se charge de valider tous les inputs issus d'un POST, PATCH, PUT
     */
    protected function validerForm(Request $request)
    {
        // Validation du form et des donnees recues
        $validation = $request->validate([
            Contact::COL_NOM       => ['required', 'string'],
            Contact::COL_PRENOM    => ['required', 'string'],
            Contact::COL_TYPE      => ['required',
                'integer',
                Rule::in(Constantes::TYPE_CONTACT)
            ],
            Contact::COL_EMAIL      => ['required', 'email'],

            Contact::COL_CIVILITE  => [
                'nullable',
                'integer',
                Rule::in(Constantes::CIVILITE)
            ],
            Contact::COL_TELEPHONE => ['nullable', 'string'],
            Contact::COL_ADRESSE   => ['nullable', 'string'],
        ]);

        // Mise a defaut des valeurs nullables
        $this->normaliseInputsOptionnels($request);
    }

    /**
     * Fonction qui valide la validite de l'id donnee et renvoie un contact le cas echeant
     */
    protected function validerModele($id)
    {
        if(null === $id
        || ! is_numeric($id))
        {
            return null;
        }

        return Contact::find($id);
    }
}
