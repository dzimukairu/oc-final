create database onlineclassroom;
	use onlineclassroom;

create table teacher(
	teacher_id int(100) not null auto_increment,
	first_name varchar(100) not null,
	last_name varchar(100) not null,
	username varchar(100) not null,
	email_address varchar(100) not null,
	password varchar(100) not null,
	image varchar(100) null,
	primary key(teacher_id)
);

create table student(
	student_id int(100) not null auto_increment,
	first_name varchar(100) not null,
	last_name varchar(100) not null,
	username varchar(100) not null,
	email_address varchar(100) not null,
	password varchar(100) not null,
	image varchar(100) null,
	primary key(student_id)
);

create table enrolls (
	student_id int(100) not null,
	subject_id int(100) not null,
	status varchar(1000) not null
);

create table subject(
	subject_id int(100) not null auto_increment,
	subject_code varchar(100) not null,
	course_title varchar(100) not null,
	course_description varchar(100) not null,
	course_about varchar(100) not null,
	teacher_id int(100) not null,
	primary key(subject_id),
	foreign key(teacher_id) references teacher(teacher_id)
);

create table chat(
	sender varchar(100) not null,
	receiver varchar(100) not null,
	message varchar(1000) not null,
	date_posted timestamp not null,
	subject_id int(100) not null,
	-- seen varchar(100) not null,
	opened varchar(100) not null,
	foreign key(subject_id) references subject(subject_id)
);

create table uploaded_files(
	file_id int(100) not null auto_increment,
	filename varchar(255) not null,
	date_posted timestamp not null,
	primary key(file_id)
);

create table learning_materials(
	id int(100) not null auto_increment,
	title varchar(100) not null,
	date_posted timestamp not null,
	subject_id int(100) not null,
	file_id int(100) not null,
	primary key(id),
	foreign key(file_id) references uploaded_files(file_id),
	foreign key(subject_id) references subject(subject_id)
);

create table announcement(
	announcement_id int(100) not null auto_increment,
	subject_id int(100) not null,
	date_posted timestamp not null,
	title varchar(100) not null,
	content varchar(1000) not null,
	primary key(announcement_id),
	foreign key(subject_id) references subject(subject_id)
);

create table announcement_comment(
	id int(100) not null auto_increment,
	announcement_id int(100) not null,
	username varchar(100) not null,
	content varchar(1000) not null,
	date_posted timestamp not null,
	primary key(id),
	foreign key(announcement_id) references announcement(announcement_id)
);

create table see_announcement(
	announcement_id int(100) not null,
	subject_id int(100) not null,
	student_id int(100) not null,
	opened varchar(1000) not null default 'false'
);

create table assignment(
	assignment_id int(100) not null auto_increment,
	subject_id int(100) not null,
	date_posted timestamp not null,
	deadline_date date not null,
	deadline_time time not null,
	title varchar(100) not null,
	instruction varchar(1000) not null,
	score int(100) not null,
	file_id int(100) null,
	assignment_type varchar(100) NOT NULL DEFAULT 'individual',
	primary key(assignment_id),
	foreign key(file_id) references uploaded_files(file_id),
	foreign key(subject_id) references subject(subject_id)
);

create table answer_assignment(
	id int(100) not null auto_increment,
	content varchar(1000) not null,
	date_posted timestamp not null,
	grade int(100) not null,
	student_id int(100) not null,
	file_id int(100) null,
	assignment_id int(100) not null,
	primary key(id),
	foreign key(student_id) references student(student_id),
	foreign key(file_id) references uploaded_files(file_id),
	foreign key(assignment_id) references assignment(assignment_id)
);

create table individual_assignment(
	assignment_id int(100) not null,
	subject_id int(100) not null,
	student_id int(100) not null,
	opened varchar(1000) not null default 'false'
);

create table group_assignment(
	assignment_id int(100) not null,
	subject_id int(100) not null,
	group_number int(100) not null,
	student_id int(100) not null,
	indicator int(100) not null,
	opened varchar(1000) not null default 'false'
);

create table answer_group_assignment(
	id int(100) not null auto_increment,
	content varchar(1000) not null default 0,
	date_posted timestamp not null,
	grade int(100) null,
	student_id int(100) not null,
	file_id int(100) null,
	assignment_id int(100) not null,
	group_number int(100) not null,
	primary key(id)
);

create table graded_assignment(
	assignment_id int(100) not null,
	subject_id int(100) not null,
	group_number int(100) not null,
	student_id int(100) not null,
	graded varchar(1000) not null default 'false',
	opened varchar(1000) not null default 'false'
);

create table quiz(
	quiz_id int(100) not null auto_increment,
	subject_id int(100) not null,
	quiz_title varchar(1000) not null,
	date_posted timestamp not null,
	deadline_date date not null,
	deadline_time time not null,
	total_grade int(100) not null,
	time_limit int(100) not null,
	primary key(quiz_id),
	foreign key(subject_id) references subject(subject_id)
);

