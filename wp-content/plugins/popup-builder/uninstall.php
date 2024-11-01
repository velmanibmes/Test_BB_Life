<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}
use sgpb\Installer;
if (!defined('SGPB_POPUP_FILE_NAME')) {
	define('SGPB_POPUP_FILE_NAME', plugin_basename(__FILE__));
}

if (!defined('SGPB_POPUP_FOLDER_NAME')) {
	define('SGPB_POPUP_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(dirname(__FILE__).'/com/config/config.php');
require_once(SG_POPUP_CLASSES_PATH.'Installer.php');

Installer::uninstall();