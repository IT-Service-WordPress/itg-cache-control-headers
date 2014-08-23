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
		if ( empty( $no_cache ) ) {
			$no_cache = false;
		} elseif ( '*' == $no_cache ) {
			$no_cache = true;
		};
		$no_store = (bool) \get_option( NO_STORE, false );
		$cache_public = (bool) \get_option( CACHE_PUBLIC, false );
		$cache_private = \get_option( CACHE_PRIVATE, false );
		if ( empty( $cache_private ) ) {
			$cache_private = false;
		} elseif ( '*' == $cache_private ) {
			$cache_private = true;
		};
		$must_revalidate = (bool) \get_option( MUST_REVALIDATE, false );
		$proxy_revalidate = (bool) \get_option( PROXY_REVALIDATE, false );
		$no_transform = (bool) \get_option( NO_TRANSFORM, false );
		$stale_if_error = intval( \get_option( STALE_IF_ERROR, 0 ) );
		$stale_while_revalidate = intval( \get_option( STALE_WHILE_REVALIDATE, 0 ) );
		
		if ( true === $no_cache ) {
			$headers = array_merge( $headers, wp_get_nocache_headers() );
		} else {
			$cache_control = new ComplexHeader(); // ( $headers[ 'Cache-Control' ] );
			
			$cache_control->params[ 'no-cache' ] = $no_cache ? : false;
			$cache_control->params[ 'no-store' ] = $no_store ? : false;
			if (
				$cache_public
				&& ! ( true === $cache_private )
			) {
				$cache_control->params[ 'public' ] = true;
				$headers[ 'Pragma' ] = 'public';
				$cache_control->params[ 's-maxage' ] = $expires;
			} else {
				$cache_control->params[ 'public' ] = false;
				unset( $cache_control->params[ 's-maxage' ] );
			};
			$cache_control->params[ 'private' ] = $cache_private;
			$cache_control->params[ 'must-revalidate' ] = $must_revalidate;
			$cache_control->params[ 'proxy-revalidate' ] = $must_revalidate ? false : $proxy_revalidate;
			$cache_control->params[ 'no-transform' ] = $no_transform;
			$cache_control->params[ 'max-age' ] = $expires;
			$cache_control->params[ 'stale-if-error' ] = $must_revalidate ? false : ( $stale_if_error ? : false );
			$cache_control->params[ 'stale-while-revalidate' ] = $stale_while_revalidate ? : false;

			// http://tools.ietf.org/html/rfc7231#section-7.1.1.1
			$headers[ 'Expires' ] = gmdate( 'D, d M Y H:i:s T', time() + $expires );

			// $headers[ 'Vary' ] = LOGGED_IN_COOKIE;
			
			$headers[ 'Cache-Control' ] = $cache_control->get_value();
		};
		
		return $headers;
	}

};

?>