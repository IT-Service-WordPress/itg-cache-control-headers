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
WPF\Loader::_require_once( 'wpf_gui_setting_page_control_number.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_control_checkbox.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_control_radiobuttons.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_component_help_tab.php' );

require_once( 'itg_wordpress_plugin_cachecontrol_functions.php' );

// new WPF\TextDomain\WPF( WPF\WPF_ADMINTEXTDOMAIN );
// new WPF\TextDomain\Plugin( TEXTDOMAIN, __FILE__ );

//new WPF\Plugin\Part\Advanced (
//);

?>