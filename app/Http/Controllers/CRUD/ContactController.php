<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request; 

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Contact;

class ContactController extends AbstractControllerCRUD
{
    public function index() 
    {
        $contacts = Contact::all();

        return view('contact.index', [
            'nombre'   => count($contacts),
            'contacts' => $contacts
        ]);
    }

    public function create() 
    {
        /*
        $newContact = new Contact();

        $newContact->nom = 'test';
        $newContact->prenom = 'test';
        $newContact->civilite = 'test';
        $newContact->type = 'test';
        $newContact->mail = 'test';
        $newContact->telephone = 'test';
        $newContact->adresse = 'test';

        $newContact->save();
        */

        return view('contact.create');
    }

    public function store(Request $request) 
    {
        return redirect()->route('contacts.index');
    }

    public function show($id) 
    {
        return view('contact.show');
    }

    public function edit($id) 
    {
        return view('contact.edit');
    }

    public function update(Request $request, $id) 
    {
        return redirect()->route('contacts.index');
    }

    public function destroy($id) 
    {
        return redirect()->route('contacts.index');
    }
}
