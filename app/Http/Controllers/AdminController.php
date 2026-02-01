<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function loginAttempts()
    {
        $attempts = LoginAttempt::orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.login-attempts', compact('attempts'));
    }

    public function backups()
    {
        $backups = [];
        $backupPath = storage_path('app/');
        
        if (is_dir($backupPath)) {
            $files = glob($backupPath . '*');
            foreach ($files as $file) {
                if (is_file($file) && (strpos($file, '.zip') !== false || strpos($file, '.sql') !== false)) {
                    $backups[] = [
                        'name' => basename($file),
                        'size' => filesize($file),
                        'date' => date('Y-m-d H:i:s', filemtime($file)),
                    ];
                }
            }
        }

        return view('admin.backups', compact('backups'));
    }

    public function runBackup()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);
            return back()->with('success', 'Sauvegarde créée avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la sauvegarde : ' . $e->getMessage());
        }
    }
}
