<?php

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

WPF\Loader::_require_once( 'wpf_plugin_part_advanced.php' );
WPF\Loader::_require_once( 'wpf_textdomain_plugin.php' );
WPF\Loader::_require_once( 'wpf_textdomain_wpf.php' );
WPF\Loader::_require_once( 'wpf_setting_pluginsetting.php' );
WPF\Loader::_require_once( 'wpf_setting_validator_base.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_pluginoptions.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_section_base.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_control_input.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_control_checkbox.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_component_help_tab.php' );

new WPF\TextDomain\WPF( WPF\WPF_ADMINTEXTDOMAIN );
new WPF\TextDomain\Plugin( TEXTDOMAIN, __FILE__ );

new WPF\Plugin\Part\Advanced (
 
	new WPF\Setting\PluginSetting( MAX_AGE, 3600, true,
		new WPF\Setting\Validate\Base( 
			__( 'Cache-Control <code>max-age</code> must be positive integer.', TEXTDOMAIN )
			, false
			, function ( $value ) {
                return ( $value > 0 );
            }
			, 'intval'
		)
	)
	, new WPF\Setting\PluginSetting( NO_CACHE, false, true,
		new WPF\Setting\Validate\Base( 
			null
			, null
			, null
			, \FILTER_VALIDATE_BOOLEAN
		)
	)
	
	, new WPF\GUI\Setting\Page\PluginOptions(
		new WPF\GUI\Setting\Page\Section\Base( 'main', __( 'HTTP 1.1 Cache-Control headers options', TEXTDOMAIN )
			, new WPF\GUI\Setting\Page\Control\CheckBox(
				NO_CACHE
				, NO_CACHE
				, __( 'Disable cache', TEXTDOMAIN )
				, __( 'Fully disable server, client (browser) and proxy servers cache.', TEXTDOMAIN )
			)
			, new WPF\GUI\Setting\Page\Control\Input(
				MAX_AGE
				, MAX_AGE
				, __( 'Default <code>max-age</code> value', TEXTDOMAIN )
				, __( 'Default <a href="http://tools.ietf.org/html/rfc7234#section-5.2.2.8" target="_blank"><code>max-age</code></a> value (max cache time-to-live, seconds) for html wordpress pages.', TEXTDOMAIN )
			)
		)

		, new WPF\GUI\Setting\Page\Component\Help\Base(
			new WPF\GUI\Setting\Page\Component\Help\PluginData()
			, new WPF\GUI\Setting\Page\Component\Help\Tab( 'rfc7234', __( 'RFC 7234', TEXTDOMAIN )
				, __( '<p><a href="http://tools.ietf.org/html/rfc7234" target="_blank">RFC 7234</a> defines HTTP caches and the associated header fields that control cache behavior or indicate cacheable response messages.</p><p>Please, <a href="http://tools.ietf.org/html/rfc7234" target="_blank">read this document</a> before using this plugin.</p>', TEXTDOMAIN )
			)
		)
	)
);

?>