-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 06:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `applyid` int(255) NOT NULL,
  `studid` varchar(255) NOT NULL,
  `studname` varchar(255) NOT NULL,
  `sem` int(10) NOT NULL,
  `apply_date` date NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apply`
--

INSERT INTO `apply` (`applyid`, `studid`, `studname`, `sem`, `apply_date`, `filename`, `filepath`, `status`) VALUES
(1041, 'AM2211012861', 'Aisyah Ahmad', 1, '2024-09-06', '673cd7984e6c7_Letter Of Permission.pdf', 'apply/673cd7984e6c7_Letter Of Permission.pdf', 'Approved'),
(1042, 'AM2211012862', 'Nurul Hana', 2, '2024-09-06', '673cd81f07b92_Letter Of Permission.pdf', 'apply/673cd81f07b92_Letter Of Permission.pdf', 'Approved'),
(1043, 'AM2211012863', 'Siti Khadijah', 3, '2024-09-10', '673cd8d245492_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cd8d245492_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1044, 'AM2312039876', 'Fatimah Zain', 4, '2024-09-06', '673cd97c55081_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cd97c55081_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1045, 'AM2411046732', 'Aina Safiyah	', 5, '2024-09-09', '673cda12ef490_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cda12ef490_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1046, 'AM2211056789', 'Nor Hidayah', 1, '2024-09-06', '673cdac36c7b3_Letter Of Permission.pdf', 'apply/673cdac36c7b3_Letter Of Permission.pdf', 'Approved'),
(1047, 'AM2312067890', 'Yasmin Amira Binti Zahid	', 2, '2024-09-10', '673cdb6de413a_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cdb6de413a_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1048, 'AM2213087654', 'Khairunnisa Binti Abdul Samad', 3, '2024-09-09', '673cdbfdf19cd_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cdbfdf19cd_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1049, 'AM2411071234', 'Aisyah Sofia', 4, '2024-09-08', '673cdc5d33bed_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cdc5d33bed_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1050, 'AM2313027896', 'Liyana Suraya', 1, '2024-09-15', '673cddca7f26e_Letter Of Permission.pdf', 'apply/673cddca7f26e_Letter Of Permission.pdf', 'Approved'),
(1051, 'AM2412034567', 'Adila Nazirah', 2, '2024-09-09', '673cde4d49c8c_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cde4d49c8c_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1052, 'AM2315072345', 'Balqis Hamidah	', 3, '2024-09-09', '673cdedf23d06_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cdedf23d06_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1053, 'AM2413058765', 'Hana Sofea	', 4, '2024-09-09', '673cdf3ccd591_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cdf3ccd591_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1054, 'AM2312036547', 'Farah Adibah', 5, '2024-09-11', '673cdf8709980_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673cdf8709980_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1055, 'AM2411045678', 'Nur Syafira Binti Mohamad', 1, '2024-09-07', '673ce008e5517_Letter Of Permission.pdf', 'apply/673ce008e5517_Letter Of Permission.pdf', 'Approved'),
(1056, 'AM2313078901', 'Amalina Aqilah	', 2, '2024-09-22', '673ce07984e28_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce07984e28_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1057, 'AM2312093456', 'Maisarah Izzati	', 3, '2024-09-10', '673ce0c08764e_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce0c08764e_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1058, 'AM2411021234', 'Nadhirah Anis', 4, '2024-09-11', '673ce125d1835_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce125d1835_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1059, 'AM2314037895', 'Siti Sarah	', 5, '2024-09-09', '673ce2177254d_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce2177254d_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1060, 'AM2415098765', 'Diyana Farhana	', 1, '2024-09-09', '673ce2589142f_Letter Of Permission.pdf', 'apply/673ce2589142f_Letter Of Permission.pdf', 'pending'),
(1061, 'AM2314015678', 'Jannah Ilhami	', 2, '2024-09-09', '673ce2a7c19e7_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce2a7c19e7_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1062, 'AM2312072345', 'Alia Nazneen	', 3, '2024-09-06', '673ce2f145ac4_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce2f145ac4_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1063, 'AM2413049876', 'Nabila Damia', 4, '2024-09-04', '673ce3312a714_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce3312a714_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1064, 'AM2413049876', 'Nadira Azra', 5, '2024-09-05', '673ce372c68cd_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce372c68cd_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1065, 'AM2311091234', 'Hanim Athirah', 1, '2024-09-17', '673ce3ae190db_Letter Of Permission.pdf', 'apply/673ce3ae190db_Letter Of Permission.pdf', 'pending'),
(1066, 'AM2313086543', 'Safiyya Naim', 2, '2024-10-04', '673ce40e2a32c_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce40e2a32c_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1067, 'AM2411022345', 'Nursyaza Balqis', 3, '2024-09-06', '673ce44f7b2c1_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce44f7b2c1_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1068, 'AM2415067890', 'Syafiah Ainul', 4, '2024-09-06', '673ce4a3a5371_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce4a3a5371_MENTOR SUPPORTING DOCUMENT.pdf', 'pending'),
(1069, 'AM2313035678', 'Arina Hayati', 5, '2024-09-06', '673ce4e1ab399_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673ce4e1ab399_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1070, 'AM2211101234', 'FARAH NADIA', 2, '2024-09-10', '673d5e7ae0fd4_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673d5e7ae0fd4_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved'),
(1071, 'AM2412038765', 'Sarah Khaleeda', 3, '2024-11-06', '673de7d09d404_MENTOR SUPPORTING DOCUMENT.pdf', 'apply/673de7d09d404_MENTOR SUPPORTING DOCUMENT.pdf', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `bookingid` int(255) NOT NULL,
  `studid` varchar(255) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`bookingid`, `studid`, `room_id`, `booking_date`) VALUES
(2026, 'AM2211101234', 6001, '2024-10-13'),
(2027, 'AM2211012861', 7001, '2024-11-01'),
(2028, 'AM2211012862', 7001, '2024-11-20'),
(2029, 'AM2211012863', 6001, '2024-11-20'),
(2030, 'AM2312039876', 6004, '2024-11-20'),
(2031, 'AM2211056789', 8001, '2024-11-20'),
(2032, 'AM2312067890', 8001, '2024-11-20'),
(2033, 'AM2213087654', 8001, '2024-11-20'),
(2034, 'AM2313027896', 8001, '2024-11-20'),
(2035, 'AM2312036547', 8001, '2024-11-20'),
(2036, 'AM2411045678', 8001, '2024-11-20'),
(2037, 'AM2313035678', 8001, '2024-11-20'),
(2038, 'AM2411046732', 8001, '2024-11-20'),
(2039, 'AM2315072345', 8001, '2024-11-20'),
(2040, 'AM2314037895', 8001, '2024-11-20'),
(2041, 'AM2411071234', 8001, '2024-11-20'),
(2043, 'AM2413058765', 6001, '2024-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `checkedout`
--

CREATE TABLE `checkedout` (
  `checkout_id` int(255) NOT NULL,
  `studid` varchar(255) NOT NULL,
  `bookingid` int(255) NOT NULL,
  `return_key` date NOT NULL,
  `checkedout_date` date NOT NULL,
  `checkout_reason` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkedout`
