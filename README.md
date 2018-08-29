# The Informal School Shop API Project

In order to start using the project, please download the repository and save it on your shop main folder. Make sure the index.php file is in the shop root.

Execute it and, if you see any problem (except a success response), this means some configuration is wrong. Therefore, search for it, correct it and make sure it is working well.

Shop.sql holds the queries to create the tables needed for this project.

This should be done until the next lecture.


# The API methods documentation

## <a href="https://ibucur.ima-solutions.ro/siit/shop_oop" target="blank">**Working Version of the API**</a>

Includes all the API documentation to be used in order to create the functionality of every single API request.

* [**1. Users**](#1-users)
  * [1.1. User Login](#11-user-login)
  * [1.2. User Logout](#12-user-logout)
  * [1.3. User Add](#13-user-add)
  * [1.4. User Update](#14-user-update)
  * [1.5. User Delete](#15-user-delete)
  * [1.6. User Get](#16-user-get)
  * [1.7. User Get All](#17-user-get-all)

* [**2. Categories**](#2-categories)
  * [2.1. Category Add](#21-category-add)
  * [2.2. Category Update](#22-category-update)
  * [2.3. Category Delete](#23-category-delete)
  * [2.4. Category Get](#24-category-get)
  * [2.5. Category Get All](#25-category-get-all)  

* [**3. Currencies**](#3-currencies)
  * [3.1. Currency Add](#31-currency-add)
  * [3.2. Currency Update](#32-currency-update)
  * [3.3. Currency Delete](#33-currency-delete)
  * [3.4. Currency Get](#34-currency-get)
  * [3.5. Currency Get All](#35-currency-get-all)

* [**4. Currency Conversions**](#4-currency-conversion)
  * [4.1. Currency Conversion Add](#41-currency-conversion-add)
  * [4.2. Currency Conversion Update](#42-currency-conversion-update)
  * [4.3. Currency Conversion Get](#43-currency-conversion-get)
  * [4.4. Currency Conversion Get All](#44-currency-get-conversion-all)

* [**5. Products**](#5-products)
  * [5.1. Products Add](#51-products-add)
  * [5.2. Products Update](#52-products-update)
  * [5.3. Products Delete](#53-products-delete)
  * [5.4. Products Get](#54-products-get)
  * [5.5. Products Get All](#55-products-get-all)

* [**6. Product Images**](#6-product-images)
  * [6.1. Product Images Add](#61-product-images-add)
  * [6.2. Product Images Update](#62-product-images-update)
  * [6.3. Product Images Delete](#63-product-images-delete)
  * [6.4. Product Images Get Main](#64-product-images-get-main)
  * [6.5. Product Images Get All](#65-product-images-get-all)

* [**7. Shopping Cart**](#7-shopping-cart)
  * [7.1. Shopping Cart Add](#71-shopping-cart-add)
  * [7.2. Shopping Cart Update](#72-shopping-cart-update)
  * [7.3. Shopping Cart Delete](#73-shopping-cart-delete)
  * [7.4. Shopping Cart Get](#74-shopping-cart-get)
  * [7.5. Shopping Cart Clear](#75-shopping-cart-clear)
  * [7.6. Shopping Cart Change Currency](#76-shopping-cart-change-currency)
  * [7.7. Shopping Cart Finalize](#77-shopping-cart-finalize)

* [**8. Orders**](#8-orders)
  * [8.1. Orders Update](#81-orders-update)
  * [8.2. Orders Cancel](#82-orders-cancel)
  * [8.3. Orders Get](#83-orders-get)
  * [8.4. Orders Get All](#84-orders-get-all)


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
  	"active": 1, 
  	"isAdmin": 1, 
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
        "categoryName": "the name of updated category"
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
        "categoryName": "the name of the category"
}
```

### 2.5. CATEGORY GET ALL
Get all the categories from the database.

**REQUEST**
```
URI: /api/categories/getAll.php[?pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
        "categoryId": 1,
        "active": 1,
        "categoryName": "the name of the category"
    }
]
```


## 3. CURRENCIES

### 3.1. CURRENCY ADD
Adds a new currency into the database.

**REQUEST**
```
URI: /api/currencies/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"currencyCode": "ISO code of the currency",
    	"currencyName": "name of the currency",
    	"active": 1
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "currencyCode": "EUR",
        "active": 1,
        "currencyName": "the name of the added currency"
}
```

### 3.2. CURRENCY UPDATE
Updates a currency into the database.

**REQUEST**
```
URI: /api/currencies/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"currencyCode": "EUR",
    	"currencyName": "name of the currency",
    	"active": 1
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "currencyCode": "EUR",
        "active": 1,
        "currencyName": "the name of the updated currency"
}
```

### 3.3. CURRENCY DELETE
Removes a currency from the database.

**REQUEST**
```
URI: /api/currencies/delete.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"currencyCode": "EUR"
}
```

**RESPONSE**
Success response format with no details specified.


### 3.4. CURRENCY GET
Get the details of a specified currency.

**REQUEST**
```
URI: /api/currencies/get.php?currencyCode=EUR
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "currencyCode": 1,
        "active": 1,
        "currencyName": "the name of the currency"
}
```

### 3.5. CURRENCY GET ALL
Get all the currencies from the database.

**REQUEST**
```
URI: /api/currencies/getAll.php[?pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
        "currencyCode": "EUR",
        "active": 1,
        "currencyName": "the name of the currency"
    }
]
```


## 4. CURRENCY CONVERSION

### 4.1. CURRENCY CONVERSION ADD
Adds a new currency conversion into the database.

**REQUEST**
```
URI: /api/currencies/conversions/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
        "fromCurrencyCode": "ISO code of the from currency",
        "toCurrencyCode": "ISO code of the to currency",
        "exchangeRate": 4.67,
        "exchangeDate": "YYYY-MM-DD"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "fromCurrencyCode": "ISO code of the from currency",
        "toCurrencyCode": "ISO code of the to currency",
        "exchangeRate": 4.67,
        "exchangeDate": "YYYY-MM-DD"
}
```

### 4.2. CURRENCY CONVERSION UPDATE
Updates a currency conversion into the database.

**REQUEST**
```
URI: /api/currencies/conversions/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
        "fromCurrencyCode": "ISO code of the from currency",
        "toCurrencyCode": "ISO code of the to currency",
        "exchangeRate": 4.67,
        "exchangeDate": "YYYY-MM-DD"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "fromCurrencyCode": "ISO code of the from currency",
        "toCurrencyCode": "ISO code of the to currency",
        "exchangeRate": 4.67,
        "exchangeDate": "YYYY-MM-DD"
}
```

### 4.3. CURRENCY CONVERSION GET
Get the details of a specified currency conversion.

**REQUEST**
```
URI: /api/currencies/conversions/get.php?fromCurrencyCode=EUR&toCurrencyCode=RON&exchangeDate="YYYY-MM-DD"
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
        "fromCurrencyCode": "ISO code of the from currency",
        "toCurrencyCode": "ISO code of the to currency",
        "exchangeRate": 4.67,
        "exchangeDate": "YYYY-MM-DD"
}
```

### 4.4. CURRENCY CONVERSIONS GET ALL
Get all the currency conversions valid on a specified date from the database.

**REQUEST**
```
URI: /api/currencies/getAll.php?exchangeDate="YYYY-MM-DD"[&pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
        "fromCurrencyCode": "ISO code of the from currency",
        "toCurrencyCode": "ISO code of the to currency",
        "exchangeRate": 4.67,
        "exchangeDate": "YYYY-MM-DD"
    }
]
```


## 5. PRODUCTS

### 5.1. PRODUCTS ADD
Adds a new product into the database.

**REQUEST**
```
URI: /api/products/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"categoryId": 1,
    	"productName": "name of the product",
    	"shortDescription": "the short description of the product",
    	"description": "the long description of the product",
    	"price": 120,
    	"currencyCode": "EUR",
    	"active": 1
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"productId": 1,
    	"categoryId": 1,
    	"productName": "name of the product",
    	"shortDescription": "the short description of the product",
    	"description": "the long description of the product",
    	"price": 120,
    	"currencyCode": "EUR",
    	"active": 1
}
```

### 5.2. PRODUCTS UPDATE
Updates a product into the database.

**REQUEST**
```
URI: /api/products/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"productId": 1,
    	"categoryId": 1,
    	"productName": "name of the product",
    	"shortDescription": "the short description of the product",
    	"description": "the long description of the product",
    	"price": 120,
    	"currencyCode": "EUR",
    	"active": 1
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"productId": 1,
    	"categoryId": 1,
    	"productName": "name of the product",
    	"shortDescription": "the short description of the product",
    	"description": "the long description of the product",
    	"price": 120,
    	"currencyCode": "EUR",
    	"active": 1
}
```

### 5.3. PRODUCTS DELETE
Removes a product from the database.

**REQUEST**
```
URI: /api/products/delete.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"productId": 1
}
```

**RESPONSE**
Success response format with no details specified.


### 5.4. PRODUCTS GET
Get the details of a specified product.

**REQUEST**
```
URI: /api/products/get.php?productId=1
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"productId": 1,
    	"categoryId": 1,
    	"productName": "name of the product",
    	"shortDescription": "the short description of the product",
    	"description": "the long description of the product",
    	"price": 120,
    	"currencyCode": "EUR",
    	"active": 1
}
```

### 5.5. PRODUCTS GET ALL
Get all the products from the database, for a specified category or all the products if no category is specified.

**REQUEST**
```
URI: /api/products/getAll.php[?categoryId=1&pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
    	"productId": 1,
    	"categoryId": 1,
    	"productName": "name of the product",
    	"shortDescription": "the short description of the product",
    	"description": "the long description of the product",
    	"price": 120,
    	"currencyCode": "EUR",
    	"active": 1
    }
]
```


## 6. PRODUCT IMAGES

### 6.1. PRODUCT IMAGES ADD
Adds a new product image into the database.

**REQUEST**
```
URI: /api/products/images/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"productId": 1,
    	"isMainImage": 1,
    	"imageBase64Encoded": "the image base 64 encoded content"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"imageId": 1,
    	"productId": 1,
    	"isMainImage": 1,
    	"imageUri": "the image uri where it can be found"
}
```

### 6.2. PRODUCT IMAGES UPDATE
Updates a product image into the database.

**REQUEST**
```
URI: /api/products/images/save.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"imageId": 1,
    	"productId": 1,
    	"isMainImage": 1,
    	"imageBase64Encoded": "the image base 64 encoded content"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"imageId": 1,
    	"productId": 1,
    	"isMainImage": 1,
    	"imageUri": "the image uri where it can be found"
}
```

### 6.3. PRODUCT IMAGES DELETE
Removes a product image from the database.

**REQUEST**
```
URI: /api/products/images/delete.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"imageId": 1
}
```

**RESPONSE**
Success response format with no details specified.


### 6.4. PRODUCT IMAGES GET
Get the details of a specified product image.

**REQUEST**
```
URI: /api/products/images/getMain.php?productId=1
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"imageId": 1,
    	"productId": 1,
    	"isMainImage": 1,
    	"imageUri": "the image uri where it can be found"
}
```

### 6.5. PRODUCTS IMAGES GET ALL
Get all the product images from the database, for a specified product.

**REQUEST**
```
URI: /api/products/images/getAll.php?productId=1[&pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
        "imageId": 1,
        "isMainImage": 1,
        "imageUri": "the image uri where it can be found"
    },
    {
        "imageId": 2,
        "isMainImage": 0,
        "imageUri": "the image uri where it can be found"
    }
]
```

## 7. SHOPPING CART

### 7.1. SHOPPING CART ADD
Adds a new product to the shopping cart.

**REQUEST**
```
URI: /api/cart/add.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"productId": 1,
    	"quantity": 1,
    	"currencyCode": "EUR"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    "currencyCode": "EUR",
    "totalValue": 240.60,
    "products":
        [
            {
                "productId": 1,
                "productName": 1,
                "quantity": 2,
                "price": 120.30,
                "total": 240.60
            }
        ]
}
```

### 7.2. SHOPPING CART UPDATE
Updates the quantity of a product from shopping cart. Sending 0 quantity removes the product from cart.

**REQUEST**
```
URI: /api/cart/update.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
[
    {
    	"productId": 1,
    	"quantity": 1,
    	"currencyCode": "EUR"
    }
]
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    "currencyCode": "EUR",
    "totalValue": 240.60,
    "products":
        [
            {
                "productId": 1,
                "productName": 1,
                "quantity": 2,
                "price": 120.30,
                "total": 240.60
            }
        ]
}
```

### 7.3. SHOPPING CART DELETE
Removes a product from the shopping cart.

**REQUEST**
```
URI: /api/cart/delete.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
[
    {
    	"productId": 1
    }
]
```

**RESPONSE**
Returns the entire cart with all the remaining products
```json
{
    "currencyCode": "EUR",
    "totalValue": 240.60,
    "products":
        [
            {
                "productId": 1,
                "productName": 1,
                "quantity": 2,
                "price": 120.30,
                "total": 240.60
            }
        ]
}
```

### 7.4. SHOPPING CART GET
Get the details of the shopping cart.

**REQUEST**
```
URI: /api/cart/get.php
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
If products are present in the cart otherwise the details content will not be present.
```json
{
    "currencyCode": "EUR",
    "totalValue": 240.60,
    "products":
        [
            {
                "productId": 1,
                "productName": 1,
                "quantity": 2,
                "price": 120.30,
                "total": 240.60
            }
        ]
}
```

### 7.5. SHOPPING CART CLEAR
Removes all the products from the shopping cart.

**REQUEST**
```
URI: /api/cart/clear.php
METHOD: GET
BODY: EMPTY
```

**SUCCESS RESPONSE FORMAT**
No content will be included in the details since the cart is empty

### 7.6. SHOPPING CART CHANGE CURRENCY
Change the current currency of the shopping cart.
The currency can be changed as well automatically if a new product is added in a different currency.
All the product prices from the cart will be changed to this new currency and the total affected.
The response will contain the entire cart.

**REQUEST**
```
URI: /api/cart/changeCurrency.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```

```json
{
        "currencyCode": "RON"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
If products are present in the cart otherwise the details content will not be present.
```json
{
    "currencyCode": "RON",
    "totalValue": 1240.60,
    "products":
        [
            {
                "productId": 1,
                "productName": 1,
                "quantity": 2,
                "price": 620.30,
                "total": 1240.60
            }
        ]
}
```

### 7.7. SHOPPING CART FINALIZE
Move the products from the shopping cart into an order and return the orderId.
In order to be able to finalize an order, the user must be logged in.

**REQUEST**
```
URI: /api/cart/finalize.php
METHOD: POST
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
If products are present in the cart otherwise the details content will not be present.
```json
{
    "orderId": 1,
    "userId": 1,
    "currencyCode": "RON",
    "totalValue": 1240.60,
    "products":
        [
            {
                "productId": 1,
                "productName": 1,
                "quantity": 2,
                "price": 620.30,
                "total": 1240.60
            }
        ]
}
```

## 8. ORDERS

### 8.1. ORDERS UPDATE
Update an order status.

**REQUEST**
```
URI: /api/orders/update.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"orderId": 1,
    	"orderStatus": "new status",
    	"fullName": "name of the customer",
        "deliveryAddress": "the customer delivery address"
}
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"orderId": 1,
    	"userId": 1,
    	"currencyCode": "EUR",
    	"totalValue": 1240.60,
    	"status": "order status",
    	"fullName": "name of the customer",
    	"deliveryAddress": "the customer delivery address",
    	"orderDateTime": "YYYY-MM-DD HH:MM:SS",
    	"statusDateTime": "YYYY-MM-DD HH:MM:SS",
    	"products": [
    	    {
    	        "productId": 1,
    	        "quantity": 2,
    	        "price": 620.30,
    	        "total": 1240.60
    	    }
    	]
}
```

### 8.2. ORDER CANCEL
Cancel an order into the database.

**REQUEST**
```
URI: /api/products/cancel.php
METHOD: POST
HEADER: content-type: application/json
BODY: JSON
```
```json
{
    	"orderId": 1
}
```

**RESPONSE**
```json
{
    	"orderId": 1,
    	"userId": 1,
    	"currencyCode": "EUR",
    	"totalValue": 1240.60,
    	"status": "order status",
    	"fullName": "name of the customer",
    	"deliveryAddress": "the customer delivery address",
    	"orderDateTime": "YYYY-MM-DD HH:MM:SS",
    	"statusDateTime": "YYYY-MM-DD HH:MM:SS",
    	"products": [
    	    {
    	        "productId": 1,
    	        "quantity": 2,
    	        "price": 620.30,
    	        "total": 1240.60
    	    }
    	]
}
```

### 8.3. ORDERS GET
Get the details of a specified orderId.

**REQUEST**
```
URI: /api/orders/get.php?orderId=1
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
{
    	"orderId": 1,
    	"userId": 1,
    	"currencyCode": "EUR",
    	"totalValue": 1240.60,
    	"status": "order status",
    	"fullName": "name of the customer",
    	"deliveryAddress": "the customer delivery address",
    	"orderDateTime": "YYYY-MM-DD HH:MM:SS",
    	"statusDateTime": "YYYY-MM-DD HH:MM:SS",
    	"products": [
    	    {
    	        "productId": 1,
    	        "quantity": 2,
    	        "price": 620.30,
    	        "total": 1240.60
    	    }
    	]
}
```

### 8.4. ORDERS GET ALL
Get all orders main details from the database, for a specified userId or all the orders if no userId is specified.

**REQUEST**
```
URI: /api/orders/getAll.php[?userId=1&pageNo=0&resultsPerPage=50]
METHOD: GET
BODY: EMPTY
```

**SUCCESS DETAILS RESPONSE FORMAT**
```json
[
    {
    	"orderId": 1,
    	"userId": 1,
    	"currencyCode": "EUR",
    	"totalValue": 1240.60,
    	"status": "order status",
    	"fullName": "name of the customer"
    }
]
```
