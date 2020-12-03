-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2020 at 09:05 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhonidb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `description`, `timestamp`) VALUES
(2, 'Arijit Singh', 'He is one of the most popular singer of India', '2020-06-25 20:01:46'),
(15, 'Asha Bhosle', 'She\'s an Indian composer, singer and music producer who works predominantly in Tamil and Hindi movies.', '2020-06-29 16:31:46'),
(16, 'Palak Muchhal', 'Palak Muchhal is an Indian playback singer.', '2020-06-29 16:54:38'),
(17, 'Armaan Malik', 'Armaan Malik is an Indian singer, songwriter and an actor. He is known for his singing in Hindi, Telugu, Kannada, Tamil, Bengali, Gujarati & Marathi', '2020-06-29 16:55:09'),
(18, 'R. D. Burman', 'Rahul Dev Burman was an Indian music director. From the 1960s to the 1990s', '2020-06-29 16:55:47'),
(19, 'Guru Randhawa', 'Gursharanjot Singh Randhawa is an Indian singer, songwriter and music composer associated with Punjabi, Bhangra, Indi-pop and Bollywood music', '2020-06-29 16:56:04'),
(20, 'Kishore Kumar', 'Kishore Kumar (4 August 1929 â€“ 13 October 1987) was a popular Indian film playback singer, actor, lyricist, composer, producer, director', '2020-06-30 07:14:33'),
(21, 'Lata Mangeshkar', 'Lata Mangeshkar was born in Indore on September 28, 1929, and became, quite simply, the most popular playback singer in Bollywood\'s history', '2020-06-30 07:15:39'),
(22, 'Mohammad Rafi', 'Mohammed Rafi, whose voice brought to life hundreds of melodies, was born in a village Kotla Sultan Singh near Amritsar long before India attained its independence.', '2020-06-30 07:16:19'),
(23, 'Asha Bhosle', 'One of the greatest playback singers in Bollywood history, Asha Bhosle has recorded over 10,000 songs for over 800 movies.', '2020-06-30 07:16:44'),
(24, 'Mukesh', 'A singer in a class of his own, Mukesh was ranked, along with Mohammad Rafi and Kishore Kumar, as one of the greatest male playback singers in Bollywood history.', '2020-06-30 07:17:00'),
(25, 'Hemanta Mukherjee', 'Hemanta Mukherjee was born on June 16, 1920 in Benares, Benares State, British India.', '2020-06-30 07:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` varchar(10) NOT NULL,
  `song_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`user_id`, `song_id`) VALUES
('1', '24'),
('2', '25'),
('3', '25'),
('4', '26'),
('2', '30'),
('9', '27'),
('9', '27'),
('9', '27'),
('9', '27'),
('9', '27'),
('9', '30'),
('9', '27'),
('9', '27'),
('9', '27'),
('9', '27'),
('9', '29'),
('9', '31'),
('9', '25'),
('2', '32');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(150) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `description`, `timestamp`) VALUES
(2, 'Blues', 'Blues, secular folk music created by African Americans in the early 20th century', '2020-06-25 20:01:46'),
(9, 'Jazz', 'Jazz is a music genre.', '2020-06-29 19:29:55'),
(10, 'Rock', 'Rock music is a broad genre of popular music that originated as \"rock and roll\" in the United State', '2020-06-29 19:45:38'),
(11, 'acoustic', 'Acoustic music is music that solely or primarily uses instruments', '2020-06-29 19:48:26'),
(12, 'EDM ', 'Electronic dance music is a broad range of percussive electronic music genres made largely for nightclubs, raves and festivals', '2020-06-29 19:51:46'),
(13, 'Blues', 'Blues, secular folk music created by African Americans in the early 20th century', '2020-06-29 20:11:56'),
(14, 'classical', 'Classical music is art music produced or rooted in the traditions of Western culture, including both liturgical and secular music.', '2020-06-30 07:19:28'),
(15, 'Salsa', 'Salsa music is a popular dance music genre that initially arose in New York City during the 1960s.', '2020-06-30 07:21:26');

-- --------------------------------------------------------

--
-- Table structure for table `moods`
--

CREATE TABLE `moods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moods`
--

INSERT INTO `moods` (`id`, `name`, `description`, `timestamp`) VALUES
(1, 'Romantic', 'This is a Romantic Mood Category', '2020-06-25 20:01:47'),
(4, 'Happy', 'Happy is a mood until your a punajabi', '2020-06-29 19:32:27'),
(5, 'Dance ', 'a sullen or gloomy state of mind', '2020-06-29 19:49:04'),
(6, 'Energetic', 'a mood showing or involving great activity or vitality.', '2020-06-29 19:49:41'),
(7, 'anxious', 'very eager or concerned to do something or for something to happen.', '2020-06-29 19:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` varchar(500) NOT NULL,
  `length` varchar(10) NOT NULL,
  `artist_id` varchar(50) NOT NULL,
  `genre_id` varchar(50) NOT NULL,
  `mood_id` varchar(50) NOT NULL,
  `file_path` varchar(1000) DEFAULT NULL,
  `thumbnail` varchar(1000) DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `name`, `description`, `length`, `artist_id`, `genre_id`, `mood_id`, `file_path`, `thumbnail`, `timestamp`) VALUES
