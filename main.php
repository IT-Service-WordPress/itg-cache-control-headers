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
WPF\Loader::_require_once( 'wpf_setting_pluginsetting.php' );
WPF\Loader::_require_once( 'wpf_setting_validator_base.php' );

require_once( 'itg_wordpress_plugin_cachecontrol_inc.php' );
require_once( 'itg_wordpress_plugin_cachecontrol_headersgenerator.php' );

new WPF\Plugin\Base (
	__FILE__

	, new WPF\Setting\PluginSetting( NO_CACHE, false, true,
		new WPF\Setting\Validate\Base(
			sprintf(
				__( 'Invalid %2$s parameter %1$s value. Must be empty string, <code>*</code> or comma separated HTTP headers list.', TEXTDOMAIN )
				, '<code>no-cache</code>'
				, '<code>Cache-Control</code>'
			)
			, false
			, '\ITG\WordPress\Plugin\CacheControl\is_http_headers_list'
			, '\ITG\WordPress\Plugin\CacheControl\sanitize_http_headers_list'
		)
	)
	, new WPF\Setting\PluginSetting( NO_STORE, true, true,
		new WPF\Setting\Validate\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
	)
	, new WPF\Setting\PluginSetting( CACHE_PUBLIC, true, true,
		new WPF\Setting\Validate\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
	)
	, new WPF\Setting\PluginSetting( CACHE_PRIVATE, false, true,
		new WPF\Setting\Validate\Base(
			sprintf(
				__( 'Invalid %2$s parameter %1$s value. Must be empty string, <code>*</code> or comma separated HTTP headers list.', TEXTDOMAIN )
				, '<code>private</code>'
				, '<code>Cache-Control</code>'
			)
			, false
			, '\ITG\WordPress\Plugin\CacheControl\is_http_headers_list'
			, '\ITG\WordPress\Plugin\CacheControl\sanitize_http_headers_list'
		)
	)
	, new WPF\Setting\PluginSetting( MAX_AGE, 3600, true,
		new WPF\Setting\Validate\Base(
			sprintf(
				__( '%2$s parameter %1$s must be positive integer.', TEXTDOMAIN )
				, '<code>max-age</code>'
				, '<code>Cache-Control</code>'
			)
			, false
			, function ( $value ) { return ( $value > 0 ); }
			, 'intval'
		)
	)
	, new WPF\Setting\PluginSetting( MUST_REVALIDATE, false, true,
		new WPF\Setting\Validate\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
	)
	, new WPF\Setting\PluginSetting( PROXY_REVALIDATE, false, true,
		new WPF\Setting\Validate\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
	)
	, new WPF\Setting\PluginSetting( NO_TRANSFORM, false, true,
		new WPF\Setting\Validate\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
	)
	, new WPF\Setting\PluginSetting( STALE_IF_ERROR, 0, true,
		new WPF\Setting\Validate\Base(
			sprintf(
				__( '%2$s parameter %1$s must be positive integer.', TEXTDOMAIN )
				, '<code>stale-if-error</code>'
				, '<code>Cache-Control</code>'
			)
			, false
			, function ( $value ) { return ( $value >= 0 ); }
			, 'intval'
		)
	)
	, new WPF\Setting\PluginSetting( STALE_WHILE_REVALIDATE, 0, true,
		new WPF\Setting\Validate\Base(
			sprintf(
				__( '%2$s parameter %1$s must be positive integer.', TEXTDOMAIN )
				, '<code>stale-while-revalidate</code>'
				, '<code>Cache-Control</code>'
			)
			, false
			, function ( $value ) { return ( $value >= 0 ); }
			, 'intval'
		)
	)
	, new WPF\Setting\PluginSetting( VARY, '', true,
		new WPF\Setting\Validate\Base(
			sprintf(
				__( 'Invalid HTTP header %1$s value. Must be empty string, <code>*</code> or comma separated HTTP headers list.', TEXTDOMAIN )
				, '<code>Vary</code>'
			)
			, false
			, '\ITG\WordPress\Plugin\CacheControl\is_http_headers_list'
			, '\ITG\WordPress\Plugin\CacheControl\sanitize_http_headers_list'
		)
	)
	, new WPF\Setting\PluginSetting( CACHE_CONTROL_REWRITE_MODE, 'rewrite', true,
		new WPF\Setting\Validate\Base(
			__( 'Unexpected option <code>%4$s</code> value (<code>%2$s</code>).', TEXTDOMAIN )
			, false
			, function ( $value ) {
				return in_array( $value, array( 'off', 'dont_overwrite', 'rewrite', 'append' ) );
			}
			, function ( $value ) {
				switch( $value ) {
					case 'off':
						return 'off';
					case 'dont_overwrite':
						return 'dont_overwrite';
					case '':
					case 'rewrite':
						return 'rewrite';
					case 'append':
						return 'append';
				};
			}
			, CACHE_CONTROL_REWRITE_MODE
		)
	)

	, new HeadersGenerator()

	, new WPF\Plugin\Part\Load\Admin()
	, new WPF\Plugin\Part\Load\Admin( 'posts-specific-admin.php' )
);

?>