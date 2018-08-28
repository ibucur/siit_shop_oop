<?php
/**
 * File that contains all the essential requires which have to be loaded everywhere.
 * We will use this approach because we do not want to use multiple requires in all the files.
 *
 * On all the modules we will include only this file since it loads everything else.
 *
 * @author Irinel BUCUR
 */

require_once(__DIR__.'/../config/config.php');
require_once(__DIR__.'/helpers/output.php');
require_once(__DIR__.'/singletons/db.php');
require_once(__DIR__.'/factories/controllerFactory.php');

