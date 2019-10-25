/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : gaosu

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 25/10/2019 17:23:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sys_config
-- ----------------------------
DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE `sys_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置标志',
  `config_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置名称',
  `config_value` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置值',
  `units` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '单位',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序字段',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_config
-- ----------------------------
INSERT INTO `sys_config` VALUES (3, 'resertPassword', '重置密码默认', '12345678', '', 1, '用户管理中重置密码功能使用的默认密码', '2019-04-30 14:50:49', '2019-04-30 14:53:09');

-- ----------------------------
-- Table structure for sys_dict
-- ----------------------------
DROP TABLE IF EXISTS `sys_dict`;
CREATE TABLE `sys_dict`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dict_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '字典名称',
  `dict_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '字典标志',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序字段',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统字典表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_dict
-- ----------------------------
INSERT INTO `sys_dict` VALUES (1, '菜单类型', 'menuType', 1, '', NULL, '2019-04-15 17:36:00');
INSERT INTO `sys_dict` VALUES (19, '日志级别', 'logLevel', 2, '', '2019-04-19 10:04:33', '2019-04-19 10:04:56');
INSERT INTO `sys_dict` VALUES (20, '按钮类别', 'btnType', 3, '', '2019-04-19 10:05:29', '2019-04-19 10:05:29');
INSERT INTO `sys_dict` VALUES (21, '状态', 'status', 4, '', '2019-04-19 10:23:17', '2019-04-19 10:23:17');
INSERT INTO `sys_dict` VALUES (22, '按钮方法', 'btnFunc', 5, '', '2019-04-19 16:02:05', '2019-04-30 13:39:08');

-- ----------------------------
-- Table structure for sys_dict_value
-- ----------------------------
DROP TABLE IF EXISTS `sys_dict_value`;
CREATE TABLE `sys_dict_value`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dict_id` int(11) NOT NULL COMMENT '字典id',
  `val_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '字典参数名称',
  `val_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '字典参数标志',
  `val_color` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '字体颜色',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序字段',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统字典参数表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_dict_value
-- ----------------------------
INSERT INTO `sys_dict_value` VALUES (1, 1, '菜单', 'M', '', 1, '', NULL, '2019-04-15 17:36:47');
INSERT INTO `sys_dict_value` VALUES (2, 1, '按钮', 'B', '', 2, '', NULL, '2019-04-15 17:36:50');
INSERT INTO `sys_dict_value` VALUES (3, 1, '分栏', 'T', '', 3, '', NULL, '2019-04-15 17:36:53');
INSERT INTO `sys_dict_value` VALUES (4, 1, '接口', 'G', '', 4, '', NULL, '2019-04-15 17:37:02');
INSERT INTO `sys_dict_value` VALUES (5, 19, '不记日志', '0', '#ff8c00', 1, '', '2019-04-19 10:06:43', '2019-04-19 10:06:43');
INSERT INTO `sys_dict_value` VALUES (6, 19, '操作日志', '1', '#009688', 2, '', '2019-04-19 10:07:00', '2019-04-19 10:07:14');
INSERT INTO `sys_dict_value` VALUES (7, 20, '列表按钮', '1', '#ff5722', 1, '', '2019-04-19 10:25:07', '2019-04-19 10:25:07');
INSERT INTO `sys_dict_value` VALUES (8, 20, '操作按钮', '2', '#009688', 2, '', '2019-04-19 10:25:47', '2019-04-19 10:25:47');
INSERT INTO `sys_dict_value` VALUES (9, 21, '停用', '0', '#ff5722', 1, '', '2019-04-19 10:26:49', '2019-04-19 10:26:49');
INSERT INTO `sys_dict_value` VALUES (10, 21, '正常', '1', '#009688', 2, '', '2019-04-19 10:27:04', '2019-04-19 10:27:04');
INSERT INTO `sys_dict_value` VALUES (11, 22, '自定义', 'custom', '', 1, '', '2019-04-19 16:02:48', '2019-04-19 16:02:48');
INSERT INTO `sys_dict_value` VALUES (12, 22, '新增', 'add', '', 2, '', '2019-04-19 16:03:49', '2019-04-19 16:03:49');
INSERT INTO `sys_dict_value` VALUES (13, 22, '删除', 'del', '', 3, '', '2019-04-19 16:04:19', '2019-04-19 16:04:19');
INSERT INTO `sys_dict_value` VALUES (14, 22, '编辑', 'edit', '', 4, '', '2019-04-19 16:04:54', '2019-04-19 16:04:54');
INSERT INTO `sys_dict_value` VALUES (15, 22, '批量删除', 'delBatch', '', 6, '', '2019-04-19 16:07:47', '2019-04-19 16:09:31');
INSERT INTO `sys_dict_value` VALUES (16, 22, '查看', 'show', '', 5, '', '2019-04-19 16:09:49', '2019-04-19 16:09:49');

