<?php
class Controller
{
	public $twig;
	
	public function __construct()
	{
		// Import twig template system as each time the controller is initiated
		// we will be rendering a template
		require_once('libs/Twig/Autoloader.php');
		Twig_Autoloader::register();
		// Load view folder into twig
		$loader = new Twig_Loader_Filesystem('views');
		// Prevent caching and set up environment
		$this->twig   = new Twig_Environment($loader, array(
		    'cache' => false
		));
	}
	
	/**
	* Create flickr image url link from model properties
	*
	* @param string $view Filename of view to render
	* @param array $data Data to be bound to view
	*
	* @since 1.0
	*/
	public function render($view, $data=array())
	{
		return $this->twig->render($view, $data);
	}
}