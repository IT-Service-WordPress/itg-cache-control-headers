<?php 

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

WPF\Loader::_require_once( 'wpf_plugin_component_base.php' );

/*
HTTP 1.1 Headers generator.

@since 1.0.0

@package   ITG Cache-Control headers
@author    Sergey S. Betke <Sergey.S.Betke@yandex.ru>
@license   GPL-2.0+
@copyright 2014 ООО "Инженер-53"
*/
class HeadersGenerator extends WPF\Plugin\Component\Base {

	public
	function bind_action_handlers_and_filters() {
		if ( ! \is_admin() ) {
			\add_action( 'wp_headers', array( &$this, 'filter_http_headers' ), 10, 2 );
		};
		if ( \WP_DEBUG ) {
			\add_filter( 'wp_headers', array( &$this, 'filter_http_debug_headers' ), 10, 2 );
		};
	}

	public
	function filter_http_headers(
		$headers
		, $wp
	) {
		$expires = \get_option( MAX_AGE, 3600 );
		
		if ( $expires >= 0 ) {
			$headers[ 'Pragma' ] = 'public';
			$headers[ 'Cache-Control' ] = 'public, max-age=' . $expires;
			// http://tools.ietf.org/html/rfc7231#section-7.1.1.1
			$headers[ 'Expires' ] = gmdate( 'D, d M Y H:i:s T', time() + $expires );
			// $headers[ 'Vary' ] = LOGGED_IN_COOKIE;
		} else {
			$headers = array_merge( $headers, wp_get_nocache_headers() );
		}
		
		return $headers;
	}

	public
	function filter_http_debug_headers(
		$headers
		, $wp
	) {
		$headers[ 'X-Debug' ] = 'plugin="ITG Cache-Control headers"';
		return $headers;
	}

};

?>