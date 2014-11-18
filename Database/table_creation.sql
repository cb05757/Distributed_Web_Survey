-- Table Creation Script


CREATE TABLE user_tbl(
   user_id INT NOT NULL AUTO_INCREMENT,
   user_email VARCHAR(50) NOT NULL,
   user_password char(128) NOT NULL,
   user_salt char(128) NOT NULL,
   user_squestion VARCHAR(100), -- maybe remove
   user_sanswer VARCHAR(128), -- maybe remove
   PRIMARY KEY ( user_id )
)ENGINE=InnoDB;


CREATE TABLE form_tbl(
   form_id INT NOT NULL AUTO_INCREMENT,
   form_admin INT NOT NULL,
   PRIMARY KEY ( form_id ),
   FOREIGN KEY (form_admin)
      REFERENCES user_tbl(user_id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
)ENGINE=InnoDB;


CREATE TABLE question_tbl(
   question_id INT NOT NULL AUTO_INCREMENT,
   question_type INT NOT NULL,  -- 1 = 1,2,3,4,5 agree disagree -- 2 = a value 1 or value 2 question -- 3 = unlimited choices
   question_form INT NOT NULL,
   question_ask VARCHAR(100) NOT NULL,
   question_value1 VARCHAR(100),
   question_value2 VARCHAR(100),
   PRIMARY KEY ( question_id ),
   FOREIGN KEY (question_form)
      REFERENCES form_tbl(form_id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
)ENGINE=InnoDB;


CREATE TABLE answer_tbl(
   answer_id INT NOT NULL AUTO_INCREMENT,
   answer_question INT NOT NULL,
   answer_value VARCHAR(100) NOT NULL, -- maybe increase to 150 chars
   answer_form INT NOT NULL, -- could remove, duplicate
   PRIMARY KEY ( answer_id ),
   FOREIGN KEY (answer_form)
      REFERENCES form_tbl(form_id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
   FOREIGN KEY (answer_question)
      REFERENCES question_tbl(question_id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
)ENGINE=InnoDB;


CREATE TABLE choices_tbl( 
	choice_id INT NOT NULL AUTO_INCREMENT,
	choiceQuestion_id INT NOT NULL,
	choice VARCHAR(100) NOT NULL, -- the choices for the question
	PRIMARY KEY (choice_id),
	FOREIGN KEY (choiceQuestion_id)
		REFERENCES question_tbl(question_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
)ENGINE=InnoDB;