<?php

use App\Http\Controllers\Admin\Google\Console\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\CallbackController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;


use App\Http\Controllers\FaqsController;

use App\Http\Controllers\MaterialController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//localhost:8000/console/login/1
Route::get('console/login', [AdminLoginController::class, 'login'])
    ->middleware('auth')
    ->name('google.users.redirect');


Route::group(['prefix' => 'inicio', 'middleware' => 'auth'], function () {
        Route::get('/', [ProjectController::class, 'index'])->name('project.index');
});

Route::group(['prefix' => 'proyecto', 'middleware' => 'auth'], function () {
    Route::get('/{project}/ver', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/{project}/editar', [ProjectController::class, 'edit'])->name('project.edit');
    Route::get('/{project}/{session}/editar', [ProjectController::class, 'editSession'])->name('project.session.edit');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('project.update');
    Route::post('/proyector/implementar', [ProjectController::class, 'implementar'])->name('proyector.implementar');
});

Route::group(['prefix' => 'sesion', 'middleware' => 'auth'], function () {
    Route::put('/{project}', [SesionController::class, 'update'])->name('project.sesion.update');
});


Route::group(['prefix' => 'material', 'middleware' => 'auth'], function () {
    Route::put('/{project}', [MaterialController::class, 'update'])->name('project.material.update');
});


Route::group(['prefix' => 'preguntas-frecuentes', 'middleware' => 'auth'], function () {
    Route::get('/', FaqsController::class)->name('faqs.index');
});

//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('console/callback', [AdminLoginController::class, 'callback'])
    ->middleware('auth')
    ->name('google.users.callback');

Route::get('/acceso-admin', function () {
    return view('landing');
})->name('landing');

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('login', LoginController::class)
    ->middleware('guest')
    ->name('login');

Route::get('callback', CallbackController::class)
    ->middleware('guest')
    ->name('callback');

Route::post('logout', LogoutController::class)
    ->name('logout');




Route::get('/editor', function () {
    return Inertia::render('Poc/Editorpoc');
})->name('editor');



//Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'auth']], function () {
//    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
//    Route::get('/{user}/editar', [AdminController::class, 'edit'])->name('admin.edit');
//    Route::get('/{user}', [AdminController::class, 'show'])->name('admin.show');
//    Route::put('/{user}', [AdminController::class, 'update'])->name('admin.update');
//    Route::delete('{course}', [CourseController::class, 'destroy'])->name('admin.destroy');
//    Route::get('/cursos-multiplicados/{id}', [AdminController::class, 'cursosMultiplicados'])->name('admin.cursos.multiplicados');
//});








