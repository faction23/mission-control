<?php

namespace DevTools;

class Git_Data {

	public function register_endpoint() {
		register_rest_route( 'gdev/v1', '/gitdata/', array(
			'methods' => 'GET',
			'callback' => array( $this, 'get_git_data' ),
		) );
	}

	public function folder_exists( $folder ) {
		// Get canonicalized absolute pathname
		$path = realpath( $folder );

		// If it exist, check if it's a directory
		return ( $path !== false and is_dir( $path ) ) ? $path : false;
	}

	public function get_git_path( $plugin ) {
		$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . $plugin . '/';
		return $plugin_path . '.git/';
	}

	public function get_branch_name( $git_path ) {
		return str_replace( array( "\r", "\n", ), '', implode( '/', array_slice( explode( '/', file_get_contents( $git_path . 'HEAD' ) ), 2 ) ) );
	}

	public function get_single_plugin_branch( $plugin ) {
		$git_path = $this->get_git_path( $plugin );
		if ( ! $this->folder_exists( $git_path ) ) {
			return array();
		}
		return array(
			'branch' => $this->get_branch_name( $git_path ),
			'name'   => ucfirst( $plugin == 'gravityforms' ? $plugin : str_replace( 'gravityforms', '', $plugin ) ),
		);
	}

	public function get_git_data( $request ) {
		$plugin = $request->get_param( 'plugin' );
		if ( ! empty( $plugin ) ) {
			return $this->get_single_plugin_branch( $plugin );
		}
		$data = array();
		$plugins = get_option( 'active_plugins' );

		$gf_plugins = array_filter( $plugins, function( $value, $key ){
			return str_contains( $value, 'gravityforms' );
		}, ARRAY_FILTER_USE_BOTH );

		foreach ( $gf_plugins as $plugin ) {
			$parts       = explode( '/', $plugin );
			$plugin_path = trailingslashit( WP_PLUGIN_DIR ) . $parts[ 0 ] . '/';
			$git_path    = $plugin_path . '.git/';
			$has_git     = $this->folder_exists( $git_path );
			$branchname  = $has_git ? $this->get_branch_name( $git_path ) : 'not using git';
			$name = $parts[ 0 ] == 'gravityforms' ? $parts[ 0 ] : str_replace( 'gravityforms', '', $parts[ 0 ] );

			$commit_hash    = '';
			$formatted_date = '';
			$commit_message = '';

			if ( $has_git ) {
				chdir( $plugin_path );
				$commit_hash = trim( exec( 'git log --pretty="%H" -n1 HEAD' ) );
				$commit_date = new \DateTime( trim( exec( 'git log -n1 --pretty=%ci HEAD' ) ) );
				$commit_date->setTimezone( new \DateTimeZone( 'UTC' ) );
				$formatted_date = $commit_date->format( 'Y-m-d H:i:s' );
				$commit_message = trim( exec( 'git log -1' ) );
			}

			$data[] = [
				'name'     => ucfirst( $name ),
				'fullname' => $parts[ 0 ],
				'branch'   => $branchname,
				'hash'     => $commit_hash,
				'date'     => $formatted_date,
				'message'  => $commit_message,
			];
		}

		return $data;
	}
}
