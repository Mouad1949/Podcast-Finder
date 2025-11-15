<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Podcast;
use Illuminate\Http\Request;

class SearchController extends Controller
{


  public function searchPodcasts(Request $request){

    $query = $request->query('query');
    $podcasts = Podcast::query()
        ->where('title', 'LIKE', "%{$query}%")
        ->orWhere('catégorie', 'LIKE', "%{$query}%")
        ->orWhereHas('animateur', function ($q) use ($query) {
            $q->where('nom', 'LIKE', "%{$query}%");
        })
        ->get();
        if ($podcasts->isEmpty()) {
            return [
                "message" => "not found podacts"
            ];
       }
        return response()->json($podcasts);
      }
    public function searchEpisode(Request $request){
    $query = $request->query('query');
    $episodes = Episode::query()
        ->where('title', 'LIKE', "%{$query}%")
        ->orWhere('created_at', 'LIKE', "%{$query}%")
        ->orWhereHas('podcast', function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%");
        })
        ->get();
        if ($episodes->isEmpty()) {
            return [
                "message" => "not found episode"
            ];
       }
        return response()->json($episodes);
      }
}
