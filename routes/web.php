<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsageQuotidienController;
use App\Http\Controllers\ArrivageController;
use App\Http\Controllers\ControleController;
use App\Http\Controllers\TemperatureController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\NettoyageController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeSessionController;
use App\Http\Controllers\ScanEtiquetteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CuissonRefroidissementController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Sélection employé (accessible sans authentification)
Route::get('/', [EmployeSessionController::class, 'index'])->name('employe-session.index');
Route::get('/employe-session/select/{user}', [EmployeSessionController::class, 'select'])->name('employe-session.select');
Route::post('/employe-session/deselect', [EmployeSessionController::class, 'deselect'])->name('employe-session.deselect');

// Route pour servir les fichiers storage avec le serveur PHP de dev
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Scan étiquette (workflow rapide avec caméra auto)
    Route::get('/scan-etiquette', [ScanEtiquetteController::class, 'index'])->name('scan-etiquette.index');
    Route::post('/scan-etiquette/select-produit', [ScanEtiquetteController::class, 'selectProduit'])->name('scan-etiquette.select-produit');
    Route::post('/scan-etiquette/store-lot', [ScanEtiquetteController::class, 'storeLot'])->name('scan-etiquette.store-lot');
    Route::delete('/lots/{lot}', [ScanEtiquetteController::class, 'destroy'])->name('lots.destroy');
    Route::post('/lots/destroy-multiple', [ScanEtiquetteController::class, 'destroyMultiple'])->name('lots.destroy.multiple');

    // Usage quotidien
    Route::get('/usage-quotidien', [UsageQuotidienController::class, 'index'])
        ->name('usage-quotidien.index');
    Route::get('/usage-quotidien/historique', [UsageQuotidienController::class, 'historique'])
        ->name('usage-quotidien.historique');
    Route::get('/usage-quotidien/{produit}/changer', [UsageQuotidienController::class, 'showChangerLot'])
        ->name('usage-quotidien.show-changer');
    Route::post('/usage-quotidien/{produit}/changer', [UsageQuotidienController::class, 'changerLot'])
        ->name('usage-quotidien.changer');
    Route::post('/lots/{lot}/cloturer', [UsageQuotidienController::class, 'cloturer'])
        ->name('lots.cloturer');

    // Paramètres
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Gestion des utilisateurs
    Route::post('admin/users/delete-bulk', [UserController::class, 'destroyMultiple'])->name('users.destroy.multiple');
    Route::resource('users', UserController::class);

    // Produits - suppression multiple (route séparée pour éviter conflit avec resource)
    Route::post('admin/produits/delete-bulk', [ProduitController::class, 'destroyMultiple'])->name('produits.destroy.multiple');

    // Produits - routes spéciales AVANT le resource
    Route::get('produits/import', [ProduitController::class, 'showImport'])->name('produits.import');
    Route::post('produits/import', [ProduitController::class, 'import'])->name('produits.import.store');
    Route::get('produits/template', [ProduitController::class, 'downloadTemplate'])->name('produits.template');
    Route::resource('produits', ProduitController::class);

    // Arrivages
    Route::get('/arrivages', [ArrivageController::class, 'index'])->name('arrivages.index');
    Route::get('/arrivages/create', [ArrivageController::class, 'create'])->name('arrivages.create');
    Route::post('/arrivages', [ArrivageController::class, 'store'])->name('arrivages.store');
    Route::get('/arrivages/{arrivage}', [ArrivageController::class, 'show'])->name('arrivages.show');
    Route::get('/arrivages/{arrivage}/edit', [ArrivageController::class, 'edit'])->name('arrivages.edit');
    Route::patch('/arrivages/{arrivage}', [ArrivageController::class, 'update'])->name('arrivages.update');
    Route::post('/arrivages/{arrivage}/lignes', [ArrivageController::class, 'addLigne'])->name('arrivages.addLigne');

    // Contrôle
    Route::get('/controle', [ControleController::class, 'index'])->name('controle.index');
    Route::get('/controle/{arrivage}/pdf', [ControleController::class, 'exportPdf'])->name('controle.pdf');
    Route::get('/controle/{arrivage}/zip', [ControleController::class, 'exportZip'])->name('controle.zip');
    Route::get('/controle/export-pdf', [ControleController::class, 'exportPdfGlobal'])->name('controle.export-pdf');

    // Températures
    Route::get('/temperatures', [TemperatureController::class, 'index'])->name('temperatures.index');
    Route::get('/temperatures/historique', [TemperatureController::class, 'historique'])->name('temperatures.historique');
    Route::get('/temperatures/quick/{equipement_temperature}', [TemperatureController::class, 'quick'])->name('temperatures.quick');
    Route::post('/temperatures/quick/{equipement_temperature}', [TemperatureController::class, 'quickStore'])->name('temperatures.quick.store');
    Route::get('/temperatures/create', [TemperatureController::class, 'create'])->name('temperatures.create');
    Route::post('/temperatures', [TemperatureController::class, 'store'])->name('temperatures.store');
    Route::get('/temperatures/{equipement_temperature}', [TemperatureController::class, 'show'])->name('temperatures.show');
    Route::get('/temperatures/{releve}/edit', [TemperatureController::class, 'edit'])->name('temperatures.edit');
    Route::patch('/temperatures/{releve}', [TemperatureController::class, 'update'])->name('temperatures.update');
    Route::delete('/temperatures/{releve}', [TemperatureController::class, 'destroy'])->name('temperatures.destroy');

    // Équipements
    Route::get('/equipements', [EquipementController::class, 'index'])->name('equipements.index');
    Route::get('/equipements/create', [EquipementController::class, 'create'])->name('equipements.create');
    Route::post('/equipements', [EquipementController::class, 'store'])->name('equipements.store');
    Route::get('/equipements/{equipement}/edit', [EquipementController::class, 'edit'])->name('equipements.edit');
    Route::patch('/equipements/{equipement}', [EquipementController::class, 'update'])->name('equipements.update');
    Route::delete('/equipements/{equipement}', [EquipementController::class, 'destroy'])->name('equipements.destroy');

    // Nettoyage
    Route::get('/nettoyage', [NettoyageController::class, 'index'])->name('nettoyage.index');
    Route::get('/nettoyage/create', [NettoyageController::class, 'create'])->name('nettoyage.create');
    Route::post('/nettoyage', [NettoyageController::class, 'store'])->name('nettoyage.store');
    Route::post('/nettoyage/quick/{tache}', [NettoyageController::class, 'quickRecord'])->name('nettoyage.quick');
    Route::get('/nettoyage/{nettoyage}/edit', [NettoyageController::class, 'edit'])->name('nettoyage.edit');
    Route::patch('/nettoyage/{nettoyage}', [NettoyageController::class, 'update'])->name('nettoyage.update');
    Route::delete('/nettoyage/{nettoyage}', [NettoyageController::class, 'destroy'])->name('nettoyage.destroy');

    // Tâches de nettoyage
    Route::get('/nettoyage/taches', [NettoyageController::class, 'taches'])->name('nettoyage.taches');
    Route::get('/nettoyage/taches/create', [NettoyageController::class, 'createTache'])->name('nettoyage.taches.create');
    Route::post('/nettoyage/taches', [NettoyageController::class, 'storeTache'])->name('nettoyage.taches.store');
    Route::get('/nettoyage/taches/{tache}/edit', [NettoyageController::class, 'editTache'])->name('nettoyage.taches.edit');
    Route::patch('/nettoyage/taches/{tache}', [NettoyageController::class, 'updateTache'])->name('nettoyage.taches.update');
    Route::delete('/nettoyage/taches/{tache}', [NettoyageController::class, 'destroyTache'])->name('nettoyage.taches.destroy');

    // Cuisson/Refroidissement
    Route::get('/cuisson-refroidissement', [CuissonRefroidissementController::class, 'index'])->name('cuisson-refroidissement.index');
    Route::get('/cuisson-refroidissement/dlc-en-cours', [CuissonRefroidissementController::class, 'dlcEnCours'])->name('cuisson-refroidissement.dlc-en-cours');
    Route::post('/cuisson-refroidissement/select-produit', [CuissonRefroidissementController::class, 'selectProduit'])->name('cuisson-refroidissement.select-produit');
    Route::post('/cuisson-refroidissement', [CuissonRefroidissementController::class, 'store'])->name('cuisson-refroidissement.store');
    Route::get('/cuisson-refroidissement/{lot}/success', [CuissonRefroidissementController::class, 'success'])->name('cuisson-refroidissement.success');
    Route::post('/cuisson-refroidissement/{lot}/print-labels', [CuissonRefroidissementController::class, 'printLabels'])->name('cuisson-refroidissement.print-labels');
    Route::get('/cuisson-refroidissement/historique', [CuissonRefroidissementController::class, 'historique'])->name('cuisson-refroidissement.historique');
    Route::delete('/cuisson-refroidissement/{lot}', [CuissonRefroidissementController::class, 'destroy'])->name('cuisson-refroidissement.destroy');
    Route::post('/cuisson-refroidissement/destroy-multiple', [CuissonRefroidissementController::class, 'destroyMultiple'])->name('cuisson-refroidissement.destroy.multiple');

    // Boîte noire - Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index')->middleware('role:admin,manager');

    // Routes Administration (admin uniquement)
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('index');
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-active', [\App\Http\Controllers\UserController::class, 'toggleActive'])->name('users.toggle-active');
        
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs');
        Route::get('/login-attempts', [\App\Http\Controllers\AdminController::class, 'loginAttempts'])->name('login-attempts');
        Route::get('/backups', [\App\Http\Controllers\AdminController::class, 'backups'])->name('backups');
        Route::post('/backups/run', [\App\Http\Controllers\AdminController::class, 'runBackup'])->name('backups.run');
    });
});

require __DIR__ . '/auth.php';
