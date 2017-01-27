use ts;

CREATE TABLE `ts`.`dialog_rooms` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(90) NOT NULL,
  `creator_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `ts`.`dialog_rooms` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

TRUNCATE `ts`.`messages`;

ALTER TABLE `ts`.`messages` 
DROP FOREIGN KEY `fk_messages_users2`;
ALTER TABLE `ts`.`messages` 
CHANGE COLUMN `receiver_id` `dialog_room_id` INT(11) NOT NULL ;
ALTER TABLE `ts`.`messages` 
ADD CONSTRAINT `fk_messages_dialog_rooms`
  FOREIGN KEY (`dialog_room_id`)
  REFERENCES `ts`.`dialog_rooms` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ts`.`messages` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

CREATE TABLE `ts`.`recipients` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `dialog_room_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `ts`.`recipients` 
ADD INDEX `fk_recipients_users_idx` (`user_id` ASC);
ALTER TABLE `ts`.`recipients` 
ADD CONSTRAINT `fk_recipients_users`
  FOREIGN KEY (`user_id`)
  REFERENCES `ts`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ts`.`recipients` 
ADD INDEX `fk_recipients_dialog_rooms_idx` (`dialog_room_id` ASC);
ALTER TABLE `ts`.`recipients` 
ADD CONSTRAINT `fk_recipients_dialog_rooms`
  FOREIGN KEY (`dialog_room_id`)
  REFERENCES `ts`.`dialog_rooms` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `ts`.`dialog_rooms` 
ADD INDEX `fk_dialog_rooms_users_idx` (`creator_id` ASC);
ALTER TABLE `ts`.`dialog_rooms` 
ADD CONSTRAINT `fk_dialog_rooms_users`
  FOREIGN KEY (`creator_id`)
  REFERENCES `ts`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `ts`.`recipients` 
ADD COLUMN `unread_counter` INT(11) NULL DEFAULT 0 AFTER `dialog_room_id`;


