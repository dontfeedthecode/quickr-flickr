<?php
class Controller_Main extends Controller
{
	public function index()
	{
		echo $this->render('index.html');
	}
	
	public function search($page=1)
	{
		$page_size = 5;
		$text      = ($_GET['s']) ? strip_tags(trim($_GET['s'])) : 'anything';
		$flickr    = new Flickr();
		$response  = $flickr->search($text, $page, $page_size);
		// Check that request status is ok
		if($response['stat'] == 'ok')
		{
			$response  = $response['photos'];
			// Bind each photo to model
			$photos = array();
			foreach($response['photo'] as $photo)
			{
				$photo_model = Model::grab('Photo');
				$photo_model->load($photo);
				$photos[] = array(
					'id'         => $photo_model->id,
					'thumb_url'  => $photo_model->fetchImage('q'),
					'image_url'  => $photo_model->fetchImage(),
					'flickr_url' => $photo_model->fetchUrl(),
					'title'      => $photo_model->title
				);
			}
			// Set up pagination
			$pagination = new Pagination();
			$pagination->setLink("/yahoo/search/%s&s={$text}");
			$pagination->setPage($response['page']);
			$pagination->setSize($page_size);
			$pagination->setTotalRecords($response['total']);
			// Save search term in session
			$_SESSION['search_term'] = $text;
			echo $this->render('search.html', 
				array(
					'search_term'   => $text,
					'total_results' => $response['total'],
					'photos'        => $photos,
					'pagination'    => $pagination->create_links()
				)
			);
		}
		else
		{
			// Pass back simple error message
			echo $this->render('error.html', 
				array(
					'search_term' => $text,
					'message'     => 'There was a problem with your search, please try again.'
				)
			);
		}
	}
	
	public function view($id=false)
	{
		// Check if ID parameter was passed
		if($id)
		{
			// Load flickr and use getInfo to return photo info
			$flickr = new Flickr();
			$response = $flickr->getInfo($id);
			// If all goes well...
			if($response['stat'] == 'ok')
			{
				// Set up photo model and do the magic
				$photo_model = new Model_Photo();
				$photo_model->load($response['photo']);
				echo $this->render('view.html',
					array(
						'search_term'  => $_SESSION['search_term'],
						'return_to'    => $_SERVER['HTTP_REFERER'],
						'medium_image' => $photo_model->fetchImage('z'),
						'large_image'  => $photo_model->fetchImage('c'),
						'owner'        => $photo_model->owner,
						'title'        => $photo_model->title,
						'description'  => $photo_model->description
					)
				);
			}
			// If something goes wrong... Should set up some pretty error
			// message depending on the status, no time unfortunately.
			else
			{
				// Pass back simple error message
				echo $this->render('error.html', 
					array(
						'message' => 'Oops! Something went wrong...'
					)
				);
			}
		}
	}
}
