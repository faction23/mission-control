<?php

namespace DevTools;

require_once( plugin_dir_path( __FILE__ ) . '/Form_Data.php' );
require_once( plugin_dir_path( __FILE__ ) . '/Page_Data.php' );

class JS_Config {

	public function admin_config() {
		return array();
	}

	public function common_config() {
		$form_data = new Form_Data();
		$page_data = new Page_Data();

		return [
			'constants' => array(
				'gf_dev_time_as_ver'  => defined( 'GF_DEV_TIME_AS_VER' ) && GF_DEV_TIME_AS_VER,
				'gf_cache_debug'      => defined( 'GF_CACHE_DEBUG' ) && GF_CACHE_DEBUG,
				'gf_enable_hmr'       => defined( 'GF_ENABLE_HMR' ) && GF_ENABLE_HMR,
				'gravity_api_url'     => defined( 'GRAVITY_API_URL' ) ? GRAVITY_API_URL : '',
				'gravity_manager_url' => defined( 'GRAVITY_MANAGER_URL' ) ? GRAVITY_MANAGER_URL : '',
				'script_debug'        => defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG,
				'wp_cache'            => defined( 'WP_CACHE' ) && WP_CACHE,
				'wp_debug'            => defined( 'WP_DEBUG' ) && WP_DEBUG,
				'wp_debug_display'    => defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY,
				'wp_debug_log'        => defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG,
			),
			'form_data'      => $form_data->get_data(),
			'page_data'      => $page_data->get_data(),
			'rest_url'       => get_rest_url(),
		];
	}

	public function theme_config() {
		return array();
	}
}
