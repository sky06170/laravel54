<?php

namespace App\Services\Youtube;

use Madcoda\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Log;

class YoutubeService{

	public $defaultYoutubePlaylist;

	public $youtubePlaylist;

	public function __construct()
	{
		$this->youtubePlaylist = $this->setYoutubePlaylist();

		$this->defaultYoutubePlaylist = '潮物開箱';
	}

	/**
	 * 設定預設播放清單
	 * @return array Playlist
	 */
	public function setYoutubePlaylist()
    {
        return [
            '潮物開箱' => [
                'id' => 'PLBUKFqm-0-UcM-M3BPhy1MlpipWQSsp72',
                'desc' => '最新潮的球鞋、3C潮物，通通先過JUKSY編輯手上！火燙燙開箱給盯著螢幕的你！',
                'img' => 'https://i.ytimg.com/vi/tKDIY-dISxA/maxresdefault.jpg',
            ],
            'JUKSY星推薦' => [
                'id' => 'PLBUKFqm-0-UfoQIAUaC0-U8r7xkukXdGu',
                'desc' => '我們都愛聽的歌手，私底下究竟會聽誰的歌？一起了解這些潮流歌手的播放清單！',
                'img' => 'https://i.ytimg.com/vi/7dBCKCIwtZk/hqdefault.jpg',
            ],
            'What\'s Up Hyper' => [
                'id' => 'PLBUKFqm-0-UeaKkv-BblhgH5oUgrcFIhS',
                'desc' => '潮流生澀難懂？才怪！誰說的！讓潮流編輯#Xin用超ㄎㄧㄤ流行語跟你解釋這些球鞋和品牌的大小事！',
                'img' => 'https://i.ytimg.com/vi/tq9mkg6oTVM/hqdefault.jpg',
            ],
        ];
    }

    /**
     * 取得所有播放清單影片
     * @return array|null
     */
    public function getAllPlaylistItems($maxResults = null)
    {
    	$datas = [];
    	$videos = [];

    	foreach($this->youtubePlaylist as $key => $list){
   			$items = Youtube::getPlaylistItemsByPlaylistId($list['id']);
			if($items != null){
				foreach($items as $item){
					$item->PlaylistItmesName = $key;
					$item->PlaylistItemsID = $list['id'];
					$datas[$item->snippet->publishedAt] = $item;
				}
			}
    	}

    	if(count($datas) > 0 && $maxResults != null){
    		$videos = array_slice($datas, 0, $maxResults);
    	}

    	krsort($videos);

    	return array_values($videos);
    }

    /**
 	 * get watch blade data info
 	 * @param  [type] $request [description]
 	 * @return [type]          [description]
 	 */
 	public function getWatchInfo($request)
 	{
 		$v = $request->input('v','');

        $playlist = $request->input('playlist','');

        if($v != ''){
        	$response = $this->watchByID($v);
        }else{
        	$response = $this->watchByName($playlist);
        }

        if(!$response['status']){
        	$response = $this->watchDefault();
        }

        return $response;
 	}

    /**
     * 取得影片
     * @param  string $v video id
     * @return object $vedio
     */
    private function getVideoByID($v = '')
    {
    	return Youtube::getVideoInfo($v);
    }

    /**
     * 取得播放清單ID
     * @param  string $v                影片ID
     * @param  array  $allPlaylistItems 所有播放清單影片
     * @return string
     */
    private function getPlaylistItemsIDByID($v,$allPlaylistItems)
    {
		$PlaylistItemsID = '';

    	foreach($allPlaylistItems as $item){
 			if($v == $item->contentDetails->videoId){
 				$PlaylistItemsID = $item->PlaylistItemsID;
 			}
 		}

 		return $PlaylistItemsID;
    }

    /**
     * get watch blade data info by v parameter
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
 	private function watchByID($v)
 	{
 		$response = [];

 		$video = $this->getVideoByID($v);

 		if(!$video){
 			return ['status' => false];
 		}

		$PlaylistItemsID = $this->getPlaylistItemsIDByID($v, $this->getAllPlaylistItems());

		$items = Youtube::getPlaylistItemsByPlaylistId($PlaylistItemsID);

		$nextVideoID = $this->getPlaylistItemsNextVideoID($v,$items);

		return [
			'status' => (!$video ? false : true),
			'video' => $video,
			'items' => $items,
			'nextVideoID' => $nextVideoID
		];
 	}

 	/**
 	 * 取得播放清單ID
 	 * @param  string $playlist 播放清單名稱
 	 * @return string           
 	 */
 	private function getPlaylistItemsByName($playlist)
    {
		$PlaylistItemsID = '';

    	foreach($this->youtubePlaylist as $key => $list){
 			if($playlist == $key){
 				$PlaylistItemsID = $list['id'];
 			}
 		}

 		return $PlaylistItemsID;
    }

    /**
     * get watch blade data info by playlist parameter
     * @param  [type] $playlist [description]
     * @return [type]           [description]
     */
    private function watchByName($playlist)
 	{
 		$response = [];

 		$PlaylistItemsID = $this->getPlaylistItemsByName($playlist);

 		if($PlaylistItemsID == ''){
 			return ['status' => false];
 		}

		$items = Youtube::getPlaylistItemsByPlaylistId($PlaylistItemsID);

		$video = $this->getVideoByID($items[0]->contentDetails->videoId);

		$nextVideoID = $this->getPlaylistItemsNextVideoID($items[0]->contentDetails->videoId,$items);

		return [
			'status' => ($PlaylistItemsID == '' ? false : true),
			'video' => $video,
			'items' => $items,
			'nextVideoID' => $nextVideoID
		];
 	}

 	/**
 	 * watch blade default data info
 	 * @return [type] [description]
 	 */
 	private function watchDefault()
 	{
 		return $this->watchByName($this->defaultYoutubePlaylist);
 	}

 	/**
 	 * 取得播放清單的下一則影片ID
 	 * @param  string $v     影片ID
 	 * @param  array  $items 影片清單
 	 * @return string
 	 */
 	private function getPlaylistItemsNextVideoID($v,$items)
 	{
 		$nextVedioID = $items[0]->contentDetails->videoId;

 		$nextSwitch = false;

 		foreach($items as $item){
 			if($nextSwitch == true){
 				$nextVedioID = $item->contentDetails->videoId;
 				break;
 			}
 			if(!$nextSwitch && $v == $item->contentDetails->videoId){
 				$nextSwitch = true;
 			}
 		}

 		return $nextVedioID;
 	}

}

?>