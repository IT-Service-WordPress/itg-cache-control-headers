<?php
/* 
Plugin Name:		ITG Cache-Control headers - pages specific
Plugin URI:			https://github.com/IT-Service-WordPress/itg-cache-control-headers
Description:		Add to "ITG Cache-Control headers" plugin posts and pages meta for posts specific cache parameters.
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

require_once( 'itg_wordpress_plugin_cachecontrol_inc.php' );

new WPF\Plugin\Base (
	__FILE__

	, new WPF\Plugin\Part\Load\Admin()
);

?>