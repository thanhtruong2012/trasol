<?php  
/**
 * Class Mail
 * Contain all system or common method.
 * @category Module
 * @package Libraries
 * @author LP (Le Van Phu) <vanphupc50@gmail.com>
 * @version 1.0
 */
// require_once VENDOR_PATH."PHPMailer/PHPMailerAutoload.php";
class Mail
{
	
	function __construct()
	{
		$this->_sendMail();
	}
	function _sendMail($email,$title,$content,$emailCC = array(),$emailBCC = array())
	{

	    $mail = new PHPMailer();

	    $mail->SMTPDebug = 0;                               

	    $mail->isSMTP();                                      // Set mailer to use SMTP

	    $mail->Mailer = 'smtp';

	    $mail->CharSet="UTF-8";

	    $mail->Host = "email-smtp.us-east-1.amazonaws.com";// Specify main and backup SMTP servers

	    $mail->SMTPAuth = true;                               // Enable SMTP authentication

	    $mail->Username = 'AKIAISUZWOZ4BXP7UEOQ';            // SMTP username

	    $mail->Password = 'ArnlihxvkuFmjWAgl7KdzNT8seMiqw3iCD3Wi8Yie0MO';// SMTP password

	    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted

	    $mail->Port = 465;                                    // TCP port to connect to

	    $mail->WordWrap = 50;                                 // set word wrap

	    $mail->setFrom("sb_relation@tabikobo.com", $this->sess_client["email"]);

	    

	    if(!empty($email)){

	        if(is_array($email)){

	            foreach($email as $_email){

	                $mail->addAddress($_email, 'Southern Breeze Reservation');

	            }

	        }else if(is_string($email)){

	            $mail->addAddress($email, 'Southern Breeze Reservation');

	        }

	    }else{

	        return false;

	    }

	    

	    if(!empty($emailCC)){

	        if(is_array($emailCC)){

	            foreach($emailCC as $_email){

	                $mail->addCC($_email);

	            }

	        }else if(is_string($emailCC)){

	            $mail->addCC($emailCC);

	        }

	    }

	    

	    if(!empty($emailBCC)){

	        if(is_array($emailBCC)){

	            foreach($emailBCC as $_email){

	                $mail->addBCC($_email);

	            }

	        }else if(is_string($emailBCC)){

	            $mail->addBCC($emailBCC);

	        }

	    }

	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments

	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    $mail->isHTML(true);                                  // Set email format to HTML



	    $mail->Subject = $title;

	    $mail->Body    = $content;

	    

	    return $mail->send();
	}
}
?>