<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ✅ Affiche la liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users')); // Assure-toi que la vue users.index existe
    }

    // ✅ Supprime un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Empêcher un admin de se supprimer lui-même
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
