<?php
/* 
Plugin Name:		ITG Cache-Control headers
Plugin URI:			https://github.com/IT-Service-WordPress/itg-cache-control-headers
Description:		Automatically send HTTP 1.1 headers "Cache-control", "Pragma" and "Expires" (<a href="http://tools.ietf.org/html/rfc7234" target="_blank">RFC 7234</a>).
Version:			1.0.0
Author:				Sergey S. Betke
Author URI:			https://github.com/sergey-s-betke
Text Domain:		itg-cache-control-headers
Domain Path:		/languages/
GitHub Plugin URI: 	https://github.com/IT-Service-WordPress/itg-cache-control-headers
*/

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

require_once( 'wpf' . DIRECTORY_SEPARATOR . 'wpf_inc.php' );
WPF\Loader::_require_once( 'wpf_plugin_base.php' );
WPF\Loader::_require_once( 'wpf_plugin_part_load_admin.php' );

const TEXTDOMAIN = 'itg-cache-control-headers';

const VARY = 'cache-control-vary';

const CACHE_CONTROL_REWRITE_MODE = 'cache-control-rewrite-mode';
const MAX_AGE = 'cache-control-max-age-default';
const NO_CACHE = 'cache-control-no-cache';
const NO_STORE = 'cache-control-no-store';
const CACHE_PUBLIC = 'cache-control-cache-public';
const CACHE_PRIVATE = 'cache-control-cache-private';
const MUST_REVALIDATE = 'cache-control-must-revalidate';
const PROXY_REVALIDATE = 'cache-control-proxy-revalidate';
const NO_TRANSFORM = 'cache-control-no-transform';
const STALE_IF_ERROR = 'cache-control-stale-if-error';
const STALE_WHILE_REVALIDATE = 'cache-control-stale-while-revalidate';

require_once( 'itg_wordpress_plugin_cachecontrol_headersgenerator.php' );

new WPF\Plugin\Base (
	__FILE__

	, new HeadersGenerator()

	, new WPF\Plugin\Part\Load\Admin()
);

?>