create table identification_quiz(
	quiz_id int(100) not null,
	question_number int(100) not null,
	question varchar(100) not null,
	answer varchar(100) not null,
	grade int(100) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multiplechoice_quiz(
	quiz_id int(100) not null,
	question_number int(100) not null,
	question varchar(100) not null,
	answer varchar(100) not null,
	grade int(100) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multiplechoice_choices(
	quiz_id int(100) not null,
	question_number int(100) not null,
	option varchar(1000) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multipleanswer_quiz(
	quiz_id int(100) not null,
	question_number int(100) not null,
	question varchar(1000) not null,
	grade int(100) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multipleanswer_choices(
	quiz_id int(100) not null,
	question_number int(100) not null,
	option varchar(1000) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table multipleanswer_answers(
	quiz_id int(100) not null,
	question_number int(100) not null,
	answer varchar(1000) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table essay_quiz(
	quiz_id int(100) not null,
	question_number int(100) not null,
	question varchar(100) not null,
	grade int(100) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table answer_quiz(
	answer_id int(100) not null auto_increment,
	date_posted timestamp not null,
	total_grade int(100) not null,
	student_id int(100) not null,
	quiz_id int(100) not null,
	primary key(answer_id),
	foreign key(student_id) references student(student_id),
	foreign key(quiz_id) references quiz(quiz_id)
);

create table answer_iden_quiz(
	answer_id int(100) not null,
	question_number int(100) not null,
	answer varchar(100) not null,
	grade int(100) not null
);

create table answer_mc_quiz(
	answer_id int(100) not null,
	question_number int(100) not null,
	answer varchar(100) not null,
	grade int(100) not null
);

create table answer_ma_quiz(
	answer_id int(100) not null,
	question_number int(100) not null,
	answer varchar(100) not null,
	grade int(100) not null
);

create table answer_essay_quiz(
	answer_id int(100) not null,
	question_number int(100) not null,
	answer varchar(100) not null,
	grade int(100) not null
);

-- INSERT INTO teacher(first_name, last_name, username, email_address, password, image) 
-- 	VALUES("teacher", "one", "teacher1", "teacher1@gmail.com", "teacher1", "teacher1-lisa.png");

-- INSERT INTO teacher(first_name, last_name, username, email_address, password, image) 
-- 	VALUES("teacher", "two", "teacher2", "teacher2@gmail.com", "teacher2", "def.png");

-- INSERT INTO student(first_name, last_name, username, email_address, password, image) 
-- 	VALUES("student", "one", "student1", "student1@gmail.com", "student1", "def.png");

-- INSERT INTO student(first_name, last_name, username, email_address, password, image) 
-- 	VALUES("student", "two", "student2", "student2@gmail.com", "student2", "def.png");

-- INSERT INTO subject(subject_code, course_title, course_description, course_about, teacher_id)
-- 	VALUES("MXBsYzRv", "CMSC 56", "Discrete Mathematics 1", "Discrete Mathematics 1 About", 1);

-- INSERT INTO subject(subject_code, course_title, course_description, course_about, teacher_id)
-- 	VALUES("MXBsYzRz", "CMSC 198.1", "Special Problem", "Special Problem About", 2);

-- INSERT INTO enrolls(student_id, subject_id, status) VALUES(1, 1, "enrolled");
-- INSERT INTO enrolls(student_id, subject_id, status) VALUES(1, 2, "enrolled");
-- INSERT INTO enrolls(student_id, subject_id, status) VALUES(2, 1, "enrolled");
-- INSERT INTO enrolls(student_id, subject_id, status) VALUES(2, 2, "enrolled");

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `username`, `email_address`, `password`, `image`) VALUES
(1, 'student', 'one', 'student1', 'student1@gmail.com', 'student1', 'def.png'),
(2, 'student', 'two', 'student2', 'student2@gmail.com', 'student2', 'def.png'),
(3, 'Jim Kyle', 'Padasas', 'jkpadasas', 'jk@gmail.com', 'jkpadasas123', 'def.png'),
(4, 'Zarah', 'Alegro', 'zrhmey', 'zarah@gmail.com', 'Zarah123', 'def.png'),
(5, 'Mayenne', 'Catuiran', 'mayenne123', 'mayenne@gmail.com', 'Mayenne123', 'def.png'),
(6, 'Eiman', 'Mission', 'eiman123', 'eiman@gmail.com', 'Eiman123', 'def.png'),
(7, 'Kandee', 'Borbonn', 'kandee123', 'kandee@gmail.com', 'Kandee123', 'def.png'),
(8, 'Bryle', 'De Mateo', 'bryle123', 'bryle@gmail.com', 'Bryle123', 'def.png'),
(9, 'Hil', 'Malumay', 'hil123', 'hil@gmail.com', 'Hil12345', 'def.png');

INSERT INTO `teacher` (`teacher_id`, `first_name`, `last_name`, `username`, `email_address`, `password`, `image`) VALUES
(1, 'teacher', 'one', 'teacher1', 'teacher1@gmail.com', 'teacher1', 'def.png'),
(2, 'teacher', 'two', 'teacher2', 'teacher2@gmail.com', 'teacher2', 'def.png');

INSERT INTO `subject` (`subject_id`, `subject_code`, `course_title`, `course_description`, `course_about`, `teacher_id`) VALUES
(1, 'MXBsYzRv', 'CMSC 56', 'Discrete Mathematics 1', 'Discrete Mathematics 1 About', 1),
(2, 'MXBsYzRz', 'CMSC 198.1', 'Special Problem', 'Special Problem About', 2);

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