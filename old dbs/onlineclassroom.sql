-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2019 at 04:57 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineclassroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_comment`
--

CREATE TABLE `announcement_comment` (
  `id` int(100) NOT NULL,
  `announcement_id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `answer_assignment`
--

CREATE TABLE `answer_assignment` (
  `id` int(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `grade` int(100) DEFAULT NULL,
  `student_id` int(100) NOT NULL,
  `file_id` int(100) DEFAULT NULL,
  `assignment_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer_assignment`
--

INSERT INTO `answer_assignment` (`id`, `content`, `date_posted`, `grade`, `student_id`, `file_id`, `assignment_id`) VALUES
(1, 'sdfghjkl;', '2019-05-02 14:37:56', -1, 1, NULL, 67),
(2, 'asdfghjk', '2019-05-02 14:38:33', -1, 1, NULL, 73);

-- --------------------------------------------------------

--
-- Table structure for table `answer_group_assignment`
--

CREATE TABLE `answer_group_assignment` (
  `id` int(100) NOT NULL,
  `content` varchar(1000) NOT NULL DEFAULT '0',
  `date_posted` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `grade` int(100) NOT NULL,
  `student_id` int(100) NOT NULL,
  `file_id` int(100) DEFAULT NULL,
  `assignment_id` int(100) NOT NULL,
  `group_number` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer_group_assignment`
--

INSERT INTO `answer_group_assignment` (`id`, `content`, `date_posted`, `grade`, `student_id`, `file_id`, `assignment_id`, `group_number`) VALUES
(1, 'student2 answer', '2019-05-02 04:08:49.058697', 50, 2, 14, 64, 1),
(2, 'mayenne update', '2019-05-02 04:08:49.058697', 50, 5, NULL, 64, 1),
(3, 'Kandee and mayenne', '2019-05-02 03:39:18.049380', 50, 5, 15, 63, 4),
(4, '0', '2019-05-02 03:39:18.049380', 50, 7, NULL, 63, 4),
(5, '6565', '2019-05-02 04:56:54.000000', 0, 3, 16, 64, 2),
(6, '0', '2019-05-02 04:56:54.687367', 0, 8, NULL, 64, 2),
(7, 'noooo', '2019-05-02 05:46:05.000000', 15, 3, 0, 66, 1),
(8, '0', '2019-05-02 05:01:51.758698', 15, 5, NULL, 66, 1),
(9, '0', '2019-05-02 05:01:51.758698', 15, 2, NULL, 66, 1),
(10, '0', '2019-05-02 05:01:51.758698', 15, 1, NULL, 66, 1),
(11, 'Jim Answer', '2019-05-02 06:22:37.746418', 3, 3, 0, 69, 1),
(12, '0', '2019-05-02 06:22:37.746418', 3, 8, NULL, 69, 1),
(13, '0', '2019-05-02 06:22:37.746418', 3, 7, NULL, 69, 1),
(14, '0', '2019-05-02 06:22:37.746418', 3, 6, NULL, 69, 1),
(15, 'wertyuio', '2019-05-02 06:22:37.746418', 3, 3, 18, 69, 1),
(16, '0', '2019-05-02 06:22:37.746418', 3, 8, NULL, 69, 1),
(17, '0', '2019-05-02 06:22:37.746418', 3, 7, NULL, 69, 1),
(18, '0', '2019-05-02 06:22:37.746418', 3, 6, NULL, 69, 1),
(19, 'jim', '2019-05-02 07:12:30.891107', 5, 3, 19, 70, 3),
(20, '0', '2019-05-02 07:12:30.891107', 5, 9, NULL, 70, 3),
(21, 'new from jim', '2019-05-02 07:16:39.418930', 0, 3, NULL, 71, 1),
(22, 'new from eiman', '2019-05-02 07:17:35.000000', 0, 6, NULL, 71, 1),
(23, '0', '2019-05-02 07:16:39.655818', 0, 7, NULL, 71, 1),
(24, '0', '2019-05-02 07:16:39.722012', 0, 5, NULL, 71, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `assignment_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `title` varchar(100) NOT NULL,
  `instruction` varchar(1000) NOT NULL,
  `score` int(100) NOT NULL,
  `file_id` int(100) DEFAULT NULL,
  `assignment_type` varchar(40) NOT NULL DEFAULT 'individual'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`assignment_id`, `subject_id`, `date_posted`, `deadline_date`, `deadline_time`, `title`, `instruction`, `score`, `file_id`, `assignment_type`) VALUES
(65, 1, '2019-05-02 03:37:25', '2019-05-02', '12:37:00', 'Individual', 'hjkl', 60, NULL, 'individual'),
(67, 1, '2019-05-02 05:56:03', '2019-05-02', '14:55:00', 'IND', 'fghjkl', 60, NULL, 'individual'),
(69, 1, '2019-05-02 06:00:02', '2019-05-09', '14:59:00', 'Group Assignment 1', 'qwertyuiop', 70, NULL, 'group'),
(70, 1, '2019-05-02 07:05:48', '2019-05-02', '15:08:00', 'Group Assignment 2', 'asdfghjk', 10, NULL, 'group'),
(71, 1, '2019-05-02 07:15:36', '2019-05-02', '16:15:00', 'Gorup Test 4', 'sdfghjkl', 10, NULL, 'group'),
(72, 1, '2019-05-02 14:08:50', '2019-05-02', '23:08:00', 'Group Merge Test', 'asdfghjkl;', 10, NULL, 'group'),
(73, 1, '2019-05-02 14:33:16', '2019-05-02', '23:32:00', 'indiv merged', 'asdfghjkl;', 10, NULL, 'individual'),
(74, 1, '2019-05-02 14:33:50', '2019-05-02', '23:33:00', 'group_again ', 'dfghjkl', 10, NULL, 'group');

-- --------------------------------------------------------

--
-- Table structure for table `enrolls`
--

CREATE TABLE `enrolls` (
  `student_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `status` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolls`
--

INSERT INTO `enrolls` (`student_id`, `subject_id`, `status`) VALUES
(1, 1, 'enrolled'),
(1, 2, 'enrolled'),
(2, 1, 'enrolled'),
(2, 2, 'enrolled'),
(3, 1, 'enrolled'),
(7, 1, 'enrolled'),
(5, 1, 'enrolled'),
(6, 1, 'enrolled'),
(9, 1, 'enrolled'),
(8, 1, 'enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `group_assignment`
--

CREATE TABLE `group_assignment` (
  `assignment_id` int(40) NOT NULL,
  `subject_id` int(40) NOT NULL,
  `group_number` int(40) NOT NULL,
  `student_id` int(40) NOT NULL,
  `indicator` int(40) NOT NULL,
  `status` int(100) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_assignment`
--

INSERT INTO `group_assignment` (`assignment_id`, `subject_id`, `group_number`, `student_id`, `indicator`, `status`) VALUES
(69, 1, 1, 8, 1, 0),
(69, 1, 1, 3, 1, 0),
(69, 1, 1, 7, 1, 0),
(69, 1, 1, 6, 1, 0),
(69, 1, 2, 2, 1, 0),
(69, 1, 2, 5, 1, 0),
(69, 1, 2, 9, 1, 0),
(69, 1, 2, 1, 1, 0),
(70, 1, 1, 7, 2, 0),
(70, 1, 1, 1, 2, 0),
(70, 1, 1, 6, 2, 0),
(70, 1, 2, 8, 2, 0),
(70, 1, 2, 5, 2, 0),
(70, 1, 2, 2, 2, 0),
(70, 1, 3, 3, 2, 0),
(70, 1, 3, 9, 2, 0),
(71, 1, 1, 6, 3, 0),
(71, 1, 1, 7, 3, 0),
(71, 1, 1, 5, 3, 0),
(71, 1, 1, 3, 3, 0),
(71, 1, 2, 9, 3, 0),
(71, 1, 2, 1, 3, 0),
(71, 1, 2, 8, 3, 0),
(71, 1, 2, 2, 3, 0),
(72, 1, 1, 8, 4, 0),
(72, 1, 1, 5, 4, 0),
(72, 1, 1, 9, 4, 0),
(72, 1, 1, 3, 4, 0),
(72, 1, 2, 6, 4, 0),
(72, 1, 2, 1, 4, 0),
(72, 1, 2, 2, 4, 0),
(72, 1, 2, 7, 4, 0),
(74, 1, 1, 1, 5, 0),
(74, 1, 1, 2, 5, 0),
(74, 1, 1, 8, 5, 0),
(74, 1, 2, 5, 5, 0),
(74, 1, 2, 9, 5, 0),
(74, 1, 2, 6, 5, 0),
(74, 1, 3, 7, 5, 0),
(74, 1, 3, 3, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `identification_quiz`
--

CREATE TABLE `identification_quiz` (
  `identification_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `question_number` int(100) NOT NULL,
  `question` varchar(100) NOT NULL,
  `answer` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `learning_materials`
--

CREATE TABLE `learning_materials` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject_id` int(100) NOT NULL,
  `file_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multipleanswer_answers`
--

CREATE TABLE `multipleanswer_answers` (
  `multipleanswer_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `answer` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multipleanswer_choices`
--

CREATE TABLE `multipleanswer_choices` (
  `multipleanswer_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `option` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multipleanswer_quiz`
--

CREATE TABLE `multipleanswer_quiz` (
  `multipleanswer_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `question_number` int(100) NOT NULL,
  `question` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multiplechoice_choices`
--

CREATE TABLE `multiplechoice_choices` (
  `multiplechoice_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `option` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multiplechoice_quiz`
--

CREATE TABLE `multiplechoice_quiz` (
  `multiplechoice_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL,
  `quiz_id` int(100) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `question_number` int(100) NOT NULL,
  `question` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(100) NOT NULL,
  `subject_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `username`, `email_address`, `password`, `image`) VALUES
(1, 'student', '1', 'student1', 'student1@gmail.com', 'student1', 'def.png'),
(2, 'student', '2', 'student2', 'student2@gmail.com', 'student2', 'def.png'),
(3, 'Jim Kyle', 'Padasas', 'jkpadasas', 'jk@gmail.com', 'jkpadasas123', 'def.png'),
(4, 'Zarah', 'Alegro', 'zrhmey', 'zarah@gmail.com', 'Zarah123', 'def.png'),
(5, 'Mayenne', 'Catuiran', 'mayenne123', 'mayenne@gmail.com', 'Mayenne123', 'def.png'),
(6, 'Eiman', 'Mission', 'eiman123', 'eiman@gmail.com', 'Eiman123', 'def.png'),
(7, 'Kandee', 'Borbonn', 'kandee123', 'kandee@gmail.com', 'Kandee123', 'def.png'),
(8, 'Bryle', 'De Mateo', 'bryle123', 'bryle@gmail.com', 'Bryle123', 'def.png'),
(9, 'Hil', 'Malumay', 'hil123', 'hil@gmail.com', 'Hil12345', 'def.png');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(100) NOT NULL,
  `subject_code` varchar(100) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `course_description` varchar(100) NOT NULL,
  `course_about` varchar(100) NOT NULL,
  `teacher_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_code`, `course_title`, `course_description`, `course_about`, `teacher_id`) VALUES
(1, 'MXBsYzRv', 'CMSC 56', 'Discrete Mathematics 1', 'Discrete Mathematics 1 About', 1),
(2, 'MXBsYzRz', 'CMSC 198.1', 'Special Problem', 'Special Problem About', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `first_name`, `last_name`, `username`, `email_address`, `password`, `image`) VALUES
(1, 'teacher', '1', 'teacher1', 'teacher1@gmail.com', 'teacher1', 'def.png'),
(2, 'teacher', '2', 'teacher2', 'teacher2@gmail.com', 'teacher2', 'def.png');

-- --------------------------------------------------------

--
-- Table structure for table `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `file_id` int(100) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploaded_files`
--

INSERT INTO `uploaded_files` (`file_id`, `filename`, `date_posted`) VALUES
(1, 'aq.php', '2019-04-29 06:24:23'),
(2, 'images.jpg', '2019-04-29 14:55:00'),
(3, 'images.jpg', '2019-04-29 15:12:39'),
(4, '20190130_095324.jpg', '2019-05-02 00:17:41'),
(5, '20190130_095704.jpg', '2019-05-02 00:44:22'),
(6, '22202_824384367651646_6083588161815887137_n.jpg', '2019-05-02 02:53:20'),
(7, '20190130_093040.jpg', '2019-05-02 03:03:48'),
(8, '20190130_101039.jpg', '2019-05-02 03:11:23'),
(9, '20190130_095324.jpg', '2019-05-02 03:20:37'),
(10, '20190130_095324.jpg', '2019-05-02 03:22:15'),
(11, '22202_824384367651646_6083588161815887137_n.jpg', '2019-05-02 03:26:45'),
(12, '22202_824384367651646_6083588161815887137_n.jpg', '2019-05-02 03:30:12'),
(13, '20190130_095704.jpg', '2019-05-02 03:32:23'),
(14, '11128118_880338235393581_3388476524792644761_o.jpg', '2019-05-02 03:33:21'),
(15, '20190130_095704.jpg', '2019-05-02 03:38:48'),
(16, '11128118_880338235393581_3388476524792644761_o.jpg', '2019-05-02 04:56:54'),
(17, '17155313_416745502006433_1407409813410135093_n.jpg', '2019-05-02 05:49:05'),
(18, '17155313_416745502006433_1407409813410135093_n.jpg', '2019-05-02 06:06:47'),
(19, '17155313_416745502006433_1407409813410135093_n.jpg', '2019-05-02 07:09:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `announcement_comment`
--
ALTER TABLE `announcement_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`);

--
-- Indexes for table `answer_assignment`
--
ALTER TABLE `answer_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `answer_group_assignment`
--
ALTER TABLE `answer_group_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `identification_quiz`
--
ALTER TABLE `identification_quiz`
  ADD PRIMARY KEY (`identification_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `multipleanswer_answers`
--
ALTER TABLE `multipleanswer_answers`
  ADD KEY `multipleanswer_id` (`multipleanswer_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `multipleanswer_choices`
--
ALTER TABLE `multipleanswer_choices`
  ADD KEY `multipleanswer_id` (`multipleanswer_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `multipleanswer_quiz`
--
ALTER TABLE `multipleanswer_quiz`
  ADD PRIMARY KEY (`multipleanswer_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `multiplechoice_choices`
--
ALTER TABLE `multiplechoice_choices`
  ADD KEY `multiplechoice_id` (`multiplechoice_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `multiplechoice_quiz`
--
ALTER TABLE `multiplechoice_quiz`
  ADD PRIMARY KEY (`multiplechoice_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`file_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_comment`
--
ALTER TABLE `announcement_comment`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `answer_assignment`
--
ALTER TABLE `answer_assignment`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `answer_group_assignment`
--
ALTER TABLE `answer_group_assignment`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `assignment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `identification_quiz`
--
ALTER TABLE `identification_quiz`
  MODIFY `identification_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multipleanswer_quiz`
--
ALTER TABLE `multipleanswer_quiz`
  MODIFY `multipleanswer_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multiplechoice_quiz`
--
ALTER TABLE `multiplechoice_quiz`
  MODIFY `multiplechoice_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `file_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `announcement_comment`
--
ALTER TABLE `announcement_comment`
  ADD CONSTRAINT `announcement_comment_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`announcement_id`);

--
-- Constraints for table `answer_assignment`
--
ALTER TABLE `answer_assignment`
  ADD CONSTRAINT `answer_assignment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `answer_assignment_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `uploaded_files` (`file_id`),
  ADD CONSTRAINT `answer_assignment_ibfk_3` FOREIGN KEY (`assignment_id`) REFERENCES `assignment` (`assignment_id`);

--
-- Constraints for table `assignment`
--
ALTER TABLE `assignment`
  ADD CONSTRAINT `assignment_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `uploaded_files` (`file_id`),
  ADD CONSTRAINT `assignment_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `identification_quiz`
--
ALTER TABLE `identification_quiz`
  ADD CONSTRAINT `identification_quiz_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `identification_quiz_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `learning_materials_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `uploaded_files` (`file_id`),
  ADD CONSTRAINT `learning_materials_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `multipleanswer_answers`
--
ALTER TABLE `multipleanswer_answers`
  ADD CONSTRAINT `multipleanswer_answers_ibfk_1` FOREIGN KEY (`multipleanswer_id`) REFERENCES `multipleanswer_quiz` (`multipleanswer_id`),
  ADD CONSTRAINT `multipleanswer_answers_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `multipleanswer_choices`
--
ALTER TABLE `multipleanswer_choices`
  ADD CONSTRAINT `multipleanswer_choices_ibfk_1` FOREIGN KEY (`multipleanswer_id`) REFERENCES `multipleanswer_quiz` (`multipleanswer_id`),
  ADD CONSTRAINT `multipleanswer_choices_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `multipleanswer_quiz`
--
ALTER TABLE `multipleanswer_quiz`
  ADD CONSTRAINT `multipleanswer_quiz_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `multipleanswer_quiz_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `multiplechoice_choices`
--
ALTER TABLE `multiplechoice_choices`
  ADD CONSTRAINT `multiplechoice_choices_ibfk_1` FOREIGN KEY (`multiplechoice_id`) REFERENCES `multiplechoice_quiz` (`multiplechoice_id`),
  ADD CONSTRAINT `multiplechoice_choices_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `multiplechoice_quiz`
--
ALTER TABLE `multiplechoice_quiz`
  ADD CONSTRAINT `multiplechoice_quiz_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`),
  ADD CONSTRAINT `multiplechoice_quiz_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
