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
  "errorCode": 1000,
  "errorMessage": "some description of the error code"
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

### * USER LOGIN

**REQUEST**
```
URI: /api/users/login.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
  {
    "email": "email address",
    "password": "password to login"
  }
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "userId": 1,
        "active": 1,
        "fullName": "full name of user",
        "email": "email address",
        "isAdmin": 1,
        "address": "address text",
        "phoneNo": "phone number",
        "lastModify": "YYYY-MM-DD HH:MM:SS"
}
```

### * USER LOGOUT
**REQUEST**
```
URI: /api/users/logout.php
METHOD: GET
BODY: EMPTY
```
**RESPONSE**
Success response with no details.

### * USER ADD

**REQUEST**
```
URI: /api/users/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
  { 
	"email": "user_email",
	"password": "some password",
	"fullName": "some customer name",
	"address": "some address",
	"phoneNo": "some phone number"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "userId": 1,
        "active": 1,
        "fullName": "full name of user",
        "email": "email address",
        "isAdmin": 1,
        "address": "address text",
        "phoneNo": "phone number",
        "lastModify": "YYYY-MM-DD HH:MM:SS"
}
```
### * USER UPDATE

**REQUEST**
```
URI: /api/users/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
  { 
  "userId": 1,
  "active": 1, //only admin can send it
  "isAdmin": 1, //only admin can send it
	"email": "user_email",
	"password": "some password - OPTIONAL ONLY IF YOU WANT TO CHANGE IT",
	"fullName": "some customer name",
	"address": "some address",
	"phoneNo": "some phone number"
}
```
_**NOTE**_: active, isAdmin and password are OPTIONAL. password should be sent only if you want to change the existing one. active and isAdmin can be sent only by the admin. Other logged in users if they send it will not be taken in consideration.

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "userId": 1,
        "active": 1,
        "fullName": "full name of user",
        "email": "email address",
        "isAdmin": 1,
        "address": "address text",
        "phoneNo": "phone number",
        "lastModify": "YYYY-MM-DD HH:MM:SS"
}
```

### * USER DELETE

**REQUEST**
```
URI: /api/users/delete.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{ 
	"userId": 1
}
```

**RESPONSE**
Success response format

