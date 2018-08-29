<?php
/**
 * Class that describes an user
 */

class User {
	/**
	 * @var int|null
	 */
	public $userId;
	/**
	 * @var int|null
	 */
	public $active;
	/**
	 * @var null|string
	 */
	public $fullName;
	/**
	 * @var null|string
	 */
	public $email;
	/**
	 * @var null|string
	 */
	public $password;
	/**
	 * @var int|null
	 */
	public $isAdmin;
	/**
	 * @var null|string
	 */
	public $address;
	/**
	 * @var null|string
	 */
	public $phoneNo;
	/**
	 * @var null|string
	 */
	public $lastModify;

	/**
	 * The class constructor. If parameters are specified when the class is instantiated (we do this by calling new User()
	 * the class properties will be set.
	 *
	 * @param null|integer $userId
	 * @param null|integer $active
	 * @param null|string $fullName
	 * @param null|string $email
	 * @param null|string $password
	 * @param null|integer $isAdmin
	 * @param null|string $address
	 * @param null|string $phoneNo
	 * @param null|string $lastModify
	 */
	function __construct($userId = NULL, $active = NULL, $fullName = NULL, $email = NULL, $password = NULL, $isAdmin = NULL, $address = NULL, $phoneNo = NULL, $lastModify = NULL){
		$this->userId       = $userId;
		$this->active       = $active;
		$this->fullName     = ucwords(strtolower($fullName));
		$this->email        = strtolower($email);
		$this->password     = !empty($password)?static::encryptPassword($password):$password;
		$this->isAdmin      = $isAdmin;
		$this->address      = $address;
		$this->phoneNo      = $phoneNo;
		$this->lastModify   = $lastModify;
	}

	/**
	 * Method that will return an encrypted hash password based on an input password.
	 * @param $password
	 *
	 * @return string
	 */
	static function encryptPassword($password) {
		return sha1($password);
	}


	
}