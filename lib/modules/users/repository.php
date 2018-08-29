<?php
/**
 * Class that defines the users repository which contains database communication functionality's.
 */

require_once(__DIR__.'/model.php');

class UserRepository {

	/**
	 * Method to be used at login which returns an user object if found or false otherwise
	 * 
	 * @param $loginEmail
	 * @param $loginPassword
	 * 
	 * @return boolean|User
	 */
	public static function getUserFromEmailAndPassword($loginEmail, $loginPassword) {
		/**
		 * The logic on selecting an user from the database based on
		 *  the email and password (used for login) is the following:
		 * 1. Get the database instance from singleton.
		 * 2. Prepare the statement. If it was not prepared the result is false and raise an error (response should be false)
		 * 3. Bind the proper parameters.
		 * 4. Execute the statement. if error on execution close the statement and raise an error (response should be false)
		 * 5. Bind the result to assign every row field value to a variable
		 * 6. Stores the result into an internal cache. Used to optimize the execution but uses more memory.
		 * 7. Check if number of selected rows is 0 (no users found to match the query condition), close the statement and return false.
		 * 8. If fetching a record is successful,
		 *  a. get the userObj based on the found userId returned by the query
		 *      by calling the proper method which returns an user object (it is defined in this class),
		 *  b. close the statement and
		 *  c. return the userObject.
		 */

		/**
		 * 1. Get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * 2. Prepare the statement. If it was not prepared the result is false and raise an error (response should be false)
		 */
		if ($stmt = $db->prepare('SELECT userId FROM Users WHERE email = ? AND password = ? and active = 1 limit 0,1')) {
			/**
			 * 3. Bind the proper parameters.
			 */
			$stmt->bind_param('ss', $loginEmail, $loginPassword);

			/**
			 * 4. Execute the statement. if error on execution close the statement and raise an error (response should be false)
			 */
			if ($stmt->execute()) {
				/**
				 * 5. Bind the result to assign every row field value to a variable
				 */
				$stmt->bind_result($userId);

				/**
				 * 6. Stores the result into an internal cache. Used to optimize the execution but uses more memory.
				 */
				$stmt->store_result();

				/**
				 * 7. check if number of selected rows is 0 (no users found to match the query condition), close the statement and return false.
				 */
				if ($stmt->num_rows == 0) {
					$stmt->close();
					return false;
				}
				elseif ($stmt->fetch()) {
					/**
					 * 8. If fetching a record is successful,
					 *  a. get the userObj based on the found userId returned by the query
					 *      by calling the proper method which returns an user object (it is defined in this class),
					 *  b. close the statement and
					 *  c. return the userObject.
					 */
					$userObj = static::getUserById($userId);

					$stmt->close();

					return $userObj;
				}
				else {
					$stmt->close();
					return false;
				}
			}
			else {
				$stmt->close();
				return false;
			}
		}
		else {
			return false;	
		}
		
	}

	/**
	 * Insert an user into the database.
	 * 
	 * @param User $userObj
	 *
	 * @return bool|User
	 */
	public static function insert(User $userObj) {
		/**
		 * The logic on inserting a user in the database is the following:
		 * 1. Get the database instance from singleton.
		 * 2. Start the transaction (it is a database change operation and we use transactions to be on the safe side)
		 * 3. Prepare the statement. If it was not prepared the result is false and raise an error (response should be false)
		 * The password field should be included in the query since we add a record and we cannot add without a password.
		 * 4. Bind the proper parameters.
		 * 5. Execute the statement. if error on execution close the statement, rollback the transaction and raise an error (response should be false)
		 * 6. Execution was successful,
		 *  a. commit the transaction,
		 *  b. complete on the userObj used the insert it (the primary key assigned automatically by the database),
		 *  c. close the statement and
		 *  d. call the method to get the updated record from the database and return it.
		 */

		/**
		 * 1. Get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * Start the transaction (it is a database change operation and we use transactions to be on the safe side)
		 */
		$db->begin_transaction();

		/**
		 * 3. Prepare the statement. If it was not prepared the result is false and raise an error (response should be false)
		 * The password field should be included in the query since we add a record and we cannot add without a password.
		 */
		if ($stmt = $db->prepare('INSERT INTO Users (active, fullName, email, password, isAdmin, address, phoneNo, lastModify) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())'))
		{
			/**
			 * 4. Bind the proper parameters.
			 */
			$stmt->bind_param('isssiss', $userObj->active, $userObj->fullName, $userObj->email, $userObj->password, $userObj->isAdmin, $userObj->address, $userObj->phoneNo);

			/**
			 * 5. Execute the statement. if error on execution close the statement, rollback the transaction and raise an error (response should be false)
			 */
			if ($stmt->execute()) {
				/**
				 * 6. Execution was successful,
				 *  a. commit the transaction,
				 *  b. complete on the userObj used the insert it (the primary key assigned automatically by the database),
				 *  c. close the statement and
				 *  d. call the method to get the updated record from the database and return it.
				 */
				$db->commit();

				$userObj->userId = $stmt->insert_id;

				$stmt->close();

				//now get the user details and return them
				return static::getUserById($userObj->userId);;
			}
			else
			{
				$stmt->close();
				$db->rollback();
				return false;
			}
		}
		else
		{
			$db->rollback();
			return false;
		}
	}

