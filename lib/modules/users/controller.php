<?php
/**
 * Class that defines the users controller. Here will be all the main functionality's for a user controller.
 */

require_once(__DIR__.'/../controllerBase.php');

require_once(__DIR__.'/model.php');
require_once(__DIR__.'/repository.php');

class UserController extends ControllerBase{
	
	public function __construct()
	{
		//empty for the moment. we do not need to do anything.
	}

	/**
	 * Method that saves an user into the database. It can be update or insert.
	 *
	 * input format:
	 * {
	 *  "userId":some_int_number - this is optional,
	 *  "fullName":"",
	 *  "email":"",
	 *  "password":"" - is optional if userId is passed and update should be done,
	 *  "address":"",
	 *  "phoneNo":"",
	 *  "active":int_number - only admin can change it or specify it,
	 *  "isAdmin":int_number - only admin can change it or specify it
	 * }
	 */
	public function save() {
		/**
		 * decode the input and store it in a local variable
		 *
		 * check if the required fields from the input are present and holds the right information. Right means follow some rules.
		 * we do not care if it exists or not in the database at this step and if it does not pass throw an error.
		 * We will use Output::returnError(_ERROR_USER_PROFILE_DETAILS_ARE_INCOMPLETE, json_encode($decodedInput));
		 *
		 * if the validation is passed, we get the active status and is admin status.
		 *
		 * $activeStatus = (static::isLoggedInUserAdmin()?$decodedInput->active:(static::isLoggedIn()?$_SESSION['user']->active:1));
		 * $isAdminStatus = (static::isLoggedInUserAdmin()?$decodedInput->isAdmin:(static::isLoggedIn()?$_SESSION['user']->isAdmin:0));
		 *
		 * create an user object based on the information you have so far from input and the status.
		 *
		 * Check if we have a record for the specified userId in order to decide if we have to update the record or to add a new one
		 * if it exists (userId is set and it exists in the db) call update method and send the userObj parameter. with the result User object update the session if the same userId's like the one in the session is present and then return the success response.
		 * otherwise check if the password is present and if not return an error, check if the email address is already in use
		 * and if it is return an error and otherwise call insert method with userObj parameter and return the success response or error if there is the case.
		 *
		 *
		 * HERE IS THE CODE EXAMPLE
		 */

		/**
		 * get the post data first since the login details are sent through a posted json
		 */
		$decodedInput = $this->getPostInput();

		if (!empty($decodedInput->fullName) AND !empty($decodedInput->email) AND !empty($decodedInput->address) AND !empty($decodedInput->phoneNo)) {

			$activeStatus = (static::isLoggedInUserAdmin()?$decodedInput->active:(static::isLoggedIn()?$_SESSION['user']->active:1));
			$isAdminStatus = (static::isLoggedInUserAdmin()?$decodedInput->isAdmin:(static::isLoggedIn()?$_SESSION['user']->isAdmin:0));

			$userObj = new User($decodedInput->userId, $activeStatus, $decodedInput->fullName, $decodedInput->email, $decodedInput->password, $isAdminStatus, $decodedInput->address, $decodedInput->phoneNo, date('Y-m-d H:i:s'));
			/**
			 * Check if we have a record for the specified userId in order to decide
			 * if we have to update the record or to add a new one
			 */
			if (!empty($decodedInput->userId) AND $decodedInput->userId > 0 AND $this->getOneUserById($decodedInput->userId) !== false) {
				/**
				 * This means we have a record and we can update.
				 */
				$this->update($userObj);
			}
			else {
				/**
				 * This means we do not have a record and we have to add a new one.
				 */
				if (empty($decodedInput->password)) {
					/**
					 * cannot add the user with no password specified
					 */
					Output::returnError(_ERROR_USER_PASSWORD_CANNOT_BE_EMPTY, json_encode($decodedInput));
				}
				elseif ($this->checkIfUserEmailInUse($decodedInput->email)) {
					/**
					 * cannot add the user with no password specified
					 */
					Output::returnError(_ERROR_USER_EMAIL_IS_ALREADY_IN_USE, json_encode($decodedInput));
				}
				else {
					$this->insert($userObj);
				}
			}
		}
		else {
			Output::returnError(_ERROR_USER_PROFILE_DETAILS_ARE_INCOMPLETE, json_encode($decodedInput));
		}

	}
	
