<?php

use \WPF\v1 as WPF;

// WPF\Loader::_require_once( 'wpf_plugin_part_base.php' );
WPF\Loader::_require_once( 'wpf_plugin_part_advanced.php' );
// WPF\Loader::_require_once( 'wpf_compatibility_validators.php' );
// WPF\Loader::_require_once( 'wpf_compatibility_validators_on.php' );
// WPF\Loader::_require_once( 'wpf_compatibility_version_wp.php' );
// WPF\Loader::_require_once( 'wpf_compatibility_version_php.php' );
WPF\Loader::_require_once( 'wpf_textdomain_plugin.php' );
WPF\Loader::_require_once( 'wpf_textdomain_wpf.php' );
// WPF\Loader::_require_once( 'wpf_plugin_component_dynamiccontroller.php' );
// WPF\Loader::_require_once( 'wpf_plugin_component_installer.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_pluginoptions.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_section_base.php' );
WPF\Loader::_require_once( 'wpf_gui_setting_page_control_input.php' );
// WPF\Loader::_require_once( 'wpf_gui_setting_page_component_help_base.php' );
// WPF\Loader::_require_once( 'wpf_gui_setting_page_component_help_sidebar.php' );
// WPF\Loader::_require_once( 'wpf_gui_setting_page_component_help_tab.php' );
// WPF\Loader::_require_once( 'wpf_gui_setting_page_component_help_plugindata.php' );

new WPF\TextDomain\WPF( WPF\WPF_ADMINTEXTDOMAIN );

// new WPF\Plugin\Part\Base (
 new WPF\Plugin\Part\Advanced (
 
	/*
	new WPF\GUI\Setting\Page\PluginOptions(
		new WPF\GUI\Setting\Page\Section\Base( 'id1', 'Первый раздел'
			, new WPF\GUI\Setting\Page\Control\Input(
				'test-option'
				, 'test-option'
				, __( 'Опция тест' )
				, __( 'Подробное описание опции.' )
			)
			, new WPF\GUI\Setting\Page\Control\Input(
				'test-id-2'
				, 'second'
				, __( 'Опция second' )
			)
		)
		, 'id2'

		, new WPF\GUI\Setting\Page\Component\Help\Base(
			new WPF\GUI\Setting\Page\Component\Help\PluginData()
			, new WPF\GUI\Setting\Page\Component\Help\Tab( 'id', __( 'title' )
				, __( '<p>Содержание справки.</p>' )
			)
			, new WPF\GUI\Setting\Page\Component\Help\Tab( 'id2', __( '<a href="%2$s" target="_blank">About author</a>', \WPF\v1\WPF_ADMINTEXTDOMAIN )
				, __( '<p>Содержание справки 2.</p>' )
			)
		)
	)
	*/

	// , new WPF\Plugin\Component\Installer()
	// , new WPF\Plugin\Component\DynamicController()
	/*
	, new WPF\Compatibility\Validators_On (
		'admin_init'
		, new WPF\Compatibility\Version\WP( '3.9.0' )
		, new WPF\Compatibility\Version\PHP( '5.5.0' )
	)
	*/
	/*
	, new WPF\Compatibility\Validators (
		new WPF\Compatibility\Version\WP( '3.9.0' )
		, new WPF\Compatibility\Version\PHP( '5.5.0' )
		//, new WPF\Compatibility\Version\PHP( '5.7.0' )
	)
	*/
);

?>