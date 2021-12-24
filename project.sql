-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2021 at 03:07 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(10) UNSIGNED NOT NULL,
  `penalties` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `penalties`) VALUES
(3, 0),
(4, 2),
(5, 1),
(6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `customerID` int(10) UNSIGNED NOT NULL,
  `productID` int(10) UNSIGNED NOT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hrpartner`
--

CREATE TABLE `hrpartner` (
  `id` int(10) UNSIGNED NOT NULL,
  `penaltiesGiven` int(11) DEFAULT NULL,
  `investigationsMade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hrpartner`
--

INSERT INTO `hrpartner` (`id`, `penaltiesGiven`, `investigationsMade`) VALUES
(1, 6, 16),
(2, 8, 12);

-- --------------------------------------------------------

--
-- Table structure for table `investigationrequest`
--

CREATE TABLE `investigationrequest` (
  `id` int(10) UNSIGNED NOT NULL,
  `auditorID` int(10) UNSIGNED NOT NULL,
  `hrID` int(10) UNSIGNED NOT NULL,
  `adminID` int(10) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `senderID` int(10) UNSIGNED NOT NULL,
  `recepientID` int(10) UNSIGNED NOT NULL,
  `messageText` varchar(255) DEFAULT NULL,
  `readStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `id` int(10) UNSIGNED NOT NULL,
  `adminID` int(10) UNSIGNED NOT NULL,
  `hrID` int(10) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penalty`
--

INSERT INTO `penalty` (`id`, `adminID`, `hrID`, `reason`) VALUES
(1, 4, 1, 'Inappropriate langauge'),
(2, 5, 1, 'Unprofessional mannerisms'),
(3, 4, 2, 'Rude to customers');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float(10,2) NOT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `1star` int(11) DEFAULT NULL,
  `2stars` int(11) DEFAULT NULL,
  `3stars` int(11) DEFAULT NULL,
  `4stars` int(11) DEFAULT NULL,
  `5stars` int(11) DEFAULT NULL,
  `numberOfReviews` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `imagePath`, `1star`, `2stars`, `3stars`, `4stars`, `5stars`, `numberOfReviews`, `category`) VALUES
(1, 'Gigabyte A320M-S2H', 'Supports AMD 3rd Gen Ryzen™/ 2nd Gen Ryzen™/ 1st Gen Ryzen™/ Athlon™ with Radeon™ Vega Graphics/ Athlon X4 Processors<br>\nDual Channel Non-ECC Unbuffered DDR4, 2 DIMMs <br>\nUltra-Fast PCIe Gen3 x4 M.2 with PCIe NVMe & SATA mode support <br>\nHigh Quality Audio Capacitors and Audio Noise Guard<br>', 1250.00, 'resources/images/ProductsPictures/Gigabyte A320M-S2H.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(2, 'GIGABYTE B560 AORUS PRO', 'Dual Channel DDR4, 4 DIMMs,Intel 2.5G GbE LAN<br>\n11th Generation Intel® Core™ i9 processors / Intel® Core™ i7 processors / Intel® Core™ i5 processors<br>\n1 x DisplayPort<br>\n1 x HDMI port<br>', 3000.00, 'resources/images/ProductsPictures/GIGABYTE B560 AORUS PRO.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(3, 'Gigabyte X570 AORUS Elite', 'AMD X570 AORUS Motherboard with 12+2 Phases Digital VRM with DrMOS<br>\r\nAdvanced Thermal Design with Enlarge Heatsink, Dual PCIe 4.0 M.2 with Single Thermal Guard<br>\r\nIntel® GbE LAN with cFosSpeed, Front USB Type-C, RGB Fusion 2.0<br>', 4000.00, 'resources/images/ProductsPictures/Gigabyte X570 AORUS Elite.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(4, 'Gigabyte Z390 MASTER', 'Intel Z390 AORUS Motherboard with 12 Phases IR Digital VRM, Fins-Array Heatsink<br>\r\nRGB Fusion 2.0, 802.11ac Wireless, Triple M.2 with Thermal Guards, ESS SABRE HIFI 9118<br>\r\nIntel® GbE LAN with cFosSpeed, Front & Rear USB 3.1 Gen 2 Type-C<br>', 6500.00, 'resources/images/ProductsPictures/Gigabyte Z390 MASTER.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(5, 'MSI A520M PRO', 'AMD A520 Chipset, 2x DDR4 memory slots, support up to 64GB<br>\r\nDual channel memory architecture, Supports non-ECC UDIMM memory<br>\r\nSupports RAID 0, RAID 1 and RAID 10 for SATA storage devices<br>', 1500.00, 'resources/images/ProductsPictures/MSI A520M PRO.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(6, 'MSI B450M Bazooka Plus', 'Lightning Fast Game experience with 1x TURBO M.2, Store MI technology<br>\r\nMSI extended PWM and enhanced circuit design ensures even high-end processors to run in full speed.<br>\r\nCore Boost with premium layout and fully digital power design to support more cores and provide better performance.<br>', 2000.00, 'resources/images/ProductsPictures/MSI B450M Bazooka Plus.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(7, 'MSI MAG Z490 TOMAHAWK', 'Intel® Z490 Chipset<br>\r\n4 x DDR4 memory slots, support up to 128GB<br>\r\n1x USB 3.2 Gen 2 10Gbps Type-A port on the back panel<br>\r\n7x USB 3.2 Gen 1 5Gbps (4 Type-A ports on the back panel<br> \r\n2 ports through the internal USB connector, 1 Type-C internal connector<br>', 4000.00, 'resources/images/ProductsPictures/MSI MAG Z490 TOMAHAWK.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(8, 'MSI MEG X570 ACE', 'Unique infinity and high-class golden design with rich specification.<br>\r\nWin games and set records with 12+2+1 IR digital power, Mystic Light Infinity, Triple Lightning M.2<br>\r\nwith Shield Frozr, Audio Boost HD, Game Boost and dual LAN with 2.5G gaming LAN plus WIFI 6 solution<br>', 7500.00, 'resources/images/ProductsPictures/MSI MEG X570 ACE.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(9, 'ASUS B460M-K', 'Intel® B460 (LGA 1200) mATX motherboard with DDR4 2933MHz, D-sub, DVI<br> \r\nUSB 3.2 Gen 1 ports, Intel® Optane memory ready, SATA 6 Gbps<br>\r\nIntel® LGA 1200 socket Ready for 10th Gen Intel® Core™ processor<br>\r\nComprehensive cooling: PCH heatsink, hybrid fan headers and Fan Xpert<br>\r\nCareful routing of traces and vias to preserve signal integrity for improved memory stability<br>\r\nM.2 support, 1 Gb Ethernet, USB 3.2 Gen 1 Type-A ® and Intel Optane memory ready<br>', 1750.00, 'resources/images/ProductsPictures/ASUS B460M-K.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(10, 'ASUS B560-A', 'Intel® B560 LGA 1200 ATX motherboard with PCIe 4.0, 8+2 teamed power stages<br>\r\nTwo-Way AI Noise Cancelation, WiFi 6 (802.11ax)<br>\r\nRealtek 2.5 Gb Ethernet, two M.2 slots with heatsinks, USB 3.2 Gen 2x2 USB Type-C<br>\r\nSATA and Aura Sync RGB lighting<br>', 4000.00, 'resources/images/ProductsPictures/ASUS B560-A.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(11, 'ASUS PRIME H510M-E', 'Intel® H510 (LGA 1200) micro ATX motherboard with PCIe 4.0, 32Gbps M.2 slot<br>\r\nIntel® 1 Gb Ethernet, DisplayPort, HDMI, D-Sub, USB 3.2 Gen 1 Type A, SATA 6Gbps, COM header, RGB header<br>\r\nIntel® LGA 1200 socket: Ready for 11th and 10th Gen Intel® Processors<br>\r\nUltrafast connectivity: PCIe 4.0, 32Gbps M.2 slot, Intel® 1 Gb Ethernet and USB 3.2 Gen 1 Type-A<br>\r\nComprehensive cooling: PCH heatsink and Fan Xpert<br>\r\n5X Protection III: Multiple hardware safeguards for all-round protection<br>', 1500.00, 'resources/images/ProductsPictures/ASUS PRIME H510M-E.jpg', 0, 0, 0, 0, 0, 0, 'Motherboard'),
(12, 'Kingston HyperX FURY RGB DDR4 16GB', 'HyperX FURY DDR4 RGB delivers a boost of performance ans style with speeds up to 3733MHz<br>\r\naggressive styling and RGB lighting that runs the length of the module for smooth and stunning<br>\r\neffects. This dazzling, cost-effective upgrade is available in 2400MHz-3733MHz speeds<br>\r\nCL15-19 latencies, single module capacities of 4GB-32GB<br>', 2000.00, 'resources/images/ProductsPictures/Kingston HyperX FURY RGB DDR4 16GB.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(13, 'G.skill Trident Z Royal RGB 32GB', 'Trident Z Royal is the latest addition to the Trident Z flagship family and features a crown jewel design<br>\r\nMeticulously crafted to display just the right amount of light refraction<br>\r\nThe patented crystalline light bar scatters the RGB colors in a magnificent display of LED lighting<br>', 5500.00, 'resources/images/ProductsPictures/G.skill Trident Z Royal RGB 32GB.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(14, 'G.SKILL RipjawsV 16GB (2×8) DDR4', 'Memory Type is DDR4<br>\r\nCapacity of 16GB (8GBx2)<br>\r\nMulti-Channel Kit, Dual Channel Kit<br>\r\nTested Speed of 3200MHz<br>\r\nError Checking is Non-ECC<br>\r\nSPD Speed is 2133MHz<br>', 2000.00, 'resources/images/ProductsPictures/G.SKILL RipjawsV 16GB (2×8) DDR4.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(15, 'Team T-Force DELTA RGB 8GB DDR4', 'Full frame 120° ultra wide angle lighting<br>\r\nBuilt-in Force Flow RGB lighting effect<br>\r\nAluminum alloy heat spreader with asymmetric minimalist design<br>\r\nSupports ASUS Aura Sync software synchronization<br>\r\nLatest JEDEC RC 2.0 PCB<br>\r\nEnergy saving 1.2V~1.4V ultra low working voltage<br>\r\nSupports XMP2.0 one-click overclocking technology<br>', 1000.00, 'resources/images/ProductsPictures/Team T-Force DELTA RGB 8GB DDR4.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(16, 'Team T-Force Vulcan Z 8GB DDR4', 'Simple design to perfectly protect the cooling module<br>\r\nHigh thermal conductive adhesive<br>\r\nSupports Intel & AMD motherboards<br>\r\nSelected high-quality IC<br>\r\nSupports XMP2.0<br>\r\nEnergy saving with ultra-low working voltage<br>', 750.00, 'resources/images/ProductsPictures/Team T-Force Vulcan Z 8GB DDR4.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(17, 'Kingston Fury Beast DDR4 16GB', 'Kingston FURY™ Beast DDR4 RGB1 delivers a boost of performance and style with speeds of up to 3733MHz<br>\r\nSingle-module capacities of 8GB–32GB<br>\r\nIt features Plug N Play automatic overclocking at 2666MHz2 and is both Intel® XMP-ready and ready for AMD Ryzen™<br>\r\nCustomise the RGB lighting effects by using Kingston FURY CTRL software and its patented Infrared Sync Technology<br>\r\nFURY Beast DDR4 RGB stays cool with its stylish, low-profile heat spreader<br>', 1600.00, 'resources/images/ProductsPictures/Kingston Fury Beast DDR4 16GB.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(18, 'Gigabyte Aorus RGB 16GB (2×8) DDR4', 'Memory Size of 16GB Kit (2 x 8GB)<br>\r\nFrequency of DDR4-3200 MHz<br>\r\nTiming is 16-18-18-38 (XMP 3200MHz)<br>\r\nVoltage of 1.35V (when XMP enable)<br>\r\nRGB Fusion supported, 100% Sorted & Tested<br>\r\nHigh efficient heat spreaders to keep performance<br>', 2250.00, 'resources/images/ProductsPictures/Gigabyte Aorus RGB 16GB (2×8) DDR4.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(19, 'Crucial Ballistix 16GB (2 x 8GB)', 'Anodized aluminum heat spreader available in black, white, or red<br> \r\nLow-profile form factor is ideal for smaller or space-limited rigs<br>\r\nCrucial Ballistix SODIMM memory is ideal for laptop gamers and performance enthusiasts<br>\r\nAluminum heat spreader included for thermal management in a compact space<br>\r\nWorks with both AMD and Intel<br>', 1500.00, 'resources/images/ProductsPictures/Crucial Ballistix 16GB (2 x 8GB).jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(20, 'Corsair VENGEANCE RGB PRO 16GB DDR4', 'VENGEANCE RGB PRO Series DDR4 overclocked memory lights up your PC with dynamic multi-zone RGB lighting<br>\r\nWhile delivering the best in DDR4 performance<br>\r\nOptimized for peak performance on the latest Intel and AMD DDR4 motherboards<br>\r\nAluminum heat spreader improves thermal conductivity for superb memory cooling even when overclocked<br>', 2500.00, 'resources/images/ProductsPictures/Corsair VENGEANCE RGB PRO 16GB DDR4.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(21, 'Corsair VENGEANCE LPX 8GB DDR4', 'VENGEANCE LPX memory is designed for high-performance overclocking<br>\r\nThe heatspreader is made of pure aluminum for faster heat dssipation<br>\r\nThe custom performance PCB helps manage heat and provides superior overclocking headroom<br>\r\nEach IC is individually screend for peak performance potential<br>', 800.00, 'resources/images/ProductsPictures/Corsair VENGEANCE LPX 8GB DDR4.jpg', 0, 0, 0, 0, 0, 0, 'RAM'),
(22, 'EVGA GeForce RTX 2060 XC 6GB GDDR6', 'The new plate-punched design improves the EVGA baseplate\'s contact with all components and the heatsink<br>\r\nCross-drilled allow air to move more freely through heatsink to remove heat<br>\r\nFeatures real-time ray tracing, NVIDIA G-SYNC compatible with game ready drivers<br>\r\nHas HDMI 2.0b, displayport 1.4 and dual-link DVI<br>', 10500.00, 'resources/images/ProductsPictures/EVGA GeForce RTX 2060 XC 6GB GDDR6.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(23, 'GALAX GeForce RTX 3080 Ti HOF 12GB GDDR6X', 'The brand new 24 phase DrMOS power design, GALAX GeForce RTX™ 3080 Ti HOF,<br>\r\nIt fulfills the extreme power need of the overclocking enthusiast and hardcore gamers<br>\r\nThe aesthetic the GPU has also been redesigned with the approach of diamond cut cooler design with<br>\r\npolygonal elements spanning across the entire graphics card,<br>\r\nAs well as the signature hexagonal LED effect on the front with GALAX latest ARGB controller<br>', 31500.00, 'resources/images/ProductsPictures/GALAX GeForce RTX 3080 Ti HOF 12GB GDDR6X.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(24, 'AORUS GeForce RTX 3060 ELITE 12G', 'GIGABYTE AORUS GeForce RTX 3060 Elite 12G (REV2.0) Graphics Card<br>\r\n3X WINDFORCE Fans, 12GB 192-bit GDDR6<br>\r\nGV-N3060AORUS E-12GD REV2.0 Video Card<br>\r\nNVIDIA Ampere Streaming Multiprocessors, 2nd Generation RT Cores, 3rd Generation Tensor Cores<br>\r\nPowered by GeForce RTX 3060, Integrated with 12GB GDDR6 192-bit memory interface<br>', 14000.00, 'resources/images/ProductsPictures/AORUS GeForce RTX 3060 ELITE 12G.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(25, 'Gigabyte GeForce GTX 1650 Super GAMING OC 4G', 'Powered by GeForce® GTX 1650 SUPER™<br>\r\nNVIDIA Turing™ architecture and GeForce Experience™<br>\r\nIntegrated with 4GB GDDR6 128-bit memory interface<br>\r\nWINDFORCE 2X Cooling System with alternate spinning fans<br>\r\n90 mm unique blade fans with protection Back Plate<br>', 3750.00, 'resources/images/ProductsPictures/Gigabyte GeForce GTX 1650 Super GAMING OC 4G.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(26, 'Gigabyte GeForce GTX 1660 OC 6G', 'Powered by GeForce® GTX 1660<br>\r\nNVIDIA Turing™ architecture and GeForce Experience™<br>\r\nIntegrated with 6GB GDDR5 192-bit memory interface<br>\r\nWINDFORCE 2X Cooling System with alternate spinning fans<br>\r\n90 mm unique blade fans with protection back plate<br>', 4400.00, 'resources/images/ProductsPictures/Gigabyte GeForce GTX 1660 OC 6G.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(27, 'Gigabyte GeForce RTX 3070 EAGLE OC 8G', 'NVIDIA Ampere Streaming Multiprocessors<br>\r\n2nd Generation RT Cores, 3rd Generation Tensor Cores<br>\r\nPowered by GeForce RTX 3070<br>\r\nIntegrated with 8GB GDDR6 256-bit memory interface<br>\r\nWINDFORCE 3X Cooling System with alternate spinning fans<br>\r\nRGB Fusion 2.0, Protection metal back plate<br>\r\n2x DisplayPort 1.4a, 2x HDMI 2.1<br>', 19000.00, 'resources/images/ProductsPictures/Gigabyte GeForce RTX 3070 EAGLE OC 8G.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(28, 'MSI GeForce GT 1030 2G DDR4 LP OC', 'Boost Clock of 1518 MHz<br>\r\nBase Clock of 1265 MHz<br>\r\n2GB GDDR5, 6008 MHz Memory<br>\r\nAluminum core for higher stability<br>\r\nLow profile design saves more spaces<br>\r\nUser can build slim or smaller system easier<br>\r\nAfterburner Overclocking Utility<br>', 2000.00, 'resources/images/ProductsPictures/MSI GeForce GT 1030 2G DDR4 LP OC.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(29, 'MSI GeForce RTX 3060 VENTUS 2X 12G OC', 'RTX™ 3060 lets you take on the latest games using the power of Ampere—NVIDIA\'s 2nd generation RTX architecture<br>\r\nGet incredible performance with enhanced Ray Tracing Cores and Tensor Cores<br>\r\nNew streaming multiprocessors, and high-speed G6 memory<br>', 12500.00, 'resources/images/ProductsPictures/MSI GeForce RTX 3060 VENTUS 2X 12G OC.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(30, 'SAPPHIRE RX 580 NITRO', 'High-polymer, aluminum capacitors offering outstanding reliability<br>\r\nThe all-aluminum backplate provides additional rigidity that guarantees nothing bends and dust stays out<br>\r\nIt also helps cool your card by increasing heat dissipation<br>\r\nWith sleek, elegant contours and unique styling these cards have been designed to suit any build<br>', 3000.00, 'resources/images/ProductsPictures/SAPPHIRE RX 580 NITRO.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(31, 'ZOTAC GeForce GTX 1030 2GB Low Profile', 'The new ZOTAC GeForce® GT 1030, powered by the award-winning NVIDIA Pascal™ architecture accelerates your entire PC experience<br>\r\nIts powerful graphics engine and state-of-the-art technologies provide a performance upgrade to drive today’s most demanding PC applications<br>', 1500.00, 'resources/images/ProductsPictures/ZOTAC GeForce GTX 1030 2GB Low Profile.jpg', 0, 0, 0, 0, 0, 0, 'Graphics Card'),
(32, 'ASUS ROG Strix LC RGB 240 Liquid Cooler', 'ROG Strix LC RGB high-performance CPU liquid coolers are perfect for RGB enthusiasts<br>\r\nThey feature the same closed-loop design as our Strix LC series but with the added benefit of addressable RGB radiator fans<br>\r\n– enabling you to unleash the full potential of your unlocked Intel or AMD CPU,<br>\r\nwhile further accentuating your build with brilliant multi-color lighting effects<br>', 4000.00, 'resources/images/ProductsPictures/ASUS ROG Strix LC RGB 240 Liquid Cooler.jpg', 0, 0, 0, 0, 0, 0, 'Fan'),
(33, 'Cooler Master Hyper T20 CPU Cooler', 'Buckle installation, easy to install and remove; applies for both Intel and AMD systems<br>\r\nQuick disassembling fan stand, easy to install and disassemble high performance<br>\r\nProvides high airflow with low sound<br>\r\nLarge aluminum fin tower to increase the cooling performance<br>\r\nDirect contact to heat pipes for continuous contact between CPU and cooler<br>', 350.00, 'resources/images/ProductsPictures/Cooler Master Hyper T20 CPU Cooler.jpg', 0, 0, 0, 0, 0, 0, 'Fan'),
(34, 'NZXT Kraken X52 240mm AIO RGB CPU Liquid Cooler', 'With an infinity mirror Design, add amazing color and lighting to your CPU cooler for a fully dynamic lighting experience<br>\r\nEngineered to achieve superior cooling while keeping noise levels to a minimum<br>', 3000.00, 'resources/images/ProductsPictures/NZXT Kraken X52 240mm AIO RGB CPU Liquid Cooler.jpg', 0, 0, 0, 0, 0, 0, 'Fan'),
(35, 'Cooler Master MasterLiquid ML240L RGB Cpu Cooler', 'Isolates the heated coolant to maximize the results of the cooling of the processor<br>\r\nRGB function to sync with the system<br>\r\nCustom design low resistance radiator allows higher flow rate, heat exchange efficiency and provides unmatched cooling performance<br>', 1500.00, 'resources/images/ProductsPictures/Cooler Master MasterLiquid ML240L RGB Cpu Cooler.jpg', 0, 0, 0, 0, 0, 0, 'Fan'),
(36, 'GIGABYTE 480GB Sata 2.5 inch SSD', 'Form Factor: 2.5-inch internal SSD<br>\r\nInterface: SATA 6.0Gb/s<br>\r\nTotal Capacity: 480GB<br>\r\nWarranty: Limited 3-years<br>\r\nSequential Read speed : up to 550 MB/s<br>\r\nSequential Write speed : up to 480 MB/s<br>\r\nTRIM & S.M.A.R.T supported<br>', 1000.00, 'resources/images/ProductsPictures/GIGABYTE 480GB Sata 2.5 inch SSD.jpg', 0, 0, 0, 0, 0, 0, 'HDD/SSD'),
(37, 'Lexar NM610 500GB M.2 NVMe SSD', 'High-speed PCIe Gen3x4 interface: 2100MB/s read and 1600MB/s write - NVMe 1. 3 supported<br>\r\nGet 3. 5x the speed of a SATA-based SSD<br>\r\nFeatures LDPC (Low-Density Parity check) and 3D NAND Flash<br>\r\nShock and vibration resistant with no moving parts<br>\r\nThree-year limited product support<br>', 1500.00, 'resources/images/ProductsPictures/Lexar NM610 500GB M.2 NVMe SSD.jpg', 0, 0, 0, 0, 0, 0, 'HDD/SSD'),
(38, 'Patriot Burst 120GB 2.5 inch Sata SSD', '120GB SSD with Phison S11 series controller<br>\r\nSATA III 6GB/s, for increased system responsiveness, lightning fast boot times, and faster overall performance<br>\r\nTrim support, Smart Zip, Low Power Management, Bad Block Management, Static and Dynamic Wear leveling<br>\r\nDRAM cache: 32MB SDR<br>', 500.00, 'resources/images/ProductsPictures/Patriot Burst 120GB 2.5 inch Sata SSD.jpg', 0, 0, 0, 0, 0, 0, 'HDD/SSD'),
(39, 'Seagate Barracuda 2TB 7200 RPM SATA HDD', 'Store more, compute faster, and do it confidently with the proven reliability of BarraCuda internal hard drives<br>\r\nBuild a powerhouse gaming computer or desktop setup with a variety of capacities and form factors<br>\r\nThe go to SATA hard drive solution for nearly every PC application—from music to video to photo editing to PC gaming\r\nConfidently rely on internal hard drive technology backed by 20 years of innovation<br>', 1000.00, 'resources/images/ProductsPictures/Seagate Barracuda 2TB 7200 RPM SATA HDD.jpg', 0, 0, 0, 0, 0, 0, 'HDD/SSD'),
(40, 'Western Digital Blue 4TB 5400 RPM SATA HDD', 'Boost your PC storage with WD Blue drives, the brand designed just for desktop and all-in-one PCs with a variety of storage capacities<br>\r\nGive your desktop a performance and storage boost when you combine your hard drive with an SSD to maximize speed of data access<br>\r\nWD Blue drive for up to 6TB of additional capacity with better technology comes bigger storage needs<br>\r\nDigital cameras that record ultra-high definition video at 4K resolution and 30 frames per second require a ton of storage<br>', 2000.00, 'resources/images/ProductsPictures/Western Digital Blue 4TB 5400 RPM SATA HDD.jpg', 0, 0, 0, 0, 0, 0, 'HDD/SSD'),
(41, 'AMD RYZEN 5 3500X', '6 CPU Cores<br>\r\n6 Threads<br>\r\nMax. Boost Clock Up to 4.1GHz<br>\r\nBase Clock 3.6GHz<br>\r\n384KB L1 Cache<br>\r\n3MB L2 Cache<br>\r\n32MB L3 Cache<br>\r\nDefault TDP 65W<br>', 2500.00, 'resources/images/ProductsPictures/AMD RYZEN 5 3500X.jpg', 0, 0, 0, 0, 0, 0, 'Processor'),
(42, 'AMD RYZEN 3 3100', '4 CPU Cores<br>\r\n8 Threads<br>\r\nMax. Boost Clock Up to 3.9GHz<br>\r\nBase Clock 3.6GHz<br>\r\n256KB L1 Cache<br>\r\n2MB L2 Cache<br>\r\n16MB L3 Cache<br>\r\nDefault TDP 65W<br>', 2000.00, 'resources/images/ProductsPictures/AMD RYZEN 3 3100.jpg', 0, 0, 0, 0, 0, 0, 'Processor'),
(43, 'Intel Pentium Gold G6405', '2 Cores<br>\r\n4 Threads<br>\r\nProcessor Base Frequency 4.10 GHz<br>\r\nCache of 4 MB Intel® Smart Cache<br>\r\nBus Speed 8 GT/s<br>\r\nTDP 58 W<br>', 1500.00, 'resources/images/ProductsPictures/Intel Pentium Gold G6405.jpg', 0, 0, 0, 0, 0, 0, 'Processor'),
(44, 'Intel Core i9-9900K Coffee Lake', '8 Cores<br>\r\n16 Threads<br>\r\nMax Turbo Frequency 5.00 GHz<br>\r\nIntel® Turbo Boost Technology 2.0 Frequency 5.00 GHz<br>\r\nProcessor Base Frequency 3.60 GHz<br>\r\n16 MB Intel® Smart Cache<br>\r\nBus Speed 8 GT/s<br>\r\nTDP 95 W<br>', 8000.00, 'resources/images/ProductsPictures/Intel Core i9-9900K Coffee Lake.jpg', 0, 0, 0, 0, 0, 0, 'Processor'),
(45, 'AMD RYZEN 5 3600X', '6 CPU Cores<br>\r\n12 Threads<br>\r\nMax. Boost Clock Up to 4.4GHz<br>\r\nBase Clock 3.8GHz<br>\r\n384KB L1 Cache<br>\r\n3MB L2 Cache<br>\r\n32MB L3 Cache<br>\r\nDefault TDP 95W<br>', 3750.00, 'resources/images/ProductsPictures/AMD RYZEN 5 3600X.jpg', 0, 0, 0, 0, 0, 0, 'Processor');

-- --------------------------------------------------------

--
-- Table structure for table `productsuggestion`
--

CREATE TABLE `productsuggestion` (
  `id` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `hrID` int(10) UNSIGNED NOT NULL,
  `adminID` int(10) UNSIGNED NOT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `productLink` varchar(255) DEFAULT NULL,
  `productname` varchar(255) DEFAULT NULL,
  `productDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(10) UNSIGNED NOT NULL,
  `productID` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `reviewText` varchar(255) DEFAULT NULL,
  `starRating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` int(10) UNSIGNED NOT NULL,
  `customerID` int(10) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `improvement` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `imagePath` varchar(255) DEFAULT NULL,
  `userType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `address`, `imagePath`, `userType`) VALUES
(1, 'Sarah', 'sarahpass', 'sarah@mail.com', 'Nasr City', 'resources/images/ProfilePictures/hr1.jpg', 'hrpartner'),
(2, 'Hady', 'hadypass', 'hady@mail.com', 'Maadi', 'resources/images/ProfilePictures/hr2.jpg', 'hrpartner'),
(3, 'Dina', 'dinapass', 'dina@mail.com', 'Obour', 'resources/images/ProfilePictures/admin1.jpg', 'administrator'),
(4, 'John', 'johnpass', 'john@mail.com', 'Nasr City', 'resources/images/ProfilePictures/admin2.jpg', 'administrator'),
(5, 'Mona', 'monapass', 'mona@mail.com', '6th of October', 'resources/images/ProfilePictures/admin3.png', 'administrator'),
(6, 'Mohamed', 'mohamedpass', 'mohamed@mail.com', 'Obour', 'resources/images/ProfilePictures/admin4.png', 'administrator'),
(7, 'Arsany', 'arsanypass', 'arsany@mail.com', 'Obour', 'resources/images/ProfilePictures/auditor1.jpg', 'auditor'),
(8, 'Mazen', 'mazenpass', 'mazen@mail.com', 'Nasr City', 'resources/images/ProfilePictures/auditor2.jpg', 'auditor'),
(9, 'Ayman', 'aymanpass', 'ayman@mail.com', 'Maadi', 'resources/images/ProfilePictures/customer1.png', 'customer'),
(10, 'Mostafa', 'mostafapass', 'mostafa@mail.com', 'Nasr City', 'resources/images/ProfilePictures/customer2.png', 'customer'),
(11, 'Laila', 'lailapass', 'laila@mail.com', 'Nasr City', 'resources/images/ProfilePictures/customer3.png', 'customer'),
(12, 'Farida', 'faridapass', 'farida@mail.com', 'Obour', 'resources/images/ProfilePictures/customer4.png', 'customer'),
(13, 'Rahma', 'rahmapass', 'rahma@mail.com', '6th of October', 'resources/images/ProfilePictures/customer5.png', 'customer'),
(14, 'Sayed', 'sayedpass', 'sayed@mail.com', 'Obour', 'resources/images/ProfilePictures/customer6.png', 'customer'),
(15, 'Helmy', 'helmypass', 'helmy@mail.com', 'Maadi', 'resources/images/ProfilePictures/customer7.png', 'customer'),
(16, 'Reem', 'reempass', 'reem@mail.com', 'Nasr City', 'resources/images/ProfilePictures/customer8.png', 'customer'),
(17, 'Wael', 'waelpass', 'wael@mail.com', 'Obour', 'resources/images/ProfilePictures/customer9.png', 'customer'),
(18, 'Khaled', 'khaledpass', 'khaled@mail.com', 'Maadi', 'resources/images/ProfilePictures/customer10.png', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`productID`,`customerID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `hrpartner`
--
ALTER TABLE `hrpartner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investigationrequest`
--
ALTER TABLE `investigationrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auditorID` (`auditorID`),
  ADD KEY `hrID` (`hrID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderID` (`senderID`),
  ADD KEY `recepientID` (`recepientID`);

--
-- Indexes for table `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `hrID` (`hrID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productsuggestion`
--
ALTER TABLE `productsuggestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`,`customerID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `investigationrequest`
--
ALTER TABLE `investigationrequest`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `productsuggestion`
--
ALTER TABLE `productsuggestion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `cartitem_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `hrpartner`
--
ALTER TABLE `hrpartner`
  ADD CONSTRAINT `hrpartner_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `investigationrequest`
--
ALTER TABLE `investigationrequest`
  ADD CONSTRAINT `investigationrequest_ibfk_1` FOREIGN KEY (`auditorID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `investigationrequest_ibfk_2` FOREIGN KEY (`hrID`) REFERENCES `hrpartner` (`id`),
  ADD CONSTRAINT `investigationrequest_ibfk_3` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`senderID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`recepientID`) REFERENCES `users` (`id`);

--
-- Constraints for table `penalty`
--
ALTER TABLE `penalty`
  ADD CONSTRAINT `penalty_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`id`),
  ADD CONSTRAINT `penalty_ibfk_2` FOREIGN KEY (`hrID`) REFERENCES `hrpartner` (`id`);

--
-- Constraints for table `productsuggestion`
--
ALTER TABLE `productsuggestion`
  ADD CONSTRAINT `productsuggestion_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `productsuggestion_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `administrator` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`);

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
