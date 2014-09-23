=== ITG Cache-Control headers ===
Contributors: sergey.s.betke@yandex.ru
Donate link:
Tags: cache, cache-control
Requires at least: 3.9.0
Tested up to: 4.0.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically send HTTP 1.1 headers "Cache-control", "Pragma" and "Expires".

== Description ==

Automatically send HTTP 1.1 headers "Cache-control", "Pragma" and "Expires"
([RFC 7234](<http://www.rfc-editor.org/rfc/rfc7234.txt>),
[RFC 5861](<http://tools.ietf.org/html/rfc5861>).
You can set cache TTL and other `Cache-Control` parameters in plugin options page.
Additional, You can set different `Cache-Control` parameters for each page.

Check plugin options on options page.

For more information, please visit the [github repository](https://github.com/IT-Service-WordPress/itg-cache-control-headers).

== Upgrade Notice ==

= 1.1.0 =
* support different `Cache-Control` parameters for site pages.

= 1.0.0 =
* Initial Release
* support [RFC 7234](<http://www.rfc-editor.org/rfc/rfc7234.txt>) and [RFC 5861](<http://tools.ietf.org/html/rfc5861>) `Cache-Control` parameters for site front-end.

== Installation ==

This section describes how to install the plugin and get it working.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'ITG Cache-Control'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard


= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `itg-cache-control-headers.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard


= Using FTP =

1. Download `itg-cache-control-headers.zip`
2. Extract the `itg-cache-control-headers` directory to your computer
3. Upload the `itg-cache-control-headers` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= Requirements? =

Just read "installation" section.

= Use shared WPF installation = 

This plugin designed with [WPF framework](https://github.com/IT-Service-WordPress/WPF/).

== Screenshots ==

== ToDo ==

The next version or later:

* `if-modified` http request header support
