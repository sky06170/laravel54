<?php

namespace App\Presenters;

class YoutubePresenter{

	public function getVideoTitle($video)
	{
		return $video->snippet->title;
	}

	public function getVideoImg($video)
	{
		return $video->snippet->thumbnails->medium->url;
	}

}

?>