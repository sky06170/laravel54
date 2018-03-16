<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ArticleRepository;
use Carbon\Carbon;

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

    public function postMessage()
    {
        try{

            $datetime = Carbon::now('Asia/Taipei')->toDateTimeString();

            $publish_time = Carbon::now('Asia/Taipei')->addSecond(15)->toDateTimeString();

            echo $publish_time.'<br>';

            $request = [
                'access_token' => env('JUKSY_FB_PAGE_TOKEN'),
                'message' => 'laravel Test !'.$datetime,
                'published' => false,
                'scheduled_publish_time' => Carbon::parse($publish_time)->getTimestamp()
            ];

            $ch = curl_init('https://graph.facebook.com/v2.12/'.env('JUKSY_FB_PAGES').'/feed');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_exec($ch);
            curl_close($ch);

            echo json_encode(array(
                'bool' => true
            ));



        }catch(\Exception $e){

            echo json_encode(array(
                'bool' => false
            ));

        }
    }

    public function deleteMessage(Request $request)
    {
        //$postID = '1261910873819373_2121466434530475';

        $postID = $request->get('postID','');

        try{

            $request = [
                'access_token' => env('JUKSY_FB_PAGE_TOKEN')
            ];

            $ch = curl_init('https://graph.facebook.com/v2.12/'.$postID);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_exec($ch);
            curl_close($ch);

            echo json_encode(array(
                'bool' => true
            ));



        }catch(\Exception $e){

            echo json_encode(array(
                'bool' => false
            ));

        }
    }
}
