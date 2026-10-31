<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conge;
use App\Models\Mission;

class AdminController extends Controller
{
    // =========================================
    // Page admin : liste des utilisateurs
    // =========================================
    public function index()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    // =========================================
    // Congés
    // =========================================
    public function addConge(Request $request, User $user)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type' => 'required|string',
        ]);

        $jours = (strtotime($request->date_fin) - strtotime($request->date_debut)) / 86400 + 1;

        if ($user->solde_conges < $jours) {
            return back()->with('error', "Solde de congés insuffisant pour cet utilisateur");
        }

        Conge::create([
            'user_id' => $user->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'type' => $request->type,
            'statut' => 'en attente',
        ]);

        $user->solde_conges -= $jours;
        $user->save();

        return back()->with('success', "Congé ajouté à {$user->name}");
    }

    public function deleteConge($id)
    {
        $conge = Conge::findOrFail($id);
        $user = $conge->user;

        // Rembourse le solde
        $jours = (strtotime($conge->date_fin) - strtotime($conge->date_debut)) / 86400 + 1;
        $user->solde_conges += $jours;
        $user->save();

        $conge->delete();

        return back()->with('success', "Congé supprimé");
    }

    // =========================================
    // Missions
    // =========================================
    public function addMission(Request $request, User $user)
    {
        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        Mission::create([
            'user_id' => $user->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        return back()->with('success', "Mission ajoutée à {$user->name}");
    }

    public function deleteMission($id)
    {
        $mission = Mission::findOrFail($id);
        $mission->delete();

        return back()->with('success', "Mission supprimée");
    }
}
