<?php
/**
 * The main config loader. This file will be included where we need to load the configuration files.
 * @author Irinel BUCUR
 */

/*
 * sets the environment variables display_errors and location of the error log file.
 */
ini_set("display_errors", E_ALL & !E_WARNING);
ini_set("error_log", __DIR__."/../logs/php.errors");

/**
 * Auto-loader function to load the user model before the session is started in order to properly decode the user object
 * stored in the session
 *
 * @param $className
 *
 * @return bool
 */
function __autoload($className) {
	if ($className == 'User' && file_exists(__DIR__.'/../lib/modules/users/model.php')) {
		require_once __DIR__.'/../lib/modules/users/model.php';
		return true;
	}
	return false;
}

/*
 * starts the session
 */
session_start();

/*
 * load the configuration class.
 */
require_once(__DIR__.'/configClass.php');
require_once(__DIR__.'/errorCodesConstants.php');
require_once(__DIR__.'/controllerTypesConstants.php');