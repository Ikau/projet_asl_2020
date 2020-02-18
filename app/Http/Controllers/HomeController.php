<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Verification du statut de l'utilisateur
        $user = Auth::user();

        if(null === $user)
        {
            echo("null");
        }
        else // Authentifie
        {
            $identite = $user->identite;

            return view('home', [
                'identite' => $identite,
            ]);
        }
    }
}
