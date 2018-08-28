<?php
/**
 * Success class to manage the returned success response more clearly.
 * @author Irinel BUCUR
 */

class SuccessResponse {

	/**
	 * Method that will format the output based on the agreement and to make sure we will use the same format everywere.
	 * @param null|array $array
	 *
	 * @return array
	 */
	static function getResponse($array = NULL){

		$output = [];

		$output['successful'] = true;
		if((is_array($array) AND count($array) > 0) OR (is_object($array)) ){
			$output['details'] = $array;
		}

		return $output;
	}
}