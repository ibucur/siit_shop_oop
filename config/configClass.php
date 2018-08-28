<?php
/**
 * Config class with static properties. We can also use the $_ENV but it is more OOP to keep everything in a class.
 * @author Irinel Bucur
 */

class Config {
	public static $url= 'http://localhost';
	public static $dbHost= '127.0.0.1';
	public static $dbUser= ''; /* todo: Define the correct username */
	public static $dbPassword= ''; /* todo: define the correct password */
	public static $dbName= 'shop';
	public static $dbPort= 3306;
	public static $imagesFolder= 'productImages';
}