-- MySQL Workbench Synchronization
-- Generated: 2018-07-23 09:31
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: alexi5h

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `agenteGP`.`plan` 
DROP FOREIGN KEY `plan_fk1`;

ALTER TABLE `agenteGP`.`plan` 
DROP COLUMN `id_seguimiento`,
DROP INDEX `id_seguimiento` ;

ALTER TABLE `agenteGP`.`seguimiento` 
ADD COLUMN `plan_id` INT(11) NOT NULL AFTER `fecha_creacion`,
ADD INDEX `fk_seguimiento_plan1_idx` (`plan_id` ASC);

ALTER TABLE `agenteGP`.`seguimiento` 
ADD CONSTRAINT `fk_seguimiento_plan1`
  FOREIGN KEY (`plan_id`)
  REFERENCES `agenteGP`.`plan` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
