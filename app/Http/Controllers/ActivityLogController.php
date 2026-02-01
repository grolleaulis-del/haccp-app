<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filtres
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);

        // Récupérer les modules et actions uniques pour les filtres
        $modules = ActivityLog::distinct()->pluck('module')->sort();
        $actions = ActivityLog::distinct()->pluck('action')->sort();
        $users = \App\Models\User::orderBy('name')->get();

        return view('activity-logs.index', [
            'logs' => $logs,
            'modules' => $modules,
            'actions' => $actions,
            'users' => $users,
            'filters' => $request->only(['module', 'action', 'user_id', 'date_debut', 'date_fin']),
        ]);
    }
}
