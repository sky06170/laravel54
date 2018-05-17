<?php

namespace App\Services\Youtube;

use Madcoda\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Log;

class YoutubeService{

	public $defaultYoutubePlaylist;

	public $youtubePlaylist;

	public function __construct()
	{
		$this->youtubePlaylist = $this->setDefaultYoutubePlaylist();

		$this->defaultYoutubePlaylist = '潮物開箱';
	}

	/**
	 * 設定預設播放清單
	 * @return array Playlist
	 */
	public function setDefaultYoutubePlaylist()
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
     * 取得影片
     * @param  string $v video id
     * @return object $vedio
     */
    public function getVideo($v = '')
    {
    	return Youtube::getVideoInfo($v);
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
    	}else{
    		$videos = $datas;
    	}

    	krsort($videos);

    	return array_values($videos);
    }

    /**
 	 * 取得 watch 頁面資料
 	 * @param  object $request http request
 	 * @return array
 	 */
 	public function getWatchInfo($request)
 	{
 		$v = $request->input('v','');

        $playlist = $request->input('playlist','');

        if($v != ''){
        	$response = $this->getWatchInfoByVideoID($v);
        }else{
        	$response = $this->getWatchInfoByPlaylistName($playlist);
        }

        if(!$response['status']){
        	$response = $this->getWatchInfoByDefault();
        }

        return $response;
 	}

 	/**
     * 透過影片 ID 取得 watch 頁面資料
     * @param  string $v video ID
     * @return array
     */
 	private function getWatchInfoByVideoID($v)
 	{
 		$video = $this->getVideo($v);

 		if(!$video){
 			return ['status' => false];
 		}

		$PlaylistItemsID = $this->getVideoPlaylistItemsID($v, $this->getAllPlaylistItems());

		if($PlaylistItemsID === ''){
			return ['status' => false];
		}

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
     * 取得影片播放清單ID
     * @param  string $v                影片ID
     * @param  array  $allPlaylistItems 所有播放清單影片
     * @return string
     */
    private function getVideoPlaylistItemsID($v,$allPlaylistItems)
    {
		$PlaylistItemsID = '';

    	foreach($allPlaylistItems as $item){
 			if($v === $item->contentDetails->videoId){
 				$PlaylistItemsID = $item->PlaylistItemsID;
 			}
 		}

 		return $PlaylistItemsID;
    }

    /**
     * 透過播放清單名稱取得 watch 頁面資料
     * @param  string $playlist 播放清單名稱
     * @return array
     */
    private function getWatchInfoByPlaylistName($playlist)
 	{
 		$response = [];

 		$PlaylistItemsID = $this->getPlaylistItemsByPlaylistName($playlist);

 		if($PlaylistItemsID == ''){
 			return ['status' => false];
 		}

		$items = Youtube::getPlaylistItemsByPlaylistId($PlaylistItemsID);

		$video = $this->getVideo($items[0]->contentDetails->videoId);

		$nextVideoID = $this->getPlaylistItemsNextVideoID($items[0]->contentDetails->videoId,$items);

		return [
			'status' => ($PlaylistItemsID == '' ? false : true),
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
 	private function getPlaylistItemsByPlaylistName($playlist)
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
 	 * 透過預設資料取得 watch 頁面資料getWatchInfoByDefault
 	 * @return array
 	 */
 	private function getWatchInfoByDefault()
 	{
 		return $this->getWatchInfoByPlaylistName($this->defaultYoutubePlaylist);
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