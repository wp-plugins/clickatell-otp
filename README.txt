=== Plugin Name ===
Contributors: chris.brand
Donate Link: -
Tags: clickatell, sms, text, two-factor, otp, authentication
Requires at least: 3.8.0
Tested up to: 4.1.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to enable Two-Factor Authentication for your site using the Clickatell SMS gateway.

== Description ==

This plugin adds [Two-Factor Authentication](http://en.wikipedia.org/wiki/Two_factor_authentication) to your login. If a user has specified a cellphone number he/she would like to be notified on, the user will receive an SMS text with a verification PIN. The PIN will have to be entered correctly before login can proceed. By doing this, we verify that it's the person in charge of the account trying to authenticate.

== Installation ==

1. Install the plugin through Wordpress or copy the entire folder to `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in Wordpress
3. Go the the general settings (or follow the settings tab from the plugin menu)
4. Configure the plugin by providing your Clickatell API token
5. Ensure that relevant users add an OTP number (under profile) to their account. You can decide how to handle this step. If no OTP number is present, two-factor authentication will be skipped for the particular user.

== Frequently Asked Questions ==

= Where do I get an API token =

You must sign up for an an account at [Clickatell](http://www.clickatell.com) and add a REST API to your account.

= Are the SMS's free =

No, the messages will be charged against your [Clickatell](http://www.clickatell.com) account, which you will have to keep topped up.

== Screenshots ==

1. The screenshot (screenshot-1) indicates how the user will be presented with the second phase of authentication.

== Changelog ==

= 1.0 =
* Allow for the Two-Factor feature to be disabled.
* Capture API responses in a message log if configured.

== Upgrade Notice ==

N/A

== Debugging SMS Delivery ==

The plugin has a fail-safe built in. If the [Clickatell](http://www.clickatell.com) API returns any errors, the second authentication step will be skipped. Any errors will be recorded in the appropriate message log which you can find under the "OTP Activity" admin section. If could possibly be that you ran out of credits or that the service is currently experiencing a problem.

You can also find more detailed delivery reports when you log into the [Clickatell](http://www.clickatell.com) portal.