--

INSERT INTO `checkedout` (`checkout_id`, `studid`, `bookingid`, `return_key`, `checkedout_date`, `checkout_reason`, `filename`, `filepath`) VALUES
(3, 'AM2211101234', 2026, '2024-11-20', '2024-11-20', 'Withdraw', 'key.jpg', 'checkout/key.jpg'),
(4, 'AM2314037895', 2040, '2024-11-20', '2024-11-20', 'Withdraw', 'key.jpg', 'checkout/key.jpg'),
(5, 'AM2411071234', 2041, '2024-11-14', '2024-11-20', 'End of Semester', 'key.jpg', 'checkout/key.jpg'),
(6, 'AM2413058765', 2043, '2024-11-21', '2024-11-21', 'End of Semester', 'key.jpg', 'checkout/key.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `registerid` int(255) NOT NULL,
  `studid` varchar(255) NOT NULL,
  `agreement` varchar(255) NOT NULL,
  `booking_id` int(255) NOT NULL,
  `acknowledge` varchar(255) NOT NULL,
  `register_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`registerid`, `studid`, `agreement`, `booking_id`, `acknowledge`, `register_date`) VALUES
(7, 'AM2211101234', 'true', 2026, 'true', '2024-11-05'),
(8, 'AM2211012861', 'true', 2027, 'true', '2024-11-20'),
(9, 'AM2211012862', 'true', 2028, 'true', '2024-11-20'),
(10, 'AM2312039876', 'true', 2030, 'true', '2024-11-20'),
(11, 'AM2211056789', 'true', 2031, 'true', '2024-11-20'),
(12, 'AM2312067890', 'true', 2032, 'true', '2024-11-20'),
(13, 'AM2213087654', 'true', 2033, 'true', '2024-11-20'),
(14, 'AM2313027896', 'true', 2034, 'true', '2024-11-20'),
(15, 'AM2312036547', 'true', 2035, 'true', '2024-11-20'),
(16, 'AM2411045678', 'true', 2036, 'true', '2024-11-20'),
(17, 'AM2313035678', 'true', 2037, 'true', '2024-11-20'),
(18, 'AM2411046732', 'true', 2038, 'true', '2024-11-20'),
(19, 'AM2315072345', 'true', 2039, 'true', '2024-11-20'),
(20, 'AM2314037895', 'true', 2040, 'true', '2024-11-20'),
(21, 'AM2411071234', 'true', 2041, 'true', '2024-11-20'),
(22, 'AM2413058765', 'true', 2043, 'true', '2024-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room` varchar(20) NOT NULL,
  `floor` int(10) NOT NULL,
  `capacity` int(10) NOT NULL DEFAULT 10,
  `current_occupancy` int(11) NOT NULL,
  `status` enum('available','booked','maintenance','') NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room`, `floor`, `capacity`, `current_occupancy`, `status`) VALUES
(6001, '11-1-1', 1, 10, 1, 'available'),
(6002, '11-1-2', 1, 10, 0, 'maintenance'),
(6003, '11-1-3', 1, 10, 0, 'maintenance'),
(6004, '11-1-4', 1, 10, 1, 'available'),
(6005, '11-1-5', 1, 10, 0, 'available'),
(6006, '11-1-6', 1, 10, 0, 'available'),
(6007, '11-1-7', 1, 10, 0, 'available'),
(6008, '11-1-8', 1, 10, 0, 'available'),
(6009, '11-1-9', 1, 10, 0, 'available'),
(6010, '11-1-10', 1, 10, 0, 'available'),
(6011, '11-1-11', 1, 10, 0, 'available'),
(6012, '11-1-12', 1, 10, 0, 'available'),
(6013, '11-1-13', 1, 10, 0, 'available'),
(6014, '11-1-14', 1, 10, 0, 'available'),
(7001, '11-2-1', 2, 10, 2, 'available'),
(7002, '11-2-2', 2, 10, 0, 'available'),
(7003, '11-2-3', 2, 10, 0, 'available'),
(7004, '11-2-4', 2, 10, 0, 'available'),
(7005, '11-2-5', 2, 10, 0, 'available'),
(7006, '11-2-6', 2, 10, 0, 'available'),
(7007, '11-2-7', 2, 10, 0, 'available'),
(7008, '11-2-8', 2, 10, 0, 'available'),
(7009, '11-2-9', 2, 10, 0, 'available'),
(7010, '11-2-10', 2, 10, 0, 'available'),
(7011, '11-2-11', 2, 10, 0, 'available'),
(7012, '11-2-12', 2, 10, 0, 'available'),
(7013, '11-2-13', 2, 10, 0, 'available'),
(7014, '11-2-14', 2, 10, 0, 'available'),
(8001, '11-3-1', 3, 10, 10, 'booked'),
(8002, '11-3-2', 3, 10, 0, 'available'),
(8003, '11-3-3', 3, 10, 0, 'available'),
(8004, '11-3-4', 3, 10, 0, 'available'),
(8005, '11-3-5', 3, 10, 0, 'available'),
(8006, '11-3-6', 3, 10, 0, 'available'),
(8007, '11-3-7', 3, 10, 0, 'available'),
(8008, '11-3-8', 3, 10, 0, 'available'),
(8009, '11-3-9', 3, 10, 0, 'available'),
(8010, '11-3-10', 3, 10, 0, 'available'),
(8011, '11-3-11', 3, 10, 0, 'available'),
(8012, '11-3-12', 3, 10, 0, 'available'),
(8013, '11-3-13', 3, 10, 0, 'available'),
(8014, '11-3-14', 3, 10, 0, 'available'),
(9001, '11-4-1', 4, 10, 0, 'available'),
(9002, '11-4-2', 4, 10, 0, 'available'),
(9003, '11-4-3', 4, 10, 0, 'available'),
(9004, '11-4-4', 4, 10, 0, 'available'),
(9005, '11-4-5', 4, 10, 0, 'available'),
(9006, '11-4-6', 4, 10, 0, 'available'),
(9007, '11-4-7', 4, 10, 0, 'available'),
(9008, '11-4-8', 4, 10, 0, 'available'),
(9009, '11-4-9', 4, 10, 0, 'maintenance'),
(9010, '11-4-10', 4, 10, 0, 'maintenance'),
(9011, '11-4-11', 4, 10, 0, 'maintenance'),
(9012, '11-4-12', 4, 10, 0, 'maintenance'),
(9013, '11-4-13', 4, 10, 0, 'maintenance'),
(9014, '11-4-14', 4, 10, 0, 'maintenance');

--
-- Triggers `room`
--
DELIMITER $$
CREATE TRIGGER `update_room_status` BEFORE UPDATE ON `room` FOR EACH ROW BEGIN
    -- Check the occupancy and capacity before the update
    IF NEW.current_occupancy >= NEW.capacity THEN
        -- If the room is full, set the status to 'booked'
        SET NEW.status = 'booked';
    ELSE
        -- If the room is not full, set the status to 'available'
        SET NEW.status = 'available';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffid` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffid`, `mail`, `pass`) VALUES
('admin', 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studid` varchar(100) NOT NULL,
  `studname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `noic` varchar(12) NOT NULL,
  `nophone` varchar(12) NOT NULL,
  `sem` int(10) NOT NULL,
  `sponsorship` varchar(255) NOT NULL,
  `parentsno` varchar(12) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studid`, `studname`, `mail`, `pass`, `program`, `noic`, `nophone`, `sem`, `sponsorship`, `parentsno`, `status`) VALUES
