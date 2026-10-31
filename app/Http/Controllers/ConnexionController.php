<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Connexion;  // Assurez-vous d'importer le modèle Connexion
use App\Models\Users; 
class ConnexionController extends Controller
{
    public function showUserConnexions()
    {
        // Récupérer les connexions de l'utilisateur connecté seulement, sauf 'created_at' et 'updated_at'
        $connexions = Connexion::select(
            'id', 'user_id', 'ip_address', 'device', 'browser', 'operating_system',
            'country', 'login_time', 'heure_connexion', 'navigateur', 'appareil',
            'date', 'time', 'cs_user_agent', 'distance_horaire', 'cs_status', 'suspicious'
        )
        ->where('user_id', Auth::id())  // Filtrer par l'ID de l'utilisateur connecté
        ->get();
    
        return view('connexions.dashboard', ['connexions' => $connexions]);
    }
}
