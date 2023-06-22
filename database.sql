-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2023 at 08:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goodreads`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `description`, `image`, `date`, `author`, `category`, `rating`, `price`) VALUES
(1, 'ታላላቅ ሰዎች', 'This is description ', 'p-1.jpg', '2023/1/11', 'ከበደ ሚካኤል ', 'novel', 1, 100),
(2, 'አፍ ', 'This is description ', 'p-2.jpg', '2023/1/11', 'አዳም ረታ', 'novel', 1, 400),
(3, 'Module', 'This is description ', 'p-3.jpg', '2023/1/11', 'MOE', 'academics', 1, 250),
(4, 'The power of Logic', 'This is description ', 'p-4.jpg', '2023/1/11', 'Daniel H.', 'academics', 1, 250),
(5, 'Advanced Programming', 'This is desrcription ', 'p-1.jpg', '2023/1/11', 'Gemechis', 'religious', 1, 250);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_id`) VALUES
(1, 5, 1),
(2, 5, 1),
(3, 5, 1),
(4, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` mediumtext NOT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment_id`, `user_id`, `comment`, `likes`) VALUES
(15, 0, 8, 'Guys Have you read this book? I love it.\r\n\"Atomic Habit\"', NULL),
(16, 0, 5, 'Yes, that book is awesome actually', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mybooks`
--

CREATE TABLE `mybooks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mybooks`
--

INSERT INTO `mybooks` (`id`, `user_id`, `book_id`) VALUES
(1, 5, 1),
(2, 5, 2),
(3, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `author` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `description`, `author`, `image`, `date`) VALUES
(1, 'ህፃናት ልያነቡት የሚገባ መፅሀፍት ዝርዝር', 'ህፃናት የሚያነቡትን መርጠን ልንሰጣቸው ይገባል! በሚያነቡት ተረት ተረት፣ ግጥም እና ታሪክ መፅሀፎች ውስጥ ልጆቻችን ምን እየተማሩ ነው? ቆም ብለን እንጠይቅ...', 'Etsubdink', 'n-1.jpg', 'Jun 21, 2023'),
(2, 'ማንበብ ሙሉ ሰው ያደርጋል!', 'በየመሃሉ ማንበብ ሙሉ ሰው ያደርጋል በሚለው ኃይለ መልዕክት ሰውን ወደ ንባብ እንዲገባ ያደርጋሉ። ለመሆኑ ሙሉ ሰው ማለት ምን ማለት ነው?', 'Duresa', 'ns-1.jpg', 'Jun 23, 2023'),
(3, 'Benefits of Reading', 'Calling book lovers and avid readers of all ages! Have you ever wondered what the benefits of reading are aside from leisure and education? From learning new words to maintaining your mental health, books can do it all!', 'Habteyesus', 'ns-2.jpg', 'May 10, 2023'),
(4, 'በኢትዮጵያ ያሉ ታርካዊ መፅፍት...', 'Have you ever read a book where you came across an unfamiliar word? Books have the power to improve your vocabulary by introducing you to new words. The more you read, the more your vocabulary grows, along with your ability to effectively communicate.', 'Fikreyohanis', 'ns-3.jpg', 'May 9, 2023'),
(6, 'የሀጥአት መጀመሪያ', 'asd', 'Aser Hailu', '6493e7f50c04a1.75369215.jpg', '2023-06-22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL DEFAULT 'no_profle.png',
  `bio` varchar(255) DEFAULT 'Student',
  `about` mediumtext DEFAULT 'Student at Addis Ababa Science and Technology University',
  `qoutes` mediumtext DEFAULT 'User didn\'t have quotes.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `profile_pic`, `bio`, `about`, `qoutes`) VALUES
(5, 'Gemechis Elias', 'Gemeelijah@gmail.com', '$2y$10$cqp8.nMLPGB7wMyWj.9H1OHUVzYZFgyLQHMXmpO7GxmV1PO47X0Pm', '6493e6f843040_profile.jpg', 'Student', 'Student at Addis Ababa Science and Technology University. | Software Engineer', 'Before was was was, was was is.'),
(6, 'Joyce', 'codeitethiopia@gmaill.com', '$2y$10$WP7EYAF3I09AlAO0DAm10O7JSw3Kr.bV8S9PuGEvy8aJrxWno87ni', 'no_profle.png', 'Student', NULL, NULL),
(7, 'Joyce', 'codeitethiopia@gmail.com', '$2y$10$R0HWvLMuMHMl73tKOSzRDO/o8oBgDtGm1XRAHOyeSuM/fOyF5C5di', 'no_profle.png', 'Student', 'Student at Addis Ababa Science and Technology University', 'User didn\'t have quotes.'),
(8, 'Aser Hailu', 'aser@gmail.com', '$2y$10$EboCu9hqQECbKYn9fa3L8unxWlg.mlbT7305ymr.SRt9UdSQ9guVK', 'no_profle.png', 'Student', 'Student at Addis Ababa Science and Technology University', 'User didn\'t have quotes.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mybooks`
--
ALTER TABLE `mybooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mybooks`
--
ALTER TABLE `mybooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