-- ----------------------------
-- Table structure for sys_log
-- ----------------------------
DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE `sys_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT 0 COMMENT '执行用户id',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名称',
  `operate_menu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作菜单',
  `operate_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '操作名称',
  `ip` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '执行行为者ip',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '执行的URL',
  `log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '日志备注',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统行为日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_log
-- ----------------------------
INSERT INTO `sys_log` VALUES (1, 1, '超级管理员', '菜单管理', '添加', '192.255.255.255', 'admin/menu/add', 'id:1', '2019-04-26 16:46:32');
INSERT INTO `sys_log` VALUES (2, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-28 14:09:01');
INSERT INTO `sys_log` VALUES (3, 2, '开发者', '系统退出', '退出', '::1', 'admin/index/logout', '', '2019-04-28 14:55:38');
INSERT INTO `sys_log` VALUES (4, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-28 14:55:51');
INSERT INTO `sys_log` VALUES (5, 2, '开发者', '系统退出', '退出', '::1', 'admin/index/logout', '', '2019-04-28 15:02:32');
INSERT INTO `sys_log` VALUES (6, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-28 15:02:44');
INSERT INTO `sys_log` VALUES (7, 2, '开发者', '系统退出', '退出', '::1', 'admin/index/logout', '', '2019-04-28 15:04:00');
INSERT INTO `sys_log` VALUES (8, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-28 15:04:07');
INSERT INTO `sys_log` VALUES (9, 2, '开发者', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-28 16:56:31');
INSERT INTO `sys_log` VALUES (10, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-28 17:31:29');
INSERT INTO `sys_log` VALUES (11, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 08:53:42');
INSERT INTO `sys_log` VALUES (12, 2, '开发者', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 10:31:00');
INSERT INTO `sys_log` VALUES (13, 3, '测试用户', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 10:34:09');
INSERT INTO `sys_log` VALUES (14, 3, '测试用户', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 11:04:54');
INSERT INTO `sys_log` VALUES (15, 3, '测试用户', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 11:05:13');
INSERT INTO `sys_log` VALUES (16, 3, '测试用户', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 11:23:41');
INSERT INTO `sys_log` VALUES (17, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 11:23:53');
INSERT INTO `sys_log` VALUES (18, 1, '超管', '配置管理', '新增', '::1', 'admin/config/add', '', '2019-04-30 11:50:55');
INSERT INTO `sys_log` VALUES (19, 1, '超管', '配置管理', '新增', '::1', 'admin/config/add', 'config_code:{$param[\'config_code\']},config_name:{$param[\'config_name\']}', '2019-04-30 11:51:32');
INSERT INTO `sys_log` VALUES (20, 1, '超管', '配置管理', '新增', '::1', 'admin/config/add', '', '2019-04-30 11:53:49');
INSERT INTO `sys_log` VALUES (21, 1, '超管', '配置管理', '新增', '::1', 'admin/config/add', 'config_code:configTimes,config_name:配置次数', '2019-04-30 11:59:15');
INSERT INTO `sys_log` VALUES (22, 1, '超管', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 12:01:17');
INSERT INTO `sys_log` VALUES (23, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 12:01:23');
INSERT INTO `sys_log` VALUES (24, 2, '开发者', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 13:44:18');
INSERT INTO `sys_log` VALUES (25, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 13:45:59');
INSERT INTO `sys_log` VALUES (26, 1, '超管', '配置管理', '新增', '::1', 'admin/config/add', '', '2019-04-30 14:49:43');
INSERT INTO `sys_log` VALUES (27, 1, '超管', '配置管理', '新增', '::1', 'admin/config/add', 'config_code:resertPassword,config_name:重置密码默认', '2019-04-30 14:50:49');
INSERT INTO `sys_log` VALUES (28, 1, '超管', '配置管理', '编辑', '::1', 'admin/config/edit/id/3', '', '2019-04-30 14:50:54');
INSERT INTO `sys_log` VALUES (29, 1, '超管', '配置管理', '编辑', '::1', 'admin/config/edit/id/3', '', '2019-04-30 14:51:07');
INSERT INTO `sys_log` VALUES (30, 1, '超管', '配置管理', '编辑', '::1', 'admin/config/edit', 'id:3', '2019-04-30 14:51:10');
INSERT INTO `sys_log` VALUES (31, 1, '超管', '配置管理', '编辑', '::1', 'admin/config/edit/id/3', '', '2019-04-30 14:52:10');
INSERT INTO `sys_log` VALUES (32, 1, '超管', '配置管理', '编辑', '::1', 'admin/config/edit', 'id:3', '2019-04-30 14:53:09');
INSERT INTO `sys_log` VALUES (33, 1, '超管', '配置管理', '删除', '::1', 'admin/config/del', 'id:2', '2019-04-30 14:55:31');
INSERT INTO `sys_log` VALUES (34, 1, '超管', '配置管理', '删除', '::1', 'admin/config/del', 'id:1', '2019-04-30 14:55:35');
INSERT INTO `sys_log` VALUES (35, 1, '超管', '用户管理', '重置密码', '::1', 'admin/user/resetPassword', 'id:2', '2019-04-30 14:56:42');
INSERT INTO `sys_log` VALUES (36, 1, '超管', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 14:56:44');
INSERT INTO `sys_log` VALUES (37, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 14:56:52');
INSERT INTO `sys_log` VALUES (38, 2, '开发者', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 14:56:56');
INSERT INTO `sys_log` VALUES (39, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 14:57:07');
INSERT INTO `sys_log` VALUES (40, 1, '超管', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 15:25:17');
INSERT INTO `sys_log` VALUES (41, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 15:25:35');
INSERT INTO `sys_log` VALUES (42, 1, '超管', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 15:50:47');
INSERT INTO `sys_log` VALUES (43, 2, '开发者', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 15:50:55');
INSERT INTO `sys_log` VALUES (44, 2, '开发者', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-04-30 15:51:02');
INSERT INTO `sys_log` VALUES (45, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-04-30 15:51:09');
INSERT INTO `sys_log` VALUES (46, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-05-23 15:39:42');
INSERT INTO `sys_log` VALUES (47, 1, '超管', '系统登录', '登录', '127.0.0.1', 'admin/index/login', '', '2019-05-23 15:40:07');
INSERT INTO `sys_log` VALUES (48, 1, '超管', '系统登录', '登录', '127.0.0.1', 'admin/index/login', '', '2019-05-29 18:10:19');
INSERT INTO `sys_log` VALUES (49, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-10-08 11:39:09');
INSERT INTO `sys_log` VALUES (50, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-10-25 17:00:44');

-- ----------------------------
-- Table structure for sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `sys_menu`;
CREATE TABLE `sys_menu`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级ID',
  `menu_url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单url',
  `menu_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单名称',
  `menu_icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单图标',
  `menu_type` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '菜单类型  M:菜单 B:按钮 G:接口 T:分栏',
  `btn_css` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '按钮样式',
  `btn_func` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '按钮方法',
  `btn_type` tinyint(1) NULL DEFAULT NULL COMMENT '按钮类型：1:列表按钮 2:操作按钮',
  `log_level` tinyint(1) NOT NULL DEFAULT 0 COMMENT '日志等级 1:纪录日志 0:不记日志',
  `log_rule` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '日志规则',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序ID',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态，1启用，0停用',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_menu
-- ----------------------------
INSERT INTO `sys_menu` VALUES (1, 0, '', '系统管理', '<i class=\'layui-icon layui-icon-app\'></i>  ', 'M', '', '', NULL, 0, '', 1000, '', 1);
INSERT INTO `sys_menu` VALUES (2, 1, 'admin/menu/index', '菜单管理', '<i class=\'layui-icon layui-icon-tabs\'></i>', 'M', '', '', NULL, 0, '', 1100, '', 1);
INSERT INTO `sys_menu` VALUES (4, 0, '', '业务管理', '', 'M', '', '', NULL, 0, '', 2000, '', 1);
INSERT INTO `sys_menu` VALUES (5, 4, '', '测试菜单', '', 'M', '', '', NULL, 0, '', 2100, '', 1);
INSERT INTO `sys_menu` VALUES (6, 2, 'admin/menu/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1101, '', 1);
INSERT INTO `sys_menu` VALUES (7, 1, 'admin/dict/index', '字典管理', '<i class=\'layui-icon layui-icon-read\'></i>', 'M', '', '', NULL, 0, '', 1200, '', 1);
INSERT INTO `sys_menu` VALUES (8, 9, 'admin/dictvalue/index', '字典参数', '<i class=\'layui-icon layui-icon-list\'></i>', 'B', '', 'showValue', 2, 0, '', 1219, '', 1);
INSERT INTO `sys_menu` VALUES (9, 7, 'admin/dict/index', '字典管理', '', 'T', '', '', NULL, 0, '', 1210, '', 1);
INSERT INTO `sys_menu` VALUES (10, 7, 'admin/dictvalue/index', '字典参数', '', 'T', '', '', NULL, 0, '', 1220, '', 1);
INSERT INTO `sys_menu` VALUES (11, 9, 'admin/dict/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1212, '', 1);
INSERT INTO `sys_menu` VALUES (12, 9, 'admin/dict/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, '', 1211, '', 1);
INSERT INTO `sys_menu` VALUES (13, 10, 'admin/dictvalue/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1221, '', 1);
INSERT INTO `sys_menu` VALUES (14, 10, 'admin/dictvalue/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, '', 1221, '', 1);
INSERT INTO `sys_menu` VALUES (15, 10, 'admin/dictvalue/delBatch', '批量删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'delBatch', 1, 0, '', 1229, '', 1);
INSERT INTO `sys_menu` VALUES (16, 10, 'admin/dictvalue/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 1228, '', 1);
INSERT INTO `sys_menu` VALUES (17, 9, 'admin/dict/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 1218, '', 1);
INSERT INTO `sys_menu` VALUES (18, 2, 'admin/menu/add', '添加下级', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '#5fb878', 'addDown', 2, 0, '', 1109, '', 1);
INSERT INTO `sys_menu` VALUES (19, 2, 'admin/menu/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 1108, '', 1);
INSERT INTO `sys_menu` VALUES (20, 2, 'admin/menu/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, '', 1100, '', 1);
INSERT INTO `sys_menu` VALUES (21, 1, 'admin/role/index', '角色管理', '<i class=\'layui-icon layui-icon-group\'></i>', 'M', '', '', 1, 0, '', 1300, '', 1);
INSERT INTO `sys_menu` VALUES (22, 21, 'admin/role/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 1, 'id:{id}', 1301, '', 1);
INSERT INTO `sys_menu` VALUES (24, 21, 'admin/role/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1301, '', 1);
INSERT INTO `sys_menu` VALUES (25, 21, 'admin/role/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 1302, '', 1);
INSERT INTO `sys_menu` VALUES (26, 21, 'admin/role/auth', '权限', '<i class=\'layui-icon layui-icon-link\'></i>', 'B', '#5fb878', 'auth', 2, 0, 'id:{id}', 1309, '', 1);
INSERT INTO `sys_menu` VALUES (27, 1, 'admin/user/index', '用户管理', '<i class=\'layui-icon layui-icon-user\'></i>', 'M', '', '', 1, 0, '', 1400, '', 1);
INSERT INTO `sys_menu` VALUES (28, 27, 'admin/user/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 1, 'id:{id}', 1401, '', 1);
INSERT INTO `sys_menu` VALUES (29, 27, 'admin/user/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1402, '', 1);
INSERT INTO `sys_menu` VALUES (30, 27, 'admin/user/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 1401, '', 1);
INSERT INTO `sys_menu` VALUES (31, 27, 'admin/user/resetPassword', '重置密码', '<i class=\'layui-icon layui-icon-refresh\'></i>', 'B', '#5fb878', 'resetPassword', 2, 1, 'id:{id}', 1409, '默认重置密码后为123456', 1);
INSERT INTO `sys_menu` VALUES (32, 1, 'admin/config/index', '配置管理', '<i class=\'layui-icon layui-icon-set-sm\'></i>', 'M', '', '', 1, 0, '', 1500, '', 1);
INSERT INTO `sys_menu` VALUES (33, 32, 'admin/config/add', '新增', '<i class=\'layui-icon layui-icon-add-circle\'></i>', 'B', '', 'add', 1, 1, 'config_code:{config_code},config_name:{config_name}', 1501, '', 1);
INSERT INTO `sys_menu` VALUES (34, 32, 'admin/config/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 1, 'id:{id}', 1501, '', 1);
INSERT INTO `sys_menu` VALUES (35, 32, 'admin/config/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 1, 'id:{id}', 1509, '', 1);
INSERT INTO `sys_menu` VALUES (36, 1, 'admin/log/index', '日志管理', '<i class=\'layui-icon layui-icon-file-b\'></i>', 'M', '', '', 1, 0, '', 1600, '', 1);
INSERT INTO `sys_menu` VALUES (37, 32, 'admin/config/clearCache', '清除缓存', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#ff5722', 'clearCache', 1, 1, '', 1502, '', 1);

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '角色名称',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '状态',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序字段',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '操作时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES (1, '超级管理员', 1, '超级管理员享有所有权限', 0, '2019-04-22 11:18:07', '2019-04-22 11:18:07');
INSERT INTO `sys_role` VALUES (2, '部门经理', 0, '', 1, '2019-04-22 11:19:18', '2019-04-30 15:49:21');

-- ----------------------------
-- Table structure for sys_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `sys_role_menu`;
CREATE TABLE `sys_role_menu`  (
  `role_id` int(11) UNSIGNED NOT NULL COMMENT '角色id',
  `menu_id` smallint(6) NOT NULL COMMENT '菜单id',
  INDEX `role_id`(`role_id`) USING BTREE,
  INDEX `menu_id`(`menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统角色菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_role_menu
-- ----------------------------
INSERT INTO `sys_role_menu` VALUES (2, 1);
INSERT INTO `sys_role_menu` VALUES (2, 7);
INSERT INTO `sys_role_menu` VALUES (2, 9);
INSERT INTO `sys_role_menu` VALUES (2, 8);
INSERT INTO `sys_role_menu` VALUES (2, 11);
INSERT INTO `sys_role_menu` VALUES (2, 12);
INSERT INTO `sys_role_menu` VALUES (2, 17);
INSERT INTO `sys_role_menu` VALUES (2, 10);
INSERT INTO `sys_role_menu` VALUES (2, 13);
INSERT INTO `sys_role_menu` VALUES (2, 14);
INSERT INTO `sys_role_menu` VALUES (2, 15);
INSERT INTO `sys_role_menu` VALUES (2, 16);
INSERT INTO `sys_role_menu` VALUES (2, 27);
INSERT INTO `sys_role_menu` VALUES (2, 28);
INSERT INTO `sys_role_menu` VALUES (2, 29);
INSERT INTO `sys_role_menu` VALUES (2, 30);
INSERT INTO `sys_role_menu` VALUES (2, 31);
INSERT INTO `sys_role_menu` VALUES (2, 32);
INSERT INTO `sys_role_menu` VALUES (2, 37);

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '管理员的密码',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '管理员的简称',
  `status` int(11) NULL DEFAULT 1 COMMENT '用户状态 0:禁用 1:正常',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '管理员手机',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `last_login_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime(0) NULL DEFAULT NULL COMMENT '最后登录时间',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES (1, 'admin', '14e1b600b1fd579f47433b88e8d85291', '超管', 1, '19156017290', '', NULL, NULL, NULL, '2019-04-30 14:48:19', NULL);
INSERT INTO `sys_user` VALUES (2, 'lil', '550e1bafe077ff0b0b67f4e32f29d751', '开发者', 1, '18212324221', '', NULL, NULL, NULL, '2019-04-30 14:56:42', NULL);
INSERT INTO `sys_user` VALUES (3, 'dev', '14e1b600b1fd579f47433b88e8d85291', '测试用户', 0, '13585788049', '', NULL, NULL, '2019-04-25 17:50:42', '2019-04-25 18:39:12', NULL);
INSERT INTO `sys_user` VALUES (4, 'demo', '14e1b600b1fd579f47433b88e8d85291', 'demo', 1, '1231', '', NULL, NULL, '2019-04-25 17:51:48', '2019-04-25 17:54:57', '2019-04-25 17:54:57');

-- ----------------------------
-- Table structure for sys_user_config
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_config`;
CREATE TABLE `sys_user_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `top_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'rgb(57, 61, 73)' COMMENT '顶部色彩',
  `left_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'rgb(57, 61, 73)' COMMENT '左侧色彩',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统个人配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user_config
-- ----------------------------
INSERT INTO `sys_user_config` VALUES (1, 1, 'rgb(57, 61, 73)', 'rgb(57, 61, 73)');

-- ----------------------------
-- Table structure for sys_user_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_role`;
CREATE TABLE `sys_user_role`  (
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `role_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '角色 id',
  INDEX `role_id`(`role_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统用户角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user_role
-- ----------------------------
INSERT INTO `sys_user_role` VALUES (1, 1);
INSERT INTO `sys_user_role` VALUES (2, 2);

SET FOREIGN_KEY_CHECKS = 1;
