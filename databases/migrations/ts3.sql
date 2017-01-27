
// db name  `think_social_db` need to change with replace

use ts;

CREATE TABLE `think_social_db`.`dialog_rooms` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(90) NOT NULL,
  `creator_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `think_social_db`.`dialog_rooms` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

TRUNCATE `think_social_db`.`messages`;

ALTER TABLE `think_social_db`.`messages` 
DROP FOREIGN KEY `fk_messages_users2`;
ALTER TABLE `think_social_db`.`messages` 
CHANGE COLUMN `receiver_id` `dialog_room_id` INT(11) NOT NULL ;
ALTER TABLE `think_social_db`.`messages` 
ADD CONSTRAINT `fk_messages_dialog_rooms`
  FOREIGN KEY (`dialog_room_id`)
  REFERENCES `think_social_db`.`dialog_rooms` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `think_social_db`.`messages` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

CREATE TABLE `think_social_db`.`recipients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `dialog_room_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `think_social_db`.`recipients` 
ADD INDEX `fk_recipients_users_idx` (`user_id` ASC);
ALTER TABLE `think_social_db`.`recipients` 
ADD CONSTRAINT `fk_recipients_users`
  FOREIGN KEY (`user_id`)
  REFERENCES `think_social_db`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `think_social_db`.`recipients` 
ADD INDEX `fk_recipients_dialog_rooms_idx` (`dialog_room_id` ASC);
ALTER TABLE `think_social_db`.`recipients` 
ADD CONSTRAINT `fk_recipients_dialog_rooms`
  FOREIGN KEY (`dialog_room_id`)
  REFERENCES `think_social_db`.`dialog_rooms` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `think_social_db`.`dialog_rooms` 
ADD INDEX `fk_dialog_rooms_users_idx` (`creator_id` ASC);
ALTER TABLE `think_social_db`.`dialog_rooms` 
ADD CONSTRAINT `fk_dialog_rooms_users`
  FOREIGN KEY (`creator_id`)
  REFERENCES `think_social_db`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `think_social_db`.`recipients` 
ADD COLUMN `unread_counter` INT(11) NULL DEFAULT 0 AFTER `dialog_room_id`;




