<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Dotenv\Repository\RepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Liste des users",
 *     @OA\Response(
 *         response=200,
 *         description="Succès",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 08:35:00"),
 *             @OA\Property(property="message", type="string", example="Users retrieved successfully"),

 *                 )
 *     )
 * )
 */
    public function index()
    {
        if(Gate::allows('viewAny' , User::class)){
            $users = User::all();
            return response()->json([
              "messges"=>"List all users",
              "users"=>$users
            ]);
        }else{
          return "You don't have access";
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */


/**
 * @OA\Post(
 *     path="/api/users/create",
 *     tags={"create user"},
 *     summary="Add user",
 *     
 *        
 *     @OA\RequestBody(
  *         required=true,
  *         @OA\JsonContent(
  *             required={"nom","prenom","email","password"},
  *             @OA\Property(property="nom", type="string", example="hamza"),
  *             @OA\Property(property="prenom", type="string", example="saad"),
  *             @OA\Property(property="email", type="string", example="saad@gmail.com"),
  *             @OA\Property(property="password", type="string", example="Test@1245"),
  *        
  *         )
  *     ),
  *     @OA\Response(
 *         response=200,
 *         description="user created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="users created successfully")
 *         )
 *     ),
       * 
 * )
 */
    public function store(StoreUserRequest $request)
    {
        if(!Gate::allows('create',User::class)){
          return "You don't have access for create user";
        }
        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
        return response()->json(["messages" => "Add user is seccussefuly" ,"user"=>$user]);

    }

    /**
     * Display the specified resource.
     */
    
    public function show(string $id ,User $user)
    { 
        if(!Gate::allows('view',$user)){
          return "You don't have access";
        }
        $user = User::find($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */

    /**
 * @OA\Put(
 *     path="/api/users/update/{id}",
 *     tags={"update role of user"},
 *     summary="Update user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to update",
 *         @OA\Schema(type="integer", example=101)
 *     ),  
 *        
 *     @OA\RequestBody(
  *         required=true,
  *         @OA\JsonContent(
  *             required={"role"},
  *             @OA\Property(property="role", type="string", example="user"),
  *        
  *         )
  *     ),
   *     @OA\Response(
 *         response=200,
 *         description="user updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="users updated successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="user not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="user not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00")
 *         )
 *     ),
       * 
 * )
 */
    public function update(Request $request, string $id)
    {

      if(!Gate::allows('create',User::class)){
          return "You don't have access for update role user";
        }
        $user = User::find($id);
        $user->role = $request->role;
        $user->update();
        return response()->json(["messages" => "Update role of user is seccussefuly" ,"user"=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     */

        /**
 * @OA\Delete(
 *     path="/api/users/delete/{id}",
 *     tags={"delete user"},
 *     summary="delete user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to delete",
 *         @OA\Schema(type="integer", example=101)
 *     ),  
 *        
   *     @OA\Response(
 *         response=200,
 *         description="user delete successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="users delete successfully")
 *         )
 *     ),
 *    @OA\Response(
 *         response=404,
 *         description="user not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="users not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function destroy(string $id)
    {
      
        $user = User::find($id);
        if(!Gate::allows('delete' ,$user)){
          return "You don't have access for delete user";
        }
        $user->delete();
        return response()->json(["messages" => "Delete user is seccussefuly" ,"user"=>$user->prenom]);
    }
}
