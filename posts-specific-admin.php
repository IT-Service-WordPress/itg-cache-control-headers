<?php

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

WPF\Loader::_require_once( 'wpf_plugin_part_base.php' );
WPF\Loader::_require_once( 'wpf_gui_meta_box_base.php' );

// new WPF\TextDomain\WPF( WPF\WPF_ADMINTEXTDOMAIN );
// new WPF\TextDomain\Plugin( TEXTDOMAIN, __FILE__ );

new WPF\Plugin\Part\Base (
	new WPF\GUI\Meta\Box\Base( 'cache_control', array(
			'title' => __( 'Cache parameters', TEXTDOMAIN )
			, 'post_type' => 'page'
			, 'context' => 'side'
			, 'priority' => 'low'
		)

		, new WPF\GUI\Help\Tab( array(
			'id' => 'cache_control_help'
			, 'title' => __( 'Cache parameters', TEXTDOMAIN )
			, 'content' => __( '<p>You can specify HTTP Cache-Control parameters for each page, or use common parameters for site. See meta box "Cache parameters".</p><p>Please read <a href="http://tools.ietf.org/html/rfc7234" target="_blank">RFC 7234</a> and <a href="http://tools.ietf.org/html/rfc5861" target="_blank">RFC 5861</a>.</p>', TEXTDOMAIN )
		) )
	)
);

?>