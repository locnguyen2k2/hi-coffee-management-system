SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `tbl_table` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `areaID` int(10) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tbl_order` (
  `id` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_image` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_image_food` (
  `id` int(10) NOT NULL,
  `foodID` int(10) NOT NULL,
  `imageID` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tbl_area` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_leftmenu` (
  `id` int(10) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `page` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tbl_leftmenu` (`id`, `name`, `page`) VALUES
(1, 'trang chủ', 'homepage'),
(2, 'thông tin', 'about'),
(3, 'facebook', 'facebook'),
(4, 'telegram', 'telegram'),
(5, 'tiktok', 'tiktok');

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

CREATE TABLE `tbl_food` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `typeID` int(10) NOT NULL,
  `price` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_user` (
  `id` int(10) NOT NULL,
  `fname` varchar(250) DEFAULT NULL,
  `lname` varchar(250) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `username` varchar(36) DEFAULT NULL,
  `password` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_permission` (
  `id` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `roleID` int(10) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tbl_role` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

CREATE TABLE `tbl_rightmenu` (
  `id` int(10) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `page` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areaID` (`areaID`);

ALTER TABLE `tbl_order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `tableID` (`tableID`),
  ADD KEY `tbl_order_detail_food` (`foodID`);

ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`,`foodID`) USING BTREE,
  ADD KEY `foodID` (`foodID`) USING BTREE;

ALTER TABLE `tbl_image`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_image_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foodID` (`foodID`),
  ADD KEY `imageID` (`imageID`);

ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`id`,`orderID`,`foodID`,`tableID`) USING BTREE,
  ADD KEY `fk_invoice_order` (`orderID`),
  ADD KEY `fk_invoice_food` (`foodID`),
  ADD KEY `fk_invoice_table` (`tableID`);

ALTER TABLE `tbl_temp_invoice`
  ADD PRIMARY KEY (`id`,`orderID`,`foodID`,`tableID`) USING BTREE,
  ADD KEY `fk_tempInvoice_order` (`orderID`),
  ADD KEY `fk_tempInvoice_food` (`foodID`),
  ADD KEY `fk_tempInvoice_table` (`tableID`);

ALTER TABLE `tbl_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

ALTER TABLE `tbl_leftmenu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_type`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `typeID` (`typeID`);

ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`,`roleID`),
  ADD KEY `fk_permission_role` (`roleID`);

ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_rightmenu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tbl_table`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_order_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_order`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_image_food`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_area`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_leftmenu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `tbl_type`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_food`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_permission`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_table`
  ADD CONSTRAINT `fk_table_area` FOREIGN KEY (`areaID`) REFERENCES `tbl_area` (`id`);

ALTER TABLE `tbl_order_detail`
  ADD CONSTRAINT `tbl_order_detail_ban` FOREIGN KEY (`tableID`) REFERENCES `tbl_table` (`id`),
  ADD CONSTRAINT `tbl_order_detail_dondat` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `tbl_order_detail_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_dondat_ibfk_1` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_image_food`
--
ALTER TABLE `tbl_image_food`
  ADD CONSTRAINT `fk_hinhanh_mon_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_hoadon`
--
ALTER TABLE `tbl_invoice`
  ADD CONSTRAINT `fk_hoadon` FOREIGN KEY (`tableID`) REFERENCES `tbl_table` (`id`),
  ADD CONSTRAINT `fk_hoadon_dondat` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `fk_hoadon_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_temp_invoice`
--
ALTER TABLE `tbl_temp_invoice`
  ADD CONSTRAINT `fk_hoadon_dathanhtoan` FOREIGN KEY (`tableID`) REFERENCES `tbl_table` (`id`),
  ADD CONSTRAINT `fk_hoadon_dathanhtoan_dondat` FOREIGN KEY (`orderID`) REFERENCES `tbl_order` (`id`),
  ADD CONSTRAINT `fk_hoadon_dathanhtoan_mon` FOREIGN KEY (`foodID`) REFERENCES `tbl_food` (`id`);

--
-- Các ràng buộc cho bảng `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD CONSTRAINT `fk_mon_loai` FOREIGN KEY (`typeID`) REFERENCES `tbl_type` (`id`);

--
-- Các ràng buộc cho bảng `tbl_permission`
--
ALTER TABLE `tbl_permission`
  ADD CONSTRAINT `fk_groupuser_group` FOREIGN KEY (`roleID`) REFERENCES `tbl_role` (`id`),
  ADD CONSTRAINT `fk_groupuser_user` FOREIGN KEY (`userID`) REFERENCES `tbl_user` (`id`);
COMMIT;
