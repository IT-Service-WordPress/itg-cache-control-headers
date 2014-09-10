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
WPF\Loader::_require_once( 'wpf_option_serializable.php' );

require_once( 'itg_wordpress_plugin_cachecontrol_inc.php' );
require_once( 'itg_wordpress_plugin_cachecontrol_headersgenerator.php' );

new WPF\Plugin\Base (
	__FILE__

	, new WPF\Option\Serializable( NO_CACHE, false, true )
	, new WPF\Option\Serializable( NO_STORE, true, true )
	, new WPF\Option\Serializable( CACHE_PUBLIC, true, true )
	, new WPF\Option\Serializable( CACHE_PRIVATE, false, true )
	, new WPF\Option\Serializable( MAX_AGE, 3600, true )
	, new WPF\Option\Serializable( MUST_REVALIDATE, false, true )
	, new WPF\Option\Serializable( PROXY_REVALIDATE, false, true )
	, new WPF\Option\Serializable( NO_TRANSFORM, false, true )
	, new WPF\Option\Serializable( STALE_IF_ERROR, 0, true )
	, new WPF\Option\Serializable( STALE_WHILE_REVALIDATE, 0, true )
	, new WPF\Option\Serializable( VARY, '', true )
	, new WPF\Option\Serializable( CACHE_CONTROL_REWRITE_MODE, 'rewrite', true )

	/*
	, new WPF\Meta\Base( NO_CACHE, false, true,
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
	*/
	, new HeadersGenerator()

	, new WPF\Plugin\Part\Load\Admin()
	, new WPF\Plugin\Part\Load\Admin( 'posts-specific-admin.php' )
);

?>