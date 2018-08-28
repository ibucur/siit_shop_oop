<?php
/**
 * @author Irinel Bucur.
 * Application main entry point. We will not have anything here since it is just a test for API
 */

require_once(__DIR__.'/lib/essentials.php');

$db = DB::getInstance();

Output::returnResponse(['message'=>"The API main index is working and the connection with the database has been established. Used to hide the folder structure of our application."]);
