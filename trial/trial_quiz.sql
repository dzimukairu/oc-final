create database trial_quiz;
	use trial_quiz;

create table quiz(
	quiz_id int(100) not null auto_increment,
	name varchar(1000) not null,
	primary key(quiz_id)
);

create table question(
	quiz_id int(100) not null,
	question_id int(100) not null,
	question varchar(1000) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table choice(
	quiz_id int(100) not null,
	question_id int(100) not null,
	choice varchar(1000) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);

create table answer(
	quiz_id int(100) not null,
	question_id int(100) not null,
	answer varchar(1000) not null,
	foreign key(quiz_id) references quiz(quiz_id)
);