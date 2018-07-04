<?php
function __autoload($class) {

	$class = strtolower($class);

	if ( (!preg_match('/ci_/', strtolower($class))) && (!preg_match('/my_/', strtolower($class))) ) {
		
		$path = dirname(__FILE__);
		$path = str_replace('helpers', '', $path);

		$file = $path.'models'.DIRECTORY_SEPARATOR.$class.'.php';

		if(file_exists($file)){
			require_once($file);
		}else{
			$file = $path.'third_party'.DIRECTORY_SEPARATOR.$class.'.php';
		}
	}
}