<?php
/**
 * Error codes class to manage the returned errors more clearly. We will define a set of error constant codes as well.
 * @author Irinel BUCUR
 */

class ErrorClass{
	/**
	 * Define the errors array using the constants defined in config.
	 * @var array
	 */
	private static $errors = array(
		_ERROR_ON_DATABASE_CONNECTION => 'The connection to the database has been failed.',
		_ERROR_ON_DECODING_THE_POST_JSON_INPUT => 'The json details sent was not properly decoded.',
		_ERROR_ON_DECODING_SINCE_METHOD_IS_NOT_POST => 'The method to be used in order to send data has to be POST.',
		_ERROR_ON_DECODING_SINCE_POSTED_DATA_IS_NOT_APPLICATION_JSON => 'The POST method used is sending other details than application/json content type.',

		_ERROR_INVALID_LOGIN_DETAILS => 'The user details sent to login are invalid',
		_ERROR_INCOMPLETE_LOGIN_DETAILS_PASSED => 'You need to pass the user email and password in order to be able to login',
		_ERROR_USER_NOT_LOGGED_IN_TO_LOGOUT => 'In order to logout you need to login first.',
		_ERROR_USER_PASSWORD_CANNOT_BE_EMPTY => 'The password cannot be left blank.',
		_ERROR_USER_PROFILE_DETAILS_ARE_INCOMPLETE => 'The user details are not correctly specified. Some fields are missing.',
		_ERROR_USER_EMAIL_IS_ALREADY_IN_USE => 'The user email is already in use.',
	);

	/**
	 * Returns the description of an error code by parsing the static errors class property.
	 * @param $errorCode
	 *
	 * @return mixed|string
	 */
	public static function getErrorDescription($errorCode) {
		return isset(static::$errors[$errorCode])?static::$errors[$errorCode]:'Unrecognized Error Code and Error Message!';
	}

	/**
	 * Method that will return the error array response to be encoded as json
	 *
	 * @param $errorCode
	 * @param string $extraDetails
	 *
	 * @return array
	 */
	public static function getError($errorCode, $extraDetails= '') {
		$result = ['successful' => false, 'errorCode' => $errorCode];
		$result['errorMessage'] = static::getErrorDescription($errorCode);

		/*
		 * If extraDetails have a value different than '', we will include the details into the error message.
		 */
		$result['errorMessage'] .= ($extraDetails!= ''?' (Extra details: '.$extraDetails.')':'');

		return $result;
	}

	//we will add more soon like header set and method to throw the error and to stop the execution
}