	/**
	 * Update an user into the database.
	 *
	 * @param User $userObj
	 *
	 * @return bool|User
	 */
	public static function update(User $userObj) {
		/**
		 * The logic to update a user on the database is the following:
		 * 1. Get the database instance from singleton.
		 * 2. Start the transaction (it is a database change operation and we use transactions to be on the safe side)
		 * 3. Prepare the statement. If it was not prepared the result is false and raise an error (response should be false)
		 * The password field should be included in the query only if it has been changed.
		 * 4. Based on the password field (if it has to be changed or not) bind the proper parameters.
		 * 5. Execute the statement. if error on execution close the statement, rollback the transaction and raise an error (response should be false)
		 * 6. Execution was successful, commit the transaction, close the statement and call the method to get the updated record from the database and return it.
		 */

		/**
		 * 1. Get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * 2. Start the transaction (it is a database change operation and we use transactions to be on the safe side)
		 */
		$db->begin_transaction();

		/**
		 * 3. Prepare the statement. If it was not prepared, rollback the transaction, the result is false and raise an error (response should be false).
		 * The password field should be included in the query only if it has been changed.
		 */
		if ($stmt = $db->prepare('UPDATE Users SET active = ?, fullName = ?, email = ?, '.(!empty($userObj->password)?'password=?,':'').' isAdmin = ?, address = ?, phoneNo = ?, lastModify = NOW() WHERE userId = ?'))
		{
			/**
			 * 4. Based on the password field (if it has to be changed or not) bind the proper parameters.
			 */
			if (!empty($userObj->password)) {
				$stmt->bind_param('isssissi', $userObj->active, $userObj->fullName, $userObj->email, $userObj->password, $userObj->isAdmin, $userObj->address, $userObj->phoneNo, $userObj->userId);
			}
			else {
				$stmt->bind_param('ississi', $userObj->active, $userObj->fullName, $userObj->email, $userObj->isAdmin, $userObj->address, $userObj->phoneNo, $userObj->userId);
			}

			/**
			 * 5. Execute the statement. if error on execution close the statement, rollback the transaction and raise an error (response should be false)
			 */
			if ($stmt->execute()) {
				/**
				 * 6. Execution was successful, commit the transaction, close the statement
				 * and call the method to get the updated record from the database and return it.
				 */
				$db->commit();

				$stmt->close();

				return static::getUserById($userObj->userId);
			}
			else
			{
				/**
				 * error on execution close the statement, rollback the transaction and raise an error (response should be false)
				 */
				$stmt->close();
				$db->rollback();
				return false;
			}
		}
		else
		{
			$db->rollback();
			return false;
		}
	}

