<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Afficher la page de paramètres
     */
    public function index()
    {
        $printer_name = Setting::get('printer_name', '');
        $printer_type = Setting::get('printer_type', 'zebra');
        $label_width = Setting::get('label_width', '100');
        $label_height = Setting::get('label_height', '50');
        $inactivity_timeout = Setting::get('inactivity_timeout', '5');

        return view('settings.index', compact(
            'printer_name',
            'printer_type',
            'label_width',
            'label_height',
            'inactivity_timeout'
        ));
    }

    /**
     * Mettre à jour les paramètres
     */
    public function update(Request $request)
    {
        $request->validate([
            'printer_name' => 'nullable|string|max:255',
            'printer_type' => 'required|in:zebra,brother,dymo,generic',
            'label_width' => 'required|numeric|min:10|max:500',
            'label_height' => 'required|numeric|min:10|max:500',
            'inactivity_timeout' => 'required|numeric|min:1|max:60',
        ]);

        Setting::set('printer_name', $request->printer_name);
        Setting::set('printer_type', $request->printer_type);
        Setting::set('label_width', $request->label_width);
        Setting::set('label_height', $request->label_height);
        Setting::set('inactivity_timeout', $request->inactivity_timeout);

        return redirect()->route('settings.index')
            ->with('success', 'Paramètres enregistrés avec succès.');
    }
}
