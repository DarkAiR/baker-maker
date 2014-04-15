// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/JG/trunk/components/com_joomgallery/assets/js/dhtml.js $
// $Id: dhtml.js 2566 2010-11-03 21:10:42Z mab $
/****************************************************************************************\
**   JoomGallery  1.5.6                                                                 **
**   By: JoomGallery::ProjectTeam                                                       **
**   Copyright (C) 2008 - 2010  JoomGallery::ProjectTeam                                **
**   Based on: JoomGallery 1.0.0 by JoomGallery::ProjectTeam                            **
**   Released under GNU GPL Public License                                              **
**   License: http://www.gnu.org/copyleft/gpl.html or have a look                       **
**   at administrator/components/com_joomgallery/LICENSE.TXT                            **
\****************************************************************************************/

// This Script was written by Benjamin Meier, b2m@gmx.de
// The DHTML-function for creating a overlaying div-layer uses parts of the Dynamic Image Mambot, written by Manuel Hirsch
// and Lightbox => core code quirksmode.org
function joom_opendhtml(imgsource, imgprice, imgoldprice, imgarticle, imgsize, imgtitle, imgtext, imgwidth, imgheight) {

  imgwidth = parseInt(imgwidth);
  imgheight = parseInt(imgheight);

  var windowWidth, windowHeight;
  if (self.innerHeight) {        // all except Explorer
    windowWidth = self.innerWidth;
    windowHeight = self.innerHeight;
  } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
    windowWidth = document.documentElement.clientWidth;
    windowHeight = document.documentElement.clientHeight;
  } else if (document.body) { // other Explorers
    windowWidth = document.body.clientWidth;
    windowHeight = document.body.clientHeight;
  }

  var yScroll, xScroll;

  if (self.pageYOffset) {
    yScroll = self.pageYOffset;
    xScroll = self.pageXOffset;
  } else if (document.documentElement && document.documentElement.scrollTop){         // Explorer 6 Strict
    yScroll = document.documentElement.scrollTop;
    xScroll = document.documentElement.scrollLeft;
  } else if (document.body) {// all other Explorers
    yScroll = document.body.scrollTop;
    xScroll = document.body.scrollLeft;
  }

  if(resizeJsImage==1) {
   if((imgwidth+3*jg_padding)>windowWidth) {
     imgheight = (imgheight * (windowWidth-2*jg_padding))/imgwidth;
     imgwidth = windowWidth-2*jg_padding;
   }
   if((imgheight+2*jg_padding+80)>windowHeight) {
     imgwidth = (imgwidth * (windowHeight-2*jg_padding-80))/imgheight;
     imgheight = windowHeight-2*jg_padding-80;
   }
  }
  var postop =(windowHeight/2)-(imgheight/2)+yScroll+document.body.style.padding-10;
  var posleft =(windowWidth/2)-(imgwidth/2)+xScroll+document.body.style.padding;
  if(postop >= 30) {
   postop = postop-30;
  }
  var bodyObj = document.getElementsByTagName('BODY')[0];
  if(!document.getElementById("jg_photocontainer")) {
    divObjContainer = document.createElement("div");
    divObjContainer.setAttribute("id", "jg_photocontainer");
    bodyObj.appendChild(divObjContainer);
  } else {
    divObjContainer = document.getElementById("jg_photocontainer");
  }
  divObjContainer.innerHTML = "";

  var closeimg = new Image();
  closeimg.src = "components/com_joomgallery/assets/images/close.png";

  var dhtmltext, dhtmltext2="";

  divObjContainer.style.display = "block";
