<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funIngresar(Request $request) {
        $credenciles = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if (!Auth::attempt($credenciles)) { /*El método attempt devolverá true si la autenticación se ha realizado correctamente */
            return response()->json(["message" => "No autenticado"]);
        }

        $usuario = Auth::user(); //tods los atribtos de tabla user en var $usuario
        $token = $usuario->createToken("token personal")->plainTextToken;
        return response()->json(["access_token"=>$token, "user"=>$usuario]);
    }

    public function funRegistro(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(["message" => "Usuario registrado."]);

    }

    public function funPerfil() {
        $usuario = Auth::user();
        return response()->json($usuario);
    }
    
    public function funSalir() {
        Auth::user()->tokens()->delete();
        return response()->json(["message" => "Logout"]);
    }
}
