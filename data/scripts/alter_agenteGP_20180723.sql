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


-- -----------------------------------------------------
-- Placeholder table for view `agenteGP`.`contenidosemana`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `agenteGP`.`contenidosemana` (`id` INT, `semana` INT, `id_asignatura` INT, `descripcion` INT, `tema` INT, `prioridad` INT, `horas_asignadas` INT, `porcentaje_aprobacion` INT, `user_id` INT);


USE `agenteGP`;

-- -----------------------------------------------------
-- View `agenteGP`.`contenidosemana`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `agenteGP`.`contenidosemana`;
USE `agenteGP`;
CREATE  OR REPLACE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `agenteGP`.`contenidosemana` AS select `agenteGP`.`contenidos`.`id` AS `id`,`agenteGP`.`contenidos`.`semana` AS `semana`,`agenteGP`.`contenidos`.`id_asignatura` AS `id_asignatura`,`agenteGP`.`contenidos`.`descripcion` AS `descripcion`,`agenteGP`.`temas`.`tema` AS `tema`,`agenteGP`.`temas`.`prioridad` AS `prioridad`,`agenteGP`.`plan`.`horas_asignadas` AS `horas_asignadas`,`agenteGP`.`plan`.`porcentaje_aprobacion` AS `porcentaje_aprobacion`,`agenteGP`.`t_docente_asignaturas`.`user_id` AS `user_id` from (((`agenteGP`.`temas` join `agenteGP`.`contenidos` on((`agenteGP`.`temas`.`id_contenido` = `agenteGP`.`contenidos`.`id`))) join `agenteGP`.`plan` on((`agenteGP`.`temas`.`id` = `agenteGP`.`plan`.`id_tema`))) join `agenteGP`.`t_docente_asignaturas` on((`agenteGP`.`contenidos`.`id_asignatura` = `agenteGP`.`t_docente_asignaturas`.`asig_id`)));

USE `agenteGP`;
DROP procedure IF EXISTS `agenteGP`.`p_TemasAfterBefore`;

DELIMITER $$
USE `agenteGP`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `p_TemasAfterBefore`(IN idContenido INTEGER(11), IN idTema INTEGER(11))
BEGIN
set @idContenido=idContenido;
set @idTema=idTema;

SELECT 
  contenidos.descripcion,
  temas.tema,
  temas.id
FROM
  contenidos
  INNER JOIN temas ON (contenidos.id = temas.id_contenido)
  WHERE	temas.id_contenido=@idContenido AND temas.id<>@idTema;

END$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
