<?php

namespace App\Services\Youtube;

use Madcoda\Youtube\Facades\Youtube;

class YoutubeService{

	public $defaultYoutubePlaylist;

	public $youtubePlaylist;

	public function __construct()
	{
		$this->youtubePlaylist = $this->setYoutubePlaylist();

		$this->defaultYoutubePlaylist = '潮物開箱';
	}

	/**
	 * set default Playlist
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
     * get all PlaylistItems
     * @return array|null [description]
     */
    public function getAllPlaylistItems()
    {
    	$datas = [];

    	foreach($this->youtubePlaylist as $list){

   			$items = Youtube::getPlaylistItemsByPlaylistId($list['id']);

			if($items != null){

				foreach($items as $item){

					$item->PlaylistItemsID = $list['id'];

					array_push($datas,$item);

				}

			}

    	}

    	return $datas;
    }

    /**
     * get videos
     * @param  integer $maxResults 
     * @return array $videos
     */
    public function getVideos($maxResults = 24)
    {
    	$videos = [];

    	$allPlaylistItems = $this->getAllPlaylistItems();

    	$videos = array_slice($allPlaylistItems, 0, $maxResults);

    	return $videos;
    }

    /**
     * get video
     * @param  string $v video id
     * @return object $vedio
     */
    public function getVideoByID($v = '')
    {
    	return Youtube::getVideoInfo($v);
    }

    public function getPlaylistItemsByID($v,$allPlaylistItems)
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
 	public function watchByID($v)
 	{
 		$response = [];

 		$video = $this->getVideoByID($v);

 		if(!$video){

 			return ['status' => false];

 		}

		$PlaylistItemsID = $this->getPlaylistItemsByID($v, $this->getAllPlaylistItems());

		$items = Youtube::getPlaylistItemsByPlaylistId($PlaylistItemsID);

		return [
			'status' => (!$video ? false : true),
			'video' => $video,
			'items' => $items
		];
 	}

 	/**
 	 * get PlaylistItems by playlist parameter
 	 * @param  [type] $playlist [description]
 	 * @return [type]           [description]
 	 */
 	public function getPlaylistItemsByName($playlist)
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
    public function watchByName($playlist)
 	{
 		$response = [];

 		$PlaylistItemsID = $this->getPlaylistItemsByName($playlist);

 		if($PlaylistItemsID == ''){

 			return ['status' => false];

 		}

		$items = Youtube::getPlaylistItemsByPlaylistId($PlaylistItemsID);

		$video = $this->getVideoByID($items[0]->contentDetails->videoId);

		return [
			'status' => ($PlaylistItemsID == '' ? false : true),
			'video' => $video,
			'items' => $items
		];
 	}

 	/**
 	 * watch blade default data info
 	 * @return [type] [description]
 	 */
 	public function watchDefault()
 	{
 		return $this->watchByName($this->defaultYoutubePlaylist);
 	}

 	/**
 	 * get watch blade data info
 	 * @param  [type] $request [description]
 	 * @return [type]          [description]
 	 */
 	public function getWatchInfo($request)
 	{
 		$response = [];

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

}

?>