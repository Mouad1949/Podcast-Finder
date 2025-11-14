<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Http\Requests\StorePodcastRequest;
use App\Http\Requests\UpdatePodcastRequest;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PodcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        /**
 * @OA\Get(
 *     path="/api/podcasts",
 *     tags={"Podcast"},
 *     summary="Liste des podcasts",
 *     @OA\Response(
 *         response=200,
 *         description="Succès",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 08:35:00"),
 *             @OA\Property(property="message", type="string", example="Podcast retrieved successfully"),

 *                 )
 *     )
 * )
 */
    public function index()
    {
        $podcasts = Podcast::all();
        return response()->json([
              "messges"=>"List all podcasts",
              "users"=>$podcasts
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
 * @OA\Post(
 *     path="/api/podcasts/create",
 *     tags={"create podcasts"},
 *     summary="Add podcasts",
 *     
 *        
 *     @OA\RequestBody(
  *         required=true,
  *         @OA\JsonContent(
  *             required={"title","description","catégorie","image"},
  *             @OA\Property(property="title", type="string", example="dev"),
  *             @OA\Property(property="description", type="string", example="text tets"),
  *             @OA\Property(property="catégorie", type="string", example="devlo"),
  *             @OA\Property(property="image", type="string", example="https//images/logo.png"),
  *        
  *         )
  *     ),
  *     @OA\Response(
 *         response=200,
 *         description="podcast created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="podcasts created successfully")
 *         )
 *     ),
 *   @OA\Response(
 *         response=404,
 *         description="podcast not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="podcast not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function store(StorePodcastRequest $request ,Podcast $podcast)
    {
        if(!Gate::allows('create' ,$podcast)){
          return "You don't have access for create podcast";
        }
        $uploadimage = Cloudinary::upload(
          $request->file('image')->getRealPath()
        );

        $imageUrl = $uploadimage->getSecurePath();
        $userId = $request->user()->id;
        $podcast = Podcast::create([
          "title" => $request->title,
          "description" => $request->description,
          "catégorie" => $request->catégorie,
          "image" => $imageUrl,
          "user_id" => $userId
        ]);
        return response()->json(["messages"=>"podcast creation payload","podcast" =>$podcast]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Podcast $podcast, Request $request , $id)
    {
        $podcast = Podcast::find($id);
        $podcast->animateur;
        $podcast->episodes;
        return  response()->json(["messages"=>"podcast creation payload","podcast" =>$podcast ]);;
    }

    /**
     * Update the specified resource in storage.
     */

        /**
 * @OA\Put(
 *     path="/api/podcasts/update/{id}",
 *     tags={"update podcasts"},
 *     summary="update podcasts",
 *   @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the podcast to update",
 *         @OA\Schema(type="integer", example=101)
 *     ),
 *     
 *        
 *     @OA\RequestBody(
  *         required=true,
  *         @OA\JsonContent(
  *             required={"title","description","catégorie","image"},
  *             @OA\Property(property="title", type="string", example="dev"),
  *             @OA\Property(property="description", type="string", example="text tets"),
  *             @OA\Property(property="catégorie", type="string", example="devlo"),
  *             @OA\Property(property="image", type="string", example="https//images/logo.png"),
  *        
  *         )
  *     ),
  *     @OA\Response(
 *         response=200,
 *         description="podcast update successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="podcasts update successfully")
 *         )
 *     ),
 *   @OA\Response(
 *         response=404,
 *         description="podcast not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="podcast not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function update(UpdatePodcastRequest $request, Podcast $podcast,$id)
    {
      
        $podcast = Podcast::find($id);
        if(!Gate::allows('update' ,$podcast)){
          return "You don't have access for update podcast";
        }
        if($request->hasFile('image')){
          $uploadimage = Cloudinary::upload(
            $request->file('image')->getRealPath()
          );
          $imageUrl = $uploadimage->getSecurePath();
          $podcast->image = $imageUrl;
        }
        $podcast->title =$request->title;
        $podcast->description =$request->description;
        $podcast->catégorie =$request->catégorie;
        $podcast->user_id = $request->user()->id;
        $podcast->update();
        return response()->json(["messages"=>"podcast update payload","podcast" =>$podcast]);
    }

    /**
     * Remove the specified resource from storage.
     */

            /**
 * @OA\Delete(
 *     path="/api/podcasts/delete/{id}",
 *     tags={"delete podcast"},
 *     summary="delete podcast",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the podcast to delete",
 *         @OA\Schema(type="integer", example=101)
 *     ),  
 *        
   *     @OA\Response(
 *         response=200,
 *         description="podcast delete successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="podcasts delete successfully")
 *         )
 *     ),
 *    @OA\Response(
 *         response=404,
 *         description="podcast not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="podcasts not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function destroy(Podcast $podcast,$id)
    {
        $podcast = Podcast::find($id);
        if(!Gate::allows('delete' ,$podcast)){
          return "You don't have access for delete podcast";
        }
        $podcast->delete();
        return response()->json(["messages" => "Delete podcast is seccussefuly" ,"podcast"=>$podcast->title]);
    }
}
