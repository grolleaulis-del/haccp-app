<?php

namespace App\Http\Controllers;

use App\Models\EquipementTemperature;
use App\Models\ReleveTemperature;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TemperatureController extends Controller
{
    public function index(Request $request)
    {
        $equipements = EquipementTemperature::where('actif', true)
            ->with(['releves' => function ($query) {
                $query->whereDate('created_at', Carbon::today())
                    ->latest()
                    ->limit(1);
            }])
            ->orderBy('nom')
            ->get();

        return view('temperatures.index', compact('equipements'));
    }

    public function quick(EquipementTemperature $equipement_temperature)
    {
        return view('temperatures.quick', ['equipement' => $equipement_temperature]);
    }

    public function quickStore(Request $request, EquipementTemperature $equipement_temperature)
    {
        $request->validate([
            'temperature' => 'required|numeric|min:-50|max:50',
            'conforme' => 'required|boolean',
            'action_corrective' => 'nullable|string|max:500',
        ]);

        ReleveTemperature::create([
            'equipement_temperature_id' => $equipement_temperature->id,
            'temperature' => $request->temperature,
            'conforme' => $request->conforme,
            'action_corrective' => $request->action_corrective,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('temperatures.index')
            ->with('success', 'Relevé enregistré avec succès pour ' . $equipement_temperature->nom);
    }

    public function historique(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $releves = ReleveTemperature::with('equipement', 'user')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('temperatures.historique', compact('releves', 'date'));
    }

    public function create()
    {
        $equipements = EquipementTemperature::where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('temperatures.create', compact('equipements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipement_temperature_id' => 'required|exists:equipements_temperature,id',
            'temperature' => 'required|numeric|min:-50|max:50',
            'conforme' => 'required|boolean',
            'action_corrective' => 'nullable|string|max:500',
        ]);

        ReleveTemperature::create([
            'equipement_temperature_id' => $request->equipement_temperature_id,
            'temperature' => $request->temperature,
            'conforme' => $request->conforme,
            'action_corrective' => $request->action_corrective,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('temperatures.index')
            ->with('success', 'Relevé enregistré avec succès.');
    }

    public function show(EquipementTemperature $equipement_temperature)
    {
        $releves = $equipement_temperature->releves()
            ->with('user')
            ->latest()
            ->paginate(30);

        return view('temperatures.show', compact('equipement', 'releves'));
    }

    public function edit(ReleveTemperature $releve)
    {
        $equipements = EquipementTemperature::where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('temperatures.edit', compact('releve', 'equipements'));
    }

    public function update(Request $request, ReleveTemperature $releve)
    {
        $request->validate([
            'equipement_temperature_id' => 'required|exists:equipements_temperature,id',
            'temperature' => 'required|numeric|min:-50|max:50',
            'conforme' => 'required|boolean',
            'action_corrective' => 'nullable|string|max:500',
        ]);

        $releve->update([
            'equipement_temperature_id' => $request->equipement_temperature_id,
            'temperature' => $request->temperature,
            'conforme' => $request->conforme,
            'action_corrective' => $request->action_corrective,
        ]);

        return redirect()->route('temperatures.index')
            ->with('success', 'Relevé mis à jour avec succès.');
    }

    public function destroy(ReleveTemperature $releve)
    {
        $releve->delete();

        return redirect()->route('temperatures.index')
            ->with('success', 'Relevé supprimé.');
    }
}
