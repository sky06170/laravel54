<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;
use App\Services\Facebook\Pages;

class TestController extends Controller
{

    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'Welcome to test!';
    }

    public function publishArticle()
    {
        $message = '系統發文測試';

        $post = $this->articleRepo->makeSchedulePost($message);

        $result = app('shredder')->postFeed(env('JUKSY_FB_PAGE_TOKEN'), $post);

        return json_encode($result);
    }

    public function deleteArticle(Request $request)
    {
        $post = $this->articleRepo->makePost($request->get('postID',''));

        $result = app('shredder')->delete(env('JUKSY_FB_PAGE_TOKEN'), $post);

        return json_encode($result);
    }

    /**
     * 發布粉絲團貼文
     */
    public function postMessage()
    {
        $publish_time = '2018-03-19 15:23:00';

        $message = 'test post';

        $pages = new Pages();

        if(isset($publish_time)){

            $result = $pages->publishScheduled($message,$publish_time);

        }else{

            $result = $pages->publish($message);

        }

        return $result;
    }

    /**
     * 刪除紛絲團貼文
     */
    public function deleteMessage(Request $request)
    {
        $postID = $request->get('postID','');

        $pages = new Pages();

        $result = $pages->delete($postID);

        return $result;
    }

}
