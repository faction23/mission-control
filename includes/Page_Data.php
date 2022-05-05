<?php


namespace DevTools;


class Page_Data {

	public function get_data( $sort = 'post_title' ) {
		$args  = array(
			'sort_order'   => 'asc',
			'sort_column'  => $sort,
			'hierarchical' => 1,
			'child_of'     => 0,
			'parent'       => - 1,
			'post_type'    => 'page',
			'post_status'  => 'publish'
		);
		$pages = get_pages( $args );
		$data  = array();

		foreach( $pages as $page ) {
			$data[] = array(
				'title' => $page->post_title,
				'id'    => $page->ID,
				'link'  => get_the_permalink( $page->ID ),
			);
		}

		return $data;
	}

}
