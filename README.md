# The Informal School Shop API Project

In order to start using the project, please download the repository and save it on your shop main folder. Make sure the index.php file is in the shop root.

Execute it and, if you see any problem (except a success response), this means some configuration is wrong. Therefore, search for it, correct it and make sure it is working well.

Shop.sql holds the queries to create the tables needed for this project.

This should be done until the next lecture.


# The API methods documentation

Includes all the API documentation to be used in order to create the functionality of every single API request.

Every API call will receive a JSON response. It can be a success one or an error one.

## Error JSON format
```json
{
  "successful": false,
  "errorCode": some error code number
  "errorMessage": some description of the error code
}
```

## Success JSON format
```json
{
  "successful": true,
  "details": "some object or array based on the request"
}
```

## USERS

### User Login
```
URI: /api/users/login.php
METHOD: POST
HEADER: content-type: application.json
BODY: JSON
```
```json
  {
    "email": "email address",
    "password": "password to login"
  }
```
```
RESPONSE:
  It is a JSON format
```
```json
{
  "successful": true,
  "details": {
        "userId": 1,
        "active": 1,
        "fullName": "full name of user",
        "email": "email address",
        "isAdmin": 1,
        "address": "address text",
        "phoneNo": "phone number",
        "lastModify": "YYYY-MM-DD HH:MM:SS"
  }
}
```