	/**
	 * Method that handles the logic to adds a specified user into the database
	 *
	 * @param User $userObj
	 */
	public function insert(User $userObj) {
		/**
		 * call the repository to insert the received userObj.
		 *
		 * if the result is false, throw an error, otherwise output the success response (which has to be an User object)
		 *
		 * HERE IS THE CODE
		 */

		$result = UserRepository::insert($userObj);

		if ($result === false) {
			Output::returnError(_ERROR_USER_PROFILE_DETAILS_ARE_INCOMPLETE, json_encode($userObj));
		}

		Output::returnResponse($result);
	}

	/**
	 * Method that updates the user sent on parameters
	 *
	 * @param User $userObj
	 */
	public function update(User $userObj) {
		/**
		 * call the repository to update the received userObj.
		 *
		 * if the result is false, throw an error, otherwise update the logged in user if there is the case
		 * and output the success response (which has to be an User object)
		 *
		 * HERE IS THE CODE
		 */
		$result = UserRepository::update($userObj);

		if ($result === false) {
			Output::returnError(_ERROR_USER_PROFILE_DETAILS_ARE_INCOMPLETE, json_encode($userObj));
		}

		/**
		 * Update the logged in user session details if it has been updated.
		 */
		if ($result->userId == $_SESSION['user']->userId)
		{
			$_SESSION['user'] = $result;
		}
		Output::returnResponse($result);
	}

	/**
	 * Method that deletes an user from the database
	 *
	 * Input Example:
	 * {
	 *    "userId": int value
	 * }
	 */
	public function delete() {
		/**
		 * decode the input and store the userId variable
		 * 
		 * check if the userId is a valid number and return an error if not
		 * 
		 * check if the userId is existing in the database and return an error if not
		 * 
		 * check if the loggedin user is an admin in order to be able to delete it and return an error if not
		 *
		 * call the repository function which has to delete the user.
		 * if the response is false, this means there was an error when deleting the user,
		 * an error message should be returned. Otherwise return success.
		 * 
		 * HERE IS THE CODE
		 */

		/**
		 * get the post data first since the login details are sent through a posted json
		 */
		$decodedInput = $this->getPostInput();
		
		if ((!isset($decodedInput->userId) || !is_integer($decodedInput->userId)) && $decodedInput->userId <= 0) {
			Output::returnError(_ERROR_THE_USER_ID_SENT_IS_INCORRECT, json_encode($decodedInput));
		}
		
		if (!static::isLoggedInUserAdmin()) {
			Output::returnError(_ERROR_ACCESS_TO_THIS_FUNCTIONALITY_IS_LIMITED_TO_LOGGED_IN_ADMIN_USERS, json_encode($decodedInput));
		}
		
		if ($this->getOneUserById($decodedInput->userId) === false) {
			Output::returnError(_ERROR_THE_USER_ID_SEND_DOES_NOT_EXISTS, json_encode($decodedInput));
		}
		
		if (UserRepository::delete($decodedInput->userId) === false) {
			Output::returnError(_ERROR_ON_RUNNING_SQL_QUERY, json_encode($decodedInput));
		}
		else {
			Output::returnResponse();
		}
	}

	/**
	 * Method that will return the details of a userId
	 * @param $userId
	 *
	 * @return boolean|User
	 */
	public function getOneUserById($userId) {
		/**
		 * call the repository to get an User object for the specified userId and then return it
		 *
		 * HERE IS THE CODE
		 */

		return UserRepository::getUserById($userId);
	}

	/**
	 * Method that checks if the e-mail address is already taken by another user.
	 *
	 * @param $email
	 *
	 * @return Boolean
	 */
	public function checkIfUserEmailInUse($email) {
		/**
		 * call the repository to check if the e-mail address exists in the users table and then return it
		 *
		 * HERE IS THE CODE
		 */

		return UserRepository::checkIfUserEmailIsInUse($email);
	}

