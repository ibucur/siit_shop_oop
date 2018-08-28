/*
Navicat MySQL Data Transfer

Source Server         : 1.3
Source Server Version : 50626
Source Host           : 192.168.1.3:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2018-08-28 16:37:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for Categories
-- ----------------------------
DROP TABLE IF EXISTS `Categories`;
CREATE TABLE `Categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for Currencies
-- ----------------------------
DROP TABLE IF EXISTS `Currencies`;
CREATE TABLE `Currencies` (
  `currencyCode` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `currencyName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`currencyCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for CurrencyConversions
-- ----------------------------
DROP TABLE IF EXISTS `CurrencyConversions`;
CREATE TABLE `CurrencyConversions` (
  `fromCurrencyCode` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `toCurrencyCode` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `exchangeRate` decimal(10,4) unsigned NOT NULL,
  `exchangeDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for OrderDetails
-- ----------------------------
DROP TABLE IF EXISTS `OrderDetails`;
CREATE TABLE `OrderDetails` (
  `autoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderId` int(10) unsigned DEFAULT NULL,
  `productId` int(10) unsigned DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,3) DEFAULT NULL,
  `total` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`autoId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for Orders
-- ----------------------------
DROP TABLE IF EXISTS `Orders`;
CREATE TABLE `Orders` (
  `orderId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('delivered','cancelled','unconfirmed','confirmed') COLLATE utf8_unicode_ci DEFAULT 'unconfirmed',
  `userId` int(10) unsigned DEFAULT NULL,
  `fullName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deliveryAddress` text COLLATE utf8_unicode_ci,
  `orderDateTime` datetime DEFAULT NULL,
  `statusDateTime` datetime DEFAULT NULL,
  `currencyCode` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalValue` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for ProductImages
-- ----------------------------
DROP TABLE IF EXISTS `ProductImages`;
CREATE TABLE `ProductImages` (
  `imageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `isMainImage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`imageId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for Products
-- ----------------------------
DROP TABLE IF EXISTS `Products`;
CREATE TABLE `Products` (
  `productId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` int(10) unsigned NOT NULL,
  `productName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `shortDescription` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL,
  `currencyCode` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for Users
-- ----------------------------
DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fullName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `address` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lastModify` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
