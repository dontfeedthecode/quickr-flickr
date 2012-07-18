<?php
class Model
{
	/**
	* Return instance of model
	*
	* @param string $name Filename of model to load
	*
	* @since 1.0
	*/
	public static function grab($name)
	{
		$class = 'Model_'.$name;
		return new $class;
	}
	
	/**
	* Load response data into model
	*
	* @param mixed $data Response data to be converted to model props
	*
	* @since 1.0
	*/
	public function load($data)
	{
		foreach($data as $k => $v)
		{
			$this->{$k} = $v;
		}
	}
}
