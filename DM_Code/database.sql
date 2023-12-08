create database z_new_database;
use z_new_database;
CREATE TABLE `z_new_database`.`new_table` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `chat` VARCHAR(500) NOT NULL,
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));