	/**
	 * Return an user from the database based on an userId
	 * 
	 * @param $userId
	 * 
	 * @return boolean|User
	 */
	public static function getUserById($userId) {
		/**
		 * The logic to get a user object from the database is the following:
		 * 1. Get the database instance from singleton.
		 * 2. Prepare the statement and limit the number of deleted rows to 1.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 * 3. Bind the proper parameters used in prepared statement
		 * 4. Execute the statement. if error on execution raise an error (response should be false)
		 * 5. Bind the selected fields from the query result.
		 * 6. Store the result
		 * 7. Check if number of selected rows is zero. This means nothing has been found and return false after closing the statement.
		 * 8. Else if fetch a row is success, create an user object instance with all the selected values,
		 *  remove the password, close the statement and return the user object.
		 * 9. Else close the statement and return false.
		 */

		/**
		 * 1. get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * 2. prepare the statement and limit the number of deleted rows to 1.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 */
		if ($stmt = $db->prepare('SELECT userId, active, fullName, email, isAdmin, address, phoneNo, lastModify FROM Users WHERE userId = ? limit 0,1')) {
			/**
			 * 3. Bind the proper parameters used in prepared statement
			 */
			$stmt->bind_param('i', $userId);

			/**
			 * 4. Execute the statement. if error on execution raise an error (response should be false)
			 */
			if ($stmt->execute()) {
				/**
				 * 5. Bind the selected fields from the query result.
				 */
				$stmt->bind_result($userId, $active, $fullName, $email, $isAdmin, $address, $phoneNo, $lastModify);

				/**
				 * 6. Stores the result into an internal cache. Used to optimize the execution but uses more memory.
				 */
				$stmt->store_result();

				/**
				 * 7. Check if number of selected rows is zero. This means nothing has been found and return false after closing the statement.
				 */
				if ($stmt->num_rows == 0) {
					$stmt->close();
					return false;
				}
				elseif ($stmt->fetch()) {
					/**
					 * 8. Else if fetch a row is success, create an user object instance with all the selected values,
					 *  remove the password, close the statement and return the user object.
					 */
					$userObj = new User($userId, $active, $fullName, $email, '', $isAdmin, $address, $phoneNo, $lastModify);
					unset($userObj->password);

					$stmt->close();

					return $userObj;
				}
				else {
					/**
					 * 9. Close the statement and return false.
					 */
					$stmt->close();
					return false;
				}
			}
		}
		else {
			return false;
		}
	}

	/**
	 * Return true if email exists in users db
	 *
	 * @param $email
	 *
	 * @return boolean
	 */
	public static function checkIfUserEmailIsInUse($email) {
		/**
		 * The logic on checking if the user email is already in use is the following:
		 * 1. get the database instance from singleton.
		 * 2. convert the email parameter to lowercase since we store all the user e-mails in lower case
		 * 3. prepare the statement and limit the number of deleted rows to 1.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 * 4. bind the proper parameters used in prepared statement
		 * 5. execute the statement. if error on execution raise an error (response should be false)
		 * 6. Bind the selected fields from the query result.
		 * 7. store the result
		 * 8. fetch a row. since we need just one record makes no sense to use while and get all rows.
		 * 9. if fetched userId value is greater than 0, it means a user having the same e-mail
		 * address has been found and we should return true after closing the statement, like we found it in use.
		 */

		/**
		 * 1. get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * 2. convert the email parameter to lowercase since we store all the user e-mails in lower case
		 */
		$email = strtolower($email);

		/**
		 * 3. prepare the statement and limit the number of deleted rows to 1.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 */
		if ($stmt = $db->prepare("SELECT userId FROM Users WHERE email = ? limit 0,1")) {
			/**
			 * bind the proper parameters used in prepared statement
			 */
			$stmt->bind_param('s', $email);

			/**
			 * 5. execute the statement. if error on execution raise an error (response should be false)
			 */
			if ($stmt->execute()) {
				/**
				 * 6. Bind the selected fields from the query result
				 */
				$stmt->bind_result($userId);

				/**
				 * 7. Stores the result into an internal cache. Used to optimize the execution but uses more memory.
				 */
				$stmt->store_result();

				/**
				 * 8. Fetch the result. Now data is populated into the binded variables.
				 */
				$stmt->fetch();

				/**
				 * 9. if fetched userId value is greater than 0, it means a user having the same e-mail
				 * address has been found and we should return true after closing the statement, like we found it in use.
				 */
				if ($userId > 0) {
					$stmt->close();
					return true;
				}
			}
			else {
				/**
				 * ATTENTION: WHEN CLOSE IS CALLED, IT DESTROY'S THE VALUE FROM BIND VARIABLES !!!
				 * I have spent 2 hours to find the error when I first used it.
				 */
				$stmt->close();

				return false;
			}
		}

		return false;
	}

