<?php
/**
 * API method to logout an user
 */
require_once(__DIR__.'/../../lib/essentials.php');

$obj = ControllerFactory::getController(_CONTROLLER_USER);

$obj->logout();
