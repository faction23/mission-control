<?php


namespace DevTools;


class I18n {

	public function admin_i18n() {
		return array();
	}

	public function common_i18n() {
		return [
			'docs_title'               => __( 'Documentation', 'gravity_dev_tools' ),
			'jump_nav_title'           => __( 'Jump Nav', 'gravity_dev_tools' ),
			'jump_nav_left_heading'    => __( 'Forms', 'gravity_dev_tools' ),
			'jump_nav_right_heading'   => __( 'Pages', 'gravity_dev_tools' ),
			'jump_nav_left_search'     => __( 'Search All Forms', 'gravity_dev_tools' ),
			'jump_nav_right_search'    => __( 'Search All Pages', 'gravity_dev_tools' ),
			'jump_nav_view'            => __( 'View', 'gravity_dev_tools' ),
			'jump_nav_edit'            => __( 'Edit', 'gravity_dev_tools' ),
			'jump_nav_settings'        => __( 'Settings', 'gravity_dev_tools' ),
			'jump_nav_entries'         => __( 'Entries', 'gravity_dev_tools' ),
			'jump_nav_preview'         => __( 'Preview', 'gravity_dev_tools' ),
			'js_title'                 => __( 'Javascript Tools', 'gravity_dev_tools' ),
			'nav_title'                => __( 'Dev Tools', 'gravity_dev_tools' ),
			'settings_title'           => __( 'Settings', 'gravity_dev_tools' ),
			'settings_hotkeys_heading' => __( 'Hotkeys', 'gravity_dev_tools' ),
		];
	}

	public function theme_i18n() {
		return array();
	}

}
