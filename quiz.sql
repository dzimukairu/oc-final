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