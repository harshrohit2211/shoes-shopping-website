-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2026 at 08:28 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoe_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `description` text COLLATE utf8_german2_ci,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Men Shoes', 'Shoes for men'),
(2, 'Women Shoes', 'Shoes for men'),
(3, 'kids Shoes', 'Shoes for kids');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `message` text COLLATE utf8_german2_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`contact_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`contact_id`, `name`, `email`, `message`, `created_at`) VALUES
(4, 'shainy', 'shainyjadav@gmail.com', 'superb', '2026-03-12 13:37:51');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) COLLATE utf8_german2_ci DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(78, 3, '2026-03-11 18:05:57', '3609.10', 'Processing'),
(77, 3, '2026-03-11 10:30:54', '4009.00', 'Processing'),
(76, 3, '2026-03-10 11:46:52', '2609.00', 'Cancelled'),
(75, 3, '2026-03-10 10:02:52', '7209.10', 'Processing'),
(74, 3, '2026-03-06 15:04:05', '7209.10', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `orderdetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `size` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`orderdetail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`orderdetail_id`, `order_id`, `product_id`, `color`, `size`, `price`, `quantity`, `subtotal`) VALUES
(56, 78, 29, 'Black Patent', '5.5', '3999.00', 1, '3999.00'),
(54, 77, 21, 'Light brown', '6', '3999.00', 1, '3999.00'),
(53, 76, 20, 'Dark brown', '7.5', '2599.00', 1, '2599.00'),
(52, 75, 2, 'Dark Myrtle-Maple Syrup', '6', '7999.00', 1, '7999.00'),
(51, 74, 2, 'Dark Myrtle-Maple Syrup', '6', '7999.00', 1, '7999.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `description` text COLLATE utf8_german2_ci,
  `price` decimal(10,2) NOT NULL,
  `discount` int(3) DEFAULT '0',
  `stock` int(11) NOT NULL,
  `color` varchar(50) COLLATE utf8_german2_ci DEFAULT NULL,
  `size` varchar(50) COLLATE utf8_german2_ci DEFAULT NULL,
  `shoe_type` varchar(50) COLLATE utf8_german2_ci NOT NULL,
  `image1` varchar(255) COLLATE utf8_german2_ci NOT NULL,
  `image2` varchar(255) COLLATE utf8_german2_ci DEFAULT NULL,
  `image3` varchar(255) COLLATE utf8_german2_ci DEFAULT NULL,
  `image4` varchar(255) COLLATE utf8_german2_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `discount`, `stock`, `color`, `size`, `shoe_type`, `image1`, `image2`, `image3`, `image4`, `category_id`) VALUES
(1, 'Smashic Comfort Casual Sneakers', 'PRODUCT STORY\r\nStep up your sneaker game with the Smashic Sneakers from PUMA. The PUMA formstrip adds a touch of style, while the Softfoam sockliner ensures maximum comfort. The rubber outsole provides superior traction, making these sneakers perfect for any occasion.', '4499.00', 55, 20, 'black,white', '6,7,8,9,', 'Casual', '1772694012_Screenshot_5-3-2026_122221_in.puma.com.jpeg', 'Screenshot_5-3-2026_122240_in.puma.com.jpeg', 'Screenshot_5-3-2026_122326_in.puma.com.jpeg', 'Screenshot_5-3-2026_122341_in.puma.com.jpeg', 1),
(20, 'Derby shoes', 'Description & fit\r\nDerby shoes with open lacing at the front. Canvas linings and soles that are patterned underneath.', '2599.00', 0, 5, 'Dark brown,Black', '7.5,8.9.5,10', 'Partywear', 'Screenshot_10-3-2026_11738_www2.hm.com.jpeg', 'Screenshot_10-3-2026_1181_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111042_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111056_www2.hm.com.jpeg', 1),
(21, 'Loafers', 'Description & fit\r\nLoafers with a soft, napped finish featuring a moccasin seam at the front. Cotton canvas linings and insoles, and soles that are fluted underneath.', '3999.00', 0, 10, 'Light brown,Navy blue', '6,7,8,9,', 'Partywear', '1773121600_Screenshot_10-3-2026_111631_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111326_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111512_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111527_www2.hm.com.jpeg', 1),
(3, 'Smash Pop Men\'s Sneakers', 'Description\r\nThe PUMA Smash Pop Sneakers bring modernity and timelessness to the table in equal measure. Inspired by tennis, the clean court silhouette features a vulcanised look at the sole, while the classic derby eyelet stay works with the iconic PUMA Formstrip to turn heads. PUMA\'s classic logos at the tongue and side serve you powerful branding and iconic energy. A sportstyle must-have, this classy sneaker exudes fresh charm.\r\n\r\nColor: PUMA White-Archive Green-PUMA Black\r\n\r\nPRODUCT STORY\r\nThe PUMA Smash Pop Sneakers bring modernity and timelessness to the table in equal measure. Inspired by tennis, the clean court silhouette features a vulcanised look at the sole, while the classic derby eyelet stay works with the iconic PUMA Formstrip to turn heads. PUMA\'s classic logos at the tongue and side serve you powerful branding and iconic energy. A sportstyle must-have, this classy sneaker exudes fresh charm.\r\n\r\nFEATURES & BENEFITS\r\nSoftFoam+: PUMA\'s comfort sockliner for instant step-in and long-lasting comfort that provides soft cushioning every step of your day\r\nDETAILS\r\nLow boot construction\r\nLace closure\r\nHeel type: Flat\r\nShoe width: Regular fit\r\nShoe pronation: Neutral\r\nHeel-to-toe-drop: 0 mm\r\nSynthetic upper\r\nEVA outsole\r\nPUMA Formstrip on side\r\nPUMA wordmark at tongue\r\n', '1235.00', 10, 23, 'White-Archive Green-PUMA Black', '6,7,8,9,', 'Casual', 'Screenshot_6-3-2026_114345_in.puma.com.jpeg', '1772777794_Screenshot_6-3-2026_114536_in.puma.com.jpeg', '1772777794_Screenshot_6-3-2026_114555_in.puma.com.jpeg', '1772777794_Screenshot_6-3-2026_114610_in.puma.com.jpeg', 1),
(14, 'CLOUDFOAM CUXXION SOCK SHOES', 'Comfortable and durable slip-on shoes with Cloudfoam cushioning.\r\nThe Cloudfoam Cuxxion Sock Shoes are designed for those who embrace a casual street style and are looking for a great blend of functionality and aesthetics.\r\n\r\nThe Cloudfoam technology in the midsole provides enhanced durability and cushioning from step-in to stride, making them well-suited for your daily walks.\r\n\r\nIn addition, the ADIWEAR outsole provides the ultimate in high-wear durability.\r\n\r\nThe elastic sock upper construction offers an adaptive fit, moulding to your foot for personalised comfort. With a laceless design, slipping these shoes on and off is very easy. Furthermore, the engineered knit ensures breathability, helping keep your feet comfortable throughout the day.\r\n\r\nWhether you\'re running errands or enjoying a leisurely stroll, these adidas shoes are designed to support your active lifestyle.', '3000.00', 10, 25, 'Charcoal / Carbon / Lucid Orange', '6,7,8,9,10,11,12', 'Sports', 'Screenshot_10-3-2026_103056_www.adidas.co.in.jpeg', 'Screenshot_10-3-2026_103115_www.adidas.co.in.jpeg', 'Screenshot_10-3-2026_103130_www.adidas.co.in.jpeg', 'Screenshot_10-3-2026_103143_www.adidas.co.in.jpeg', 1),
(15, 'Nike Journey Run', 'Enjoy every step, route and jaunt in the Nike Journey Run. It\'ll have you striding and smiling on punishing pavements, thanks to an extra-high foam stack and super-soft ComfyRide cushioning. It\'s so comfortable that you\'ll already be looking forward to lacing \'em up again.\r\nColour Shown: Black|Anthracite|White\r\nStyle: FN0228-001', '3999.00', 10, 25, 'Black|Anthracite|White', '6,7,8,9,10', 'Sports', 'Screenshot_10-3-2026_103918_www.nike.in.jpeg', 'Screenshot_10-3-2026_103933_www.nike.in.jpeg', 'Screenshot_10-3-2026_104027_www.nike.in.jpeg', 'Screenshot_10-3-2026_104041_www.nike.in.jpeg', 1),
(16, 'Nike Free Metcon 6', 'From power lifts to ladders, from grass blades to grainy platforms, from the turf to the track, your workout has a certain purpose, a specific focus. The Free Metcon 6 supports every grunt, growl and \"got it!\" We added even more forefoot flexibility to our most adaptable trainer and reinforced the heel with extra foam. That means more freedom for dynamic movements during plyos and cardio classes, plus the stable base you need for weights.\r\nColour Shown: Wolf Grey|Photon Dust|Black|White\r\nStyle: FJ7127-009', '2999.00', 10, 25, 'Grey|Photon Dust|Black|White', '6,7,8,9', 'Sports', 'Screenshot_10-3-2026_104616_www.nike.in.jpeg', 'Screenshot_10-3-2026_104633_www.nike.in.jpeg', 'Screenshot_10-3-2026_104646_www.nike.in.jpeg', 'Screenshot_10-3-2026_104712_www.nike.in.jpeg', 1),
(17, 'Nike Air Max Alpha Trainer 6', 'From power lifts to ladders, from grass blades to grainy platforms, from the turf to the track, your workout has a certain purpose, a specific focus. The Free Metcon 6 supports every grunt, growl and \"got it!\" We added even more forefoot flexibility to our most adaptable trainer and reinforced the heel with extra foam. That means more freedom for dynamic movements during plyos and cardio classes, plus the stable base you need for weights.\r\nColour Shown: Wolf Grey|Photon Dust|Black|White\r\nStyle: FJ7127-009', '2999.00', 10, 25, 'Grey|Photon Dust|Black|White', '6,7,8,9,10', 'Sports', 'Screenshot_10-3-2026_104942_www.nike.in.jpeg', 'Screenshot_10-3-2026_104954_www.nike.in.jpeg', 'Screenshot_10-3-2026_10503_www.nike.in.jpeg', 'Screenshot_10-3-2026_105016_www.nike.in.jpeg', 1),
(18, 'Air Jordan 1 Low', 'Inspired by the original that debuted in 1985, the Air Jordan 1 Low offers a clean, classic look that\'s familiar yet always fresh. With an iconic design that pairs perfectly with any \'fit, these kicks ensure you\'ll always be on point.\r\nColour Shown: White\r\nStyle: 553558-136', '4999.00', 10, 10, 'White', '6,7,8,9', 'Casual', 'Screenshot_10-3-2026_105545_www.nike.in.jpeg', 'Screenshot_10-3-2026_105556_www.nike.in.jpeg', 'Screenshot_10-3-2026_105612_www.nike.in.jpeg', 'Screenshot_10-3-2026_105625_www.nike.in.jpeg', 1),
(19, 'Nike Dunk Low Retro SE', 'You can always count on a classic. This special-edition Dunk Low features a monochromatic suede upper and matching outsole for a clean look. And like all Dunks, it has plush padding for game-changing comfort that lasts.\r\nColour Shown: Cave Stone\r\nStyle: IB6651-200', '4999.00', 10, 15, 'Cave Stone', '6,7,8,9,', 'Casual', 'Screenshot_10-3-2026_105947_www.nike.in.jpeg', 'Screenshot_10-3-2026_105959_www.nike.in.jpeg', 'Screenshot_10-3-2026_11011_www.nike.in.jpeg', 'Screenshot_10-3-2026_11029_www.nike.in.jpeg', 1),
(22, 'Chelsea boots', 'Description & fit\r\nChelsea boots with a soft, napped finish. Elastic gores in the sides, a loop at the back and cotton canvas linings and insoles. Patterned soles.', '2999.00', 0, 10, 'Black,Dark brown', '6,7,8,9,', 'Partywear', 'Screenshot_10-3-2026_11184_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111818_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111834_www2.hm.com.jpeg', 'Screenshot_10-3-2026_111846_www2.hm.com.jpeg', 1),
(23, 'BIRKENSTOCK Boston Soft Footbed', 'The BIRKENSTOCK Boston clog is a veritable classic that can easily be worn all year round. With its additional foam layer, the soft footbed offers extra comfort and pampers feet all day long. Its natural design is down to the upper made from especially soft suede, which hugs the foot like a second skin.', '7999.00', 0, 3, 'Beige Beige/Taupe', '7.5,8.5,9.5', 'Formal', 'Screenshot_10-3-2026_112440_www.birkenstock.in.jpeg', 'Screenshot_10-3-2026_112529_www.birkenstock.in.jpeg', 'Screenshot_10-3-2026_112550_www.birkenstock.in.jpeg', 'Screenshot_10-3-2026_112618_www.birkenstock.in.jpeg', 1),
(24, 'Gizeh BS', 'The BIRKENSTOCK Gizeh is a genuine classic and a stylish all-rounder. Our elegant thong sandal combines optimum grip with minimalist, fashionable design. The lining of the semi-exquisite footbed is covered with soft smooth leather and matches the shoe in color. The upper is made from extra thick, oiled nubuck leather and features an open-selvage finish.', '3999.00', 0, 5, ' Brown / Cognac', '7.5,8.5,10', 'Formal', 'Screenshot_10-3-2026_113219_www.birkenstock.in.jpeg', 'Screenshot_10-3-2026_113242_www.birkenstock.in.jpeg', 'Screenshot_10-3-2026_113258_www.birkenstock.in.jpeg', 'Screenshot_10-3-2026_113324_www.birkenstock.in.jpeg', 1),
(25, 'Samba OG Shoes', 'Shoes that bring a vibrant energy.\r\nThe latest version of the iconic adidas Samba OG shoes is here to make a bit of a scene. That\'s because they\'re all about that bold, undeniable energy with a pony hair upper that goes the extra mile with leather details and colorful lining. Originally designed in the 1950s as an indoor football shoe, these shoes have created a world of their own.', '2900.00', 10, 20, 'Core Black / Preloved Red / Cream White', '', 'Casual', 'Screenshot_12-3-2026_114438_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_114448_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_114459_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_11457_www.adidas.co.in.jpeg', 2),
(26, 'SUPERSTAR II SHOES', 'Leather shoes with iconic shelltoe and serrated stripes for a blend of comfort and style.\r\nThe adidas Superstar II Shoes are back with a bold twist, rocking the iconic shelltoe and serrated stripes that have defined the style for decades. This updated version of a â€˜90s classic brings new proportions and a fresh attitude - ideal for those who like to make a statement with their footwear.\r\n\r\nThe street-ready look in a striking aurora coffee, off-white and earth strata colourway pairs with branded tongue label, distinctive 3-Stripes and trefoil branded heeltab for an unforgettable impression. Plus, the Superstar sign-off on the lateral side is a reminder of the styleâ€™s rich heritage.\r\n\r\nWhether you\'re hitting the streets or simply hanging out, these shoes help you look sharp and feel great, with a regular fit and distinctive look that are just at home at work and at play.', '2999.00', 10, 23, 'Beige / Off White / Gold Metallic', '3,4,5,6,7', 'Casual', 'Screenshot_12-3-2026_114941_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_114952_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_11508_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_115021_www.adidas.co.in.jpeg', 2),
(27, 'JEWELACE Laces', 'Lightweight and versatile laces for a sleek and sophisticated look.\r\nThe Jewelace laces are designed to add a touch of elegance to your footwear. These laces are not just functional; they are a statement piece that enhance the overall look of your shoes.\r\n\r\nWhether you\'re heading to a casual outing or a formal event, these laces will complement your outfits. The black colourway provides versatility, allowing you to pair them with various shoe designs. These laces are part of the adidas Originals collection, reflecting a blend of classic design and modern aesthetics.\r\n\r\nThese laces are designed to be lightweight so that they do not add unnecessary bulk to your shoes. The quality materials and construction offer durability.\r\n\r\nElevate your shoe game with these laces and experience the combination of form and function. Trust adidas to deliver accessories that not only look good but also perform well.', '2999.00', 10, 23, 'White,Black', '3,4,5,6,7', 'Formal', 'Screenshot_12-3-2026_115452_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_115516_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_115630_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_115642_www.adidas.co.in.jpeg', 2),
(28, 'Mercedes AMG Petronas Formula One Team Ultimashow 2.0 Shoes', 'Shoes with Cloudfoam cushioning for comfort and style.\r\nWhen it comes to motorsport-inspired style, the adidas Mercedes AMG Petronas Formula One Team Ultimashow 2.0 Shoes are your ticket to the fast lane. These shoes are not just about looks - they\'re about performance. With a nod to the iconic Ultraboost 1.0, they combine a mesh upper with a TPU cage and heel counter for a look that means business.\r\n\r\nFeel the comfort with every step. The Cloudfoam midsole cushioning provides a soft, springy feel, making these shoes a great choice for casual strolls or street adventures. The regular tongue offers a snug fit, while the lace closure lets you adjust the lockdown to optimise your comfort level and fit.\r\n\r\nThe rubber outsole adds essential durability and grip, making these shoes ready for city adventures and off-the-beaten-track travels. Whether a motorsport fan or just love the sleek, engineered design, race ahead of the pack with smart, sporty shoes celebrating your team.', '2999.00', 10, 23, 'Core Black / Semi Mint Rush / Core Black', '4,5,6,7,8,9', 'Sports', 'Screenshot_12-3-2026_12341_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_12351_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_12359_www.adidas.co.in.jpeg', 'Screenshot_12-3-2026_1245_www.adidas.co.in.jpeg', 1),
(29, 'Bandolino', 'The Bandolino Korrar loafers will add style to any outfit. They feature a high stacked block heel, feminine bow wrapped upper and a cushioned footbed. You will want them in every color. Established in 1960, Bandolino is a mix of timeless design and uncompromising quality.', '3999.00', 10, 20, 'Black Patent', '5.5,6,6.5,6.5,7,8', 'Partywear', '1773297942_Screenshot_12-3-2026_121533_www.macys.com.jpeg', 'Screenshot_12-3-2026_121225_www.macys.com.jpeg', 'Screenshot_12-3-2026_121233_www.macys.com.jpeg', 'Screenshot_12-3-2026_121243_www.macys.com.jpeg', 2),
(30, 'Easy Spirit', 'Women\'s Zaira eFlex Slip-on Loafers\r\nStyle meets comfort in the Easy Spirit Zaira loafers. Featuring a slip-on silhouette and an almond shaped toe. The Zaira is the perfect wardrobe staple. Plus, it offers eFlex Technology featuring arch support, a padded footbed, flex grooves. Providing comfort over 35 years, Easy Spirit shoes are designed with benefits that keep you moving.', '2999.00', 0, 23, 'Navy Nubuck', '5.5,6,6.5,6.5,7,8', 'Partywear', 'Screenshot_12-3-2026_121659_www.macys.com.jpeg', 'Screenshot_12-3-2026_121717_www.macys.com.jpeg', 'Screenshot_12-3-2026_121741_www.macys.com.jpeg', 'Screenshot_12-3-2026_121756_www.macys.com.jpeg', 2),
(31, 'Cute Walk by Babyhug Slip On Solid Color Loafers - Beige', 'Specifications:\r\nBrand - Cute Walk by Babyhug\r\nType - Oxfords & Loafers\r\nOccasion - Formal, Party Wear\r\nClosure - Slip Ons\r\nOuter Material - PU\r\nPattern/Print - Solid', '599.00', 10, 10, ' Solid', 'Age: 2.5 - 3 Y ', 'Partywear', 'Screenshot_12-3-2026_122138_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_122149_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_122157_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_12226_www.firstcry.com.jpeg', 3),
(32, 'Babyoye Velcro Closure Solid Colour Casual Shoes - Purple', 'Brand - Babyoye\r\nType - Casual Shoes\r\nOccasion - Casual/Essentials\r\nClosure - Velcro\r\nOuter Material - PU\r\nPattern/Print - Solid', '599.00', 10, 10, 'Purple', 'Age: 9 - 12 M ', 'Sports', 'Screenshot_12-3-2026_12283_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_122814_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_122826_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_122837_www.firstcry.com.jpeg', 3),
(33, 'Cute Walk by Babyhug Canvas Velcro Closure Polka Dots Printed & Bow Applique Casual Shoes ', 'Specifications:\r\nBrand - Cute Walk by Babyhug\r\nType - Casual Shoes\r\nOccasion - Casual/Essentials\r\nClosure - Velcro\r\nOuter Material - Canvas\r\nCollection - Polka Dots\r\nPattern/Print - All Over Printed, Applique\r\n', '599.00', 10, 10, 'pink', 'Age: 9 - 12 M', 'Casual', 'Screenshot_12-3-2026_123243_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_123311_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_123332_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_123343_www.firstcry.com.jpeg', 3),
(34, 'Babyoye Sandals With Velcro Closure - Brown', 'Specifications:\r\nBrand - Babyoye\r\nType - Sandals\r\nOccasion - Casual\r\nClosure - Velcro\r\nOuter Material - Synthetic', '599.00', 10, 10, 'Brown', 'Age: 12 - 18 M', 'Formal', 'Screenshot_12-3-2026_12366_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_123615_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_123623_www.firstcry.com.jpeg', 'Screenshot_12-3-2026_123630_www.firstcry.com.jpeg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_german2_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_german2_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_german2_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8_german2_ci DEFAULT 'Customer',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`, `role`) VALUES
(3, 'rohit harsh', 'kavyapatelkp1105@gmail.com', '$2y$10$HCYskYFex9rNtSne0/9eJOQwncZUEZ8reX8.ekpxXEURihTRkIfaS', '1234567890', 'kathlal,gujarat', 'Customer'),
(4, 'harsh', 'youradmin@gmail.com', '$2y$10$CBJbhyqk85r3VWWFfyVdceSJY/9jgiwHxxcCKqLF82wBbcVdxw0L6', '1234567890', 'mahisa ', 'Admin'),
(6, 'Patel Kavya ', 'kp1105@gmail.com', '$2y$10$IvZxbH0bCubNJ7oI2a22XeAJF.bDscw/qrsi/G4Mmykf.vG4Nrqha', '9056781542', NULL, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wishlist_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `created_at`) VALUES
(10, 4, 17, '2026-03-10 05:25:03'),
(11, 3, 14, '2026-03-11 12:36:02'),
(8, 4, 11, '2026-03-05 09:59:24'),
(9, 3, 2, '2026-03-06 09:34:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
