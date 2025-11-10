<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
      public function register(StoreUserRequest $request){
      $user = User::create([
        'nom'=>$request->nom,
        'prenom'=>$request->prenom,
        'email'=>$request->email,
        'password'=>$request->password,
      ]);
      $token = $user->createToken('auth_Token')->plainTextToken;
      return response()->json([
        "messsage"=>"register user successfuly",
        "user"=>$user->prenom,
        'token' => $token
      ]);
    }

    public function login(Request $request){
      $request->validate([
        "email"=>"required|string|email",
        "password"=>"required|string"
      ]);
      if(!Auth::attempt($request->only('email','password'))){
        return response()->json([
          'message'=> "invalid login",
        ]);
      }

      $user = User::where('email' , $request->email)->firstOrFail();
      $token = $user->createToken('auth_Token')->plainTextToken;
      return response()->json([
        'messages'=>"login user successfuly",
        "user" =>$user,
        "token"=>$token
      ]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
          return response()->json([
        "messsage"=>"logout successfuly"]);
    
    }
}
