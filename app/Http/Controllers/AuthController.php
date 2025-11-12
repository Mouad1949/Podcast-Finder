<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/**
 * @OA\Info(
 *     title="Auth",
 *     version="1.0",
 *     description="Document about Authentification "
 * )
 *
 * @OA\Tag(
 *     name="Authentification",
 *     description="create function auth register and login and logout and rest password"
 * )
 */

class AuthController extends Controller
{

/**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"register"},
 *     summary="Add user",
 *     
 *        
 *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom","email","role","password"},
     *             @OA\Property(property="nom", type="string", example="hamza"),
     *             @OA\Property(property="prenom", type="string", example="saad"),
     *             @OA\Property(property="email", type="string", example="saad@gmail.com"),
     *             @OA\Property(property="role", type="string", example="user"),
     *             @OA\Property(property="password", type="string", example="Test@1245"),
     *        
     *         )
     *     ),
     *     @OA\Response(response=201, description="register is seccusefuly")
     * 
 * )
 */
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
/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"login"},
 *     summary="login in application",
 *     
 *        
 *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="mouad@gmail.com"),
     *             @OA\Property(property="password", type="string", example="1234568"),
     *        
     *         )
     *     ),
     *     @OA\Response(response=201, description="login is seccusefuly")
     * 
 * )
 */
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


  /**
 * @OA\Put(
 *     path="/api/reset/password/7",
 *     tags={"reset password"},
 *     summary="update password",
 *     
 *        
 *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"password"},
     *             @OA\Property(property="password", type="string", example="1234568"),
     *        
     *         )
     *     ),
     *     @OA\Response(response=201, description="update password is seccusefuly")
     * 
 * )
 */

  public function restPassword(Request $request,$id){

    $request->validate([
      'password'=>'required|min:6|'
    ]);
    
    $user = User::find($id);
    $user->password = $request->password;
    $user->update();
    return response()->json(["messsage"=>"update password is successfuly"]);
  }

}
