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
	)
);

?>