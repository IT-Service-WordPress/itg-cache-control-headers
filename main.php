<?php
/* 
Plugin Name:		ITG Cache-Control headers
Plugin URI:			https://github.com/IT-Service-WordPress/itg-cache-control-headers
Description:		Automatically send HTTP 1.1 headers "Cache-control", "Pragma" and "Expires" (<a href="http://tools.ietf.org/html/rfc7234" target="_blank">RFC 7234</a>).
Version:			0.1.0
Author:				Sergey S. Betke
Author URI:			https://github.com/sergey-s-betke
Text Domain:		itg-cache-control-headers
Domain Path:		/languages/
GitHub Plugin URI: 	https://github.com/IT-Service-WordPress/itg-cache-control-headers
*/

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

require_once ( 'wpf' . DIRECTORY_SEPARATOR . 'wpf_inc.php' );
WPF\Loader::_require_once( 'wpf_plugin_base.php' );
WPF\Loader::_require_once( 'wpf_setting_base.php' );
WPF\Loader::_require_once( 'wpf_setting_pluginsetting.php' );
WPF\Loader::_require_once( 'wpf_setting_validator_base.php' );
WPF\Loader::_require_once( 'wpf_plugin_part_load_admin.php' );
// WPF\Loader::_require_once( 'wpf_textdomain_plugin.php' );

const TEXTDOMAIN = 'itg-cache-control-headers';

// new WPF\TextDomain\Plugin( 'itg-cache-control-headers', __FILE__ );

new WPF\Plugin\Base (
	__FILE__

	, new WPF\Plugin\Part\Load\Admin()
);

?>