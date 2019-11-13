/*
 Navicat Premium Data Transfer

 Source Server         : 本地数据库
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : wkmp

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 13/11/2019 18:09:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pin_site_banner
-- ----------------------------
DROP TABLE IF EXISTS `pin_site_banner`;
CREATE TABLE `pin_site_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `img` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片地址',
  `url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '链接地址',
  `position_id` int(11) NOT NULL COMMENT '位置',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态，0关闭1正常',
  `sort` int(11) NOT NULL COMMENT '排序，升序',
  `create_time` datetime(0) NOT NULL COMMENT '插入时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品banner表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_site_banner_position
-- ----------------------------
DROP TABLE IF EXISTS `pin_site_banner_position`;
CREATE TABLE `pin_site_banner_position`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `position_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `remark` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注说明',
  `sort` int(11) NOT NULL COMMENT '排序，升序',
  `create_time` datetime(0) NOT NULL COMMENT '插入时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品banner位置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_site_express
-- ----------------------------
DROP TABLE IF EXISTS `pin_site_express`;
CREATE TABLE `pin_site_express`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `express` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递名称',
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递编号',
  `kdn_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递鸟快递编号',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递号码',
  `icon` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递LOGO',
  `create_time` datetime(0) NOT NULL COMMENT '插入时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '快递公司信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pin_site_express
-- ----------------------------
INSERT INTO `pin_site_express` VALUES (1, '顺丰快递', 'sf', 'SF', '95338', '/images/express/shunfeng.jpeg', '2017-03-22 00:00:00', '2017-11-24 02:46:41');
INSERT INTO `pin_site_express` VALUES (11, '韵达快递', 'yd', 'YD', '96645', '', '2017-03-23 00:00:00', '2018-04-27 23:52:10');
INSERT INTO `pin_site_express` VALUES (3, '申通快递', 'sto', 'STO', '95543', '', '2017-04-22 00:00:00', '2017-11-24 02:47:47');
INSERT INTO `pin_site_express` VALUES (4, '圆通快递', 'yt', 'YTO', '95554', '', '2017-04-22 00:00:00', '2017-11-24 02:48:03');
INSERT INTO `pin_site_express` VALUES (5, '天天快递', 'tt', 'HHTT', '400-188-8888', '', '2017-04-22 00:00:00', '2017-11-24 02:48:15');
INSERT INTO `pin_site_express` VALUES (6, '中通快递', 'zto', 'ZTO', '95311', '', '2017-04-22 00:00:00', '2017-11-24 02:48:59');
INSERT INTO `pin_site_express` VALUES (7, '汇通快递', 'ht', 'HTKY', '95320', '', '2017-04-22 00:00:00', '2017-11-24 02:47:05');
INSERT INTO `pin_site_express` VALUES (8, '国通快递', 'gt', 'GTO', '400-111-1123', '', '2017-04-22 00:00:00', '2017-11-24 19:56:29');
INSERT INTO `pin_site_express` VALUES (9, '中国邮政', 'zgyz', 'YZPY', '11183', '', '0000-00-00 00:00:00', '2017-11-24 19:56:33');
INSERT INTO `pin_site_express` VALUES (2, '京东快递', 'jd', 'JD', '950616', '', '2017-03-22 00:00:00', '2018-04-28 00:01:41');

-- ----------------------------
-- Table structure for pin_site_info
-- ----------------------------
DROP TABLE IF EXISTS `pin_site_info`;
CREATE TABLE `pin_site_info`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '主标题',
  `sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '副标题',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '简介',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '主图',
  `fir_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第一张图',
  `fir_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第一张图名称',
  `fir_name_eng` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第一张图英文',
  `sec_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第二张图',
  `sec_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第二张图名称',
  `sec_name_eng` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第二张图英文',
  `thr_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第三张图',
  `thr_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第三张图名称',
  `thr_name_eng` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '第三张图英文',
  `kf_head_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '客服头像',
  `kf_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '客服名称',
  `kf_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '客服手机',
  `kf_qr_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '客服二维码',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '店家信息' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pin_site_info
-- ----------------------------
INSERT INTO `pin_site_info` VALUES (1, '生活的多种味道， 名品汇来寻找', '带来不经意的生活品味，提升美好生活品质', '名品汇创立于2019年，致力于名品销售，我们一直寻找城市合伙人，打造共赢社区，发展新式B2C电子商务', '/images/shop/20191113\\fbd5c5f7f574b5f2002efedc73d9f478.png', '/images/info/20191113\\c2e0527864697a325a69d45ed3f932cf.png', '办公室', 'OFFICE', '/images/info/20191113\\5facc50925ad48df1856f8ceb5d00c69.png', '会议室', 'CONFERENCE ROOM', '/images/info/20191113\\7c5f31ab3650bf08ae422287a705005a.png', '工作区', 'WORK AREA', '/images/info/20191113\\35ebe2fa227c0a24ea82eb2ed03928ef.jpg', '库空名品', '13892831212', '/images/info/20191113\\9f4e7d98c04e2968226fde0589a82e95.png', '2019-11-13 11:32:58', '2019-11-13 11:31:04');

-- ----------------------------
-- Table structure for pin_site_search_hot
-- ----------------------------
DROP TABLE IF EXISTS `pin_site_search_hot`;
CREATE TABLE `pin_site_search_hot`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '关键词',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序ID',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品热门搜索表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pin_site_search_hot
-- ----------------------------
INSERT INTO `pin_site_search_hot` VALUES (1, '古井5年', 0, '2019-11-13 13:33:33', '2019-11-13 13:33:33');

-- ----------------------------
-- Table structure for pin_site_shop
-- ----------------------------
DROP TABLE IF EXISTS `pin_site_shop`;
CREATE TABLE `pin_site_shop`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '封面图片',
  `shop_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商家名称',
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系方式',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '商家地址',
  `sort` int(11) NULL DEFAULT 0 COMMENT '排序',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品商家表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_user
-- ----------------------------
DROP TABLE IF EXISTS `pin_user`;
CREATE TABLE `pin_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '会员姓名',
  `parent_id` int(11) NULL DEFAULT 0 COMMENT '父级id',
  `phone` int(11) NOT NULL COMMENT '联系方式',
  `openid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'openid',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '微信昵称',
  `headimgurl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '微信头像',
  `balance` int(11) NULL DEFAULT 0 COMMENT '余额',
  `total_profit` int(11) NULL DEFAULT 0 COMMENT '总收益',
  `level` tinyint(3) NULL DEFAULT 0 COMMENT '会员等级：0普通会员 1vip会员 2推广顾问 3高级顾问',
  `total_sale_user` int(11) NULL DEFAULT 0 COMMENT '个人销售总额',
  `total_sale_team` int(11) NULL DEFAULT 0 COMMENT '团队销售总额（包括自己）',
  `xl_sale_user` int(11) NULL DEFAULT 0 COMMENT '个人系列酒销售总额',
  `xl_sale_team` int(11) NULL DEFAULT 0 COMMENT '团队系列酒销售总额（包括自己）',
  `total_person_num` int(11) NULL DEFAULT 1 COMMENT '团队总人数（包括自己）',
  `vip_team_num` int(11) NULL DEFAULT 0 COMMENT 'vip团队数',
  `tg_team_num` int(11) NULL DEFAULT 0 COMMENT '推广团队数',
  `gj_team_num` int(11) NULL DEFAULT 0 COMMENT '高级团队数',
  `is_back` tinyint(3) NULL DEFAULT 0 COMMENT '作为团队是否满销售额返现:0未返现 1已返现',
  `status` int(11) NULL DEFAULT 1 COMMENT '用户状态 0:禁用 1:正常',
  `last_login_time` datetime(0) NULL DEFAULT NULL COMMENT '最近登录时间',
  `join_time` datetime(0) NULL DEFAULT NULL COMMENT '入团时间',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_user_address
-- ----------------------------
DROP TABLE IF EXISTS `pin_user_address`;
CREATE TABLE `pin_user_address`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `contact_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系人',
  `contact_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系方式',
  `address` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系地址',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品用户地址表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_user_gift_order
-- ----------------------------
DROP TABLE IF EXISTS `pin_user_gift_order`;
CREATE TABLE `pin_user_gift_order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `from_id` int(11) NULL DEFAULT 0 COMMENT '父级用户id',
  `status` tinyint(3) NULL DEFAULT 0 COMMENT '订单状态 0:待支付 1:已支付 2已取消',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '会员姓名',
  `phone` int(11) NOT NULL COMMENT '联系方式',
  `type` tinyint(3) NULL DEFAULT 1 COMMENT '礼包品种：1： 2： 3：',
  `transaction_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '微信支付订单号',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `from_id`(`from_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品礼包订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_user_profit
-- ----------------------------
DROP TABLE IF EXISTS `pin_user_profit`;
CREATE TABLE `pin_user_profit`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `from_id` int(11) NULL DEFAULT 0 COMMENT '奖励来源用户id',
  `type` tinyint(3) NULL DEFAULT 1 COMMENT '会员等级：1礼包奖励 2销售额奖励 3流通酒奖励',
  `money` int(11) NULL DEFAULT 0 COMMENT '奖励金额',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `from_id`(`from_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品用户奖励表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_user_search
-- ----------------------------
DROP TABLE IF EXISTS `pin_user_search`;
CREATE TABLE `pin_user_search`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '关键词',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品个人搜索表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_user_take
-- ----------------------------
DROP TABLE IF EXISTS `pin_user_take`;
CREATE TABLE `pin_user_take`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `money` int(11) NULL DEFAULT 0 COMMENT '提现金额',
  `handle_fee` int(11) NULL DEFAULT 0 COMMENT '手续费',
  `status` tinyint(3) NULL DEFAULT 1 COMMENT '提现状态：0提交待审核 1提现成功 2审核失败',
  `transaction_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '微信支付订单号',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '名品用户提现表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_wine
-- ----------------------------
DROP TABLE IF EXISTS `pin_wine`;
CREATE TABLE `pin_wine`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wine_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '酒品名称',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '酒品封面',
  `wine_style` tinyint(3) NULL DEFAULT 0 COMMENT 'wineStyle 系列:1流通酒 2系列酒',
  `wine_cate` tinyint(3) NULL DEFAULT 0 COMMENT 'wineCate 大分类:1白酒 2红酒 3啤酒 4洋酒',
  `brand_id` tinyint(3) NULL DEFAULT 0 COMMENT '品牌id',
  `wine_size` tinyint(3) NULL DEFAULT 0 COMMENT 'wineSize 规格:字典',
  `mall_price` int(11) NULL DEFAULT 0 COMMENT '市场价',
  `vip_price` int(11) NULL DEFAULT 0 COMMENT '会员价',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序ID',
  `status` tinyint(3) NULL DEFAULT 1 COMMENT 'upDown 上下架 0:下架 1:上架',
  `is_recommend` tinyint(3) NULL DEFAULT 0 COMMENT 'isTrue 首页推荐：0否 1是',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pin_wine
-- ----------------------------
INSERT INTO `pin_wine` VALUES (1, '五粮液股份 百鸟朝凤醇品 浓香型白酒礼盒装 整箱装 52度500ml*6瓶 高度纯粮食', '/images/banner/20191113\\8368495c2f8231bcbcf4a766c716306a.jpg', 1, 1, 4, 6, 598, 448, 0, 1, 0, '2019-11-13 17:49:11', '2019-11-13 18:02:20');
INSERT INTO `pin_wine` VALUES (2, '五粮液5年浓香型52度', '/images/banner/20191113\\d0e828305347c212ba334b4aafa81951.jpg', 1, 1, 4, 1, 180, 150, 1, 1, 1, '2019-11-13 17:49:11', '2019-11-13 17:58:34');

-- ----------------------------
-- Table structure for pin_wine_brand
-- ----------------------------
DROP TABLE IF EXISTS `pin_wine_brand`;
CREATE TABLE `pin_wine_brand`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '品牌名称',
  `status` tinyint(3) NULL DEFAULT 1 COMMENT '状态 0:禁用 1:正常',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '品牌图片',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序ID',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品品牌表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pin_wine_brand
-- ----------------------------
INSERT INTO `pin_wine_brand` VALUES (1, '贵州茅台', 1, '/images/banner/20191113\\675cb1e9428e6ba9aa3f2aaba37516a5.png', 0, '2019-11-13 14:35:35', '2019-11-13 14:35:35');
INSERT INTO `pin_wine_brand` VALUES (2, '古井', 1, '/images/banner/20191113\\d53c974bcf18175b7ce26a2b544946d6.png', 0, '2019-11-13 14:36:00', '2019-11-13 14:36:37');
INSERT INTO `pin_wine_brand` VALUES (3, '洋河', 1, '/images/banner/20191113\\89add48a07b432a05df5a816d9b73c9c.png', 0, '2019-11-13 14:36:30', '2019-11-13 14:36:30');
INSERT INTO `pin_wine_brand` VALUES (4, '五粮液', 0, '/images/banner/20191113\\e9c66bd41870131468b1df0df6489d12.png', 0, '2019-11-13 14:37:05', '2019-11-13 15:31:57');

-- ----------------------------
-- Table structure for pin_wine_cart
-- ----------------------------
DROP TABLE IF EXISTS `pin_wine_cart`;
CREATE TABLE `pin_wine_cart`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `wine_id` int(11) NULL DEFAULT 0 COMMENT '酒品id',
  `quantity` int(11) NULL DEFAULT 1 COMMENT '购买数量',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `wine_id`(`wine_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品购物车表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_wine_imgs
-- ----------------------------
DROP TABLE IF EXISTS `pin_wine_imgs`;
CREATE TABLE `pin_wine_imgs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wine_id` int(11) NULL DEFAULT 0 COMMENT '酒品id',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '管理员的简称',
  `sort` smallint(6) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序ID',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `wine_id`(`wine_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品详情图表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_wine_order
-- ----------------------------
DROP TABLE IF EXISTS `pin_wine_order`;
CREATE TABLE `pin_wine_order`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `status` tinyint(11) NULL DEFAULT 0 COMMENT '订单状态 0:待支付 1:已支付 2已取消 3已发货 4已完成 5已取消',
  `total_money` int(11) NULL DEFAULT 0 COMMENT '实付订单总额(包含快递费)',
  `mall_wine_money` int(11) NULL DEFAULT 0 COMMENT '酒品市场价订单总额',
  `total_wine_money` int(11) NULL DEFAULT 0 COMMENT '酒品会员价订单总额',
  `transaction_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '微信支付订单号',
  `is_express` tinyint(11) NULL DEFAULT 1 COMMENT '提货方式 1:快递 2:自提',
  `shop_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '0' COMMENT '自提店家冗余',
  `address_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '下单地址冗余',
  `express_id` int(11) NULL DEFAULT 0 COMMENT '物流id',
  `express` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '物流编号',
  `express_price` int(11) NOT NULL DEFAULT 0 COMMENT '发件运费',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pin_wine_order_wines
-- ----------------------------
DROP TABLE IF EXISTS `pin_wine_order_wines`;
CREATE TABLE `pin_wine_order_wines`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `user_id` int(11) NULL DEFAULT 0 COMMENT '用户id',
  `wine_id` int(11) NULL DEFAULT 0 COMMENT '酒品id',
  `wine_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '酒品名称',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '封面图片',
  `quantity` int(11) NULL DEFAULT 1 COMMENT '购买数量',
  `mall_price` int(11) NULL DEFAULT 0 COMMENT '市场价',
  `vip_price` int(11) NULL DEFAULT 0 COMMENT '会员价',
  `wine_style` tinyint(3) NULL DEFAULT 0 COMMENT 'wineStyle 系列:1流通酒 2系列酒',
  `wine_size` tinyint(3) NULL DEFAULT 0 COMMENT 'wineSize 规格:字典',
  `create_time` datetime(0) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `wine_id`(`wine_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '酒品订单表' ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统字典表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_dict
-- ----------------------------
INSERT INTO `sys_dict` VALUES (1, '菜单类型', 'menuType', 1, '', NULL, '2019-04-15 17:36:00');
INSERT INTO `sys_dict` VALUES (19, '日志级别', 'logLevel', 2, '', '2019-04-19 10:04:33', '2019-04-19 10:04:56');
INSERT INTO `sys_dict` VALUES (20, '按钮类别', 'btnType', 3, '', '2019-04-19 10:05:29', '2019-04-19 10:05:29');
INSERT INTO `sys_dict` VALUES (21, '状态', 'status', 4, '', '2019-04-19 10:23:17', '2019-04-19 10:23:17');
INSERT INTO `sys_dict` VALUES (22, '按钮方法', 'btnFunc', 5, '', '2019-04-19 16:02:05', '2019-04-30 13:39:08');
INSERT INTO `sys_dict` VALUES (23, '酒品系列', 'wineStyle', 6, '', '2019-11-13 16:13:14', '2019-11-13 16:13:14');
INSERT INTO `sys_dict` VALUES (24, '酒品分类', 'wineCate', 7, '', '2019-11-13 16:13:41', '2019-11-13 16:13:41');
INSERT INTO `sys_dict` VALUES (25, '包装规格', 'wineSize', 8, '', '2019-11-13 16:13:58', '2019-11-13 16:34:34');
INSERT INTO `sys_dict` VALUES (26, '是否', 'isTrue', 0, '', '2019-11-13 16:26:54', '2019-11-13 16:26:54');
INSERT INTO `sys_dict` VALUES (27, '上下架', 'upDown', 10, '', '2019-11-13 16:29:31', '2019-11-13 16:29:31');

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
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统字典参数表' ROW_FORMAT = Dynamic;

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
INSERT INTO `sys_dict_value` VALUES (17, 23, '流通酒', '1', '#009688', 1, '', '2019-11-13 16:18:53', '2019-11-13 16:18:53');
INSERT INTO `sys_dict_value` VALUES (18, 23, '系列酒', '2', '#ff5722', 2, '', '2019-11-13 16:19:12', '2019-11-13 16:19:12');
INSERT INTO `sys_dict_value` VALUES (19, 26, '是', '1', '#009688', 0, '', '2019-11-13 16:27:17', '2019-11-13 16:27:17');
INSERT INTO `sys_dict_value` VALUES (20, 26, '否', '0', '#ff5722', 1, '', '2019-11-13 16:27:33', '2019-11-13 16:27:42');
INSERT INTO `sys_dict_value` VALUES (21, 27, '上架', '1', '#009688', 1, '', '2019-11-13 16:29:57', '2019-11-13 16:29:57');
INSERT INTO `sys_dict_value` VALUES (22, 27, '下架', '0', '#ff5722', 2, '', '2019-11-13 16:30:09', '2019-11-13 16:30:09');
INSERT INTO `sys_dict_value` VALUES (23, 24, '白酒', '1', '', 1, '', '2019-11-13 17:16:40', '2019-11-13 17:16:40');
INSERT INTO `sys_dict_value` VALUES (24, 24, '红酒', '2', '', 2, '', '2019-11-13 17:16:52', '2019-11-13 17:16:52');
INSERT INTO `sys_dict_value` VALUES (25, 24, '啤酒', '3', '', 3, '', '2019-11-13 17:17:02', '2019-11-13 17:17:02');
INSERT INTO `sys_dict_value` VALUES (26, 24, '洋酒', '4', '', 4, '', '2019-11-13 17:17:13', '2019-11-13 17:17:13');
INSERT INTO `sys_dict_value` VALUES (27, 25, '1*4*1瓶', '4', '', 4, '', '2019-11-13 17:19:47', '2019-11-13 17:57:43');
INSERT INTO `sys_dict_value` VALUES (28, 25, '1*2*1瓶', '2', '', 2, '', '2019-11-13 17:20:09', '2019-11-13 17:57:55');
INSERT INTO `sys_dict_value` VALUES (29, 25, '1*6*1瓶', '6', '', 6, '', '2019-11-13 17:20:47', '2019-11-13 17:58:05');
INSERT INTO `sys_dict_value` VALUES (30, 25, '1*1*1瓶', '1', '', 1, '', '2019-11-13 17:57:20', '2019-11-13 17:57:20');

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
) ENGINE = InnoDB AUTO_INCREMENT = 61 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统行为日志表' ROW_FORMAT = Dynamic;

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
INSERT INTO `sys_log` VALUES (51, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-11-08 10:59:31');
INSERT INTO `sys_log` VALUES (52, 1, '超管', '系统登录', '登录', '127.0.0.1', 'admin/index/login', '', '2019-11-08 13:29:56');
INSERT INTO `sys_log` VALUES (53, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-11-12 14:36:37');
INSERT INTO `sys_log` VALUES (54, 1, '超管', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-11-12 14:45:27');
INSERT INTO `sys_log` VALUES (55, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-11-12 14:45:38');
INSERT INTO `sys_log` VALUES (56, 1, '超管', '系统注销', '注销', '::1', 'admin/index/logout', '', '2019-11-12 14:53:17');
INSERT INTO `sys_log` VALUES (57, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-11-12 14:53:27');
INSERT INTO `sys_log` VALUES (58, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-11-12 15:55:31');
INSERT INTO `sys_log` VALUES (59, 1, '超管', '系统登录', '登录', '::1', 'admin/index/login', '', '2019-11-13 09:09:19');
INSERT INTO `sys_log` VALUES (60, 1, '超管', '配置管理', '新增', '::1', 'admin/sysconfig/add', '', '2019-11-13 10:47:43');

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
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_menu
-- ----------------------------
INSERT INTO `sys_menu` VALUES (1, 0, '', '系统管理', '<i class=\'layui-icon layui-icon-app\'></i>  ', 'M', '', '', NULL, 0, '', 1000, '', 1);
INSERT INTO `sys_menu` VALUES (2, 1, 'admin/sysmenu/index', '菜单管理', '<i class=\'layui-icon layui-icon-tabs\'></i>', 'M', '', '', NULL, 0, '', 1300, '', 1);
INSERT INTO `sys_menu` VALUES (4, 0, 'admin/siteinfo/index', '商城管理', '', 'M', '', '', 1, 0, '', 2000, '', 1);
INSERT INTO `sys_menu` VALUES (5, 4, 'admin/siteinfo/index', '商城管理', '', 'M', '', '', 1, 0, '', 2100, '', 1);
INSERT INTO `sys_menu` VALUES (6, 2, 'admin/sysmenu/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1301, '', 1);
INSERT INTO `sys_menu` VALUES (7, 1, 'admin/sysdict/index', '字典管理', '<i class=\'layui-icon layui-icon-read\'></i>', 'M', '', '', NULL, 0, '', 1400, '', 1);
INSERT INTO `sys_menu` VALUES (8, 9, 'admin/sysdictvalue/index', '字典参数', '<i class=\'layui-icon layui-icon-list\'></i>', 'B', '', 'showValue', 2, 0, '', 1419, '', 1);
INSERT INTO `sys_menu` VALUES (9, 7, 'admin/sysdict/index', '字典管理', '', 'T', '', '', NULL, 0, '', 1410, '', 1);
INSERT INTO `sys_menu` VALUES (10, 7, 'admin/sysdictvalue/index', '字典参数', '', 'T', '', '', NULL, 0, '', 1420, '', 1);
INSERT INTO `sys_menu` VALUES (11, 9, 'admin/sysdict/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1412, '', 1);
INSERT INTO `sys_menu` VALUES (12, 9, 'admin/sysdict/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, '', 1411, '', 1);
INSERT INTO `sys_menu` VALUES (13, 10, 'admin/sysdictvalue/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1421, '', 1);
INSERT INTO `sys_menu` VALUES (14, 10, 'admin/sysdictvalue/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, '', 1421, '', 1);
INSERT INTO `sys_menu` VALUES (15, 10, 'admin/sysdictvalue/delBatch', '批量删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'delBatch', 1, 0, '', 1429, '', 1);
INSERT INTO `sys_menu` VALUES (16, 10, 'admin/sysdictvalue/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 1428, '', 1);
INSERT INTO `sys_menu` VALUES (17, 9, 'admin/sysdict/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 1418, '', 1);
INSERT INTO `sys_menu` VALUES (18, 2, 'admin/sysmenu/add', '添加下级', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '#5fb878', 'addDown', 2, 0, '', 1309, '', 1);
INSERT INTO `sys_menu` VALUES (19, 2, 'admin/sysmenu/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 1308, '', 1);
INSERT INTO `sys_menu` VALUES (20, 2, 'admin/sysmenu/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, '', 1300, '', 1);
INSERT INTO `sys_menu` VALUES (21, 1, 'admin/sysrole/index', '角色管理', '<i class=\'layui-icon layui-icon-group\'></i>', 'M', '', '', 1, 0, '', 1200, '', 1);
INSERT INTO `sys_menu` VALUES (22, 21, 'admin/sysrole/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 1, 'id:{id}', 1201, '', 1);
INSERT INTO `sys_menu` VALUES (24, 21, 'admin/sysrole/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1201, '', 1);
INSERT INTO `sys_menu` VALUES (25, 21, 'admin/sysrole/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 1202, '', 1);
INSERT INTO `sys_menu` VALUES (26, 21, 'admin/sysrole/auth', '权限', '<i class=\'layui-icon layui-icon-link\'></i>', 'B', '#5fb878', 'auth', 2, 0, 'id:{id}', 1209, '', 1);
INSERT INTO `sys_menu` VALUES (27, 1, 'admin/sysuser/index', '用户管理', '<i class=\'layui-icon layui-icon-user\'></i>', 'M', '', '', 1, 0, '', 1100, '', 1);
INSERT INTO `sys_menu` VALUES (28, 27, 'admin/sysuser/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 1, 'id:{id}', 1101, '', 1);
INSERT INTO `sys_menu` VALUES (29, 27, 'admin/sysuser/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 1102, '', 1);
INSERT INTO `sys_menu` VALUES (30, 27, 'admin/sysuser/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 1101, '', 1);
INSERT INTO `sys_menu` VALUES (31, 27, 'admin/sysuser/resetPassword', '重置密码', '<i class=\'layui-icon layui-icon-refresh\'></i>', 'B', '#5fb878', 'resetPassword', 2, 1, 'id:{id}', 1109, '默认重置密码后为123456', 1);
INSERT INTO `sys_menu` VALUES (32, 1, 'admin/sysconfig/index', '配置管理', '<i class=\'layui-icon layui-icon-set-sm\'></i>', 'M', '', '', 1, 0, '', 1500, '', 1);
INSERT INTO `sys_menu` VALUES (33, 32, 'admin/sysconfig/add', '新增', '<i class=\'layui-icon layui-icon-add-circle\'></i>', 'B', '', 'add', 1, 1, 'config_code:{config_code},config_name:{config_name}', 1501, '', 1);
INSERT INTO `sys_menu` VALUES (34, 32, 'admin/sysconfig/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 1, 'id:{id}', 1501, '', 1);
INSERT INTO `sys_menu` VALUES (35, 32, 'admin/sysconfig/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 1, 'id:{id}', 1509, '', 1);
INSERT INTO `sys_menu` VALUES (36, 1, 'admin/syslog/index', '日志管理', '<i class=\'layui-icon layui-icon-file-b\'></i>', 'M', '', '', 1, 0, '', 1600, '', 1);
INSERT INTO `sys_menu` VALUES (37, 32, 'admin/sysconfig/clearCache', '清除缓存', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#ff5722', 'clearCache', 1, 1, '', 1502, '', 1);
INSERT INTO `sys_menu` VALUES (38, 4, 'admin/siteshop/index', '门店管理', '', 'M', '', '', 1, 0, '', 2200, '', 1);
INSERT INTO `sys_menu` VALUES (39, 4, 'admin/sitebanner/index', '广告管理', '', 'M', '', '', 1, 0, '', 2300, '', 1);
INSERT INTO `sys_menu` VALUES (40, 39, 'admin/sitebanner/index', '广告管理', '', 'T', '', '', 1, 0, '', 2310, '', 1);
INSERT INTO `sys_menu` VALUES (41, 39, 'admin/sitebannerposition/index', '广告位管理', '', 'T', '', '', 1, 0, '', 2320, '', 1);
INSERT INTO `sys_menu` VALUES (42, 38, 'admin/siteshop/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, 'shop_name:{shop_name}', 2208, '', 1);
INSERT INTO `sys_menu` VALUES (43, 38, 'admin/siteshop/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'shop_name:{shop_name}', 2202, '', 1);
INSERT INTO `sys_menu` VALUES (44, 38, 'admin/siteshop/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, 'id:{id}', 2201, '', 1);
INSERT INTO `sys_menu` VALUES (45, 41, 'admin/sitebannerposition/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, 'position_name:{position_name}', 2329, '', 1);
INSERT INTO `sys_menu` VALUES (46, 41, 'admin/sitebannerpoistion/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 2322, '', 1);
INSERT INTO `sys_menu` VALUES (47, 41, 'admin/sitebannerposition/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, 'id:{id}', 2321, '', 1);
INSERT INTO `sys_menu` VALUES (48, 4, 'admin/siteinfo/edit', '编辑官网', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '#009688', 'edit', 2, 0, '', 2102, '', 1);
INSERT INTO `sys_menu` VALUES (49, 40, 'admin/sitebanner/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, '', 2319, '', 1);
INSERT INTO `sys_menu` VALUES (50, 40, 'admin/sitebanner/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, '', 2312, '', 1);
INSERT INTO `sys_menu` VALUES (51, 40, 'admin/sitebanner/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '', '', 2, 0, 'id:{id}', 2310, '', 1);
INSERT INTO `sys_menu` VALUES (52, 4, 'admin/siteinfo/editkf', '编辑客服', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '#009688', 'edit', 2, 0, '', 2103, '', 1);
INSERT INTO `sys_menu` VALUES (53, 4, 'admin/sitesearchhot/index', '热搜管理', '', 'M', '', '', 1, 0, '', 2400, '', 1);
INSERT INTO `sys_menu` VALUES (54, 53, 'admin/sitesearchhot/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, 'keywords:{keywords}', 2409, '', 1);
INSERT INTO `sys_menu` VALUES (55, 53, 'admin/sitesearchhot/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id},keywords:{keywords}', 2402, '', 1);
INSERT INTO `sys_menu` VALUES (56, 53, 'admin/sitesearchhot/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, 'id:{id}', 2401, '', 1);
INSERT INTO `sys_menu` VALUES (57, 0, 'admin/wine/index', '酒品管理', '', 'M', '', '', 1, 0, '', 3000, '', 1);
INSERT INTO `sys_menu` VALUES (58, 57, 'admin/wine/index', '酒品管理', '', 'M', '', '', 1, 0, '', 3100, '', 1);
INSERT INTO `sys_menu` VALUES (59, 57, 'admin/winebrand/index', '品牌管理', '', 'M', '', '', 1, 0, '', 3200, '', 1);
INSERT INTO `sys_menu` VALUES (60, 59, 'admin/winebrand/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, 'brand_name:{brand_name}', 3209, '', 1);
INSERT INTO `sys_menu` VALUES (61, 59, 'admin/winebrand/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 3202, '', 1);
INSERT INTO `sys_menu` VALUES (62, 59, 'admin/winebrand/del', '删除', '<i class=\'layui-icon layui-icon-delete\'></i>', 'B', '#FF5722', 'del', 2, 0, 'id:{id}', 3201, '', 1);
INSERT INTO `sys_menu` VALUES (63, 58, 'admin/wine/add', '新增', '<i class=\'layui-icon layui-icon-add-circle-fine\'></i>', 'B', '', 'add', 1, 0, 'wine_name:{wine_name}', 3109, '', 1);
INSERT INTO `sys_menu` VALUES (64, 58, 'admin/wine/edit', '编辑', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '', 'edit', 2, 0, 'id:{id}', 3102, '', 1);
INSERT INTO `sys_menu` VALUES (65, 58, 'admin/wine/editcpt', '酒品图', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '#ffb800', 'edit', 2, 0, 'wine_id:{wine_id}', 3102, '', 1);
INSERT INTO `sys_menu` VALUES (66, 58, 'admin/wine/editxqt', '详情图', '<i class=\'layui-icon layui-icon-edit\'></i>', 'B', '#ffb800', 'edit', 2, 0, 'wine_id:{wine_id}', 3103, '', 1);

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
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE,
  UNIQUE INDEX `name_2`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统管理员表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES (1, 'admin', '14e1b600b1fd579f47433b88e8d85291', '超管', 1, '19156017290', '', '::1', '2019-11-13 09:09:19', NULL, '2019-11-13 09:09:20', NULL);
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
