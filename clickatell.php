<?php
/*
Plugin Name: Clickatell OTP
Plugin URI: http://arcturial.github.com
Description: Two-Factor Authentication using the Clickatell SMS gateway
Author: Chris Brand
Version: 1.0
Author URI: http://github.com/arcturial
*/

define('CCONF_SECTION', 'click_conf_section');
define('CFIELD_API_TOKEN', 'click_api_token');
define('CFIELD_SETTINGS', 'click_settings');
define('CFIELD_TWO_FACTOR', 'click_two_factor');
define('CFIELD_MSG_LOG', 'click_message_log');
define('CFIELD_OTP', 'otp_number');
define('CLOG_FORMAT', 'message.%s.log');

spl_autoload_register(function ($class) {
    $class = str_replace("\\", "/", $class);
    $class = preg_replace("/^Clickatell\//", "", $class);
    $file = __DIR__ . '/subtree/clickatell/src/' . $class . '.php';
    if (file_exists($file)) require_once $file;
});

require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/settings.php';
require_once __DIR__ . '/inc/login.php';
require_once __DIR__ . '/inc/log.php';

// Register the database tasks
register_activation_hook(__FILE__, 'create_schema');