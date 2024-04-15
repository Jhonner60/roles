<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* grupo de autenticación con SANCTUM */
Route::prefix("v1/auth")->group(function(){
    Route::post('login', [AuthController::class, "funIngresar"]);
    Route::post("register", [AuthController::class, "funRegistro"]);

    /* proteccion de rutas, solo se muestran si estas logeado */
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('profile', [AuthController::class, "funPerfil"]);
        Route::post('logout', [AuthController::class, "funSalir"]);    
    });
});

Route::middleware('auth:sanctum')->group(function(){
    /* direcciones tabla Users, permisos y roles */
    Route::apiResource("users", UserController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("role", RoleController::class);
});
