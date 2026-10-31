<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index()
    {
        $missions = Mission::where('user_id', Auth::id())->get();
        return view('missions.index', compact('missions'));
    }

    public function create()
    {
        return view('missions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
        ]);

        Mission::create([
            'user_id' => Auth::id(),
            ...$request->all(),
            'statut' => 'en cours'
        ]);

        return redirect()->route('missions.index');
    }

    public function edit(Mission $mission)
    {
        $this->authorize('update', $mission);
        return view('missions.edit', compact('mission'));
    }

    public function update(Request $request, Mission $mission)
    {
        $this->authorize('update', $mission);

        $mission->update($request->all());
        return redirect()->route('missions.index');
    }

    public function destroy(Mission $mission)
    {
        $this->authorize('delete', $mission);

        $mission->delete();
        return redirect()->route('missions.index');
    }
     public function myMissions()
    {
        $user = Auth::user();
        $missions = $user->missions;

        return view('missions.my', compact('missions'));
    }
}
