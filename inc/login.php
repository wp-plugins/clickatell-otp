<?php
require_once __DIR__ . '/db.php';

use Clickatell\Otp\SessionStorage;
use Clickatell\Api\ClickatellRest;
use Clickatell\Otp\ClickatellOtp;
use \Exception;

/**
 * Get the storage mechanism we will use for storing OTP's
 *
 * @return SessionStorage
 */
function get_library_storage()
{
    return new SessionStorage(true);
}

/**
 * Get the API we will use for delivery.
 *
 * @return ClickatellRest
 */
function get_library_api()
{
    $token = get_option(CFIELD_API_TOKEN);
    return new ClickatellRest($token);
}

/**
 * Return the OTP library that will do the heavy lifting.
 *
 * @return ClickatellOtp
 */
function get_library_otp()
{
    return new ClickatellOtp(get_library_api(), get_library_storage());
}

/**
 * Send a new OTP to the specified number, capture any errors
 * and log any activty.
 *
 * @param string $number The mobile number
 * @param int    $user   The user ID
 *
 * @return boolean
 */
function click_send_otp($number, $user)
{
    try
    {
        $message = get_option(CFIELD_MESSAGE);
        $message = strlen($message) ? $message : CMESSAGE_FORMAT;

        $otp = get_library_otp();
        $otp->setMessage($message);

        $id = $otp->sendPin($number, $user);
        log_message($number, $id);
        return true;
    }
    catch (Exception $e)
    {
        log_message($number, null, $e->getMessage());
        return false;
    }
}

/**
 * Verify a delivered OTP message.
 *
 * @param string $number The number it was delivered to
 * @param string $token  The PIN
 * @param int    $user   The user ID
 *
 * @return boolean
 */
function click_verify_otp($number, $token, $user)
{
    return get_library_otp()->verifyPin($number, $token, $user);
}

/**
 * Render the second step in the authentication.
 *
 * @param int      $id     The user ID
 * @param string   $number The number it was sent to
 * @param WP_Error $error  Any notices/errors
 *
 * @return void
 */
function click_render_otp_page($id, $number, $error = null)
{
    login_header(__('Log In - Verify OTP'), '', $error);
    $url = esc_url(site_url('wp-login.php', 'login_post'));

    ?>
    <form name="otpform" id="otpform" action="<?php echo $url; ?>" method="post">
        <input type="hidden" name="otp_step" value="verify" />
        <input type="hidden" name="user_id" value="<?php echo $id; ?>" />
        <p>
            <label for="user_login">
                <?php _e('Verification PIN') ?><br />
                <input type="text" name="pin" class="input" value="" size="20" />
            </label>
        </p>
        <p class="forgetmenot">
            <a href="<?php echo $url; ?>">Log in as another user</a>
        </p>
        <p class="submit">
            <input
                type="submit"
                name="wp-submit"
                id="wp-submit"
                class="button button-primary button-large"
                value="<?php esc_attr_e('Verify'); ?>" />
        </p>
    </form>
    <?php
    login_footer();
    die(0);
}

/**
 * Run the authentication checks. If the user has an OTP number and
 * two factor authentication has been enabled. We will attempt to deliver
 * an OTP. If all of these steps are false, we will fall back and skip OTP.
 *
 * @param WP_User $user The user object
 *
 * @return void
 */
function click_otp_authenticate($user)
{
    $check_ajax = (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST);
    $check_app  = (defined('APP_REQUEST') && APP_REQUEST);
    $enabled = get_option(CFIELD_TWO_FACTOR);
    if ($check_ajax || $check_app || !$enabled) return $user;

    if ($user instanceof WP_User)
    {
        if ($number = get_user_meta($user->ID, CFIELD_OTP, true))
        {
            if (click_send_otp($number, $user->ID))
            {
                $error = new WP_Error;
                $error->add('otp', __('PIN has been sent to number: <strong>' . $number . '</strong>'), 'message');
                return click_render_otp_page($user->ID, $number, $error);
            }
        }

        return $user;
    }

    $user = isset($_POST['user_id']) ? get_user_by('id', $_POST['user_id']) : null;
    $token = isset($_POST['pin']) ? $_POST['pin']: false;

    if ($user && $token !== false)
    {
        if ($number = get_user_meta($user->ID, CFIELD_OTP, true))
        {
            if (click_verify_otp($number, $token, $user->ID))
            {
                return $user;
            }
            else
            {
                $error = new WP_Error;
                $error->add('otp', __('The pin you entered was invalid.'));
                return click_render_otp_page($user->ID, $number, $error);
            }
        }
    }

    return $user;
}

/**
 * Show the OTP number under a users profile.
 *
 * @param WP_User $user The user
 *
 * @return void
 */
function click_show_otp_profile_fields($user)
{
    ?>
    <h3>Two-Factor Authentication</h3>

    <table class="form-table">
        <tr>
            <th><label for="<?php echo CFIELD_OTP; ?>">Cellphone Number</label></th>
            <td>
                <input
                    type="text"
                    name="<?php echo CFIELD_OTP; ?>"
                    id="<?php echo CFIELD_OTP; ?>"
                    value="<?php echo esc_attr(get_the_author_meta(CFIELD_OTP, $user->ID)); ?>"
                    class="regular-text" />

                <br />
                <span class="description">Store your number using international format (ex. +27)</span>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save the updated OTP number under a users profile.
 *
 * @param int $user_id The user ID modified
 *
 * @return void
 */
function click_save_otp_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) return false;
    update_usermeta($user_id, CFIELD_OTP, $_POST[CFIELD_OTP]);
}

add_filter('authenticate', 'click_otp_authenticate', 21);
add_action('show_user_profile', 'click_show_otp_profile_fields');
add_action('edit_user_profile', 'click_show_otp_profile_fields');
add_action('personal_options_update', 'click_save_otp_profile_fields');
add_action('edit_user_profile_update', 'click_save_otp_profile_fields');