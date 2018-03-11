<?php
/**
 * Constants file.
 * This file for define all custom constant of LP.
 * @author LVP [levanphu.info] <vanphupc50@gmail.com>
 * @copyright 2018 LP Group.
 * @since 1.0
 */
class SBException extends Exception
{
	
	 public function __toString() {
	 	$error =  "WARNING  :: $this->message".'By'. $_SERVER['HTTP_USER_AGENT'];
	 	Logs::wr($error);
	 	return $error;
    }
}
?>