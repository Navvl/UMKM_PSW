/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : banana_go

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 08/06/2026 19:40:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pesan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id_message`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`  (
  `id_detail` int NOT NULL AUTO_INCREMENT,
  `id_order` int NOT NULL,
  `id_product` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga` int NOT NULL,
  PRIMARY KEY (`id_detail`) USING BTREE,
  INDEX `id_order`(`id_order` ASC) USING BTREE,
  INDEX `id_product`(`id_product` ASC) USING BTREE,
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` enum('pending','dikonfirmasi','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `stock_dikurangi` enum('belum','sudah') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'belum',
  PRIMARY KEY (`id_order`) USING BTREE,
  INDEX `id_user`(`id_user` ASC) USING BTREE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `nama_product` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `harga` int NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stok` int NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `categories` enum('Cheese','Chocolate','Matcha','Mix','Drinks','Sop Buah') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_product`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (14, 'Piscok Lumer 1 Rasa', 30000, 'SnapInsta.to_543986224_18041094704669640_2859379465061712984_n.jpg', 35, '2026-06-08 19:16:37', 'Chocolate');
INSERT INTO `products` VALUES (15, 'Piscok Lumer Keju', 33000, 'SnapInsta.to_541587876_18041094728669640_705275229593147474_n.jpg', 23, '2026-06-08 19:16:58', 'Cheese');
INSERT INTO `products` VALUES (16, 'Piscok Lumer 2 Rasa', 32000, 'SnapInsta.to_542222743_18041094713669640_2498091291813719014_n.jpg', 12, '2026-06-08 19:17:22', 'Mix');
INSERT INTO `products` VALUES (17, 'Pisang Gendur 1 Rasa', 30000, 'SnapInsta.to_541954507_18041094752669640_4069013675799396947_n.jpg', 18, '2026-06-08 19:17:46', 'Chocolate');
INSERT INTO `products` VALUES (18, 'Pisang Gendut Keju', 32000, 'SnapInsta.to_541923753_18041094764669640_7950321754399869546_n.jpg', 7, '2026-06-08 19:18:04', 'Cheese');
INSERT INTO `products` VALUES (19, 'Keju Aroma', 33000, 'SnapInsta.to_542294054_18041094743669640_7322333011327788161_n.jpg', 12, '2026-06-08 19:18:25', 'Matcha');
INSERT INTO `products` VALUES (20, 'Ubi Goreng', 28000, 'SnapInsta.to_542371601_18041094785669640_7048727506101421416_n.jpg', 35, '2026-06-08 19:18:57', 'Chocolate');
INSERT INTO `products` VALUES (21, 'Pisang Nugget', 32000, 'SnapInsta.to_540616338_18041094776669640_6961615538088487743_n.jpg', 12, '2026-06-08 19:19:16', 'Cheese');
INSERT INTO `products` VALUES (22, 'Lumpia Kering', 30000, 'SnapInsta.to_541555390_18041094797669640_5847880561289658926_n.jpg', 16, '2026-06-08 19:20:02', 'Mix');
INSERT INTO `products` VALUES (23, 'Sparkling Watermelon', 28000, 'SnapInsta.to_541580911_18041094809669640_8554181590584962233_n.jpg', 12, '2026-06-08 19:20:28', 'Sop Buah');
INSERT INTO `products` VALUES (24, 'Ximilu Sop Buah Segar', 30000, 'SnapInsta.to_542535496_18041094818669640_8651136730249273020_n.jpg', 11, '2026-06-08 19:20:49', 'Sop Buah');
INSERT INTO `products` VALUES (25, 'Banana Milk', 25000, 'delicious-bubble-tea-drink-with-yellow-straw.jpg', 54, '2026-06-08 19:24:58', 'Drinks');
INSERT INTO `products` VALUES (26, 'Milo', 18000, 'Ice Milo.jpg', 12, '2026-06-08 19:26:59', 'Sop Buah');
INSERT INTO `products` VALUES (27, 'Coklat', 18000, 'Hot Chocolate.jpg', 7, '2026-06-08 19:27:49', 'Drinks');
INSERT INTO `products` VALUES (28, 'Kopi', 18000, 'Hot Mocha.jpg', 19, '2026-06-08 19:29:13', 'Drinks');
INSERT INTO `products` VALUES (29, 'Matcha', 18000, 'pexels-gulsum-coban-844585548-32695045.jpg', 20, '2026-06-08 19:30:58', 'Drinks');
INSERT INTO `products` VALUES (30, 'Milk Tea', 18000, 'pexels-vui-nguyen-745287463-18750034.jpg', 18, '2026-06-08 19:33:22', 'Drinks');
INSERT INTO `products` VALUES (31, 'Lemon Tea', 18000, 'pexels-shameel-mukkath-3421394-11009225.jpg', 12, '2026-06-08 19:34:03', 'Drinks');
INSERT INTO `products` VALUES (32, 'Peach Tea', 18000, 'pexels-soc-nang-d-ng-2150345854-33573170.jpg', 9, '2026-06-08 19:34:33', 'Drinks');
INSERT INTO `products` VALUES (33, 'Teh Obeng', 15000, 'pexels-dovinda-rd-993674313-31336109.jpg', 10, '2026-06-08 19:35:11', 'Drinks');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Admin', '$2y$10$TzsRDXWxWzYpglJOQKhtOuxrkypPui.Y8d2VXS/r.spw/W1QdN2FS', 'admin');
INSERT INTO `users` VALUES (7, 'User', '$2y$10$Qw3cYnaVH4ax9xwxJK3k0uJP3AOcjPL0JLAVm1laOqXiNZrLddOiC', 'user');

SET FOREIGN_KEY_CHECKS = 1;
