<?php
require_once __DIR__ . '/db.php';

define('CPAGE_LOG', 'clickatell-log');

/**
 * Display the log file listing page.
 *
 * @return void
 */
function click_log_options()
{
    $enabled = (boolean) get_option(CFIELD_MSG_LOG);
    $otp = (boolean) get_option(CFIELD_TWO_FACTOR);

    echo '<div class="wrap">';
    echo '<h2>Clickatell Message Log</h2>';

    if (!$enabled)
    {
        echo '<div class="error">';
        echo '<p>Message log currently disabled. You can enable it <a href="' . admin_url('options-general.php#clickatell') . '">here</a></p>';
        echo '</div>';
    }

    if (!$otp)
    {
        echo '<div class="error">';
        echo '<p>Two-factor authentication disabled. You can enable it <a href="' . admin_url('options-general.php#clickatell') . '">here</a></p>';
        echo '</div>';
    }

    if ($enabled)
    {
        echo '<p>This page should help you debug any recent activity problems. For more information, it would be better to view the full message log located on your server.</p>';
        echo '<br/>';
        echo '<table class="wp-list-table widefat fixed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col" class="manage-column">Date/Time</th>';
        echo '<th scope="col" class="manage-column">Number</th>';
        echo '<th scope="col" class="manage-column">Response</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $lines = get_latest_20();

        foreach ($lines as $key => $row)
        {
            $time = date("Y-m-d H:i:s", $row->time);
            $number = $row->number;
            $response = $row->response;
            echo '<tr ' . (($key % 2) == 0 ? 'class="alternate"' : '') . '>';
            echo '<td>' . $time . '</td><td>' . $number . '</td><td>' . $response . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        $total = get_total()->total;

        echo '<p>Page only shows the last <strong>' . count($lines) . '</strong> out of  <strong>' . $total . '</strong></p>';
    }

    echo '</div>';
}

/**
 * Add a new menu link that points to the OTP activity log files.
 *
 * @return void
 */
function click_log_menu()
{
    add_menu_page('Clickatell Message Log', 'OTP Activity', 'manage_options', CPAGE_LOG, 'click_log_options', 'dashicons-admin-comments');
}

add_action('admin_menu', 'click_log_menu');