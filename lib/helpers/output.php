<?php
/**
 * Class that will manage the output. Based on the request it will identify if an error message should be thrown or a success message should be returned.
 * @author Irinel BUCUR
 */

/**
 * include the error and success response formatter classes
 */
require_once(__DIR__.'/errorClass.php');
require_once(__DIR__.'/successClass.php');

class Output {
	/**
	 * Method that sets the response header to JSON
	 */
	static function setJSONHeader(){
		header('Content-Type:application/json');
	}

	/**
	 * Method that will output an error json response.
	 * There is an extra details string which will be used to pass more details about an error.
	 *
	 * @param $errorCode
	 * @param string $extraDetails
	 */
	static function returnError($errorCode, $extraDetails = ''){

		/*
		 * set the application/json header to make sure the response will be interpreted as an json object.
		 */
		static::setJSONHeader();
		
		/*
		 * get the error message in an array format, encode it and display
		 */
		echo json_encode(ErrorClass::getError($errorCode, $extraDetails));

		/*
		 * close any database active singleton connection
		 */
		DB::destroyInstance();

		/*
		 * stop the execution after the message is thrown
		 */
		exit();
	}


	/**
	 *
	 * Method that will output the array passed parameter into a JSON format.
	 *
	 * @param null|array $array
	 */
	static function returnResponse($array = NULL){
		/*
		 * set the application/json header to make sure the response will be interpreted as an json object.
		 */
		static::setJSONHeader();
		
		/*
		 * get the success message formatted based on the input array, encode it and display.
		 */
		echo json_encode(SuccessResponse::getResponse($array));

		/*
		 * close any database active singleton connection
		 */
		DB::destroyInstance();
		
		/*
		 * stop the execution after the message is thrown
		 */
		exit();
	}
}