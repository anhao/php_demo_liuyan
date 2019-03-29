/*
Navicat MySQL Data Transfer

Source Server         : LOC
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : liuyan

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-29 22:35:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tg_article
-- ----------------------------
DROP TABLE IF EXISTS `tg_article`;
CREATE TABLE `tg_article` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '帖子id',
  `tg_reid` mediumint(8) unsigned zerofill NOT NULL COMMENT '回帖id',
  `tg_title` varchar(30) NOT NULL COMMENT '帖子标题',
  `tg_type` varchar(255) DEFAULT NULL,
  `tg_content` text NOT NULL COMMENT '帖子内容',
  `tg_date` datetime NOT NULL COMMENT '发帖时间',
  `tg_username` varchar(30) NOT NULL COMMENT '发帖用户',
  `tg_ready` smallint(6) NOT NULL DEFAULT '0' COMMENT '帖子阅读量',
  `tg_comm` smallint(6) NOT NULL DEFAULT '0' COMMENT '评论数',
  `tg_last_modify` datetime DEFAULT NULL,
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tg_flowers
-- ----------------------------
DROP TABLE IF EXISTS `tg_flowers`;
CREATE TABLE `tg_flowers` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//id',
  `tg_touser` varchar(20) NOT NULL COMMENT '//收花者',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//送花者',
  `tg_flower` mediumint(10) NOT NULL COMMENT '//送花数目',
  `tg_content` varchar(200) NOT NULL COMMENT '//送花留言',
  `tg_date` datetime DEFAULT NULL COMMENT '//送花时间',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tg_friend
-- ----------------------------
DROP TABLE IF EXISTS `tg_friend`;
CREATE TABLE `tg_friend` (
  `tg_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) NOT NULL COMMENT '//被添加的好友',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//添加的人',
  `tg_content` text NOT NULL COMMENT '//请求内容',
  `tg_status` mediumint(1) NOT NULL DEFAULT '0' COMMENT '//状态',
  `tg_date` datetime NOT NULL COMMENT '//时间',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='//好友表';

-- ----------------------------
-- Table structure for tg_login_count
-- ----------------------------
DROP TABLE IF EXISTS `tg_login_count`;
CREATE TABLE `tg_login_count` (
  `tg_username` varchar(30) NOT NULL COMMENT '登陆记录//用户名',
  `tg_last_time` datetime DEFAULT NULL COMMENT '最后登陆的时间',
  `tg_last_ip` varchar(30) DEFAULT NULL COMMENT '登陆的ip',
  KEY `tg_username` (`tg_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tg_message
-- ----------------------------
DROP TABLE IF EXISTS `tg_message`;
CREATE TABLE `tg_message` (
  `tg_id` mediumint(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tg_touser` varchar(20) NOT NULL COMMENT '接收者',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '发送者',
  `tg_content` varchar(200) DEFAULT NULL COMMENT '内容',
  `tg_date` datetime NOT NULL COMMENT '发送时间',
  `tg_status` mediumint(1) unsigned zerofill NOT NULL COMMENT '状态/0未读，1已读',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tg_user
-- ----------------------------
DROP TABLE IF EXISTS `tg_user`;
CREATE TABLE `tg_user` (
  `tg_id` mediumint(8) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT '//用户自动编号',
  `tg_uniqid` char(40) NOT NULL COMMENT '//验证身份的唯一标识符',
  `tg_active` char(40) NOT NULL COMMENT '//激活登录用户',
  `tg_username` varchar(20) NOT NULL COMMENT '//用户名',
  `tg_password` char(40) NOT NULL COMMENT '//密码',
  `tg_question` varchar(20) NOT NULL COMMENT '//密码提示',
  `tg_answer` char(40) NOT NULL COMMENT '//密码回答',
  `tg_email` varchar(40) DEFAULT NULL COMMENT '//邮件',
  `tg_qq` varchar(10) DEFAULT NULL COMMENT '//QQ',
  `tg_url` varchar(40) DEFAULT NULL COMMENT '//网址',
  `tg_sex` char(1) NOT NULL COMMENT '//性别',
  `tg_face` char(12) NOT NULL COMMENT '//头像',
  `tg_level` tinyint(1) unsigned zerofill NOT NULL DEFAULT '0' COMMENT '会员等级',
  `tg_reg_time` datetime NOT NULL COMMENT '//注册时间',
  `tg_last_time` datetime NOT NULL COMMENT '//最后登录的时间',
  `tg_last_ip` varchar(20) NOT NULL COMMENT '//最后登录的IP',
  `tg_login_count` smallint(4) unsigned zerofill NOT NULL COMMENT '登陆次数',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1025 DEFAULT CHARSET=utf8 COMMENT='//用户表';
