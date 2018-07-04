<?php

/**
*
* Assets Function to help with file url's
*
*/
function assets($type, $url, $file = null){

	$_ci = &get_instance();
	$_assetsUrl = $_ci->config->slash_item('base_url'). 'assets/';

	if($type == "libs"){
		$fullURL = $_assetsUrl.'libs/'.$file;
	}elseif($type == "system"){

		switch($url){
			case 'assets':
				$fullURL = $_assetsUrl.'system/assets/'.$file;
			break;
			case 'css':
				$fullURL = $_assetsUrl.'system/css/'.$file;
			break;
			case 'js':
				$fullURL = $_assetsUrl.'system/js/'.$file;
			break;
			case 'img':
				$fullURL = $_assetsUrl.'system/img/'.$file;
			break;	
			case 'system':
				$fullURL = $_assetsUrl.'system/';
			break;
		}
	}
	return $fullURL;
}