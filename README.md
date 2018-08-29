# The Informal School Shop API Project

In order to start using the project, please download the repository and save it on your shop main folder. Make sure the index.php file is in the shop root.

Execute it and, if you see any problem (except a success response), this means some configuration is wrong. Therefore, search for it, correct it and make sure it is working well.

Shop.sql holds the queries to create the tables needed for this project.

This should be done until the next lecture.


# The API methods documentation

Includes all the API documentation to be used in order to create the functionality of every single API request.

[1. Users](#1-users)
    [1.1. User Login](#11-user-login)
    [1.2. User Logout](#12-user-logout)
    [1.3. User Add](#13-user-add)
    [1.4. User Update](#14-user-update)
    [1.5. User Delete](#15-user-delete)
    [1.6. User Get](#16-user-get)
    [1.7. User Get All](#17-user-get-all)
[2. Categories](#2-categories)
    [2.1. Category Add](#21-category-add)
    [2.2. Category Update](#22-category-update)
    [2.3. Category Delete](#23-category-delete)
    [2.4. Category Get](#24-category-get)
    [2.5. Category Get All](#25-category-get-all)
    

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

## 1. USERS

### 1.1. USER LOGIN
Logs in a user using the passed credentials.

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

### 1.2. USER LOGOUT
Performs logout of a logged in user.

**REQUEST**
```
URI: /api/users/logout.php
METHOD: GET
BODY: EMPTY
```
**RESPONSE**
Success response with no details.

### 1.3. USER ADD
Adds a user into the database.

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
### 1.4. USER UPDATE
Updates a specified user into the database.

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

### 1.5. USER DELETE
Removes a specified user from the database.

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

### 1.6. USER GET
Returns all the user details of a specified user or of the current logged in user.

**REQUEST**
```
URI: /api/users/get.php[?userId=1]
METHOD: GET
BODY: EMPTY
```
The userId query string parameter can be specified by an admin or, if it is specified by the current logged in user which is not an admin, it should match the logged in userId. If it is not specified, the returned details will be the ones of the logged in user.


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

### 1.7. USER GET ALL
Returns all the users from the database if a logged in admin makes the request.

**REQUEST**
```
URI: /api/users/getAll.php[?pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```


**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
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
]
```


## 2. CATEGORIES

### 2.1. CATEGORY ADD
Adds a new category into the database.

**REQUEST**
```
URI: /api/categories/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
  {
    "categoryName": "name of the category",
    "active": 1
  }
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "categoryId": 1,
        "active": 1,
        "categoryName": "the name of added category"
}
```

### 2.2. CATEGORY UPDATE
Updates a category into the database.

**REQUEST**
```
URI: /api/categories/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    "categoryId": 1,
    "categoryName": "name of the category",
    "active": 1
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "categoryId": 1,
        "active": 1,
        "categoryName": "the name of added category"
}
```

### 2.3. CATEGORY DELETE
Removes a category from the database.

**REQUEST**
```
URI: /api/categories/delete.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    "categoryId": 1
}
```

**RESPONSE**
Success response format with no details specified.


### 2.4. CATEGORY GET
Get the details of a specified category.

**REQUEST**
```
URI: /api/categories/get.php?categoryId=1
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "categoryId": 1,
        "active": 1,
        "categoryName": "the name of added category"
}
```

### 2.5. CATEGORY GET ALL
Get all the categories from the database.

**REQUEST**
```
URI: /api/categories/getAll.php
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
        "categoryId": 1,
        "active": 1,
        "categoryName": "the name of added category"
    }
]
```
