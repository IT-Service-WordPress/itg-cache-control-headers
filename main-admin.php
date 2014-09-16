<?php

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

WPF\Loader::_require_once( 'wpf_plugin_part_advanced.php' );
WPF\Loader::_require_once( 'wpf_textdomain_plugin.php' );
WPF\Loader::_require_once( 'wpf_textdomain_wpf.php' );
WPF\Loader::_require_once( 'wpf_gui_validator_base.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_pluginoptions.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_section_base.php' );
WPF\Loader::_require_once( 'wpf_gui_control_input.php' );
WPF\Loader::_require_once( 'wpf_gui_control_number.php' );
WPF\Loader::_require_once( 'wpf_gui_control_checkbox.php' );
WPF\Loader::_require_once( 'wpf_gui_control_radiobuttons.php' );
WPF\Loader::_require_once( 'wpf_gui_help_tab.php' );
WPF\Loader::_require_once( 'wpf_gui_help_plugindata.php' );

require_once( 'itg_wordpress_plugin_cachecontrol_functions.php' );

new WPF\TextDomain\WPF( WPF\WPF_ADMINTEXTDOMAIN );
new WPF\TextDomain\Plugin( TEXTDOMAIN, __FILE__ );

new WPF\Plugin\Part\Advanced (
	new WPF\GUI\Setting\Page\PluginOptions(
		new WPF\GUI\Setting\Page\Section\Base( 'rfc7234', __( 'RFC 7234 HTTP 1.1 Cache-Control headers options', TEXTDOMAIN )
			, new WPF\GUI\Control\RadioButtons( 'dont_rewrite_cache_control', CACHE_CONTROL_REWRITE_MODE
				, array(
					'title' => __( '<code>Cache-Control</code> rewrite mode', TEXTDOMAIN )
					, 'description' => __( '<code>Cache-Control</code> header overwrite mode.', TEXTDOMAIN )
					, 'choices' => array(
						'off' => __( 'Don\'t modify or add', TEXTDOMAIN )
						, 'dont_overwrite' => __( 'Don\'t overwrite', TEXTDOMAIN )
						, 'rewrite' => __( 'Rewrite', TEXTDOMAIN )
						, 'append' => __( 'Append', TEXTDOMAIN )
					)
				)
				, new WPF\GUI\Validator\Base(
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
			, new WPF\GUI\Control\Input( 'no_cache', NO_CACHE
				, array(
					'title' => __( 'Disable cache for headers', TEXTDOMAIN )
					, 'description' => __( 'Disable cache for specified HTTP headers, but enable cache for other parts of response. <code>*</code> - fully disable server, client (browser) and proxy servers cache, <code>""</code> - don\'t disable cache. <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.2" target="_blank"><code>no-cache</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base(
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
			, new WPF\GUI\Control\CheckBox( 'no_store', NO_STORE
				, array(
					'title' => __( 'Disable permanent cache storage', TEXTDOMAIN )
					, 'description' => __( 'Disable permanent cache storage (for security reasons) - <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.3" target="_blank"><code>no-store</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
			)
			, new WPF\GUI\Control\CheckBox( 'public', CACHE_PUBLIC
				, array(
					'title' => __( 'Enable public cache', TEXTDOMAIN )
					, 'description' => __( 'Enable public cache (client (browser) and proxy servers cache) - <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.5" target="_blank"><code>public</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
			)
			, new WPF\GUI\Control\Input( 'private', CACHE_PRIVATE
				, array(
					'title' => __( 'Disable public cache for headers', TEXTDOMAIN )
					, 'description' => __( 'Disable public cache for specified HTTP headers, but don\'t disable public cache for other parts of response. <code>*</code> - fully disable public (proxy servers) cache, <code>""</code> - don\'t disable public cache. <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.6" target="_blank"><code>private</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base(
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
			, new WPF\GUI\Control\Number( 'max_age', MAX_AGE
				, array(
					'title' => __( 'Default <code>max-age</code> value', TEXTDOMAIN )
					, 'postfix' => __( 'seconds', TEXTDOMAIN )
					, 'description' => __( 'Default <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.8" target="_blank"><code>max-age</code></a> value (max cache time-to-live, seconds) for html wordpress pages.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base(
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
			, new WPF\GUI\Control\CheckBox( 'must_revalidate', MUST_REVALIDATE
				, array(
					'title' => __( 'Doesn\'t use stale cache', TEXTDOMAIN )
					, 'description' => __( 'If cache content to become stale, a cache <strong>must not</strong> use the response to satisfy requests without successful validation on the origin server. <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.1" target="_blank"><code>must-revalidate</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
			)
			, new WPF\GUI\Control\CheckBox( 'proxy_revalidate', PROXY_REVALIDATE
				, array(
					'title' => __( 'Doesn\'t use stale cache on proxy servers', TEXTDOMAIN )
					, 'description' => __( 'If cache content on proxy servers to become stale, a cache <strong>must not</strong> use the response to satisfy requests without successful validation on the origin server. But private (browser) cache can use stale content. <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.7" target="_blank"><code>proxy-revalidate</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
			)
			, new WPF\GUI\Control\CheckBox( 'no_transform', NO_TRANSFORM
				, array(
					'title' => __( 'Don\'t transform content parts in cache', TEXTDOMAIN )
					, 'description' => __( 'Cache (regardless of whether it implements a cache) <strong>must not</strong> transform the payload, as defined in <a href="http://tools.ietf.org/html/rfc7230#section-5.7.2" target="_blank">Section 5.7.2 of RFC 7230</a>. <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.4" target="_blank"><code>no-transform</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base( null, null, null, \FILTER_VALIDATE_BOOLEAN )
			)
			, new WPF\GUI\Control\Input( 'vary', VARY
				, array(
					'title' => __( 'Second cache keys', TEXTDOMAIN )
					, 'description' => __( 'List of request headers, for different values of which responses may be different. <a href="http://tools.ietf.org/html/rfc7234#section-4.1" target="_blank"><code>Vary</code></a> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base(
					sprintf(
						__( 'Invalid HTTP header %1$s value. Must be empty string, <code>*</code> or comma separated HTTP headers list.', TEXTDOMAIN )
						, '<code>Vary</code>'
					)
					, false
					, '\ITG\WordPress\Plugin\CacheControl\is_http_headers_list'
					, '\ITG\WordPress\Plugin\CacheControl\sanitize_http_headers_list'
				)
			)
		)
		, new WPF\GUI\Setting\Page\Section\Base( 'rfc5861', __( 'RFC 5861 HTTP Cache-Control Extensions for Stale Content', TEXTDOMAIN )
			, new WPF\GUI\Control\Number( 'stale_while_revalidate', STALE_WHILE_REVALIDATE
				, array(
					'title' => __( 'Return stale content while revalidate', TEXTDOMAIN )
					, 'postfix' => __( 'seconds', TEXTDOMAIN )
					, 'description' => __( 'In seconds. A cached stale response <strong>may</strong> be used to satisfy the request, up to the indicated number of seconds, while source server request in progress. <a href="http://tools.ietf.org/html/rfc5861#section-3" target="_blank"><code>stale-while-revalidate</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base(
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
			, new WPF\GUI\Control\Number( 'stale_if_error', STALE_IF_ERROR
				, array(
					'title' => __( 'Return stale content if error', TEXTDOMAIN )
					, 'postfix' => __( 'seconds', TEXTDOMAIN )
					, 'description' => __( 'In seconds. When an error is encountered (in source server response), a cached stale response <strong>may</strong> be used to satisfy the request, regardless of other freshness information. <a href="http://tools.ietf.org/html/rfc5861#section-4" target="_blank"><code>stale-if-error</code></a> parameter of <code>Cache-Control</code> header.', TEXTDOMAIN )
				)
				, new WPF\GUI\Validator\Base(
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
		)

		, new WPF\GUI\Help\PluginData()
		, new WPF\GUI\Help\Tab( 'rfc7234', __( 'RFC 7234', TEXTDOMAIN )
			, __( '<p><a href="http://tools.ietf.org/html/rfc7234" target="_blank">RFC 7234</a> defines HTTP caches and the associated header fields that control cache behavior or indicate cacheable response messages.</p><p>Please, <a href="http://tools.ietf.org/html/rfc7234" target="_blank">read this document</a> before using this plugin.</p>', TEXTDOMAIN )
		)
		, new WPF\GUI\Help\Tab( 'rfc5861', __( 'RFC 5861', TEXTDOMAIN )
			, __( '<p><a href="http://tools.ietf.org/html/rfc5861" target="_blank">RFC 5861</a> defines two independent HTTP Cache-Control extensions that allow control over the use of stale responses by caches.</p>', TEXTDOMAIN )
		)
	)
);

?>