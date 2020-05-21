/*
Navicat MySQL Data Transfer

Source Server         : admin
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : axon2_3

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-08-13 11:02:56
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ps_nrteditors_html`
-- ----------------------------
DROP TABLE IF EXISTS `ps_nrteditors_html`;
CREATE TABLE `ps_nrteditors_html` (
  `id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_html`),
  KEY `id_html` (`id_html`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ps_nrteditors_html
-- ----------------------------
INSERT INTO `ps_nrteditors_html` VALUES ('1', '1');
INSERT INTO `ps_nrteditors_html` VALUES ('2', '1');

-- ----------------------------
-- Table structure for `ps_nrteditors_htmlc`
-- ----------------------------
DROP TABLE IF EXISTS `ps_nrteditors_htmlc`;
CREATE TABLE `ps_nrteditors_htmlc` (
  `id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id_html`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ps_nrteditors_htmlc
-- ----------------------------
INSERT INTO `ps_nrteditors_htmlc` VALUES ('1', 'countdown');
INSERT INTO `ps_nrteditors_htmlc` VALUES ('2', 'Intro');

-- ----------------------------
-- Table structure for `ps_nrteditors_htmlc_lang`
-- ----------------------------
DROP TABLE IF EXISTS `ps_nrteditors_htmlc_lang`;
CREATE TABLE `ps_nrteditors_htmlc_lang` (
  `id_html` int(11) unsigned NOT NULL,
  `id_lang` int(11) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL,
  `html` text,
  KEY `id_html` (`id_html`,`id_lang`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ps_nrteditors_htmlc_lang
-- ----------------------------
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('1', '1', '0', '<div class=\"item-countdown-box\">\r\n<div class=\"item-countdown-time\" data-time=\"2020-02-05 00:00:00\"></div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('1', '2', '0', '<div class=\"item-countdown-box\">\r\n<div class=\"item-countdown-time\" data-time=\"2020-02-05 00:00:00\"></div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('1', '3', '0', '<div class=\"item-countdown-box\">\r\n<div class=\"item-countdown-time\" data-time=\"2020-02-05 00:00:00\"></div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('1', '4', '0', '<div class=\"item-countdown-box\">\r\n<div class=\"item-countdown-time\" data-time=\"2020-02-05 00:00:00\"></div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('2', '1', '0', '<div class=\"static-intro hidden-md-down\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-paper-plane\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">NO LIMITED</span> <span class=\"content_intro\">Worldwide free shipping</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-rotate-left\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">MONEY BACK</span> <span class=\"content_intro\">7 days money back guaranteed</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-headphones\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">SAFETY</span> <span class=\"content_intro\"> We never share your individual info</span> </span> </a></div>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('2', '2', '0', '<div class=\"static-intro hidden-md-down\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-paper-plane\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">NO LIMITED</span> <span class=\"content_intro\">Worldwide free shipping</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-rotate-left\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">MONEY BACK</span> <span class=\"content_intro\">7 days money back guaranteed</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-headphones\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">SAFETY</span> <span class=\"content_intro\"> We never share your individual info</span> </span> </a></div>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('2', '3', '0', '<div class=\"static-intro hidden-md-down\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-paper-plane\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">NO LIMITED</span> <span class=\"content_intro\">Worldwide free shipping</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-rotate-left\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">MONEY BACK</span> <span class=\"content_intro\">7 days money back guaranteed</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-headphones\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">SAFETY</span> <span class=\"content_intro\"> We never share your individual info</span> </span> </a></div>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrteditors_htmlc_lang` VALUES ('2', '4', '0', '<div class=\"static-intro hidden-md-down\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-paper-plane\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">NO LIMITED</span> <span class=\"content_intro\">Worldwide free shipping</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-rotate-left\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">MONEY BACK</span> <span class=\"content_intro\">7 days money back guaranteed</span> </span> </a></div>\r\n<div class=\"col-sm-4 col-xs-12\"><a href=\"#\" class=\"intro-box\" style=\"background: url(\'/axon2/home3/modules/nrtpageeditors/images/bg_intro.jpg\');\"> <span class=\"intro-top\"> <span class=\"fa fa-headphones\">.</span> </span> <span class=\"intro-bottom\"> <span class=\"title_intro\">SAFETY</span> <span class=\"content_intro\"> We never share your individual info</span> </span> </a></div>\r\n</div>\r\n</div>');
