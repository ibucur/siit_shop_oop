<?php
/**
 * Singleton class which is responsible with the database connection and makes sure only one instance exists.
 * @author Irinel BUCUR
 */

class DB {
	/**
	 * Private variable that holds the mysqli instance.
	 * @var null | MySQLi
	 */
	private static $connection = null;

	/**
	 * DB constructor should be private on a singleton
	 */
	protected function __construct() { }

	/**
	 * __clone should be private in a singleton
	 */
	private function __clone() { }

	/**
	 * __wakeup should be private on a singleton
	 */
	private function __wakeup() { }

	/**
	 * Public static method
	 */
	public static function getInstance(){
		if(static::$connection != null) return static::$connection;
		else{
			static::$connection = new MySQLi(Config::$dbHost, Config::$dbUser, Config::$dbPassword, Config::$dbName, Config::$dbPort);
			if(static::$connection->connect_errno) {
				$errorDetails = "Failed to connect to MySQL: (" . static::$connection->connect_errno. ") " . static::$connection->connect_error;

				static::$connection = null;

				/*
				 * return the error json and stop the execution
				 */
				Output::returnError(_ERROR_ON_DATABASE_CONNECTION, $errorDetails);

			}
			else return static::$connection;
		}
	}

	public static function destroyInstance() {
		if (static::$connection !== null) {
			static::$connection->close();
			static::$connection = null;
		}
	}
}