<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\EntryOfficeController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Biometrics\BiometricsController;


Route::get('/getPatient', [BiometricsController::class, 'getPatient'])->name('getPatient');

Route::middleware(['auth', 'check_temp'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Entry office routes
    Route::prefix('entry/office')->name('entry.')->group(function () {
        Route::get('/', [EntryOfficeController::class, 'index'])->name('index');
        Route::get('/create', [EntryOfficeController::class, 'create'])->name('create');
        Route::get('/search', [EntryOfficeController::class, 'search'])->name('search');
    });



    // Exception acces aus soins
    Route::prefix('exception')->name('exception.')->middleware('admin')->group(function () {
        Route::get('/create', [ExceptionController::class, 'create'])->name('create');
        Route::get('/search', [ExceptionController::class, 'search'])->name('search');

        // Nouvelles routes pour l'employeur
        Route::get('/employer/create', [ExceptionController::class, 'createEmployer'])->name('employer.create');
    });

    // Entry office routes
    Route::prefix('profile')->name('profile.')->middleware('admin')->group(function () {
        Route::get('/{user}', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/{user}/reset', [ProfileController::class, 'resetPassword'])->name('resetPassword');

        Route::post('/{user}/toggle-print', [ProfileController::class, 'togglePrint'])->name('togglePrint');
        Route::post('/{user}/toggle-except', [ProfileController::class, 'toggleExcept'])->name('toggleExcept');
        Route::post('/{user}/toggle-print-family', [ProfileController::class, 'togglePrintFamily'])->name('togglePrintFamily');
        Route::post('/{user}/update-place', [ProfileController::class, 'updatePlace'])->name('updatePlace');
    });


     // Biometrie
    Route::prefix('biometrie')->name('biometrie.')->middleware(['auth','is_desktop','can_biometrie'])->group(function () {
        Route::get('/', [BiometricsController::class, 'index'])->name('index');
        Route::get('/visage', [BiometricsController::class, 'showFaceCapture'])->name('face');
        Route::get('/empreinte', [BiometricsController::class, 'empreinte'])->name('empreinte');
        Route::get('/lecteur-carte', [BiometricsController::class, 'lecteurCarte'])->name('lecteur-carte');
        Route::get('/getPatient', action: [BiometricsController::class, 'getPatient'])->name('getPatient');
   });


    // users routes
    Route::prefix('users')->name('users.')->middleware('admin')->controller(UsersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'createStore');
    });

    // places routes
    Route::prefix('places')->name('places.')->middleware('admin')->controller(PlacesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{place}/edit', 'edit')->name('edit');
        Route::put('/{place}', 'update')->name('update');
        Route::delete('/{place}', 'destroy')->name('destroy');
    });

    Route::prefix('settings')->name('settings.')->middleware('admin')->controller(SettingController::class)->group(function () {
        Route::get('/sites', 'sitesIndex')->name('sitesIndex');
    });

    // ajax routes
    Route::prefix('ajax')->name('ajax.')->controller(AjaxController::class)->group(function () {
        Route::post('/get/patients', 'getPatients')->name('getPatients');
        Route::post('/search/patients', 'searchPatient')->name('searchPatient');
        Route::post('/store/fiche', 'storeFiche')->name('storeFiche');

        //assure
        Route::post('/get/patient-exception', 'getPatientForException')->name('getPatientForException');
        Route::post('/update/family-access', 'updateFamilyAccess')->name('updateFamilyAccess');

        // cotisant

        Route::post('/get/employer-exception', 'getEmployerForException')->name('getEmployerForException');

        Route::post('/update/employer-access', 'updateEmployerAccess')->name('updateEmployerAccess');
    });

    // pdf routes
    Route::prefix('printing')->name('printing.')->controller(PrintController::class)->group(function () {
        Route::get('/auth/{id}', 'printAuth')->name('authform');
        Route::get('/family/{id}', 'printFamily')->name('familyform');
    });

    Route::get('/patient/{ssn}', [ManualController::class, 'getAMU'])->name('getAMU');
});

Route::get('/clear', [ManualController::class, 'clear'])->name('clear');
require __DIR__ . '/auth.php';


Route::get('/check/arret/{unicode}', [PrintController::class, 'arretCheck'])->name('arretCheck');
// Redirect if user typed a route that not exist.
Route::any(
    '{query}',
    function () {
        return redirect('/');
    }
)
    ->where('query', '.*');
