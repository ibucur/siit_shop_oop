<?php
/**
 * API method to login one user
 */

require_once(__DIR__.'/../../lib/essentials.php');

$obj = ControllerFactory::getController(_CONTROLLER_USER);

$obj->login();
