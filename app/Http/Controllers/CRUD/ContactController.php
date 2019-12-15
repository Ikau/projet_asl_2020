<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request; 

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Contact;
use App\Utils\Constantes;

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

        return view('contact.index', [
            'titre'    => ContactController::TITRE_INDEX,
            'contacts' => $contacts,
        ]);
    }

    public function create() 
    {
        return view('contact.form', [
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

        return view('contact.show', [
            'titre'   => ContactController::TITRE_SHOW,
            'contact' => $contact,
        ]);
    }

    public function edit($id) 
    {
        $contact = Contact::find($id);
        if(null === $contact) abort('404');

        return view('contact.form', [
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
                if(null === $request->civilite) abort('404');
                if(null === $request->telephone) abort('404');
                if(null === $request->adresse) abort('404');
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $contact = $this->validerModele($request->id);
                if( is_null($contact) ) abort('404');
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
        if(null === $request->civilite)
            $request['civilite'] = Constantes::CIVILITE['vide'];
        
        if(null === $request->telephone)
            $request['telephone'] = Constantes::STRING_VIDE;
        
        if(null === $request->adresse)
            $request['adresse'] = Constantes::STRING_VIDE;
    }

    /**
     * Fonction qui se charge de valider tous les inputs issus d'un POST, PATCH, PUT
     */
    protected function validerForm(Request $request)
    {
        // Validation du form et des donnees recues
        $validation = $request->validate([
            'nom'       => ['required', 'string'],
            'prenom'    => ['required', 'string'],
            'type'      => ['required',
                'numeric', 
                'min:' . Constantes::TYPE_CONTACT['min'], 
                'max:' . Constantes::TYPE_CONTACT['max']
            ],
            'email'      => ['required', 'email'],

            'civilite'  => [
                'nullable',
                'numeric',
                'min:' . Constantes::CIVILITE['min'],
                'max:' . Constantes::CIVILITE['max']
            ],
            'telephone' => ['nullable', 'string'],
            'adresse'   => ['nullable', 'string'],
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