	/**
	 * Method that contains the login business logic
	 *
	 * input format:
	 * {
	 *  "email": "some_string",
	 *  "password": "some_password_string"
	 * }
	 */
	public function login() {
		/**
		 * The login functionality logic should be as following:
		 * 1. decode the input
		 * 2. check if the input has all the required parameters sent. Isset validation on objects should be always done.
		 * 3. format the email in lower case and encrypt the received password since we store the password encrypted.
		 * 4. call the repository to receive the user object or false value if no user has been found.
		 * 5. if no user found then return error.
		 * 6. if user found store it in the session and return success response including the user details.
		 */

		/*
		 * get the post data first since the login details are sent through a posted json
		 */
		$decodedInput = $this->getPostInput();

		/*
		 * check if all the required params are sent
		 */
		if (!isset($decodedInput->email) || empty($decodedInput->email) || !isset($decodedInput->password) || empty($decodedInput->password)) {
			Output::returnError(_ERROR_INCOMPLETE_LOGIN_DETAILS_PASSED);
		}

		/*
		 * format the email in lower case and encode the sent password in order to be able to match it
		 */
		$decodedInput->email    = strtolower($decodedInput->email);
		$decodedInput->password = User::encryptPassword($decodedInput->password);

		/*
		 * call the repository method that executes the query and returns an object or false if no user found
		 */
		$userObj = UserRepository::getUserFromEmailAndPassword($decodedInput->email, $decodedInput->password);

		/*
		 * is user has not been found throw error message otherwise it continues.
		 */
		if ($userObj === false) {
			$extraDetails = 'email: '.$decodedInput->email.', password: '.$decodedInput->password;
			Output::returnError(_ERROR_INVALID_LOGIN_DETAILS, $extraDetails);
		}

		/*
		 * set the session user object. this is how we know if a user is logged in or not by checking this session variable
		 */
		$_SESSION['user'] = $userObj;

		/*
		 * Return the logged in user details. The password is not set since it has no relevance being encrypted and stops.
		 */
		Output::returnResponse($userObj);
	}

	/**
	 * Method that contains the logout business logic
	 */
	public function logout() {
		if ($this->isLoggedIn()) {
			unset($_SESSION['user']);
			Output::returnResponse();
		}
		else {
			Output::returnError(_ERROR_USER_NOT_LOGGED_IN_TO_LOGOUT);
		}
	}

	/**
	 * Method that identifies if a user is logged in or not
	 *
	 * @return boolean
	 */
	public static function isLoggedIn() {
		if (isset($_SESSION['user']) && is_object($_SESSION['user'])) return true;
		else return false;
	}

	/**
	 * Method that identifies if a logged in user is admin or not
	 *
	 * @return boolean
	 */
	public static function isLoggedInUserAdmin() {
		if (static::isLoggedIn() && $_SESSION['user']->isAdmin == 1) return true;
		else return false;
	}

