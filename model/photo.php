<?php
class Model_Photo extends Model
{
	/**
	* Create flickr image url link from model properties
	*
	* @param string $size Size of image
	*        s	small square 75x75
	*	     q	large square 150x150
	*	     t	thumbnail, 100 on longest side
	*	     m	small, 240 on longest side
	*	     n	small, 320 on longest side
	*	     -	medium, 500 on longest side
	*	     z	medium 640, 640 on longest side
	*	     c	medium 800, 800 on longest side†
	*	     b	large, 1024 on longest side*
	*	     o	original image, either a jpg, gif or png, depending on source format
	*
	* @since 1.0
	*/
	public function fetchImage($size='m')
	{
		return sprintf("http://farm%s.staticflickr.com/%s/%s_%s_%s.jpg",
			$this->farm,
			$this->server,
			$this->id,
			$this->secret,
			$size
		);
	}
	
	/**
	* Create flickr url link
	*
	*/
	public function fetchUrl()
	{
		return sprintf("http://www.flickr.com/photos/%s/%s",
			$this->owner,
			$this->id
		);
	}
}