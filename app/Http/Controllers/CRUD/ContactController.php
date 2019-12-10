<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request; 

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Contact;
use App\Utils\Constantes;

class ContactController extends AbstractControllerCRUD
{
    public function index() 
    {
        $contacts = Contact::all();

        return view('contact.index', [
            'nombre'   => count($contacts),
            'contacts' => $contacts,
        ]);
    }

    public function create() 
    {
        return view('contact.form', [
            'type'     => Constantes::TYPE_CONTACT,
            'civilite' => Constantes::CIVILITE
        ]);
    }

    public function store(Request $request) 
    {
        $validation = $request->validate([
            'nom'       => ['required', 'alpha_dash'],
            'prenom'    => ['required', 'alpha_dash'],
            'type'      => ['required', 'numeric'],
            'mail'      => ['required', 'email'],

            'civilite'  => ['nullable', 'numeric'],
            'telephone' => ['nullable'],
            'adresse'   => ['nullable'],
        ]);

        $requestContact = new Contact();
        $requestContact->fill($request->all());
        $requestContact->nullToDefault();

        $requestContact->save();
        return redirect()->route('contacts.index');
    }

    public function show($id) 
    {
        return view('contact.show');
    }

    public function edit($id) 
    {
        $contact = Contact::find($id);

        return view('contact.form', [
            'id'       => $id,
            'contact'  => $contact,
            'type'     => Constantes::TYPE_CONTACT,
            'civilite' => Constantes::CIVILITE
        ]);
    }

    public function update(Request $request, $id) 
    {
        $contact = Contact::find($id);

        $contact->fill($request->all());
        $contact->nullToDefault();
        $contact->save();

        return redirect()->route('contacts.index');
    }

    public function destroy($id) 
    {
        Contact::destroy($id);

        echo ("ok");

        return redirect()->route('contacts.index');
    }
}