/*  dhtmltext  = "<div class=\"jg_photocontainer\" style=\"top:"+postop+"px; left:"+posleft+"px; position: absolute; display:block;z-index:99999;\" onclick=\"joom_photocontainershut()\">";
  dhtmltext += "<div class=\"photoborder\" style=\"background-color: "+jg_openjs_background+"; padding: "+jg_padding+"px; border: solid 1px "+jg_dhtml_border+";\">";
  dhtmltext += "<img onclick=\"joom_photocontainershut()\" style=\"cursor:pointer;border: solid 1px #000;width:"+imgwidth+"px;height:"+imgheight+"px;\" src=\""+imgsource+"\" alt=\""+imgtitle+"\" width=\""+imgwidth+"px\" height=\""+imgheight+"px\" class=\"pngfile\" \/>";
  dhtmltext += "<img onclick=\"joom_photocontainershut()\" style=\"cursor:pointer;position:absolute;bottom:"+jg_padding+"px;right:"+jg_padding+"px;width:"+closeimg.width+"px;height:"+closeimg.height+"px;\" src=\""+closeimg.src+"\" alt=\"close\" id=\"dhtml_close\" class=\"pngfile\" />";
  dhtmltext += "<br /><div id=\"joom_dhtml_imgtext\" style=\"margin-top:"+jg_padding+"px;text-align: justify; width:"+imgwidth+"px;\">&nbsp;<br />&nbsp;</div>";
  dhtmltext += "<\/div></div>";*/




// »щем все ссылки на картинки
var elems = document.getElementsByTagName('a');
var links = Array();
var prevUrl = "";
var nextUrl = "";
var currIndex = 0;
var dhtmltext = "";
var index = 0;
for( var i=0; i<elems.length; i++ )
{
  arr = elems[i].href.match(/joom_opendhtml\('([^']+)[^\"]+/i);
  if( arr != null && arr.length > 1 )
  {
    links.push( arr[0] );
    if( arr[1] == imgsource )
    {
      currIndex = index;
    }
    index++;
  }
}
if( currIndex > 0 )
  prevUrl = links[currIndex-1];
if( currIndex < links.length-1 )
  nextUrl = links[currIndex+1];

//      top = window.getScrollTop() + (window.getHeight() / 15);

var scrollAmount = window.pageYOffset ? window.pageYOffset : document[(document.compatMode == 'CSS1Compat') ? 'documentElement' : 'body'].scrollTop;

  dhtmltext += ''
+ '<div class="overlay"></div>'
+ '<div class="popup_cont" onClick="joom_photocontainershut()" style="top:' + (scrollAmount + 50) + 'px">'
+ '<div class="popup" id="item_123">'
+ '<div class="close_but"><a href="javascript:joom_photocontainershut()"><img src="' + closeimg.src + '" alt="close" /></a></div>'
+ '<div class="popup_head">' + imgtitle + '</div>'
+ '<div class="popup_photo"><img src="' + imgsource + '" width="' + imgwidth + 'px" height="' + imgheight + 'px" alt="' + imgtitle + '" /></div>'
+ '<div class="item_data">'
//+ '<div class="item_label"><img src="components/com_joomgallery/assets/images/label.jpg" width="60" height="60" alt="ќбразец ткани" /></div>'

+ joomgallery_size + ': <strong>' + imgsize + '</strong>&nbsp;&nbsp;&nbsp;'
+ joomgallery_article + ': <strong>' + imgarticle + '</strong><br />'
+ joomgallery_price + ': <span class="item_old_price">' + imgoldprice + '</span> <span class="item_new_price">' + imgprice + '</span>'
+ '</div>'
+ '<div class="down_links"><div>';

if( prevUrl != "" )
  dhtmltext += '<a href="javascript:' + prevUrl + '">&larr; ' + joomgallery_prev + '</a>';
else
  dhtmltext += '&nbsp;';

dhtmltext += '</div><div class="down_links_r">';

if( nextUrl != "" )
  dhtmltext += '<a href="javascript:' + nextUrl + '">' + joomgallery_next + ' &rarr;</a>';
else
  dhtmltext += '&nbsp;';

dhtmltext += '</div></div>'
+ '</div>'
+ '</div>';


  divObjContainer.innerHTML = dhtmltext;
     document.getElementById("joom_dhtml_imgtext").style.width2 = document.getElementById("joom_dhtml_imgtext").style.width-document.getElementById("dhtml_close").style.width;
  if (jg_show_title_in_dhtml==1) {
   dhtmltext2 += "<strong>"+imgtitle+"</strong><br />";
  }
  if (jg_show_description_in_dhtml==1) {
   dhtmltext2 += imgtext;
  }
  if (dhtmltext2!="") {
   document.getElementById("joom_dhtml_imgtext").innerHTML = dhtmltext2;
  }

  if (jg_disableclick==1) {
    divObjContainer.oncontextmenu = function(){return false;}
  }
}

function joom_photocontainershut() {
  document.getElementById("jg_photocontainer").style.display = "none";
}

