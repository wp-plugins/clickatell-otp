<?php

/**
 * Render the Clickatell SignUp instructions.
 *
 * @return void
 */
function click_conf_info()
{
    echo '<ul id="clickatell">';
    echo '<li>1. Sign up for an account at <a href="http://www.clickatell.com">Clickatell</a>.</li>';
    echo '<li>2. Sign in and go to <a href="https://central.clickatell.com/api/add" target="_blank">Set up a new API</a> > <a href="https://central.clickatell.com/api/rest/add" target="_blank">Add REST API</a>.</li>';
    echo '<li>3. Enter the token that was given to you below.</li>';
    echo '</ul>';
}

/**
 * Render the API Token field.
 *
 * @return void
 */
function click_conf_api_token()
{
    echo '<label for="' . CFIELD_API_TOKEN . '">';
    echo '<input type="text" id="' . CFIELD_API_TOKEN . '" name="' . CFIELD_API_TOKEN .'" value="' . get_option(CFIELD_API_TOKEN) . '" />';
    echo '</label>';
}

/**
 * Render the checkbox fields.
 *
 * @return void
 */
function click_conf_settings()
{
    echo '<fieldset>';
    echo '<label for="' . CFIELD_TWO_FACTOR . '">';
    echo '<input type="checkbox" id="' . CFIELD_TWO_FACTOR . '" name="' . CFIELD_TWO_FACTOR .'" value="1" ' . checked(1, get_option(CFIELD_TWO_FACTOR), false) . ' />';
    echo 'Enable two-factor authentication';
    echo '</label>';
    echo '<br/>';
    echo '<label for="' . CFIELD_MSG_LOG . '">';
    echo '<input type="checkbox" id="' . CFIELD_MSG_LOG . '" name="' . CFIELD_MSG_LOG .'" value="1" ' . checked(1, get_option(CFIELD_MSG_LOG), false) . ' />';
    echo 'Enable message activity log';
    echo '</label>';
    echo '<p class="description">Enabling this setting will help debug any potential delivery problems</p>';
    echo '</fieldset>';
}

/**
 * Configure out settings page.
 *
 * @return void
 */
function click_conf()
{
    add_settings_section(CCONF_SECTION, 'Clickatell Configuration', 'click_conf_info', 'general');
    add_settings_field(CFIELD_API_TOKEN, 'API Token', 'click_conf_api_token', 'general', CCONF_SECTION);
    add_settings_field(CFIELD_SETTINGS, 'Settings', 'click_conf_settings', 'general', CCONF_SECTION);

    register_setting('general', CFIELD_API_TOKEN, 'esc_attr');
    register_setting('general', CFIELD_MSG_LOG, 'esc_attr');
    register_setting('general', CFIELD_TWO_FACTOR, 'esc_attr');
}

/**
 * Add a settings link to the plugin page.
 *
 * @return void
 */
function click_action_links($links, $file)
{
    if (strpos($file, "clickatell.php"))
    {
        array_unshift($links, '<a href="' . admin_url('options-general.php#clickatell') . '">Settings</a>');
    }

    return $links;
}

add_action('admin_init', 'click_conf');
add_filter('plugin_action_links', 'click_action_links', 10, 2);