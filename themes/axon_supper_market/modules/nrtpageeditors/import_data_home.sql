/*
Navicat MySQL Data Transfer

Source Server         : admin
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : croma

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-05-19 16:58:22
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ps_nrtfooteditors_html`
-- ----------------------------
DROP TABLE IF EXISTS `ps_nrtfooteditors_html`;
CREATE TABLE `ps_nrtfooteditors_html` (
  `id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_html`),
  KEY `id_html` (`id_html`,`id_shop`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ps_nrtfooteditors_html
-- ----------------------------
INSERT INTO `ps_nrtfooteditors_html` VALUES ('2', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('5', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('6', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('8', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('9', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('10', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('11', '1');
INSERT INTO `ps_nrtfooteditors_html` VALUES ('12', '1');

-- ----------------------------
-- Table structure for `ps_nrtfooteditors_htmlc`
-- ----------------------------
DROP TABLE IF EXISTS `ps_nrtfooteditors_htmlc`;
CREATE TABLE `ps_nrtfooteditors_htmlc` (
  `id_html` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id_html`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ps_nrtfooteditors_htmlc
-- ----------------------------
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('2', 'MY ACCOUNT');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('5', 'PAYMENT');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('6', 'Address');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('8', 'Follow Us');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('9', 'CONTACT US');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('10', 'LINKS');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('11', 'EXTRAS');
INSERT INTO `ps_nrtfooteditors_htmlc` VALUES ('12', 'OUR SUPPORT');

-- ----------------------------
-- Table structure for `ps_nrtfooteditors_htmlc_lang`
-- ----------------------------
DROP TABLE IF EXISTS `ps_nrtfooteditors_htmlc_lang`;
CREATE TABLE `ps_nrtfooteditors_htmlc_lang` (
  `id_html` int(11) unsigned NOT NULL,
  `id_lang` int(11) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL,
  `html` text,
  KEY `id_html` (`id_html`,`id_lang`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ps_nrtfooteditors_htmlc_lang
-- ----------------------------
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('2', '1', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>MY ACCOUNT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_my_acount\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_my_acount\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">My orders</a></li>\r\n<li><a href=\"#\" title=\"\">My credit slips</a></li>\r\n<li><a href=\"#\" title=\"\">My addresses</a></li>\r\n<li><a href=\"#\" title=\"\">My personal info</a></li>\r\n<li><a href=\"#\" title=\"\">My vouchers</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('2', '2', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>MY ACCOUNT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_my_acount\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_my_acount\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">My orders</a></li>\r\n<li><a href=\"#\" title=\"\">My credit slips</a></li>\r\n<li><a href=\"#\" title=\"\">My addresses</a></li>\r\n<li><a href=\"#\" title=\"\">My personal info</a></li>\r\n<li><a href=\"#\" title=\"\">My vouchers</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('2', '3', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>MY ACCOUNT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_my_acount\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_my_acount\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">My orders</a></li>\r\n<li><a href=\"#\" title=\"\">My credit slips</a></li>\r\n<li><a href=\"#\" title=\"\">My addresses</a></li>\r\n<li><a href=\"#\" title=\"\">My personal info</a></li>\r\n<li><a href=\"#\" title=\"\">My vouchers</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('2', '4', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>MY ACCOUNT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_my_acount\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_my_acount\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">My orders</a></li>\r\n<li><a href=\"#\" title=\"\">My credit slips</a></li>\r\n<li><a href=\"#\" title=\"\">My addresses</a></li>\r\n<li><a href=\"#\" title=\"\">My personal info</a></li>\r\n<li><a href=\"#\" title=\"\">My vouchers</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('5', '1', '0', '<div class=\"links box-links payment\">\r\n<h3>payment</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_payment\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_payment\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\"><img class=\"img-responsive\" src=\"/croma/home1/modules/nrtfootereditors/images/payment_footer.png\" alt=\"\" /> </a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('5', '2', '0', '<div class=\"links box-links payment\">\r\n<h3>payment</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_payment\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_payment\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\"><img class=\"img-responsive\" src=\"/croma/home1/modules/nrtfootereditors/images/payment_footer.png\" alt=\"\" /> </a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('5', '3', '0', '<div class=\"links box-links payment\">\r\n<h3>payment</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_payment\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_payment\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\"><img class=\"img-responsive\" src=\"/croma/home1/modules/nrtfootereditors/images/payment_footer.png\" alt=\"\" /> </a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('5', '4', '0', '<div class=\"links box-links payment\">\r\n<h3>payment</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_payment\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_payment\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\"><img class=\"img-responsive\" src=\"/croma/home1/modules/nrtfootereditors/images/payment_footer.png\" alt=\"\" /> </a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('6', '1', '0', '<div class=\"row\">\r\n<div class=\"footer-address\">\r\n<p>Copyright © 2017 <a href=\"#\"> Lightatend</a>. All rights reserved.</p>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('6', '2', '0', null);
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('6', '3', '0', null);
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('6', '4', '0', null);
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('8', '1', '0', '<div class=\"links box-links social_footer\">\r\n<h3>Follow Us</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_follow\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_follow\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\" class=\"fa  fa-facebook\">.</a> <a href=\"#\" class=\"fa  fa-twitter\">.</a> <a href=\"#\" class=\"fa  fa-google-plus\">.</a><a href=\"#\" class=\"fa  fa-pinterest\">.</a> <a href=\"#\" class=\"fa  fa-linkedin\">.</a> <a href=\"#\" class=\"fa  fa-skype\">.</a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('8', '2', '0', '<div class=\"links box-links social_footer\">\r\n<h3>Follow Us</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_follow\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_follow\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\" class=\"fa  fa-facebook\">.</a> <a href=\"#\" class=\"fa  fa-twitter\">.</a> <a href=\"#\" class=\"fa  fa-google-plus\">.</a><a href=\"#\" class=\"fa  fa-pinterest\">.</a> <a href=\"#\" class=\"fa  fa-linkedin\">.</a> <a href=\"#\" class=\"fa  fa-skype\">.</a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('8', '3', '0', '<div class=\"links box-links social_footer\">\r\n<h3>Follow Us</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_follow\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_follow\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\" class=\"fa  fa-facebook\">.</a> <a href=\"#\" class=\"fa  fa-twitter\">.</a> <a href=\"#\" class=\"fa  fa-google-plus\">.</a><a href=\"#\" class=\"fa  fa-pinterest\">.</a> <a href=\"#\" class=\"fa  fa-linkedin\">.</a> <a href=\"#\" class=\"fa  fa-skype\">.</a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('8', '4', '0', '<div class=\"links box-links social_footer\">\r\n<h3>Follow Us</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_follow\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_follow\" class=\"collapse wrapper-social\">\r\n<li><a href=\"#\" class=\"fa  fa-facebook\">.</a> <a href=\"#\" class=\"fa  fa-twitter\">.</a> <a href=\"#\" class=\"fa  fa-google-plus\">.</a><a href=\"#\" class=\"fa  fa-pinterest\">.</a> <a href=\"#\" class=\"fa  fa-linkedin\">.</a> <a href=\"#\" class=\"fa  fa-skype\">.</a></li>\r\n</ul>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('9', '1', '0', '<div class=\"links contact_ft\">\r\n<div class=\"box-links\">\r\n<h3>CONTACT US</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_contact\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_contact\" class=\"collapse\">\r\n<li>\r\n<div class=\"fa fa-map-marker\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Address: </span> <span>123 Main Street, Anytown, CA 12345 USA</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-phone\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale telephone: </span> <span>+1 800 123 1234</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-envelope\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale email account: </span> <a href=\"#\">lightatendthemes@gmail.com</a></div>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('9', '2', '0', '<div class=\"links contact_ft\">\r\n<div class=\"box-links\">\r\n<h3>CONTACT US</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_contact\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_contact\" class=\"collapse\">\r\n<li>\r\n<div class=\"fa fa-map-marker\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Address: </span> <span>123 Main Street, Anytown, CA 12345 USA</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-phone\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale telephone: </span> <span>+1 800 123 1234</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-envelope\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale email account: </span> <a href=\"#\">lightatendthemes@gmail.com</a></div>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('9', '3', '0', '<div class=\"links contact_ft\">\r\n<div class=\"box-links\">\r\n<h3>CONTACT US</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_contact\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_contact\" class=\"collapse\">\r\n<li>\r\n<div class=\"fa fa-map-marker\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Address: </span> <span>123 Main Street, Anytown, CA 12345 USA</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-phone\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale telephone: </span> <span>+1 800 123 1234</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-envelope\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale email account: </span> <a href=\"#\">lightatendthemes@gmail.com</a></div>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('9', '4', '0', '<div class=\"links contact_ft\">\r\n<div class=\"box-links\">\r\n<h3>CONTACT US</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_contact\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_contact\" class=\"collapse\">\r\n<li>\r\n<div class=\"fa fa-map-marker\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Address: </span> <span>123 Main Street, Anytown, CA 12345 USA</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-phone\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale telephone: </span> <span>+1 800 123 1234</span></div>\r\n</li>\r\n<li>\r\n<div class=\"fa fa-envelope\"></div>\r\n<div class=\"right-contact\"><span class=\"lable\">Sale email account: </span> <a href=\"#\">lightatendthemes@gmail.com</a></div>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('10', '1', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>LINKS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_links\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_links\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">About Us</a></li>\r\n<li><a href=\"#\" title=\"\">Stores</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Terms & Conditions</a></li>\r\n<li><a href=\"#\" title=\"\">Testimonials</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('10', '2', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>LINKS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_links\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_links\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">About Us</a></li>\r\n<li><a href=\"#\" title=\"\">Stores</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Terms & Conditions</a></li>\r\n<li><a href=\"#\" title=\"\">Testimonials</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('10', '3', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>LINKS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_links\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_links\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">About Us</a></li>\r\n<li><a href=\"#\" title=\"\">Stores</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Terms & Conditions</a></li>\r\n<li><a href=\"#\" title=\"\">Testimonials</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('10', '4', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>LINKS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_links\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_links\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">About Us</a></li>\r\n<li><a href=\"#\" title=\"\">Stores</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Terms & Conditions</a></li>\r\n<li><a href=\"#\" title=\"\">Testimonials</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('11', '1', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>EXTRAS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_extras\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_extras\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">Women</a></li>\r\n<li><a href=\"#\" title=\"\">Men</a></li>\r\n<li><a href=\"#\" title=\"\">Kids</a></li>\r\n<li><a href=\"#\" title=\"\">Bags</a></li>\r\n<li><a href=\"#\" title=\"\">Shoes</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('11', '2', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>EXTRAS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_extras\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_extras\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">Women</a></li>\r\n<li><a href=\"#\" title=\"\">Men</a></li>\r\n<li><a href=\"#\" title=\"\">Kids</a></li>\r\n<li><a href=\"#\" title=\"\">Bags</a></li>\r\n<li><a href=\"#\" title=\"\">Shoes</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('11', '3', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>EXTRAS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_extras\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_extras\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">Women</a></li>\r\n<li><a href=\"#\" title=\"\">Men</a></li>\r\n<li><a href=\"#\" title=\"\">Kids</a></li>\r\n<li><a href=\"#\" title=\"\">Bags</a></li>\r\n<li><a href=\"#\" title=\"\">Shoes</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('11', '4', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>EXTRAS</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_extras\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_extras\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">Women</a></li>\r\n<li><a href=\"#\" title=\"\">Men</a></li>\r\n<li><a href=\"#\" title=\"\">Kids</a></li>\r\n<li><a href=\"#\" title=\"\">Bags</a></li>\r\n<li><a href=\"#\" title=\"\">Shoes</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('12', '1', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>OUR SUPPORT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_our\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_our\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">F.A.Q</a></li>\r\n<li><a href=\"#\" title=\"\">Shipping</a></li>\r\n<li><a href=\"#\" title=\"\">Contact Us</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Site map</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('12', '2', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>OUR SUPPORT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_our\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_our\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">F.A.Q</a></li>\r\n<li><a href=\"#\" title=\"\">Shipping</a></li>\r\n<li><a href=\"#\" title=\"\">Contact Us</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Site map</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('12', '3', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>OUR SUPPORT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_our\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_our\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">F.A.Q</a></li>\r\n<li><a href=\"#\" title=\"\">Shipping</a></li>\r\n<li><a href=\"#\" title=\"\">Contact Us</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Site map</a></li>\r\n</ul>\r\n</div>\r\n</div>');
INSERT INTO `ps_nrtfooteditors_htmlc_lang` VALUES ('12', '4', '0', '<div class=\"links bullet\">\r\n<div class=\"box-links\">\r\n<h3>OUR SUPPORT</h3>\r\n<div class=\"title\" data-target=\"#footer_sub_menu_col_our\" data-toggle=\"collapse\">\r\n<div class=\"navbar-toggler collapse-icons hidden-md-up\">\r\n<div class=\"fa fa-plus add\"></div>\r\n<div class=\"fa fa-minus remove\"></div>\r\n</div>\r\n</div>\r\n<ul id=\"footer_sub_menu_col_our\" class=\"collapse\">\r\n<li><a href=\"#\" title=\"\">F.A.Q</a></li>\r\n<li><a href=\"#\" title=\"\">Shipping</a></li>\r\n<li><a href=\"#\" title=\"\">Contact Us</a></li>\r\n<li><a href=\"#\" title=\"\">Privacy Policy</a></li>\r\n<li><a href=\"#\" title=\"\">Site map</a></li>\r\n</ul>\r\n</div>\r\n</div>');
