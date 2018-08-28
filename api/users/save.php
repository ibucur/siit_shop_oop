<?php
/**
 * API method to add / update a user into the database
 */

require_once(__DIR__.'/../../lib/essentials.php');

$obj = ControllerFactory::getController(_CONTROLLER_USER);

$obj->save();