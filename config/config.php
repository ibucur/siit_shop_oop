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