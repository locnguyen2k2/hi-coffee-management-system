-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 31, 2024 lúc 05:54 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `orderapp`
--

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `list_user`
-- (See below for the actual view)
--
CREATE TABLE `list_user` (
`id` int(10)
,`fname` varchar(250)
,`lname` varchar(250)
,`number` int(11)
,`email` varchar(250)
,`status` tinyint(1)
,`username` varchar(36)
,`password` varchar(255)
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_area`
--

CREATE TABLE `tbl_area` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_area`
--

INSERT INTO `tbl_area` (`id`, `name`) VALUES
(1, 'Tầng Trệt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `typeID` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `name`, `typeID`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cà phê đá', 1, 20002, 0, '2024-12-30 12:01:23', '2024-12-30 12:01:23'),
(2, 'Cà phê sữa đá', 1, 22000, 0, '2024-12-31 04:37:14', '2024-12-31 04:37:14'),
(3, 'Bạc xĩu', 1, 22000, 0, '2024-12-31 03:21:56', '2024-12-31 03:21:56'),
(4, 'Cacao đá xây', 3, 25000, 0, '2024-12-31 03:22:06', '2024-12-31 03:22:06'),
(5, 'Pepsi lon 330ml', 6, 15000, 0, '2024-12-30 11:32:41', '2024-12-30 11:32:41'),
(6, 'Sting dâu 33ml', 6, 15000, 0, '2024-12-31 03:22:26', '2024-12-31 03:22:26'),
(7, 'Matcha đá xây', 3, 27000, 0, '2024-12-30 11:33:09', '2024-12-30 11:33:09'),
(8, 'Trà vải', 4, 32000, 0, '2024-12-31 04:22:50', '2024-12-31 04:22:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_image`
--

CREATE TABLE `tbl_image` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_image`
--

INSERT INTO `tbl_image` (`id`, `name`, `created_at`) VALUES
(1, 'loc_1725106528.jpg', '2024-08-31 12:15:28'),
(2, 'loc_1732959132.jpg', '2024-11-30 09:32:12'),
(3, 'Ca-phe-da_1703635756_1735615212.png', '2024-12-31 03:20:12'),
(4, 'Ca-phe-sua_1703635525_1735615298.png', '2024-12-31 03:21:38'),
(5, 'Bac-siu_1703635839_1735615316.png', '2024-12-31 03:21:56'),
(6, '615ae6ef1f19bf324539a7f2_CÀ_PHÊ_ĐÁ_XAY_L-removebg-preview_1703636379_1735615325.png', '2024-12-31 03:22:05'),
(7, 'pixlr-bg-result-11_1703636312_1735615345.png', '2024-12-31 03:22:26'),
(8, 'tradau_1735618970.jpg', '2024-12-31 04:22:50'),
(9, 'caphesuada_1735619834.jpg', '2024-12-31 04:37:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_image_food`
--

CREATE TABLE `tbl_image_food` (
  `id` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `imageID` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_image_food`
--

INSERT INTO `tbl_image_food` (`id`, `foodID`, `imageID`, `created_at`) VALUES
(1, 1, 1, '2024-08-31 12:15:28'),
(2, 2, 2, '2024-11-30 09:32:12'),
(3, 1, 3, '2024-12-31 03:20:12'),
(4, 2, 4, '2024-12-31 03:21:39'),
(5, 3, 5, '2024-12-31 03:21:56'),
(6, 4, 6, '2024-12-31 03:22:05'),
(7, 6, 7, '2024-12-31 03:22:26'),
(8, 8, 8, '2024-12-31 04:22:50'),
(9, 2, 9, '2024-12-31 04:37:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `id` int(10) NOT NULL,
  `orderID` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tableID` int(10) NOT NULL,
  `typeID` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `username` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`id`, `orderID`, `foodID`, `quantity`, `total`, `status`, `created_at`, `updated_at`, `tableID`, `typeID`, `price`, `username`) VALUES
(1, 1735573921, 2, 1, 20000, 1, '2024-12-30 17:01:51', '2024-12-30 17:01:51', 1, 1, 20000, 'admin01'),
(1, 1735573921, 7, 1, 27000, 1, '2024-12-30 17:01:56', '2024-12-30 17:01:56', 1, 3, 27000, 'admin01'),
(1, 1735577673, 7, 1, 27000, 1, '2024-12-30 17:01:57', '2024-12-30 17:01:57', 1, 3, 27000, 'admin01'),
(3, 1735616098, 4, 2, 50000, 1, '2024-12-31 03:44:43', '2024-12-31 03:44:43', 2, 3, 25000, 'nhanvien01'),
(5, 1735617243, 4, 2, 50000, 1, '2024-12-31 04:06:36', '2024-12-31 04:06:36', 2, 3, 25000, 'nhanvien01'),
(5, 1735617833, 5, 1, 15000, 1, '2024-12-31 04:47:59', '2024-12-31 04:47:59', 2, 6, 15000, 'admin01'),
(5, 1735617834, 7, 1, 27000, 1, '2024-12-31 04:48:00', '2024-12-31 04:48:00', 2, 3, 27000, 'admin01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_leftmenu`
--

CREATE TABLE `tbl_leftmenu` (
  `id` int(10) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `page` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_leftmenu`
--

INSERT INTO `tbl_leftmenu` (`id`, `name`, `page`) VALUES
(1, 'trang chủ', 'homepage'),
(2, 'thông tin', 'about'),
(3, 'facebook', 'facebook'),
(4, 'telegram', 'telegram'),
(5, 'tiktok', 'tiktok');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `foodID`, `quantity`, `created_at`, `updated_at`) VALUES
(1735573921, 2, 1, '2024-12-30 15:54:38', '2024-12-30 15:54:38'),
(1735573921, 7, 1, '2024-12-30 15:52:01', '2024-12-30 15:52:01'),
(1735577673, 7, 1, '2024-12-30 16:54:33', '2024-12-30 16:54:33'),
(1735616098, 4, 2, '2024-12-31 03:43:00', '2024-12-31 03:43:00'),
(1735617243, 4, 2, '2024-12-31 03:55:31', '2024-12-31 03:55:31'),
(1735617244, 3, 1, '2024-12-31 03:54:02', '2024-12-31 03:54:02'),
(1735617833, 5, 1, '2024-12-31 04:03:52', '2024-12-31 04:03:52'),
(1735617834, 7, 1, '2024-12-31 04:03:52', '2024-12-31 04:03:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order_detail`
--

CREATE TABLE `tbl_order_detail` (
  `id` int(10) NOT NULL,
  `orderID` int(10) NOT NULL,
  `tableID` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `typeID` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` tinyint(4) NOT NULL,
  `total` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_order_detail`
--

INSERT INTO `tbl_order_detail` (`id`, `orderID`, `tableID`, `foodID`, `typeID`, `price`, `quantity`, `total`, `status`, `created_at`, `updated_at`) VALUES
(133, 1735573921, 1, 7, 3, 27000, 1, 27000, 1, '2024-12-30 17:01:56', '2024-12-30 17:01:56'),
(134, 1735573921, 1, 2, 1, 20000, 1, 20000, 1, '2024-12-30 17:01:51', '2024-12-30 17:01:51'),
(137, 1735577673, 1, 7, 3, 27000, 1, 27000, 1, '2024-12-30 17:01:57', '2024-12-30 17:01:57'),
(150, 1735616098, 2, 4, 3, 25000, 2, 50000, 1, '2024-12-31 03:44:42', '2024-12-31 03:44:42'),
(152, 1735617243, 2, 4, 3, 25000, 2, 50000, 1, '2024-12-31 04:06:36', '2024-12-31 04:06:36'),
(153, 1735617244, 1, 3, 1, 22000, 1, 22000, 0, '2024-12-31 03:54:02', '2024-12-31 03:54:02'),
(162, 1735617833, 2, 5, 6, 15000, 1, 15000, 1, '2024-12-31 04:47:59', '2024-12-31 04:47:59'),
(163, 1735617834, 2, 7, 3, 27000, 1, 27000, 1, '2024-12-31 04:47:59', '2024-12-31 04:47:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_permission`
--

CREATE TABLE `tbl_permission` (
  `id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `roleID` int(10) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_permission`
--

INSERT INTO `tbl_permission` (`id`, `userID`, `roleID`, `status`) VALUES
(2, 2, 1, 0),
(3, 2, 3, 0),
(4, 3, 1, 0),
(5, 4, 3, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_rightmenu`
--

CREATE TABLE `tbl_rightmenu` (
  `id` int(10) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `page` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'manager'),
(3, 'staff');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_table`
--

CREATE TABLE `tbl_table` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `areaID` int(10) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_table`
--

INSERT INTO `tbl_table` (`id`, `name`, `areaID`, `status`) VALUES
(1, 'Phòng lạnh', 1, 1),
(2, 'Bàn 2', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_temp_invoice`
--

CREATE TABLE `tbl_temp_invoice` (
  `id` int(10) NOT NULL,
  `orderID` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tableID` int(10) NOT NULL,
  `typeID` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `username` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_temp_invoice`
--

INSERT INTO `tbl_temp_invoice` (`id`, `orderID`, `foodID`, `quantity`, `total`, `status`, `created_at`, `updated_at`, `tableID`, `typeID`, `price`, `username`) VALUES
(4, 1735617244, 3, 1, 22000, 0, '2024-12-31 03:54:02', '2024-12-31 03:54:02', 1, 1, 22000, 'nhanvien01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_type`
--

CREATE TABLE `tbl_type` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_type`
--

INSERT INTO `tbl_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cà phê', 0, '2024-08-31 12:14:32', '2024-08-31 12:14:32'),
(2, 'Cacao', 0, '2024-08-31 12:14:37', '2024-08-31 12:14:37'),
(3, 'Đá xay', 0, '2024-08-31 12:14:43', '2024-08-31 12:14:43'),
(4, 'Trà', 0, '2024-08-31 12:14:47', '2024-08-31 12:14:47'),
(5, 'Trà sữa', 0, '2024-08-31 12:14:52', '2024-08-31 12:14:52'),
(6, 'Nước ngọt', 0, '2024-12-30 11:32:19', '2024-12-30 11:32:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) NOT NULL,
  `fname` varchar(250) DEFAULT NULL,
  `lname` varchar(250) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `username` varchar(36) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `fname`, `lname`, `number`, `email`, `status`, `username`, `password`) VALUES
(2, 'Loc', 'Nguyen', 32766666, 'locnguyentan1230@gmail.com', 0, 'admin01', '$2y$10$B388Tq9TPALe0KRz10gvee0KyBoCosq7QM5.WMkewDRDbdNOwYUva'),
(3, 'undefined', '123', 123, '1233', 0, '123', '123'),
(4, 'Lộc', 'Tấn', 123456789, 'locnguyentan1230@gmail.com', 0, 'nhanvien01', '$2y$10$DqGhPAfAJAvsofmQMxRVveuAdqHnBkiTzTz01CWj2..jgO6HVTqbi');

-- --------------------------------------------------------

--
-- Cấu trúc cho view `list_user`
--
DROP TABLE IF EXISTS `list_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `list_user`  AS SELECT `tbl_user`.`id` AS `id`, `tbl_user`.`fname` AS `fname`, `tbl_user`.`lname` AS `lname`, `tbl_user`.`number` AS `number`, `tbl_user`.`email` AS `email`, `tbl_user`.`status` AS `status`, `tbl_user`.`username` AS `username`, `tbl_user`.`password` AS `password` FROM `tbl_user` ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_area`
--
ALTER TABLE `tbl_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Chỉ mục cho bảng `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `typeID` (`typeID`);

--
-- Chỉ mục cho bảng `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_image_food`
--
ALTER TABLE `tbl_image_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foodID` (`foodID`),
  ADD KEY `imageID` (`imageID`);

--
-- Chỉ mục cho bảng `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`id`,`orderID`,`foodID`,`tableID`) USING BTREE,
  ADD KEY `fk_invoice_order` (`orderID`),
  ADD KEY `fk_invoice_food` (`foodID`),
  ADD KEY `fk_invoice_table` (`tableID`);

--
-- Chỉ mục cho bảng `tbl_leftmenu`
--
ALTER TABLE `tbl_leftmenu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`,`foodID`) USING BTREE,
  ADD KEY `foodID` (`foodID`) USING BTREE;

--
-- Chỉ mục cho bảng `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `tableID` (`tableID`),
  ADD KEY `tbl_order_detail_food` (`foodID`);

--
-- Chỉ mục cho bảng `tbl_permission`
--
ALTER TABLE `tbl_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`,`roleID`),
  ADD KEY `fk_permission_role` (`roleID`);

--
-- Chỉ mục cho bảng `tbl_rightmenu`
--
ALTER TABLE `tbl_rightmenu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_table`
--
ALTER TABLE `tbl_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areaID` (`areaID`);

--
-- Chỉ mục cho bảng `tbl_temp_invoice`
--
ALTER TABLE `tbl_temp_invoice`
  ADD PRIMARY KEY (`id`,`orderID`,`foodID`,`tableID`) USING BTREE,
  ADD KEY `fk_tempInvoice_order` (`orderID`),
  ADD KEY `fk_tempInvoice_food` (`foodID`),
  ADD KEY `fk_tempInvoice_table` (`tableID`);

--
-- Chỉ mục cho bảng `tbl_type`
--
ALTER TABLE `tbl_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_area`
--
ALTER TABLE `tbl_area`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tbl_image`
--
ALTER TABLE `tbl_image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `tbl_image_food`
--
ALTER TABLE `tbl_image_food`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `tbl_leftmenu`
--
ALTER TABLE `tbl_leftmenu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT cho bảng `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT cho bảng `tbl_permission`
--
ALTER TABLE `tbl_permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tbl_table`
--
ALTER TABLE `tbl_table`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tbl_type`
--
ALTER TABLE `tbl_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD CONSTRAINT `fk_mon_loai` FOREIGN KEY (`typeID`) REFERENCES `tbl_type` (`id`);

--
-- Các ràng buộc cho bảng `tbl_image_food`
--
ALTER TABLE `tbl_image_food`
  ADD CONSTRAINT `fk_hinhanh_mon_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD CONSTRAINT `fk_hoadon` FOREIGN KEY (`tableID`) REFERENCES `tbl_table` (`id`),
  ADD CONSTRAINT `fk_hoadon_dondat` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `fk_hoadon_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_dondat_ibfk_1` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_order_detail`
--
ALTER TABLE `tbl_order_detail`
  ADD CONSTRAINT `tbl_order_detail_ban` FOREIGN KEY (`tableID`) REFERENCES `tbl_table` (`id`),
  ADD CONSTRAINT `tbl_order_detail_dondat` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `tbl_order_detail_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_permission`
--
ALTER TABLE `tbl_permission`
  ADD CONSTRAINT `fk_groupuser_group` FOREIGN KEY (`roleID`) REFERENCES `tbl_role` (`id`),
  ADD CONSTRAINT `fk_groupuser_user` FOREIGN KEY (`userID`) REFERENCES `tbl_user` (`id`);

--
-- Các ràng buộc cho bảng `tbl_table`
--
ALTER TABLE `tbl_table`
  ADD CONSTRAINT `fk_table_area` FOREIGN KEY (`areaID`) REFERENCES `tbl_area` (`id`);

--
-- Các ràng buộc cho bảng `tbl_temp_invoice`
--
ALTER TABLE `tbl_temp_invoice`
  ADD CONSTRAINT `fk_hoadon_dathanhtoan` FOREIGN KEY (`tableID`) REFERENCES `tbl_table` (`id`),
  ADD CONSTRAINT `fk_hoadon_dathanhtoan_dondat` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `fk_hoadon_dathanhtoan_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
