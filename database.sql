-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 04, 2021 lúc 02:02 PM
-- Phiên bản máy phục vụ: 10.4.21-MariaDB
-- Phiên bản PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `database`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_department`
--

CREATE TABLE `tbl_department` (
  `id` int(255) NOT NULL,
  `roomname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `roomnumber` int(255) NOT NULL,
  `manager` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_department`
--

INSERT INTO `tbl_department` (`id`, `roomname`, `description`, `roomnumber`, `manager`) VALUES
(19, 'Kỹ thuật', 'Bộ phận giữ vai trò xây dựng và duy trì các cấu trúc, máy móc, thiết bị, hệ thống và chương trình hoạt động của máy móc, thiết bị trong các doanh nghiệp. Bộ phận này trực tiếp điều hành những việc liên quan đến kỹ thuật, công nghệ và máy móc của doanh nghiệp nhằm đảm bảo các hoạt động có liên quan đến kỹ thuật công nghệ diễn ra thuận lợi, hiệu quả. Đồng thời, nhanh chóng sửa chữa, khắc phục các lỗi có liên quan đến công nghệ, máy móc, tiến hành bảo dưỡng theo quy định, đảm bảo hệ thống máy móc, thiết bị công nghệ làm việc suôn sẻ, không để xảy ra tình trạng gián đoạn gây ảnh hưởng đến hoạt động sản xuất kinh doanh.', 1, 'letriduc'),
(20, 'Kỹ thuật', 'Bộ phận giữ vai trò xây dựng và duy trì các cấu trúc, máy móc, thiết bị, hệ thống và chương trình hoạt động của máy móc, thiết bị trong các doanh nghiệp. Bộ phận này trực tiếp điều hành những việc liên quan đến kỹ thuật, công nghệ và máy móc của doanh nghiệp nhằm đảm bảo các hoạt động có liên quan đến kỹ thuật công nghệ diễn ra thuận lợi, hiệu quả. Đồng thời, nhanh chóng sửa chữa, khắc phục các lỗi có liên quan đến công nghệ, máy móc, tiến hành bảo dưỡng theo quy định, đảm bảo hệ thống máy móc, thiết bị công nghệ làm việc suôn sẻ, không để xảy ra tình trạng gián đoạn gây ảnh hưởng đến hoạt động sản xuất kinh doanh.', 2, NULL),
(21, 'Nhân sự', 'Bộ phận nhân sự của một công ty có nhiệm vụ đào tạo và phát triển công nhân của mình, những người được coi là một số nguồn lực quan trọng nhất của công ty.', 1, 'nguyenquocdat'),
(22, 'Nhân sự', 'Bộ phận nhân sự của một công ty có nhiệm vụ đào tạo và phát triển công nhân của mình, những người được coi là một số nguồn lực quan trọng nhất của công ty.', 2, 'tranthihoadao');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_leave`
--

CREATE TABLE `tbl_leave` (
  `id` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `proof` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `today` date DEFAULT NULL,
  `status` int(30) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_leave`
--

INSERT INTO `tbl_leave` (`id`, `user`, `description`, `begin`, `end`, `proof`, `today`, `status`) VALUES
(26, 'letriduc', 'Nghỉ phép', '2021-10-01', '2021-10-02', NULL, '2021-09-24', 2),
(27, 'letriduc', 'Về quê ăn cỗ', '2021-10-31', '2021-11-02', NULL, '2021-10-29', 1),
(28, 'levanly', 'Về quê có chuyện gia đình', '2021-10-29', '2021-10-31', '../assets/images/leave/leavewj3hlspvi1user.jpg', '2021-10-29', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_task`
--

CREATE TABLE `tbl_task` (
  `id` int(255) NOT NULL,
  `creator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enddate` date NOT NULL,
  `staff` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(255) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` int(255) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `images` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numleave` int(30) NOT NULL DEFAULT 12,
  `action` int(1) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user`, `department`, `password`, `fullname`, `address`, `phone`, `email`, `images`, `numleave`, `action`, `level`) VALUES
(1, 'admin', NULL, '21232f297a57a5a743894a0e4a801fc3', 'admin', NULL, NULL, NULL, NULL, 0, 1, 0),
(23, 'letriduc', 19, '525c45d316d13b9a7f000c6ee805d98f', 'Lê Trí Đức', NULL, NULL, NULL, NULL, 12, 1, 1),
(24, 'levanly', 19, '6f5246685c22313f40b520f53644ec6b', 'Lê Vạn Lý', NULL, NULL, NULL, NULL, 9, 1, 2),
(25, 'nguyenmyanh', 19, 'fe37bb4e47f0c5f88b1dc3987acea7ad', 'Nguyễn Mỹ Anh', NULL, NULL, NULL, NULL, 12, 0, 2),
(26, 'nguyenquocdat', 21, '727ae7fec3a92eaeb2ab45e178cc58a6', 'Nguyễn Quốc Đạt', NULL, NULL, NULL, NULL, 15, 0, 1),
(27, 'nguyentranminhhoa', 21, '8769d024ebb61017c6001bd1570545cc', 'Nguyễn Trần Minh Hoa', NULL, NULL, NULL, NULL, 12, 1, 2),
(28, 'nguyenthithaonhu', 21, '276be985b1d3a3c2363eb71cd79f4a48', 'Nguyễn Thị Thảo Như', NULL, NULL, NULL, NULL, 12, 0, 2),
(29, 'thaikhanhha', 22, 'c7ffccb493b477ef218409f57195a067', 'Thái Khánh Hà', NULL, NULL, NULL, NULL, 12, 0, 2),
(30, 'tranthihoadao', 22, 'd9b39d441e3c8c7cac5d2fd831758953', 'Trần Thị Hoa Đào', NULL, NULL, NULL, NULL, 15, 0, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_leave`
--
ALTER TABLE `tbl_leave`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tbl_task`
--
ALTER TABLE `tbl_task`
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
-- AUTO_INCREMENT cho bảng `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `tbl_leave`
--
ALTER TABLE `tbl_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `tbl_task`
--
ALTER TABLE `tbl_task`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
