<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin.home', [
            'titre' => 'Zone administrateur'
        ]);
    }
}
