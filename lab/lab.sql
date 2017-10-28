/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50091
Source Host           : localhost:3306
Source Database       : bookinfo

Target Server Type    : MYSQL
Target Server Version : 50091
File Encoding         : 65001

Date: 2014-01-03 15:45:14
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(225) collate utf8_bin default NULL,
  `realname` varchar(225) collate utf8_bin default NULL,
  `password` varchar(225) collate utf8_bin default NULL,
  `email` varchar(225) collate utf8_bin default NULL,
  `roles` tinyint(1) default 0,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO users VALUES ('1', 'admin', '管理员','admin','qudeyong@tenda.cn','0');

-- ----------------------------
-- Table structure for `lend`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(6) NOT NULL auto_increment,
  `productname` varchar(100) NOT NULL,
  `numbers` int(3) NOT NULL,
  PRIMARY KEY  (`id`,`productname`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO products(productname,numbers) VALUES('AC15',1);
INSERT INTO products(productname,numbers) VALUES('AC18',2);
INSERT INTO products(productname,numbers) VALUES('AC9',3);
INSERT INTO products(productname,numbers) VALUES('F9',3);
INSERT INTO products(productname,numbers) VALUES('W60E', 3);
-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `lend_record`;
CREATE TABLE `lend_record` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(225) collate utf8_general_ci default NULL,
  `productname` varchar(225) collate utf8_general_ci default NULL,
  `lend_time` datetime NOT NULL,
  `lend_numbers` int(11) collate utf8_general_ci default NULL,
  `back_time` datetime NOT NULL,
  `back_numbers` int(11)  default 0,
  `mark` varchar(225) collate utf8_general_ci  default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `cost`;
CREATE TABLE `cost` (
  `id` int(11) NOT NULL auto_increment,
  `cost_center` varchar(225) collate utf8_general_ci NOT NULL,
  `cost_id` varchar(225) collate utf8_general_ci NOT NULL,
  `cost_name` varchar(225) collate utf8_general_ci NOT NULL,
  `cost_model` varchar(225) collate utf8_general_ci NOT NULL,
  `position`  varchar(225) collate utf8_general_ci NOT NULL,
  `mark` varchar(225) collate utf8_general_ci  default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `comproducts`;
CREATE TABLE `comproducts` (
  `id` int(11) NOT NULL auto_increment,
  `code` varchar(225) collate utf8_general_ci NOT NULL,
  `product_name` varchar(225) collate utf8_general_ci NOT NULL,
  `model_name` varchar(225) collate utf8_general_ci NOT NULL,
  `numbers` varchar(225) collate utf8_general_ci NOT NULL,
  `position`  varchar(225) collate utf8_general_ci NOT NULL,
  `mark` varchar(225) collate utf8_general_ci  default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
