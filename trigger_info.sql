DROP TRIGGER if EXISTS before_begining_insert;
drop table if EXISTS DATA_INPUT;
CREATE TABLE DATA_INPUT(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nomination VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    skill_level VARCHAR(255) NOT NULL,
    group_age VARCHAR(255) NOT NULL,
    fio VARCHAR(255) NOT NULL,
    number VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    facebook VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    number_name VARCHAR(255) NOT NULL,
    team_name VARCHAR(255) NOT NULL,
    duration TIME NOT NULL,
    amount INT NOT NULL,
    max_age INT NOT NULL,
    min_age INT NOT NULL,
    photo_name VARCHAR(255), 
    file_name VARCHAR(255) NOT NULL,
    dance_style VARCHAR(255) NOT NULL
);

INSERT INTO DATA_INPUT VALUES 
    (1,1,"ABC","ABC","ABC","ABC","ABC","ABC","ABC","ABC","ABC","ABC","ABC","00:00:00:",1,1,1,"hi.jpg","DUDE.MP3","abc");
DELIMITER $$
 
CREATE TRIGGER before_begining_insert
BEFORE INSERT
ON DATA_INPUT FOR EACH ROW
BEGIN
    DECLARE old_begining TIME;
    DECLARE old_duration TIME;
    DECLARE xid INT;

    SELECT duration, begining_time,id INTO old_duration, old_begining,xid  
    FROM DATA_INPUT WHERE id = (SELECT MAX(id) FROM DATA_INPUT);
        SET new.begining_time = SEC_TO_TIME(TIME_TO_SEC(old_begining) + TIME_TO_SEC(old_duration) + 60);
 
END $$

