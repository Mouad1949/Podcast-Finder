<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Http\Requests\StoreEpisodeRequest;
use App\Http\Requests\UpdateEpisodeRequest;
use App\Models\Podcast;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

            /**
 * @OA\Get(
 *     path="/api/episodes",
 *     tags={"episode"},
 *     summary="Liste des episodes",
 *     @OA\Response(
 *         response=200,
 *         description="Succès",
 *         @OA\JsonContent(type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 08:35:00"),
 *             @OA\Property(property="message", type="string", example="Episode retrieved successfully"),

 *                 )
 *     )
 * )
 */
    public function index($id)
    {
        $podcast = Podcast::find($id);
        $episodes = $podcast->episodes;
        return response()->json([
              "messges"=>"List all episodes",
              "podcast"=>$podcast->title,
              "episodes"=>$episodes
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */


        /**
     * Store a newly created resource in storage.
     */

    /**
 * @OA\Post(
 *     path="/api/episodes/create",
 *     tags={"create episodes"},
 *     summary="Add episodes",
 *     
 *        
 *     @OA\RequestBody(
  *         required=true,
  *         @OA\JsonContent(
  *             required={"title","description","audio"},
  *             @OA\Property(property="title", type="string", example="dev"),
  *             @OA\Property(property="description", type="string", example="text tets"),
  *             @OA\Property(property="audio", type="string", example="https//images/music.mp3"),
  *        
  *         )
  *     ),
  *     @OA\Response(
 *         response=200,
 *         description="episode created successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="episodes created successfully")
 *         )
 *     ),
 *   @OA\Response(
 *         response=404,
 *         description="episode not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="episode not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function store(StoreEpisodeRequest $request, $id ,Episode $episode)
    {
    
      $podcast = Podcast::find($id);
        if(!Gate::allows('create' ,$episode)){
                return "You don't have access for create episode";
      }
      $uploadAudio = Cloudinary::upload(
          $request->file('audio')->getRealPath(),['resource_type' => 'video']
      );
      $audioPath = $uploadAudio->getSecurePath();

      $episode = $podcast->episodes()->create([
        "title"=>$request->title,
        "description"=>$request->description,
        "audio"=>$audioPath,
      ]);
      return response()->json(["messages"=>"episode creation payload","episode" =>$episode]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Episode $episode,$id)
    {
        $episode = Episode::find($id);
           if (!$episode) {
        return response()->json(["error" => "Episode not found"], 404);
        }
        $prenomAnim = $episode->podcast->animateur->prenom;
        $podcast = $episode->podcast->title;
        return response()->json([
              "messges"=>"Show details episode",
              "podcast"=>$podcast,
              "prenom animateur"=>$prenomAnim,
              "episodes" =>$episode
            ]);
    }

    /**
     * Update the specified resource in storage.
     */

            /**
 * @OA\Put(
 *     path="/api/episodes/{id}/update/",
 *     tags={"update episodes"},
 *     summary="update episodes",
 *   @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the episode to update",
 *         @OA\Schema(type="integer", example=101)
 *     ),
 *     
 *        
 *     @OA\RequestBody(
  *         required=true,
  *         @OA\JsonContent(
  *             required={"title","description","audio"},
  *             @OA\Property(property="title", type="string", example="Epis"),
  *             @OA\Property(property="description", type="string", example="text tets"),
  *             @OA\Property(property="audio", type="string", example="https//audio.mp3"),
  *        
  *         )
  *     ),
  *     @OA\Response(
 *         response=200,
 *         description="episode update successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="episodes update successfully")
 *         )
 *     ),
 *   @OA\Response(
 *         response=404,
 *         description="episode not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="episode not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function update(UpdateEpisodeRequest $request, Episode $episode,$id)
    {
      $episode = Episode::find($id);
       if (!$episode) {
        return response()->json(["error" => "Episode not found"], 404);
      }
      if(!Gate::allows('update' ,$episode)){
                return "You don't have access for update episode";
      }
      if($request->hasFile('audio')){
        $uploadaudio = Cloudinary::upload(
          $request->file('audio')->getRealPath(),['resource_type' => 'video']
        );
        $audioPath = $uploadaudio->getSecurePath();
        $episode->audio = $audioPath;
      }
      $episode->title = $request->title;
      $episode->description = $request->description;
      
      $episode->update();
      return response()->json(["messages"=>"episode update payload","episode" =>$episode]);
    }

    /**
     * Remove the specified resource from storage.
     */


    
  /**
 * @OA\Delete(
 *     path="/api/episodes/{id}/delete",
 *     tags={"delete episode"},
 *     summary="delete episode",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the episode to delete",
 *         @OA\Schema(type="integer", example=101)
 *     ),  
 *        
   *     @OA\Response(
 *         response=200,
 *         description="episode delete successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Success"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:20:00"),
 *             @OA\Property(property="message", type="string", example="episodes delete successfully")
 *         )
 *     ),
 *    @OA\Response(
 *         response=404,
 *         description="episode not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Failed"),
 *             @OA\Property(property="message", type="string", example="episodes not found"),
 *             @OA\Property(property="timestamp", type="string", example="2025-10-13 11:45:00")
 *         )
 *     ),
       * 
 * )
 */
    public function destroy(Episode $episode , $id)
    {
      $episode = Episode::find($id);
        if(!Gate::allows('delete' ,$episode)){
                return "You don't have access for delete episode";
      }
       if (!$episode) {
        return response()->json(["error" => "Episode not found"], 404);
        }
        $episode->delete();
        return response()->json(["messages"=>"episode delete ","title episode" =>$episode->title]);
    }


  public function searchEpisode(){
    return "tetst";
  }
    
}
