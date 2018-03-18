<?php

namespace App\Services\Facebook;

use App\Traits\Date;

class Pages
{

    use Date;

    public $vision;

    public $pagesID;

    public $pagesToken;

    public function __construct()
    {
        $this->vision = 'v2.12';

        $this->pagesID = env('JUKSY_FB_PAGES');

        $this->pagesToken = env('JUKSY_FB_PAGE_TOKEN');
    }

    /**
     * 排程發佈時間(起始)
     *
     * @return String
     */
    private function startScheduledPublishTime()
    {
        return Date::now()->subHour(8)->addMinute(10)->addSecond(30)->toDateTimeString();
    }

    /**
     * 排程發佈時間(結束)
     *
     * @return String
     */
    private function endScheduledPublishTime()
    {
        return Date::now()->subHour(8)->addMonth(6)->addSecond(30)->toDateTimeString();
    }

    /**
     * 排程發佈時間(預計)
     *
     * @param $publish_datetime
     * @return String
     */
    private function scheduledPublishTime($publish_datetime)
    {
        return Date::object($publish_datetime)->subHour(8)->addSecond(30)->toDateTimeString();
    }

    /**
     * 是否在排程發佈時間範圍內
     *
     * @param $publish_datetime
     * @return bool
     */
    private function isInScheduledPublishTimeRange($publish_datetime)
    {
        $startTimestamp = Date::timeStamp($this->startScheduledPublishTime());

        $endTimestamp = Date::timeStamp($this->endScheduledPublishTime());

        $publishTimestamp = Date::timeStamp($publish_datetime);

        if($startTimestamp <= $publishTimestamp && $publishTimestamp <= $endTimestamp)
        {
            return true;
        }

        return false;
    }

    /**
     * 發布貼文
     *
     * @param $message
     * @return String
     */
    public function publish($message)
    {
        $request = [
            'access_token' => $this->pagesToken,
            'message' => $message
        ];

        $ch = curl_init('https://graph.facebook.com/'.$this->vision.'/'.$this->pagesID.'/feed');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * 發佈排程貼文
     *
     * @param $message
     * @param null $scheduled_publish_datetime
     * @return bool|String
     */
    public function publishScheduled($message,$scheduled_publish_datetime = null)
    {

        $publish_datetime = $this->scheduledPublishTime($scheduled_publish_datetime);

        if(!$this->isInScheduledPublishTimeRange($publish_datetime))
        {
            return false;
        }

        $request = [
            'access_token' => $this->pagesToken,
            'message' => $message,
            'published' => false,
            'scheduled_publish_time' => Date::timeStamp($publish_datetime)
        ];

        $ch = curl_init('https://graph.facebook.com/'.$this->vision.'/'.$this->pagesID.'/feed');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * 刪除貼文
     *
     * @param string $postID
     * @return String
     */
    public function delete($postID = '')
    {
        $request = [
            'access_token' => $this->pagesToken
        ];

        $ch = curl_init('https://graph.facebook.com/'.$this->vision.'/'.$postID);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}