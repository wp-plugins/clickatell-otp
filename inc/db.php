<?php
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

global $table_name;
$table_name = $wpdb->prefix . 'click_otp';

/**
 * Create the table schema
 *
 * @return void
 */
function create_schema()
{
    global $table_name, $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time int(10) NOT NULL,
        number varchar(25) NOT NULL,
        response varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta($sql);
}

/**
 * Get last 20 log entries
 *
 * @return array
 */
function get_latest_20()
{
    global $table_name, $wpdb;
    return $wpdb->get_results("SELECT `time`, `number`, `response` FROM $table_name ORDER BY `time` DESC");
}

/**
 * Return total amount of log entries.
 *
 * @return stdClass
 */
function get_total()
{
    global $table_name, $wpdb;
    return $wpdb->get_row("SELECT COUNT(*) AS total FROM $table_name");
}

/**
 * Log a new message to the current active log file.
 *
 * @param string $number The number the message was sent to
 * @param string $id     The API ID
 * @param string $error  Error message (if any)
 *
 * @return void
 */
function log_message($number, $id, $error = false)
{
    $enabled = (boolean) get_option(CFIELD_MSG_LOG);
    if (!$enabled) return true;

    global $table_name, $wpdb;
    return $wpdb->insert($table_name, array('time' => time(), 'number' => $number, 'response' => ($error ? $error : $id)));
}