	/**
	 * Method that deletes an user specified by userId from the database users table
	 *
	 * @param $userId
	 *
	 * @return bool
	 */
	public static function delete($userId) {
		/**
		 * The logic on delete is the following:
		 * 1. get the database instance from singleton.
		 * 2. start the transaction on the db instance
		 * 3. prepare the statement and limit the number of deleted rows to 1.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 * 4. bind the proper parameters used in prepared statement
		 * 5. execute the statement. if error on execution raise an error (response should be false)
		 * 6. check if number of affected rows (the deleted ones) are 0 when it means no users has been found to match the sql conditions.
		 * rollback the transaction, close the statement and return false.
		 * 7. if affected rows are greater than 0 it means some users has been deleted.
		 *  close the statement, commit the transaction and return true
		 */

		/**
		 * 1. get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * 2. start the transaction on the db instance
		 */
		$db->begin_transaction();

		/**
		 * 3. prepare the statement and limit the number of deleted rows to 1.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 */
		if ($stmt = $db->prepare("DELETE FROM Users WHERE userId = ? limit 1")) {
			/**
			 * 4. bind the proper parameters used in prepared statement
			 */
			$stmt->bind_param('i', $userId);

			/**
			 * 5. execute the statement. if error on execution raise an error (response should be false)
			 */
			if ($stmt->execute()) {
				if ($stmt->affected_rows == 0) {
					/**
					 * 6. check if number of affected rows (the deleted ones) are 0 when it means no users has been found to match the sql conditions.
					 * rollback the transaction, close the statement and return false.
					 */
					$stmt->close();
					$db->rollback();
					return false;
				}
				else {
					/**
					 * 7. if affected rows are greater than 0 it means some users has been deleted.
					 *  close the statement, commit the transaction and return true
					 */

					/**
					 * close the statement
					 */
					$stmt->close();
					/**
					 * commit the transaction
					 */
					$db->commit();

					/**
					 * return true as operation was successful
					 */
					return true;
				}
			}
			else {
				//the execution failed and we show the error
				/**
				 * close the statement
				 */
				$stmt->close();

				/**
				 * rollback the transaction
				 */
				$db->rollback();

				/**
				 * return false
				 */
				return false;
			}
		}
		else {
			/**
			 * rollback the transaction
			 */
			$db->rollback();

			/**
			 * return false
			 */
			return false;
		}
	}

	/**
	 * Method that returns all the users from the database based on some input parameters.
	 * 
	 * @param bool $sortByName
	 * @param int $pageNo
	 * @param int $resultsPerPage
	 *
	 * @return array|bool
	 */
	public static function getAll($sortByName = true, $pageNo = 0, $resultsPerPage = 50) {
		/**
		 * The logic on getting all the users is the following:
		 * 1. get the database instance from singleton.
		 * 2. prepare the statement and limit the number of selected users based on pageNo (it is the offset) and resultPerPage. Order by fullName if it is requested.
		 *  if it was not prepared the result is false and raise an error (response should be false)
		 * 4. bind the proper parameters used in prepared statement
		 * 5. execute the statement. if error on execution raise an error (response should be false)
		 * 6. initiate an empty array for the found users.
		 * 7. bind the result into some variables. The number of bind variables should match the order and number of selected fields.
		 * 8. Store the result. This initiates the storing into the bind variables.
		 * 9. into a while repetitive statement start fetching every single row,
		 * create an user object, unset the password field and store it into the array of found users.
		 * 10. close the statement
		 * 11. return the array of users found.
		 */

		/**
		 * get the database instance from singleton.
		 */
		$db = DB::getInstance();

		/**
		 * prepare the statement and limit the number of selected users based on pageNo (it is the offset) and resultPerPage. Order by fullName if it is requested.
		 * if it was not prepared the result is false and raise an error (response should be false) - this is on else bellow
		 */
		if ($stmt = $db->prepare('SELECT userId, active, fullName, email, isAdmin, address, phoneNo, lastModify FROM Users '.($sortByName === true?'ORDER BY fullName ASC':'').' limit ?,?')) {
			/**
			 * bind the proper parameters used in prepared statement
			 */
			$stmt->bind_param('ii', $pageNo, $resultsPerPage);

			/**
			 * execute the statement. if error on execution raise an error (response should be false) - this is on else bellow
			 */
			if ($stmt->execute()) {

				/**
				 * initiate an empty array for the found users.
				 */
				$arrUserObj = [];

				/**
				 * bind the result into some variables. The number of bind variables should match the order and number of selected fields.
				 */
				$stmt->bind_result($userId, $active, $fullName, $email, $isAdmin, $address, $phoneNo, $lastModify);

				/**
				 * Stores the result into an internal cache. Used to optimize the execution but uses more memory.
				 */
				$stmt->store_result();

				/**
				 * into a while repetitive statement start fetching every single row,
				 * create an user object, unset the password field and store it into the array of found users.
				 */
				while ($stmt->fetch()) {
					$userObj = new User($userId, $active, $fullName, $email, '', $isAdmin, $address, $phoneNo, $lastModify);
					unset($userObj->password);
					array_push($arrUserObj, $userObj);
				}
				/**
				 * close the statement
				 */
				$stmt->close();

				/**
				 * return the array of users found.
				 */
				return $arrUserObj;
				
			}
			else {
				/**
				 * close the statement
				 */
				$stmt->close();

				/**
				 * return false
				 */
				return false;
			}
		}

		/**
		 * return false if the statement was not prepared.
		 */
		return false;
	}

}