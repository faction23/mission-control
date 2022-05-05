<?php
/**
 * Plugin Name: Mission Control
 * Description: Various dev tools for Gravity Forms
 * Version: 1.0.1
 * Author: Ryan Urban, Samuel Estok
 **/

require_once( plugin_dir_path( __FILE__ ) . '/includes/Git_Data.php' );
require_once( plugin_dir_path( __FILE__ ) . '/includes/JS_Config.php' );
require_once( plugin_dir_path( __FILE__ ) . '/includes/I18n.php' );
require_once( plugin_dir_path( __FILE__ ) . '/includes/Scripts.php' );

add_action( 'init', [ 'DevTools', 'init' ] );

class DevTools {

	public static $version = '1.0';

	public static function init() {
		if ( ! class_exists( 'GFForms' ) ) {
			return;
		}

		$scripts = new DevTools\Scripts();

		self::register_endpoints();
		self::register_scripts_and_styles();
		self::localize_scripts();

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( 'DevTools', 'enqueue_admin_scripts_and_styles' ) );
		} else {
			add_action( 'wp_enqueue_scripts', array( 'DevTools', 'enqueue_scripts_and_styles' ), 11 );
		}

		$scripts->init();
	}

	public static function register_scripts_and_styles() {
		$base_url = self::get_base_url();
		$version  = self::$version;
		$min      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		wp_register_script( 'gform_gravityforms_devtools_admin_vendors', $base_url . "/assets/js/dist/vendor-admin{$min}.js", array(), $version, true );
		wp_register_script( 'gform_gravityforms_devtools_admin', $base_url . "/assets/js/dist/scripts-admin{$min}.js", array(
			'gform_gravityforms_devtools_admin_vendors',
		), $version, true );
		wp_register_script( 'gform_gravityforms_devtools_theme_vendors', $base_url . "/assets/js/dist/vendor-theme{$min}.js", array(), $version, true );
		wp_register_script( 'gform_gravityforms_devtools_theme', $base_url . "/assets/js/dist/scripts-theme{$min}.js", array(
			'gform_gravityforms_devtools_theme_vendors',
		), $version, true );
		wp_register_style( 'gform_devtools_admin', $base_url . "/assets/css/dist/admin.css", array(), $version );
		wp_register_style( 'gform_devtools_theme', $base_url . "/assets/css/dist/theme.css", array(), $version );
	}

	public static function localize_scripts() {
		$config = new DevTools\JS_Config();
		$i18n  = new DevTools\I18n();

		if ( is_admin() ) {
			wp_localize_script( 'gform_gravityforms_devtools_admin', 'gform_devtools_admin_config', $config->admin_config() );
			wp_localize_script( 'gform_gravityforms_devtools_admin', 'gform_devtools_admin_i18n', $i18n->admin_i18n() );
		} else {
			wp_localize_script( 'gform_gravityforms_devtools_theme', 'gform_devtools_theme_config', $config->theme_config() );
			wp_localize_script( 'gform_gravityforms_devtools_theme', 'gform_devtools_theme_i18n', $i18n->theme_i18n() );
		}

		wp_localize_script( 'gform_gravityforms_devtools_admin', 'gform_devtools_common_config', $config->common_config() );
		wp_localize_script( 'gform_gravityforms_devtools_admin', 'gform_devtools_common_i18n', $i18n->common_i18n() );
		wp_localize_script( 'gform_gravityforms_devtools_theme', 'gform_devtools_common_config', $config->common_config() );
		wp_localize_script( 'gform_gravityforms_devtools_theme', 'gform_devtools_common_i18n', $i18n->common_i18n() );

	}

	public static function register_endpoints() {
		add_action( 'rest_api_init', function () {
			$git_data = new DevTools\Git_Data();

			$git_data->register_endpoint();
		} );
	}

	public static function get_base_url() {
		return plugins_url( '', __FILE__ );
	}

	public static function enqueue_admin_scripts_and_styles() {
		wp_enqueue_script( 'gform_gravityforms_devtools_admin' );
		wp_enqueue_style( 'gform_devtools_admin' );
	}

	public static function enqueue_scripts_and_styles() {
		wp_enqueue_script( 'gform_gravityforms_devtools_theme' );
		wp_enqueue_style( 'gform_devtools_theme' );
	}
}