	/**
	 * The functionality to get the details of a specified user sent by GET. If no user specified get the current logged user details
	 */
	public function get() {

		/**
		 * The logic is the following:
		 * 1. check if the user is logged in and return error to login if not
		 * 2. get the userId sent by get or if no value sent use the logged in userId
		 * 3. check if the input is correct. We do not check yet the database
		 * 4. check if the required user details belongs to other user than the logged in one
		 * and if the logged in user is admin in order to have access to this functionality
		 * 5. get the user object by calling another local method.
		 * 6. if the received response from step 5 is false return error (no user found in db),
		 * otherwise return success including the user details
		 */

		/**
		 * check if the user is logged in and return error to login if not
		 */
		if (!static::isLoggedIn()) {
			Output::returnError(_ERROR_THE_FUNCTIONALITY_IS_LIMITED_ONLY_TO_LOGGED_IN_USERS);
		}

		/**
		 * get the userId sent by get or if no value sent use the logged in userId
		 */
		if (isset($_GET['userId']) && !empty($_GET['userId'])) {
			/**
			 * force the conversion to integer. we can add 0 or we can use the specific cast (int) in front of the value.
			 */
			//$userId = $_GET['userId'] + 0;
			$userId = (int) $_GET['userId'];
		}
		else {
			$userId = $_SESSION['user']->userId;
		}

		/**
		 * check if all the parameters are properly sent
		 */
		if (!is_integer($userId) OR $userId <= 0) {
			Output::returnError(_ERROR_THE_USER_ID_SENT_IS_INCORRECT, 'userId = '.$userId);
		}
		
		/**
		 * check if the user tries to get other user profile and it is not admin 
		 */
		if ($userId != $_SESSION['userId']->userId && !static::isLoggedInUserAdmin()) {
			Output::returnError(_ERROR_ACCESS_TO_THIS_FUNCTIONALITY_IS_LIMITED_TO_LOGGED_IN_ADMIN_USERS, 'userId = '.$userId);
		} 
		
		/**
		 * try to get the user and if the result is false, the user was not found return error.
		 * Otherwise return the user
		 */
		$userObj = $this->getOneUserById($userId);

		if ($userObj === false) {
			Output::returnError(_ERROR_THE_USER_ID_SEND_DOES_NOT_EXISTS, 'userId = '.$userId);
		}
		else {
			Output::returnResponse($userObj);
		}
	}

	/**
	 * Method that returns all the users from the database. Only admin users have access to this functionality.
	 * No input is required
	 */
	public function getAll() {
		/**
		 * The logic of this functionality should be:
		 * 1. check if the admin user is logged in in order to access this functionality
		 * 2. check if GET parameter pageNo has been specified and if yes use it. Otherwise use 0.
		 * 3. check if GET parameter resultsPerPage has been specified and use it. Otherwise use default 50.
		 * 4. Call the repository functionality to receive all the users
		 * 5. check if a false result has been received and return an error
		 * 6. return the users found. It can be no users if there are none in the database.
		 *  it will not be the case since the first validation is if a user is logged in.
		 *  So, at least one should be present.
		 *
		 * HERE IS THE CODE
		 */


		/**
		 * check if the admin is logged in
		 */
		if (!static::isLoggedInUserAdmin()) {
			Output::returnError(_ERROR_ACCESS_TO_THIS_FUNCTIONALITY_IS_LIMITED_TO_LOGGED_IN_ADMIN_USERS);
		}

		/**
		 * check if the page number get parameter has been specified and use it. Otherwise set it to first page.
		 *
		 * $pageNo = (isset($_GET['pageNo']) && $_GET['pageNo'] >= 0? $_GET['pageNo']: 0);
		 */
		if (isset($_GET['pageNo']) && $_GET['pageNo'] >= 0) {
			$pageNo = $_GET['pageNo'];
		}
		else {
			$pageNo = 0;
		}

		/**
		 * check if the number of results per page get parameter has been specified and use it.
		 * Otherwise set it to default 50 users per page.
		 *
		 * $resultsPerPage = (isset($_GET['resultsPerPage']) && $_GET['resultsPerPage'] >= 0? $_GET['resultsPerPage']: 50);
		 */
		if (isset($_GET['resultsPerPage']) && $_GET['resultsPerPage'] >= 0) {
			$resultsPerPage = $_GET['resultsPerPage'];
		}
		else {
			$resultsPerPage = 50;
		}

		/**
		 * Call the repository functionality to receive all the users
		 */
		$arrUserObj = UserRepository::getAll(true, $pageNo, $resultsPerPage);

		/**
		 * check if a false result has been received and return an error
		 */
		if ($arrUserObj === false) {
			Output::returnError(_ERROR_ON_RUNNING_SQL_QUERY);
		}

		/**
		 * return the users found. It can be no users if there are none in the database.
		 * it will not be the case since the first validation is if a user is logged in.
		 * So, at least one should be present.
		 */
		Output::returnResponse($arrUserObj);
	}

}