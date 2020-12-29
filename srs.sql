-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2020 at 11:22 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srs`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `lo_id` int(11) NOT NULL,
  `st_id` varchar(12) NOT NULL,
  `ro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`lo_id`, `st_id`, `ro_id`) VALUES
(1, '999', 1),
(2, '998', 2),
(3, '997', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(200) DEFAULT NULL,
  `prod_price` double DEFAULT NULL,
  `su_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_price`, `su_id`) VALUES
(1, 'Dell Inspiron 15 3000', 1849.99, 3),
(2, 'Acer Aspire 3 A314-32-C2VP NoteBook', 1419, 2),
(3, 'Asus ZenBook Pro Duo', 2000, 4),
(4, 'Asus ROG Strix G-531G-DBQ086T Gaming Laptop', 3200, 4),
(5, 'Asus ROG 3 ZS661KS Gaming Phone', 2999.99, 4),
(6, 'Samsung Galaxy Z Fold2', 7999, 5),
(7, 'Samsung Galaxy Book S Laptop', 1620, 5),
(9, 'Toshiba 40 Full HD LED TV', 809, 6),
(10, 'Toshiba 50 INCH 4K UHD SMART TV', 1499, 6),
(11, 'Panasonic 1.0HP Supper Deluxe Inverter R410', 1599, 7),
(12, 'Panasonic LUMIX BGH1 4K Camera', 8093.86, 7),
(13, 'Canon EOS 3000D', 1250, 8),
(14, 'Canon EOS M6 Mark II', 3379.99, 8),
(15, 'Canon IVY REC Digital Camera', 198.49, 8);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `ro_id` int(11) NOT NULL,
  `ro_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`ro_id`, `ro_name`) VALUES
(1, 'Admin'),
(2, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `st_id` varchar(12) NOT NULL,
  `st_username` varchar(45) NOT NULL,
  `st_password` varchar(45) NOT NULL,
  `st_name` varchar(200) DEFAULT NULL,
  `st_email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`st_id`, `st_username`, `st_password`, `st_name`, `st_email`) VALUES
('997', 'Staff997', '58b1216b06850385d9a4eadbedc806c4', 'Staff Test No2', 'test@test.test'),
('998', 'Staff998', '58b1216b06850385d9a4eadbedc806c4', 'Staff Test', 'test@test.test'),
('999', 'Admin999', '58b1216b06850385d9a4eadbedc806c4', 'Admin Test', 'test@test.test');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `su_id` int(11) NOT NULL,
  `su_name` varchar(150) DEFAULT NULL,
  `su_phone` varchar(13) DEFAULT NULL,
  `su_email` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`su_id`, `su_name`, `su_phone`, `su_email`) VALUES
(2, 'Acer Malaysia Inc.', '03-4123 3432', 'malaysia@acer.my'),
(3, 'Dell Malaysia', '03-4234 1231', 'dellmy@dell.com'),
(4, 'AsusTek Computer Inc.', '03-4332 8892', 'asustek@asus.io'),
(5, 'Samsung Malaysia', '03-5442 9922', 'samsungmy@samsung.my'),
(6, 'Toshiba Corporation', '03-5123 9943', 'toshibacorp@toshiba.com'),
(7, 'Panasonic Malaysia Corporation', '03 5991 2300', 'panasoniccorp@panasonic.my'),
(8, 'Canon Inc.', '03-1449 0322', 'canonopticinc@canon.jp');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tr_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `st_id` varchar(12) NOT NULL,
  `tr_qty` int(11) DEFAULT NULL,
  `tr_date` datetime DEFAULT NULL,
  `tr_key_in` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`tr_id`, `prod_id`, `st_id`, `tr_qty`, `tr_date`, `tr_key_in`) VALUES
(1, 5, '998', 1, '2020-12-15 12:57:00', '2020-12-29 18:38:00'),
(4, 3, '998', 1, '2020-12-16 10:08:00', '2020-12-29 18:42:00'),
(5, 6, '998', 1, '2020-12-07 08:44:00', '2020-12-29 18:42:00'),
(6, 1, '998', 5, '2020-11-18 14:09:00', '2020-12-29 19:11:00'),
(7, 4, '998', 2, '2020-12-10 06:36:00', '2020-12-29 18:43:00'),
(9, 2, '998', 4, '2020-12-02 13:16:00', '2020-12-29 18:43:00'),
(10, 3, '997', 2, '2020-11-30 08:55:00', '2020-12-29 18:51:00'),
(11, 1, '997', 4, '2020-12-09 18:51:00', '2020-12-29 18:51:00'),
(12, 10, '997', 2, '2020-12-11 22:42:00', '2020-12-29 19:10:00'),
(13, 13, '997', 2, '2020-11-13 09:13:00', '2020-12-29 19:11:00'),
(14, 12, '997', 1, '2020-11-19 22:14:00', '2020-12-29 19:11:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`lo_id`),
  ADD KEY `fk_login_role_idx` (`ro_id`),
  ADD KEY `fk_login_staff_idx` (`st_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `fk_prod_sup_idx` (`su_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ro_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`su_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`tr_id`),
  ADD KEY `fk_trans_prod_idx` (`prod_id`),
  ADD KEY `fk_trans_staff_idx` (`st_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `ro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `su_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login_role` FOREIGN KEY (`ro_id`) REFERENCES `role` (`ro_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_login_staff` FOREIGN KEY (`st_id`) REFERENCES `staff` (`st_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_prod_sup` FOREIGN KEY (`su_id`) REFERENCES `supplier` (`su_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_trans_prod` FOREIGN KEY (`prod_id`) REFERENCES `product` (`prod_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_trans_staff` FOREIGN KEY (`st_id`) REFERENCES `staff` (`st_id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
