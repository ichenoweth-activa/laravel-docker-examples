<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/db-status', function () {
    try {
        // Ejecutar una consulta simple
/*        DB::connection()->getPdo();

        // Verificar si la tabla users existe
        if (!Schema::hasTable('users')) {
            return response()->json([
                'success' => false,
                'message' => 'Conexión exitosa, pero la tabla users no existe.'
            ], 200);
        }*/

        // Consultar algunos registros de users
        $users = User::take(10)->get();

        return response()->json([
            'success' => true,
            'message' => 'Conexión exitosa a la base de datos.',
            'data' => $users
        ]);
    } catch (\Exception $e) {
        Log::error('Error de conexión a la base de datos: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Error de conexión a la base de datos.',
            'error' => $e->getMessage()
        ], 500);
    }
});
