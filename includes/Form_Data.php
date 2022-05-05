<?php


namespace DevTools;


class Form_Data {

	public function get_data( $sort = 'title' ) {
		$forms = \GFAPI::get_forms( true, false, $sort );
		$data  = array();

		foreach( $forms as $form ) {
			$data[] = array(
				'title' => $form[ 'title' ],
				'id'    => $form[ 'id' ],
			);
		}

		return $data;
	}

}
