<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoverController extends Controller
{
    // Le middleware 'auth' vérifie que l'utilisateur est authentifié
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Retourne la vue 'cover'
        return view('cover');
    }
}
