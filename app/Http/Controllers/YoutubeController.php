<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Madcoda\Youtube\Facades\Youtube;
use App\Services\Youtube\YoutubeService;

class YoutubeController extends Controller
{

    protected $youtubeService;

    public function __construct(YoutubeService $youtubeService)
    {
        $this->youtubeService = $youtubeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $playlist = $this->youtubeService->youtubePlaylist;

        $videos = $this->youtubeService->getVideos(24);

        $data = compact('playlist', 'videos');

        dd($videos);
        
        return view('youtube', $data);
    }

    public function watch(Request $request)
    {
        $reponse = $this->youtubeService->getWatchInfo($request);

        $video = $reponse['video'];

        $items = $reponse['items'];

        return 'watch';
    }

}
