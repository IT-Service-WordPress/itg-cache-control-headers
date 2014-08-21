<?php 

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

WPF\Loader::_require_once( 'wpf_plugin_component_base.php' );
require_once( 'itg_wordpress_plugin_cachecontrol_complexheader.php' );

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
			\add_filter( 'nocache_headers', array( &$this, 'filter_http_nocache_headers' ) );
			\add_filter( 'wp_headers', array( &$this, 'filter_http_headers' ), 999, 2 );
		};
	}

	public
	function filter_http_nocache_headers(
		$headers
	) {
		$headers[ 'Cache-Control' ] = 'no-cache, no-store, must-revalidate, max-age=0, s-maxage=0';
		return $headers;
	}

	public
	function filter_http_headers(
		$headers
		, $wp
	) {
		$expires = intval( \get_option( MAX_AGE, 3600 ) );
		$no_cache = \get_option( NO_CACHE, false );
		$cache_public = \get_option( CACHE_PUBLIC, false );
		
		if ( $no_cache ) {
			$headers = array_merge( $headers, wp_get_nocache_headers() );
		} else {
			$cache_control = new ComplexHeader(); // ( $headers[ 'Cache-Control' ] );
			
			if ( $cache_public ) {
				$cache_control->params[ 'public' ] = true;
				$headers[ 'Pragma' ] = 'public';
				$cache_control->params[ 's-maxage' ] = $expires;
			} else {
				$cache_control->params[ 'public' ] = false;
				unset( $cache_control->params[ 's-maxage' ] );
			};
			$cache_control->params[ 'max-age' ] = $expires;
			// http://tools.ietf.org/html/rfc7231#section-7.1.1.1
			$headers[ 'Expires' ] = gmdate( 'D, d M Y H:i:s T', time() + $expires );

			// $headers[ 'Vary' ] = LOGGED_IN_COOKIE;
			
			$headers[ 'Cache-Control' ] = $cache_control->get_value();
		};
		
		return $headers;
	}

};

?>