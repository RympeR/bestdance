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
drop table if EXISTS TICKET_AMOUNT;
CREATE TABLE TICKET_AMOUNT(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    fio VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    amount INT NOT NULL
    );
ALTER TABLE DATA_INPUT AUTO_INCREMENT = 101;
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




INSERT INTO `DATA_INPUT` (`id`, `user_id`, `nomination`, `category`, `skill_level`, `group_age`, `fio`, `number`, `email`, `city`, `number_name`, `team_name`, `duration`, `amount`, `max_age`, `min_age`, `photo_name`, `file_name`, `dance_style`) VALUES (NULL, '6', 'Современная хореография', 'Solo', 'Pro (Опытные)', '10-12 juniors1', 'Брагида Виталина', '0939141247', 'kyblo2008@gmail.com', 'Чернигов', 'Dark paradise', 'Мельничук Доминика', '00:02:00', '1', '11', '11', '2_IMG_20200219_085115_228.jpg', '101_Dark paradice.mp3', 'Dan;ce show')

INSERT INTO `DATA_INPUT` (`id`, `user_id`, `nomination`, `category`, `skill_level`, `group_age`, `fio`, `number`, `email`, `city`, `number_name`, `team_name`, `duration`, `amount`, `max_age`, `min_age`, `photo_name`, `file_name`, `dance_style`) VALUES (NULL, '6', 'Современная хореография', 'Solo', 'Pro (Опытные)', '10-12 juniors1', 'Брагида Виталина', '0939141247', 'kyblo2008@gmail.com', 'Чернигов', 'Mad world', 'Сова Анастасия', '00:02:00', '1', '10', '10', '3_IMG_20200219_085115_228.jpg', '102_Mad world.mp3', 'Contemporary');

INSERT INTO `DATA_INPUT` (`id`, `user_id`, `nomination`, `category`, `skill_level`, `group_age`, `fio`, `number`, `email`, `city`, `number_name`, `team_name`, `duration`, `amount`, `max_age`, `min_age`, `photo_name`, `file_name`, `dance_style`) VALUES (NULL, '6', 'Эстрадный танец', 'Solo', 'Pro (Опытные)', '10-12 juniors1', 'Брагида Виталина', '0939141247', 'kyblo2008@gmail.com', 'Чернигов', 'Soul dance', 'Мельничук Доминика', '00:01:56', '1', '11', '11', '4_IMG_20200219_085115_228.jpg', '103_Мельничук Доминика_Soul dance_с точки.mp3', 'Спортивный танец');