-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019-06-13 13:49:34
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmanagement`
--

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(20) DEFAULT NULL COMMENT '书籍名称',
  `book_author` varchar(20) DEFAULT NULL COMMENT '书籍作者',
  `book_pub` varchar(40) DEFAULT NULL COMMENT '书籍出版社',
  `book_sort` int(20) DEFAULT NULL COMMENT '书籍分类',
  `book_record` date DEFAULT NULL COMMENT '书籍登记日期',
  `book_image` varchar(100) DEFAULT NULL COMMENT '书籍封面',
  `book_download_url` varchar(100) DEFAULT NULL COMMENT '书籍下载地址'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `book`
--

INSERT INTO `book` (`book_id`, `book_name`, `book_author`, `book_pub`, `book_sort`, `book_record`, `book_image`, `book_download_url`) VALUES
(2, '高老头', '巴尔扎克', '长江文艺出版社', 3, '2019-05-19', 'image/2.jpg', 'pdf/3.pdf'),
(3, '巴黎圣母院', '维克多雨果', '上海译文出版社', 3, '2019-05-09', 'image/3.jpg', 'pdf/3.pdf'),
(4, '活着', '余华', '作家出版社', 2, '2019-05-15', 'image/4.jpg', 'pdf/4.pdf'),
(5, '百年孤独', '加西亚马尔克斯', '上海译文出版社', 3, '2019-05-22', 'image/5.jpg', 'pdf/5.pdf'),
(6, '红楼梦', '曹雪芹', '中信出版社', 4, '2019-06-02', 'image/6.jpg', 'pdf/6.pdf'),
(17, '谁的青春不迷茫', '刘同', '青春文艺出版社', 1, '2019-07-07', 'http://php/homework/image/3.jpg', 'pdf/1.pdf');

-- --------------------------------------------------------

--
-- 表的结构 `sort`
--

CREATE TABLE `sort` (
  `sort_id` int(11) NOT NULL,
  `sort_name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sort`
--

INSERT INTO `sort` (`sort_id`, `sort_name`) VALUES
(1, '青春文学'),
(2, '现代小说'),
(3, '外国小说'),
(4, '经典名著'),
(5, '优秀译文');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_account` int(11) NOT NULL,
  `password` varchar(20) NOT NULL COMMENT '用户密码'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_account`, `password`) VALUES
(1111, '1111'),
(2222, '2222'),
(3333, '3333'),
(4444, '4444'),
(6666, '6666'),
(7777, '7777'),
(8888, '8888'),
(9999, '9999');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `book_id` (`book_id`);

--
-- Indexes for table `sort`
--
ALTER TABLE `sort`
  ADD PRIMARY KEY (`sort_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_account`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- 使用表AUTO_INCREMENT `sort`
--
ALTER TABLE `sort`
  MODIFY `sort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
