<?php
/**
 * Constants file.
 * This file for define all custom constant of LP.
 * @author LVP [levanphu.info] <vanphupc50@gmail.com>
 * @copyright 2018 LP Group.
 * @since 1.0
 */

define('VERSION', '1.0');
/**
 * Debuging flags
 */
define('DEBUG', false); // Kint debugging helper
define('DEBUG_BAR', false); // Kint debugging helper
// PHP extension constant
define('PHP_EXT', '.php');
// Ini extension constant
define('INI_EXT', '.ini');
// Json extension constant
define('JSON_EXT', '.json');

define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']); // Base URL

define('VENDOR_PATH', DOCROOT . 'vendor' . DS); // Vendor path constant
define('LIBS_PATH', DOCROOT . 'libraries' . DS); // LP Library path
define('MODULES_PATH', DOCROOT . 'modules' . DS); // Module path constant
define('LOGS_PATH', DOCROOT . 'logs' . DS); //System path constant
//define("MOD_PATH", "modules/");
define("LANG_CODE", "en");
define("DEFAULT_CONTROLLER", "Index");
define("DEFAULT_METHOD", "index");

if($_SERVER['SERVER_NAME']=="ginatours.com"){
	define("SITE_PROTOCOL","http");
	define("SITE_HOST",$_SERVER['HTTP_HOST']);
	define("SITE_DOMAIN","mvc_fw_new");
}else{
	define("SITE_PROTOCOL","http");
	define("SITE_HOST",$_SERVER['HTTP_HOST']);
	define("SITE_DOMAIN","mvc_fw_new");
}
define("BASE_URL",SITE_PROTOCOL."://".SITE_HOST."/".SITE_DOMAIN."/");
