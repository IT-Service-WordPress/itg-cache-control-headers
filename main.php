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
WPF\Loader::_require_once( 'wpf_data_option_base.php' );
WPF\Loader::_require_once( 'wpf_data_meta_post_base.php' );
WPF\Loader::_require_once( 'wpf_gui_notice_scheduled.php' );

require_once( 'itg_wordpress_plugin_cachecontrol_inc.php' );
require_once( 'itg_wordpress_plugin_cachecontrol_headersgenerator.php' );

new WPF\Plugin\Base (
	__FILE__

	, new WPF\Data\Option\Base( NO_CACHE, array( 'default_value' => false, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( NO_STORE, array( 'default_value' => true, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( CACHE_PUBLIC, array( 'default_value' => true, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( CACHE_PRIVATE, array( 'default_value' => false, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( MAX_AGE, array( 'default_value' => 3600, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( MUST_REVALIDATE, array( 'default_value' => false, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( PROXY_REVALIDATE, array( 'default_value' => false, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( NO_TRANSFORM, array( 'default_value' => false, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( STALE_IF_ERROR, array( 'default_value' => 0, 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( STALE_WHILE_REVALIDATE, array( 'default_value' => 0, 'autoload' => true, 'serialize' => true ))
	, new WPF\Data\Option\Base( VARY, array( 'default_value' => '', 'autoload' => true, 'serialize' => true ) )
	, new WPF\Data\Option\Base( CACHE_CONTROL_REWRITE_MODE, array( 'default_value' => 'rewrite', 'autoload' => true, 'serialize' => true ) )

//	, new WPF\Data\Meta\Post\Base( NO_CACHE, array( 'default_value' => false, 'serialize' => true ) )
	, new WPF\Data\Meta\Post\Base( CACHE_CONTROL_REWRITE_MODE, array( 'default_value' => 'rewrite', 'serialize' => false ) )

	, new HeadersGenerator()

	, new WPF\Plugin\Part\Load\Admin()
	, new WPF\Plugin\Part\Load\Admin( 'posts-specific-admin.php' )
);

?>