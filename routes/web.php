<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Billing;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ExampleLaravel\UserManagement;
use App\Http\Livewire\ExampleLaravel\UserProfile;
use App\Http\Livewire\Notifications;
use App\Http\Livewire\Profile;
use App\Http\Livewire\RTL;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Tables;
use App\Http\Livewire\VirtualReality;
use GuzzleHttp\Middleware;
use App\Http\Controllers\CamionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AssuranceController;
use App\Http\Controllers\VisiteController;
use App\Http\Controllers\TaxeSpecialeAnnuelleController;
use App\Http\Controllers\CartGriseController;
use App\Http\Controllers\CartAutorisationController;
use App\Http\Controllers\ChauffeurController;
use App\Http\Controllers\PermisController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TrajetController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect('sign-in');
});

Route::get('forgot-password', ForgotPassword::class)->middleware('guest')->name('password.forgot');
Route::get('reset-password/{id}', ResetPassword::class)->middleware('signed')->name('reset-password');



Route::get('sign-up', Register::class)->middleware('guest')->name('register');
Route::get('sign-in', Login::class)->middleware('guest')->name('login');

Route::get('user-profile', UserProfile::class)->middleware('auth')->name('user-profile');
Route::get('user-management', UserManagement::class)->middleware('auth')->name('user-management');

Route::group(['middleware' => 'auth'], function () {
Route::get('dashboard', Dashboard::class)->name('dashboard');
Route::get('billing', Billing::class)->name('billing');
Route::get('profile', Profile::class)->name('profile');
Route::get('tables', Tables::class)->name('tables');
Route::get('notifications', Notifications::class)->name("notifications");
Route::get('virtual-reality', VirtualReality::class)->name('virtual-reality');
Route::get('static-sign-in', StaticSignIn::class)->name('static-sign-in');
Route::get('static-sign-up', StaticSignUp::class)->name('static-sign-up');
Route::get('rtl', RTL::class)->name('rtl');



// Routes pour la gestion des trajets
Route::middleware(['auth'])->group(function () {

    // Display a listing of the camions
    Route::get('/camions', [CamionController::class, 'index'])->name('camions.index');

    // Show the form for creating a new camion
    Route::get('/camions/create', [CamionController::class, 'create'])->name('camions.create');

    // Store a newly created camion in storage
    Route::post('/camions', [CamionController::class, 'store'])->name('camions.store');

    // Display the specified camion
    Route::get('/camions/{camion}', [CamionController::class, 'show'])->name('camions.show');

    // Show the form for editing the specified camion
    Route::get('/camions/{camion}/edit', [CamionController::class, 'edit'])->name('camions.edit');

    // Update the specified camion in storage
    Route::put('/camions/{camion}', [CamionController::class, 'update'])->name('camions.update');

    // Remove the specified camion from storage
    Route::delete('/camions/{camion}', [CamionController::class, 'destroy'])->name('camions.destroy');

    // Optional: Additional custom routes
    // Example: Show images associated with a specific camion
    Route::get('/camions/{camion}/images', [CamionController::class, 'showImages'])->name('camions.images');

    // Example: Generate a report for a specific camion
    Route::get('/camions/{camion}/report', [CamionController::class, 'generateReport'])->name('camions.report');


    Route::resource('assurances', AssuranceController::class);

    // Routes pour les Cartes Grise
    Route::resource('cartGrise', CartGriseController::class);

    // Routes pour les Visites Techniques
    Route::resource('visites', VisiteController::class);

    // Routes pour les Cartes d'Autorisation
    Route::resource('cartAutorisation', CartAutorisationController::class);

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');


    // Route  Taxe Spéciale Annuelle
    Route::get('/taxes/create', [TaxeSpecialeAnnuelleController::class, 'create'])->name('taxes.create');
    Route::post('/taxes', [TaxeSpecialeAnnuelleController::class, 'store'])->name('taxes.store');
    Route::get('/taxes/{id}/edit', [TaxeSpecialeAnnuelleController::class, 'edit'])->name('taxes.edit');
    Route::put('taxes/{id}', [TaxeSpecialeAnnuelleController::class, 'update'])->name('taxes.update');
    Route::delete('taxes/{id}', [TaxeSpecialeAnnuelleController::class, 'destroy'])->name('taxes.destroy');

    Route::resource('visites', VisiteController::class);

    Route::resource('cartesgrise', CartGriseController::class);

    Route::resource('cartesautorisation', CartAutorisationController::class);


    Route::resource('chauffeurs', ChauffeurController::class);


    Route::post('/chauffeurs/{chauffeur}/contrats', [ChauffeurController::class, 'storeContrat'])->name('contrats.store');
    Route::put('/chauffeurs/{chauffeurId}/contrats/{contratsId}', [ChauffeurController::class, 'updateContrat'])->name('contrats.update');
    Route::delete('chauffeurs/{chauffeur}/contrats/{contrat}', [ChauffeurController::class, 'destroyContrat'])->name('contrats.destroy');

    Route::post('/chauffeurs/{chauffeur}/permis', [ChauffeurController::class, 'storePermis'])->name('permis.store');
    Route::put('/chauffeurs/{chauffeurId}/permis/{permisId}', [ChauffeurController::class, 'updatePermis'])->name('permis.update');
    Route::delete('chauffeurs/{chauffeur}/permis/{permis}', [ChauffeurController::class, 'destroyPermis'])->name('permis.destroy');


    Route::resource('clients', ClientController::class);

    Route::post('/clients/{client}/contrats', [ClientController::class, 'storeContratsClients'])
         ->name('clients.storeContratsClients');
    Route::put('/clients/{client}/contrats/{contrat}', [ClientController::class, 'updateContratsClients'])->name('clients.updateContratsClients');
    Route::delete('/clients/{clientId}/contrats/{contratId}', [ClientController::class, 'deleteContratsClients'])->name('clients.deleteContratsClients');



    // Afficher la liste des trajets
    Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');

    // Afficher le formulaire de création d'un trajet
    Route::get('/trajets/create', [TrajetController::class, 'create'])->name('trajets.create');

    // Enregistrer un nouveau trajet
    Route::post('/trajets', [TrajetController::class, 'store'])->name('trajets.store');

    // Afficher les détails d'un trajet spécifique
    Route::get('/trajets/{trajet}', [TrajetController::class, 'show'])->name('trajets.show');

    // Afficher le formulaire de modification d'un trajet
    Route::get('/trajets/{trajet}/edit', [TrajetController::class, 'edit'])->name('trajets.edit');

    // Mettre à jour un trajet
    Route::put('/trajets/{trajet}', [TrajetController::class, 'update'])->name('trajets.update');

    // Supprimer un trajet
    Route::delete('/trajets/{trajet}', [TrajetController::class, 'destroy'])->name('trajets.destroy');
});
});


