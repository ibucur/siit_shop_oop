<?php
/**
 * API method to delete one user from the database
 */
require_once(__DIR__.'/../../lib/essentials.php');

$obj = ControllerFactory::getController(_CONTROLLER_USER);

$obj->delete();