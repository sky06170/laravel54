<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/3/16
 * Time: 上午10:56
 */

namespace App\Repositories;

use Carbon\Carbon;
use Juksy\Shredder\Entities\SchedulePost;
use Juksy\Shredder\Entities\Post;
use Juksy\Shredder\Entities\InstantArticles;

class ArticleRepository
{

    public function makeSchedulePost($message)
    {
        $now_datetime = Carbon::now('Asia/Taipei')->toDateTimeString();

        $publish_time = Carbon::now('Asia/Taipei')->addMinute(1);

        // New a entity
        $post = new SchedulePost();
        $post->page_id = env('JUKSY_FB_PAGES');
        $post->message = $message;
        $post->link = 'https://laravel54.app/test/'.$now_datetime;
        $post->scheduled_publish_time = Carbon::parse($publish_time)->getTimestamp();

        return $post;
    }

}