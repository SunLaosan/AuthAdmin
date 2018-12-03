/*
Navicat MySQL Data Transfer

Source Server         : Linux
Source Server Version : 50556
Source Host           : 116.62.116.179:3306
Source Database       : cms

Target Server Type    : MYSQL
Target Server Version : 50556
File Encoding         : 65001

Date: 2018-12-03 10:15:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `fred_admin`
-- ----------------------------
DROP TABLE IF EXISTS `fred_admin`;
CREATE TABLE `fred_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(255) NOT NULL COMMENT '管理员姓名',
  `admin_pwd` varchar(255) NOT NULL COMMENT '管理员密码',
  `admin_lasttime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '登录时间',
  `admin_ip` varchar(255) NOT NULL COMMENT '登录IP',
  `admin_ctime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `admin_status` tinyint(1) DEFAULT '1' COMMENT '账号状态0.封禁1.正常',
  `admin_times` int(9) DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fred_admin
-- ----------------------------
INSERT INTO `fred_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2018-11-30 14:30:07', '61.175.197.194', '2018-03-22 16:32:18', '1', '31');
INSERT INTO `fred_admin` VALUES ('3', '苦力怕', '21232f297a57a5a743894a0e4a801fc3', '2018-03-30 10:39:06', '61.175.197.194', '2018-03-30 10:33:12', '0', '0');

-- ----------------------------
-- Table structure for `fred_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `fred_auth_group`;
CREATE TABLE `fred_auth_group` (
  `group_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_title` char(100) NOT NULL DEFAULT '',
  `group_status` tinyint(1) NOT NULL DEFAULT '1',
  `group_rules` text NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fred_auth_group
-- ----------------------------
INSERT INTO `fred_auth_group` VALUES ('1', '超级管理员', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31');
INSERT INTO `fred_auth_group` VALUES ('2', '运营者', '1', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24');
INSERT INTO `fred_auth_group` VALUES ('3', '文员', '1', '14,15');

-- ----------------------------
-- Table structure for `fred_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `fred_auth_group_access`;
CREATE TABLE `fred_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fred_auth_group_access
-- ----------------------------
INSERT INTO `fred_auth_group_access` VALUES ('1', '1');
INSERT INTO `fred_auth_group_access` VALUES ('2', '2');
INSERT INTO `fred_auth_group_access` VALUES ('3', '2');

-- ----------------------------
-- Table structure for `fred_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `fred_auth_rule`;
CREATE TABLE `fred_auth_rule` (
  `rule_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `rule_url` varchar(80) NOT NULL DEFAULT '',
  `rule_title` varchar(20) NOT NULL DEFAULT '',
  `rule_type` tinyint(1) NOT NULL DEFAULT '1',
  `rule_status` tinyint(1) NOT NULL DEFAULT '1',
  `rule_condition` char(100) NOT NULL DEFAULT '',
  `rule_sort` int(3) DEFAULT NULL COMMENT '排序',
  `rule_pid` int(4) DEFAULT NULL,
  `rule_icon` varchar(15) DEFAULT NULL,
  `rule_isshow` tinyint(1) DEFAULT '1' COMMENT '是否显示在列表中0/1',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fred_auth_rule
-- ----------------------------
INSERT INTO `fred_auth_rule` VALUES ('1', '', '管理员', '1', '1', '', '2', '0', '&#xe62d;', '1');
INSERT INTO `fred_auth_rule` VALUES ('2', 'admin/admin/adminshow', '管理员列表', '1', '1', '', '2', '1', null, '1');
INSERT INTO `fred_auth_rule` VALUES ('3', 'admin/admin/adminadd', '添加管理员', '1', '1', '', '1', '1', null, '1');
INSERT INTO `fred_auth_rule` VALUES ('4', 'admin/admin/adminupdate', '修改管理员', '1', '1', '', null, '1', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('5', 'admin/admin/admindelete', '删除管理员', '1', '1', '', null, '1', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('6', '', '基本配置', '1', '1', '', '1', '0', '&#xe62e;', '1');
INSERT INTO `fred_auth_rule` VALUES ('7', 'admin/basic/index', '基本配置', '1', '1', '', '1', '6', '', '1');
INSERT INTO `fred_auth_rule` VALUES ('8', 'admin/basic/save', '修改基本配置', '1', '1', '', '0', '6', '', '0');
INSERT INTO `fred_auth_rule` VALUES ('14', 'admin/index/index', '首页', '1', '1', '', null, '0', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('9', '', '权限', '1', '1', '', '999', '0', '&#xe63c;', '1');
INSERT INTO `fred_auth_rule` VALUES ('10', 'admin/role/rolegroup', '权限组', '1', '1', '', '1', '9', null, '1');
INSERT INTO `fred_auth_rule` VALUES ('11', 'admin/role/rolenode', '权限设置', '1', '1', '', '2', '9', '', '1');
INSERT INTO `fred_auth_rule` VALUES ('12', 'admin/role/rolerule', '权限规则', '1', '1', '', '3', '9', null, '1');
INSERT INTO `fred_auth_rule` VALUES ('13', 'admin/role/groupadd', '权限组添加', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('15', 'admin/index/welcome', '欢迎页', '1', '1', '', null, '0', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('16', 'admin/role/groupadddo', '权限组添加处理', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('18', 'admin/role/nodeupdate', '权限修改', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('19', 'admin/role/nodeupdatedo', '权限修改处理', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('20', 'admin/role/ruledelete', '删除规则', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('21', 'admin/role/ruleupdate', '修改规则', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('22', 'admin/role/ruleupdatedo', '修改规则处理', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('23', 'admin/role/ruleadd', '添加规则', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('24', 'admin/role/ruleadddo', '添加规则处理', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('25', 'admin/admin/adminadddo', '添加管理员处理', '1', '1', '', null, '1', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('26', 'admin/admin/adminupdatedo', '修改管理员处理', '1', '1', '', null, '1', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('27', 'admin/role/roleaccess', '权限分配', '1', '1', '', '4', '9', '', '1');
INSERT INTO `fred_auth_rule` VALUES ('28', 'admin/role/accessupdate', '权限分配展示', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('29', 'admin/role/accessupdatedo', '权限分配处理', '1', '1', '', null, '9', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('30', 'admin/base/fileupload', '文件上传', '1', '1', '', null, '0', null, '0');
INSERT INTO `fred_auth_rule` VALUES ('31', 'admin/index/fileupload', '文件爱你上传1', '1', '1', '', null, '0', null, '0');

-- ----------------------------
-- Table structure for `fred_config`
-- ----------------------------
DROP TABLE IF EXISTS `fred_config`;
CREATE TABLE `fred_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_webname` varchar(50) DEFAULT '' COMMENT '网站名称',
  `config_ico` varchar(50) DEFAULT '' COMMENT 'icon图标地址',
  `config_phone` varchar(11) DEFAULT '' COMMENT '电话',
  `config_email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `config_address` varchar(255) DEFAULT '' COMMENT '地址',
  `config_icp` varchar(25) DEFAULT '' COMMENT 'ICP备案号',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fred_config
-- ----------------------------
INSERT INTO `fred_config` VALUES ('1', 'FRED-CMS', '', '', '', '', '');

-- ----------------------------
-- Table structure for `fred_log`
-- ----------------------------
DROP TABLE IF EXISTS `fred_log`;
CREATE TABLE `fred_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) DEFAULT NULL,
  `log_ip` varchar(255) DEFAULT NULL,
  `log_content` varchar(255) DEFAULT NULL,
  `log_remarks` varchar(255) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of fred_log
-- ----------------------------
INSERT INTO `fred_log` VALUES ('1', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:01:43');
INSERT INTO `fred_log` VALUES ('2', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:01:53');
INSERT INTO `fred_log` VALUES ('3', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:08:02');
INSERT INTO `fred_log` VALUES ('4', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:08:14');
INSERT INTO `fred_log` VALUES ('5', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:26:19');
INSERT INTO `fred_log` VALUES ('6', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:26:23');
INSERT INTO `fred_log` VALUES ('7', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:29:11');
INSERT INTO `fred_log` VALUES ('8', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:29:14');
INSERT INTO `fred_log` VALUES ('9', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:35:27');
INSERT INTO `fred_log` VALUES ('10', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:35:31');
INSERT INTO `fred_log` VALUES ('11', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:36:08');
INSERT INTO `fred_log` VALUES ('12', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:36:17');
INSERT INTO `fred_log` VALUES ('13', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:36:24');
INSERT INTO `fred_log` VALUES ('14', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:44:50');
INSERT INTO `fred_log` VALUES ('15', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:44:58');
INSERT INTO `fred_log` VALUES ('16', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:45:01');
INSERT INTO `fred_log` VALUES ('17', 'admin', '61.175.197.194', '登陆失败', '使用账号:密码:', '2018-07-25 11:46:10');
INSERT INTO `fred_log` VALUES ('18', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-25 11:46:22');
INSERT INTO `fred_log` VALUES ('19', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-26 09:51:32');
INSERT INTO `fred_log` VALUES ('20', 'admin', '61.175.197.194', '删除管理员成功', '管理员ID:3', '2018-07-26 11:49:14');
INSERT INTO `fred_log` VALUES ('21', 'admin', '127.0.0.1', '登陆成功', '无', '2018-07-26 14:41:19');
INSERT INTO `fred_log` VALUES ('22', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-26 15:35:29');
INSERT INTO `fred_log` VALUES ('23', 'admin', '127.0.0.1', '登陆成功', '无', '2018-07-26 16:17:41');
INSERT INTO `fred_log` VALUES ('24', 'admin', '127.0.0.1', '登陆成功', '无', '2018-07-26 16:18:18');
INSERT INTO `fred_log` VALUES ('25', 'admin', '61.175.197.194', '登陆成功', '无', '2018-07-26 16:33:28');
INSERT INTO `fred_log` VALUES ('26', 'admin', '61.175.197.194', '登陆成功', '无', '2018-08-13 10:12:02');
INSERT INTO `fred_log` VALUES ('27', 'admin', '61.175.197.194', '登陆成功', '无', '2018-08-13 10:26:08');
INSERT INTO `fred_log` VALUES ('28', 'admin', '61.175.197.194', '登陆成功', '无', '2018-10-08 10:26:05');
INSERT INTO `fred_log` VALUES ('29', '未知用户', '61.175.197.194', '登陆失败', '使用账号:admin密码:123456', '2018-11-30 14:29:59');
INSERT INTO `fred_log` VALUES ('30', 'admin', '61.175.197.194', '登陆成功', '无', '2018-11-30 14:30:07');
