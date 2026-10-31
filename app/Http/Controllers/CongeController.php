<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::where('user_id', Auth::id())->get();
        return view('conges.index', compact('conges'));
    }
public function myConges()
    {
        $user = Auth::user();
        $conges = $user->conges;

        return view('conges.my', compact('conges'));
    }
    public function create()
    {
        return view('conges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type' => 'required|string',
        ]);

        Conge::create([
            'user_id' => Auth::id(),
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'type' => $request->type,
            'statut' => 'en attente',
        ]);

        return redirect()->route('conges.index');
    }

    public function edit(Conge $conge)
    {
        $this->authorize('update', $conge);
        return view('conges.edit', compact('conge'));
    }

    public function update(Request $request, Conge $conge)
    {
        $this->authorize('update', $conge);

        $conge->update($request->all());
        return redirect()->route('conges.index');
    }

    public function destroy(Conge $conge)
    {
        $this->authorize('delete', $conge);

        $conge->delete();
        return redirect()->route('conges.index');
    }
}
