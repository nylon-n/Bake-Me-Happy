-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2023 at 10:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakemehappy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_name`, `price`, `image`, `quantity`) VALUES
(148, 6, 'Carrot Cake', '1180', '8.png', 1),
(150, 6, 'Mango Créme Cake', '1180', '9.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_manager`
--

CREATE TABLE `order_manager` (
  `Order_id` int(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `date_of_delivery` varchar(100) NOT NULL,
  `time_of_delivery` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_manager`
--

INSERT INTO `order_manager` (`Order_id`, `user_id`, `first_name`, `last_name`, `email`, `phone_number`, `city`, `address`, `date_of_delivery`, `time_of_delivery`) VALUES
(67, 5, 'Avien', 'Batul', 'avienflairebatul@gmail.com', '09773942061', 'Angeles', '2097, Marisol, Ninoy Aquino, , Angeles City', '2023-06-09', '6:15 PM'),
(68, 5, 'Avien ', 'Batul', 'avienflairebatul@gmail.com', '09773942061', 'Angeles', '2097, Marisol, Ninoy Aquino, , Angeles City', '2023-06-09', '5:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `allergens` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `storage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `image`, `description`, `allergens`, `storage`) VALUES
(1, 'Pastel de Tres Leches Cake', '980', '1.png', 'A vanilla sponge cake soaked in 3 kinds of milk and caramel, coated in chantilly cream, strawberry bits and lightly dusted with cinammon. \r\n', 'Milk, Eggs, Wheat, Caramel', 'Chilled 2-3 days'),
(2, 'Coffee Cashew Cake', '1080', '2.png', 'A rich, triple-layer mocha cake with chocolate ganache and coffee buttercream frosting, coated in crushed cashew nuts. \r\n', 'Nuts, Milk, Eggs, Wheat, Chocolate', 'Chilled 3-4 days'),
(3, 'Chocolate Decadent Cake', '1080', '3.png', 'A super moist chocolate cake filled and coated with a rich, dark chocolate ganache. \r\n', 'Milk, Eggs, Wheat, Chocolate', 'Chilled 3-5 days'),
(4, 'Strawberry Créme Cake', '1080', '4.png', 'A buttery, strawberry sponge cake filled with strawberry compôte, coated with rich, strawberry cream. ', 'Milk, Dairy, Eggs, Wheat, Strawberry', 'Chilled 3-4 days'),
(5, 'Red Velvet Cake', '1080', '5.png', 'A moist, buttery and slightly chocolatey sponge cake covered in smooth cream cheese frosting, coated with red cake crumbs. ', 'Milk, Dairy, Eggs, Wheat', 'Chilled 3-5 days'),
(6, 'Chocolate Caramel Cake', '1080', '6.png', 'A moist chocolate cake layered with caramel fudge and coated in rich, dark chocolate ganache. ', 'Milk, Dairy, Eggs, Wheat, Chocolate, Caramel', 'Chilled 3-4 days'),
(7, 'Strawberry Chantilly Cake', '1180', '7.png\r\n', 'A light strawberry sponge cake filled with strawberry compôte, coated with chantilly cream and topped with fresh strawberries. ', 'Milk, Dairy, Eggs, Wheat, Strawberry', 'Chilled 3-4 days'),
(8, 'Carrot Cake', '1180', '8.png', 'A fluffy, carrot cake with tangy cream cheese layers, coated in our signature, crunchy nut mixture. ', 'Wheat, Eggs, Nuts, Dairy, Nuts', 'Chilled 3-4 days'),
(9, 'Mango Créme Cake', '1180', '9.png', 'A moist, vanilla sponge cake layered with sweet mango compôte and fresh mangoes, topped in light mango cream and more mangoes. \r\n', 'Wheat, Eggs, Dairy, Mango', 'Chilled 2-3 days'),
(10, 'Lemon Meringue Cake', '980', '10.png', 'A light sponge cake filled with lemon curd, covered in a toasted cloud-like, fluffy Italian meringue frosting.', 'Wheat, Eggs, Dairy, Citrus', 'Chilled 2-3 days'),
(11, 'Ube Custard Cake', '980', '11.png', 'A fluffy, ube chiffon cake filled with homemade yema custard, coated with ube cream frosting. ', 'Wheat, Eggs, Nuts, Dairy, Nuts, Ube', 'Chilled 3-4 days'),
(12, 'Wild Berry Cake', '980', '12.png', 'A moist white velvet cake with blueberry compôte, coated with rich cream cheese frosting.', 'Wheat, Eggs, Dairy, Berries', 'Chilled 3-4 days');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, '', '', '', 'asdasd@gmail.com', 'e2fc714c4727ee9395f324cd2e7f331f'),
(2, 'Paul', 'p', 'y', 'paultrustanyumang@gmail.com', '202cb962ac59075b964b07152d234b70'),
(3, '', '', '', 'yumang.paultrustan@auf.edu.ph', '202cb962ac59075b964b07152d234b70'),
(4, 'Paul', 'Paul', 'Yumang', 'awdad@gmail.com', '202cb962ac59075b964b07152d234b70'),
(5, 'avn00', 'Avien', 'Batul', 'avienflairebatul@gmail.com', 'e2fc714c4727ee9395f324cd2e7f331f'),
(6, 'basiliobites', 'Kristine', 'Basilio', 'kristinebasilio@gmail.com', 'e2fc714c4727ee9395f324cd2e7f331f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_manager`
--
ALTER TABLE `order_manager`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `order_manager`
--
ALTER TABLE `order_manager`
  MODIFY `Order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
