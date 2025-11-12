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
    public function store(StorePodcastRequest $request)
    {
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
    public function show(Podcast $podcast, Request $request)
    {
        $user = $request->user();
        $podcast = $user->podcasts;
        return $podcast;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePodcastRequest $request, Podcast $podcast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Podcast $podcast)
    {
        //
    }
}