(25, 'CHAND SI MAHBOOBA HO MERI', 'wonderful song', '03:55', '18', '9', '1', 'files/songs/chand-si-mahbooba-ho-meri-file.mp3', 'files/songs/chand-si-mahbooba-ho-meri-thumbnail.jpg', '2020-06-25 20:01:47'),
(27, 'Nashe Si Chadh Gayi', 'awesome song', '02:34', '2', '10', '1', 'files/songs/nashe-si-chadh-gayi-file.mp3', 'files/songs/nashe-si-chadh-gayi-thumbnail.jpg', '2020-06-25 20:06:45'),
(29, 'Ek Ladki Bheegi Bhagi Si', 'Ek Ladki Bheegi Bhagi Si is a great song', '04:02', '20', '14', '1', 'files/songs/ek-ladki-bheegi-bhagi-si-file.mp3', 'files/songs/ek-ladki-bheegi-bhagi-si-thumbnail.jpg', '2020-06-30 07:43:29'),
(30, ' Bindiya Chamkegi Chudi Khankegi', 'It is great song by lata madam', '05:01', '21', '14', '1', 'files/songs/-bindiya-chamkegi-chudi-khankegi-file.mp3', 'files/songs/-bindiya-chamkegi-chudi-khankegi-thumbnail.jpg', '2020-06-30 10:07:11'),
(31, 'Mere Mehboob Qayamat Hogi (Original)', 'It is great song by kishore', '04:32', '20', '14', '1', 'files/songs/mere-mehboob-qayamat-hogi-(original)-file.mp3', 'files/songs/mere-mehboob-qayamat-hogi-(original)-thumbnail.jpg', '2020-06-30 10:40:45'),
(32, 'Kabhi Kabhi Mere Dil Mein Khayal Aata Hai', 'One of the best songs of mukesh', '04:23', '24', '2', '1', 'files/songs/kabhi-kabhi-mere-dil-mein-khayal-aata-hai-file.mp3', 'files/songs/kabhi-kabhi-mere-dil-mein-khayal-aata-hai-thumbnail.jpg', '2020-06-30 11:32:48'),
(33, 'Ude Jab Jab Zulfen Teri', 'It is great song by md rafi', '05:01', '22', '9', '6', 'files/songs/ude-jab-jab-zulfen-teri-file.mp3', 'files/songs/ude-jab-jab-zulfen-teri-thumbnail.jpg', '2020-06-30 11:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `number` varchar(50) NOT NULL,
  `path` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `number`, `path`) VALUES
(2, 'Mohit Soni', 'm@gmail.com', '123', 'Male', '7894561230', NULL),
(3, 'Shyam Laal', 'shyam.lal@gmail.com', '123', 'Male', '9874125633', 'files/images/shyam.lal-img.jpg'),
(4, 'Champa', 'a@gmail.in', '123', 'Female', '9876543210', 'files/images/a-img.jpg'),
(5, 'Champak', 'champak@gmail.com', '123', 'Male', '7894561230', 'files/images/champak-img.jpg'),
(6, 'Ram lal', 'rl@gmail.in', '123', 'Male', '9876543210', 'files/images/rl-img.jpg'),
(7, 'Johnny Singh', 'j@gmail.com', '123', 'Male', '7894561230', 'files/images/j-img.jpg'),
(8, 'Mohan Lal', 'mohan@gmail.com', '123', 'Male', '68976543210', 'files/images/mohan-img.jpg'),
(9, 'Abhishek Soni', 'abhi@gmail.com', '123', 'Male', '7894561230', 'files/images/abhi-img.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moods`
--
ALTER TABLE `moods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `moods`
--
ALTER TABLE `moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
