<?php
/**
 * Contains the controller abstract class and it is the reference for all controllers
 */

abstract class ControllerBase {
	protected function getPostInput() {
		/*
		 * Make sure that it is a POST request.
		 */
		if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
			Output::returnError(_ERROR_ON_DECODING_SINCE_METHOD_IS_NOT_POST);
		}

		//Make sure that the content type of the POST request has been set to application/json
		$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
		if(strcasecmp($contentType, 'application/json') != 0){
			Output::returnError(_ERROR_ON_DECODING_SINCE_POSTED_DATA_IS_NOT_APPLICATION_JSON);
		}

		/*
		 * Get JSON as a string
		 */
		$json_str = file_get_contents('php://input');

		/*
		 * Get as an object
		 */
		$json_obj = json_decode($json_str);

		if (!is_array($json_obj) && !is_object($json_obj)) {
			Output::returnError(_ERROR_ON_DECODING_THE_POST_JSON_INPUT, $json_str);
		}

		return $json_obj;
	}

	public abstract function save();
	public abstract function delete();
	public abstract function get();
	public abstract function getAll();


}