('AM2211012861', 'Aisyah Ahmad', 'aisyah.ahmad@student.edu.my', 'pass1234', 'BK201', '990101145678', '0123456789', 1, 'PTPTN', '0191234567', 'registered'),
('AM2211012862', 'Nurul Hana	', 'nurul.hana@student.edu.my', 'pass5678', 'AB202', '030202235678', '0123456789', 2, 'MARA', '0191234567', 'registered'),
('AM2211012863', '', 'siti.khadijah@student.edu.my', 'pass9012', '', '', '', 0, '', '', ''),
('AM2211056789', 'Nor Hidayah', 'nor.hidayah@student.edu.my', 'pass1111', 'AB201', '981011665678', '0102233445', 1, 'MARA', '0187654321', 'registered'),
('AM2211101234', 'FARAH NADIAH', 'farah.nadia@student.edu.my', 'pass1234', 'BK201', '980205235678', '0136677889', 2, 'MARA', '0125566777', 'checked out'),
('AM2213087654', 'Khairunnisa Binti Abdul Samad', 'khairunnisa@student.edu.my', 'pass3333', 'CM201', '960806495678', '0165544332', 3, 'MARA', '0179988776', 'registered'),
('AM2310045678', '', 'aqilah.izzati@student.edu.my', 'pass1234', '', '', '', 0, '', '', ''),
('AM2311091234', '', 'hanim.athirah@student.edu.my', 'pass1415', '', '', '', 0, '', '', ''),
('AM2312036547', 'Farah Adibah', 'farah.adibah@student.edu.my', 'pass1010', 'AA103', '950401535678', '0111122334', 5, 'MARA', '0168877665', 'registered'),
('AM2312039876', 'Fatimah Zain	', 'fatimah.zain@student.edu.my', 'pass3456', 'CM201', '040405445678', '0123456789', 4, 'NONE', '0123456789', 'registered'),
('AM2312058765', '', 'nadira.azra@student.edu.my', 'pass1213', '', '', '', 0, '', '', ''),
('AM2312067890', 'Yasmin Amira Binti Zahid', 'yasmin.amira@student.edu.my', 'pass2222', 'AB202', '970907875678', '0175544332', 2, 'NONE', '0132211223', 'registered'),
('AM2312072345', '', 'alia.nazneen@student.edu.my', 'pass9090', '', '', '', 0, '', '', ''),
('AM2312093456', '', 'maisarah.izzati@student.edu.my', 'pass4040', '', '', '', 0, '', '', ''),
('AM2313027896', 'Liyana Suraya', 'liyana.suraya@student.edu.my', 'pass6666', 'BE201', '991202115678', '0142233445', 1, 'MARA', '0145566777', 'registered'),
('AM2313035678', 'Arina Hayati	', 'arina.hayati@student.edu.my', 'pass2223', 'CT206', '020805345678', '0121234567', 5, 'MARA', '0177766554', 'registered'),
('AM2313078901', '', 'amalina.aqilah@student.edu.my', 'pass3030', '', '', '', 0, '', '', ''),
('AM2313086543', '', 'safiyya.naim@student.edu.my', 'pass1617	', '', '', '', 0, '', '', ''),
('AM2314015678', '', 'jannah.ilhami@student.edu.my', 'pass8080', '', '', '', 0, '', '', ''),
('AM2314037895', 'Siti Sarah', 'siti.sarah@student.edu.my', 'pass6060', 'AB202', '990603015678', '0191122334', 5, 'PTPTN', '0185566777', 'checked out'),
('AM2314096543', '', 'zahra.azmin@student.edu.my', 'pass5555', '', '', '', 0, '', '', ''),
('AM2315072345', 'Balqis Hamidah', 'balqis.hamidah@student.edu.my', 'pass8888', 'BK201', '000610765678', '0101234567', 3, 'PTPTN', '0198765432', 'registered'),
('AM2411021234', '', 'nadhirah.anis@student.edu.my', 'pass5050', '', '', '', 0, '', '', ''),
('AM2411022345', '', 'nursyaza.balqis@student.edu.my', 'pass1819', '', '', '', 0, '', '', ''),
('AM2411024567', '', 'hani.syuhada@student.edu.my', 'pass1111	', '', '', '', 0, '', '', ''),
('AM2411045678', 'Nur Syafira	', 'nur.syafira@student.edu.my', 'pass2020', 'CM201', '940307445678', '0193344556', 1, 'MARA', '0175566777', 'registered'),
('AM2411046732', 'Aina Safiyah', 'aina.safiyah@student.edu.my', 'pass7890', 'AB201', '050507545678', '0120987654', 5, 'MARA', '0198765432', 'registered'),
('AM2411071234', 'Aisyah Sofia	', 'aisyah.sofia@student.edu.my', 'pass4444', 'AC201', '950705315678', '0123344556', 4, 'PTPTN', '0192760423', 'checked out'),
('AM2412034567', '', 'adila.nazirah@student.edu.my', 'pass7777', '', '', '', 0, '', '', ''),
('AM2412038765', '', 'sarah.khaleeda@student.edu.my', 'pass1234', '', '', '', 0, '', '', ''),
('AM2413049876', '', 'nabila.damia@student.edu.my', 'pass1112', '', '', '', 0, '', '', ''),
('AM2413058765', 'Hana Sofea', 'hana.sofea@student.edu.my', 'pass9999', 'BK201', '950705315678', '0123344556', 4, 'PTPTN', '0192760423', 'checked out'),
('AM2415067890', '', 'syafiah.ainul@student.edu.my', 'pass2021', '', '', '', 0, '', '', ''),
('AM2415098765', '', 'diyana.farhana@student.edu.my', 'pass7070', '', '', '', 0, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`applyid`),
  ADD KEY `apply` (`studid`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`bookingid`),
  ADD KEY `booking` (`studid`),
  ADD KEY `available` (`room_id`);

--
-- Indexes for table `checkedout`
--
ALTER TABLE `checkedout`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `checkedout` (`studid`),
  ADD KEY `bookroom` (`bookingid`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`registerid`),
  ADD KEY `register` (`studid`),
  ADD KEY `booked` (`booking_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apply`
--
ALTER TABLE `apply`
  MODIFY `applyid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1073;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `bookingid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2044;

--
-- AUTO_INCREMENT for table `checkedout`
--
ALTER TABLE `checkedout`
  MODIFY `checkout_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `registerid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9016;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply`
--
ALTER TABLE `apply`
  ADD CONSTRAINT `apply` FOREIGN KEY (`studid`) REFERENCES `student` (`studid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `available` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking` FOREIGN KEY (`studid`) REFERENCES `student` (`studid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkedout`
--
ALTER TABLE `checkedout`
  ADD CONSTRAINT `bookroom` FOREIGN KEY (`bookingid`) REFERENCES `booking` (`bookingid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `checkedout` FOREIGN KEY (`studid`) REFERENCES `student` (`studid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `booked` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`bookingid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `register` FOREIGN KEY (`studid`) REFERENCES `student` (`studid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
