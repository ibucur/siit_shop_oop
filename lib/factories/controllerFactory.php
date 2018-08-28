<?php
/**
 * The controller factory class.
 */

require_once(__DIR__.'/../modules/users/controller.php');

class ControllerFactory {
	/**
	 * @param int $type
	 *
	 * @return ControllerBase|UserController
	 */
	public static function getController($type) {
		switch ($type) {
			case _CONTROLLER_USER:
				$userController = new UserController();
				return $userController;
				break;

			case _CONTROLLER_CATEGORY:

				break;

			case _CONTROLLER_CURRENCY:

				break;

			case _CONTROLLER_CURRENCY_CONVERSION:

				break;

			case _CONTROLLER_PRODUCT:

				break;

			case _CONTROLLER_PRODUCT_IMAGE:

				break;

			case _CONTROLLER_ORDER:

				break;
		}
	}
}