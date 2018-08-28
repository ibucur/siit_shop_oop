<?php
/**
 * API method to get one user from the database
 */
require_once(__DIR__.'/../../lib/essentials.php');

$obj = ControllerFactory::getController(_CONTROLLER_USER);

$obj->get();