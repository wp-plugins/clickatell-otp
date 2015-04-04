=== Plugin Name ===
Contributors: chris.brand
Donate Link: -
Tags: clickatell, sms, text, two-factor, otp, authentication
Requires at least: 3.8.0
Tested up to: 4.1.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Secure your site with Two-Factor Authentication (TFA) using the Clickatell SMS gateway.

== Description ==

[Two-Factor Authentication](http://en.wikipedia.org/wiki/Two_factor_authentication) adds a second step to your login that verfies the identify of a user. When authenticating, the user will receive a SMS/text containing a PIN. The PIN will have to be entered correctly before login can proceed. By doing this, we verify that it's the person in charge of the account trying to authenticate.

= What does it do? =

This plugin makes use of the SMS/text messages to a deliver a randomly generated PIN token to a mobile device. The user has the option to opt in or out of the service depending on if he/she has a mobile number loaded in their profile.

Visit the [FAQ](https://wordpress.org/plugins/clickatell-otp/faq/) for more information.

== Installation ==

= Using Wordpress =

1. Search for "Clickatell" in the Wordpress "Plugins" section
2. Click "Install" once you locate the "Clickatell OTP" plugin
3. Activate the plugin and go to "Settings" (or Wordpress general settings)
4. Configure your API token and preferences
5. Ensure that the appropriate users have mobile numbers loaded under their user profile.

= Manual Install =

1. Install the plugin through Wordpress or copy the entire folder to `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in Wordpress
3. Go the the general settings (or follow the settings tab from the plugin menu)
4. Configure the plugin by providing your Clickatell API token
5. Ensure that relevant users add an OTP number (under profile) to their account. You can decide how to handle this step. If no OTP number is present, two-factor authentication will be skipped for the particular user.

== Frequently Asked Questions ==

= What is Two-Factor Authentication (TFA) =

Two-Factor Authentication usually indicates to the use of a second requirement during authentication. This can be accomplished in multiple ways, but one of the most common ways include the use of a unique PIN generated and delivered to a physical device in the possession of the user.

= Why do I need an API token and where do I get one =

In order for the SMS/text messages to be delivered, you need to have an account with [Clickatell](http://www.clickatell.com). You can sign up for an account on their site, [Clickatell](http://www.clickatell.com), and add a **REST API** to your account. It is important to note that the **REST API** is the only supported API type at the moment.

= Are the text messages free =

No, the messages will be charged against your [Clickatell](http://www.clickatell.com) account. You will have to monitor the account and keep it loaded with credits.

= I lost my device and can't get into my account =

You can disable the plugin manually if you have access to where your site is hosted (ex. via FTP). The following article provides instructions. [Understanding how WordPress installs plugins](https://updraftplus.com/understanding-wordpress-installs-plugins/).

= I am not receiving the second step during authentication =

This can point to one of the following

* The **Two-Factor Authentication** option should be enabled under your settings
* Please ensure that you have a mobile number configured under your profile
* Check the OTP activity page for any error messages. (It could be that your Clickatell account needs more credits)

== Screenshots ==

1. The screenshot (screenshot-1) indicates how the user will be presented with the second phase of authentication.

== Changelog ==

= 1.0 =
* Allow for the Two-Factor feature to be disabled.
* Capture API responses in a message log if configured.

== Upgrade Notice ==

N/A

== Debugging SMS Delivery ==

The plugin has a **fail-safe** mechanism built in. If the [Clickatell](http://www.clickatell.com) API returns any errors, the second authentication step will be skipped. Any of these errors will be recorded in the message log which you can find under the "OTP Activity" admin section.

A common problem could be that you ran out of credits or that the service is currently experiencing a problem.

You can also find more detailed delivery reports when you log into the [Clickatell](http://www.clickatell.com) portal.
