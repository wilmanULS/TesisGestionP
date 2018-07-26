# SQL Manager 2007 for MySQL 4.1.2.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : agenteGP


SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `agenteGP`
    CHARACTER SET 'latin1'
    COLLATE 'latin1_swedish_ci';

USE `agenteGP`;

#
# Structure for the `t_cat_asignatura` table : 
#

CREATE TABLE `t_cat_asignatura` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `as_nombre` varchar(60) DEFAULT NULL,
  `as_nivel` int(11) DEFAULT NULL,
  `as_num_credito` int(11) DEFAULT NULL,
  `as_antecesor` int(11) DEFAULT NULL,
  `as_estado` binary(1) DEFAULT NULL,
  PRIMARY KEY (`as_id`),
  KEY `t_cat_asignatura_fk` (`as_antecesor`),
  CONSTRAINT `t_cat_asignatura_fk` FOREIGN KEY (`as_antecesor`) REFERENCES `t_cat_asignatura` (`as_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

#
# Structure for the `contenidos` table : 
#

CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana` int(11) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `id_asignatura` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_competencias` (`id_asignatura`),
  CONSTRAINT `contenidos_fk` FOREIGN KEY (`id_asignatura`) REFERENCES `t_cat_asignatura` (`as_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

#
# Structure for the `temas` table : 
#

CREATE TABLE `temas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema` varchar(200) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `id_contenido` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_contenido` (`id_contenido`),
  CONSTRAINT `temas_fk` FOREIGN KEY (`id_contenido`) REFERENCES `contenidos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

#
# Structure for the `antecesor` table : 
#

CREATE TABLE `antecesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema_id` int(11) DEFAULT NULL,
  `antecesor` varchar(20) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tema_id` (`tema_id`),
  CONSTRAINT `antecesor_fk` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Structure for the `users` table : 
#

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `periodo_academico` table : 
#

CREATE TABLE `periodo_academico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Structure for the `t_docente_asignaturas` table : 
#

CREATE TABLE `t_docente_asignaturas` (
  `dasg_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `asig_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id_periodo` int(11) DEFAULT NULL,
  PRIMARY KEY (`dasg_id`),
  UNIQUE KEY `dasg_id` (`dasg_id`),
  KEY `user_id` (`user_id`),
  KEY `asig_id` (`asig_id`),
  KEY `id_periodo` (`id_periodo`),
  CONSTRAINT `t_docente_asignaturas_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `t_docente_asignaturas_fk1` FOREIGN KEY (`asig_id`) REFERENCES `t_cat_asignatura` (`as_id`),
  CONSTRAINT `t_docente_asignaturas_fk2` FOREIGN KEY (`id_periodo`) REFERENCES `periodo_academico` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# Structure for the `asignatura_horas` table : 
#

CREATE TABLE `asignatura_horas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `horasPracticas` int(11) DEFAULT NULL,
  `horasTeoricas` int(11) DEFAULT NULL,
  `horasLaboratorio` int(11) DEFAULT NULL,
  `dasg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `dasg_id` (`dasg_id`),
  CONSTRAINT `asignatura_horas_fk` FOREIGN KEY (`dasg_id`) REFERENCES `t_docente_asignaturas` (`dasg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

#
# Structure for the `categories` table : 
#

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `nivelcognoscitivo` table : 
#

CREATE TABLE `nivelcognoscitivo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) DEFAULT NULL,
  `dificultad` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Structure for the `taxonomia_blooms` table : 
#

CREATE TABLE `taxonomia_blooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `verbo` varchar(30) DEFAULT NULL,
  `id_nc` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_nc` (`id_nc`),
  CONSTRAINT `taxonomia_blooms_fk` FOREIGN KEY (`id_nc`) REFERENCES `nivelcognoscitivo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;

#
# Structure for the `competencias` table : 
#

CREATE TABLE `competencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tax` int(11) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `id_horas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tax` (`id_tax`),
  KEY `id_horas` (`id_horas`),
  CONSTRAINT `competencias_fk` FOREIGN KEY (`id_tax`) REFERENCES `taxonomia_blooms` (`id`),
  CONSTRAINT `competencias_fk1` FOREIGN KEY (`id_horas`) REFERENCES `asignatura_horas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

#
# Structure for the `descripcion_tecnica` table : 
#

CREATE TABLE `descripcion_tecnica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tamaño` float(3,2) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `dificultad` table : 
#

CREATE TABLE `dificultad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Structure for the `formato` table : 
#

CREATE TABLE `formato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Structure for the `idioma` table : 
#

CREATE TABLE `idioma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Structure for the `keywords` table : 
#

CREATE TABLE `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag1` varchar(20) NOT NULL,
  `tag2` varchar(20) DEFAULT NULL,
  `tag3` varchar(20) DEFAULT NULL,
  `tag4` varchar(20) DEFAULT NULL,
  `tag5` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `menu_items` table : 
#

CREATE TABLE `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `depth` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `metadatos` table : 
#

CREATE TABLE `metadatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `migrations` table : 
#

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `permissions` table : 
#

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `model_has_permissions` table : 
#

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `roles` table : 
#

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `model_has_roles` table : 
#

CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `tipo_recurso_educativo` table : 
#

CREATE TABLE `tipo_recurso_educativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Structure for the `objetos_aprendizaje` table : 
#

CREATE TABLE `objetos_aprendizaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(300) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `evaluacion_profesor` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `nd_id` int(11) DEFAULT NULL,
  `dt_id` int(11) DEFAULT NULL,
  `cf_id` int(11) DEFAULT NULL,
  `tr_id` int(11) DEFAULT NULL,
  `kw_id` int(11) DEFAULT NULL,
  `tema_id` int(11) DEFAULT NULL,
  `autor1` varchar(20) NOT NULL,
  `id_idioma` int(11) DEFAULT NULL,
  `autor2` varchar(20) DEFAULT NULL,
  `autor3` varchar(20) DEFAULT NULL,
  `meta_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kw_id` (`kw_id`),
  KEY `dt_id` (`dt_id`),
  KEY `tr_id` (`tr_id`),
  KEY `nd_id` (`nd_id`),
  KEY `cf_id` (`cf_id`),
  KEY `tema_id` (`tema_id`),
  KEY `id_autor` (`autor1`),
  KEY `id_idioma` (`id_idioma`),
  KEY `meta_id` (`meta_id`),
  CONSTRAINT `objetos_aprendizaje_fk` FOREIGN KEY (`kw_id`) REFERENCES `keywords` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk1` FOREIGN KEY (`dt_id`) REFERENCES `descripcion_tecnica` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk2` FOREIGN KEY (`tr_id`) REFERENCES `tipo_recurso_educativo` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk3` FOREIGN KEY (`nd_id`) REFERENCES `dificultad` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk4` FOREIGN KEY (`cf_id`) REFERENCES `formato` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk5` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk6` FOREIGN KEY (`meta_id`) REFERENCES `metadatos` (`id`),
  CONSTRAINT `objetos_aprendizaje_fk7` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `pages` table : 
#

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `extras` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `password_resets` table : 
#

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `seguimiento` table : 
#

CREATE TABLE `seguimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semana_actual` int(11) DEFAULT NULL,
  `horas_impartidas` int(11) DEFAULT NULL,
  `horas_restantes` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Structure for the `plan` table : 
#

CREATE TABLE `plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) DEFAULT NULL,
  `horas_asignadas` int(11) DEFAULT NULL,
  `porcentaje_aprobacion` float(9,3) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `id_seguimiento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_contenido` (`id_tema`),
  KEY `id_seguimiento` (`id_seguimiento`),
  CONSTRAINT `plan_fk` FOREIGN KEY (`id_tema`) REFERENCES `temas` (`id`),
  CONSTRAINT `plan_fk1` FOREIGN KEY (`id_seguimiento`) REFERENCES `seguimiento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

#
# Structure for the `role_has_permissions` table : 
#

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `settings` table : 
#

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `field` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Structure for the `sucesor` table : 
#

CREATE TABLE `sucesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tema_id` int(11) DEFAULT NULL,
  `sucesor` varchar(200) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tema_id` (`tema_id`),
  CONSTRAINT `sucesor_fk` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Definition for the `p_TemasAfterBefore` procedure : 
#

CREATE DEFINER = 'root'@'localhost' PROCEDURE `p_TemasAfterBefore`(IN idContenido INTEGER(11), IN idTema INTEGER(11))
    NOT DETERMINISTIC
    CONTAINS SQL
    SQL SECURITY DEFINER
    COMMENT ''
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

END;

#
# Definition for the `contenidosemana` view : 
#

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `contenidosemana` AS 
  select 
    `contenidos`.`id` AS `id`,
    `contenidos`.`semana` AS `semana`,
    `contenidos`.`id_asignatura` AS `id_asignatura`,
    `contenidos`.`descripcion` AS `descripcion`,
    `temas`.`tema` AS `tema`,
    `temas`.`prioridad` AS `prioridad`,
    `plan`.`horas_asignadas` AS `horas_asignadas`,
    `plan`.`porcentaje_aprobacion` AS `porcentaje_aprobacion`,
    `t_docente_asignaturas`.`user_id` AS `user_id` 
  from 
    (((`temas` join `contenidos` on((`temas`.`id_contenido` = `contenidos`.`id`))) join `plan` on((`temas`.`id` = `plan`.`id_tema`))) join `t_docente_asignaturas` on((`contenidos`.`id_asignatura` = `t_docente_asignaturas`.`asig_id`)));

#
# Data for the `t_cat_asignatura` table  (LIMIT 0,500)
#

INSERT INTO `t_cat_asignatura` (`as_id`, `as_nombre`, `as_nivel`, `as_num_credito`, `as_antecesor`, `as_estado`) VALUES 
  (1,'Geometría ',0,4,NULL,'0'),
  (2,'Matemáticas',0,10,NULL,'1'),
  (3,'Física I',0,5,NULL,'1'),
  (4,'Comunicación Oral y Escrita',0,4,NULL,'1'),
  (5,'Introducción a la Computación',0,4,NULL,'1'),
  (6,'Cálculo Diferencial',1,4,NULL,'1'),
  (7,'Álgebra Lineal',1,6,NULL,'1'),
  (8,'Cálculo Proposicional y Predicado',1,4,NULL,'1'),
  (9,'Física II',1,5,3,'1'),
  (10,'Metodología de la Investigación',1,4,NULL,'1'),
  (11,'Programación Básica',1,6,5,'1'),
  (12,'Cálculo Integral',2,4,6,'1'),
  (13,'Cálculo Integral',2,4,7,'1'),
  (14,'Matemáticas Discretas',2,5,6,'0'),
  (15,'Matemáticas Discretas',2,5,8,'0'),
  (16,'Lógica Difusa y Aplicaciones Lógicas',2,4,8,'1'),
  (17,'Electrología y Circuitos Lógicos',2,5,9,'0'),
  (18,'Estructura de Datos I',2,6,11,'0'),
  (19,'Ecuaciones DIferenciales',3,4,12,'1'),
  (20,'Estadística',3,6,12,'1'),
  (21,'Diseño de Computadores',3,4,16,'0'),
  (22,'Diseño de Computadores',3,4,17,'0'),
  (23,'Programación Orientada a Objetos',3,5,18,'1'),
  (24,'Estructura de Datos II',3,4,18,'0'),
  (25,'Sistemas Operativos',3,4,18,'1'),
  (26,'Contabilidad Básica',3,4,NULL,'0'),
  (27,'Métodos Numéricos',4,5,9,'1'),
  (28,'Investigación Operativa',4,4,10,'1'),
  (29,'Teoría de la Comunicación y de la Información',4,4,22,'1'),
  (30,'Lenguajes de Programación',4,3,23,'0'),
  (31,'Diseño de Lenguajes y Autómatas',4,4,24,'0'),
  (32,'Diseño Lógico de Sistemas Operativos',4,3,25,'0'),
  (33,'Mercadeo',4,3,20,'1'),
  (34,'Contabilidad de Costos',4,2,26,'1'),
  (35,'Graficación y Animación',5,4,27,'1'),
  (36,'Graficación y Animación',5,4,30,'1'),
  (37,'Compiladores e Intérpretes',5,4,31,'1'),
  (38,'Ingeniería de Software I',5,4,29,'1'),
  (39,'Ingeniería de Software I',5,4,30,'1'),
  (40,'Base de Datos I',5,5,30,'1'),
  (41,'Inteligencia Artificial I',5,4,31,'1'),
  (42,'Finanzas',5,4,34,'1'),
  (43,'Redes',6,5,39,'1'),
  (44,'Redes',6,5,40,'1'),
  (45,'Nuevas Técnicas de Programación',6,4,36,'1'),
  (46,'Nuevas Técnicas de Programación',6,4,37,'1'),
  (47,'Ingeniería de Software II',6,5,38,'1'),
  (48,'Ingeniería de Software II',6,5,40,'1'),
  (49,'Ingeniería de Software II',6,5,42,'1'),
  (50,'Base de Datos II',6,5,40,'1'),
  (51,'Teoría de Sistemas',6,5,38,'0'),
  (52,'Procesamiento de Imágenes',6,4,35,'1'),
  (53,'Evaluación de Sistemas',7,4,47,'1'),
  (54,'Evaluación de Sistemas',7,4,50,'1'),
  (55,'Evaluación de Sistemas',7,4,51,'1'),
  (56,'Planificación de Sistemas',7,4,51,'1'),
  (57,'Planificación de Sistemas',7,4,47,'1'),
  (58,'Simulación',7,4,52,'1'),
  (59,'Inteligencia Artificial II',7,4,41,'1'),
  (60,'Economía ',7,3,42,'0'),
  (61,'Programación Avanzada',8,3,45,'1'),
  (62,'Sistemas de Información Geográfica',8,3,47,'1'),
  (63,'Informática Legal',8,3,56,'0'),
  (64,'Aplicaciones Difusas',8,4,59,'1'),
  (65,'Titulación I',7,2,NULL,'1'),
  (66,'Reeingeniería de Procesos y Calidad Total',8,4,56,'0'),
  (67,'Gestión de Proyectos',8,2,65,'1');

COMMIT;

#
# Data for the `contenidos` table  (LIMIT 0,500)
#

INSERT INTO `contenidos` (`id`, `semana`, `descripcion`, `estado`, `id_asignatura`) VALUES 
  (1,1,'hola','Disponible',10),
  (2,1,'hola','Disponible',10),
  (3,1,'hola','Disponible',10),
  (4,1,'hola','Disponible',10),
  (5,1,'hola','Disponible',10),
  (6,1,'hola','Disponible',26),
  (7,1,'chao','Disponible',26),
  (8,1,'como andamios','Disponible',26),
  (9,1,'holibiris','Disponible',26),
  (10,1,'holibiris','Disponible',26),
  (11,1,'hola chao','Disponible',26),
  (12,2,'semana 2','Disponible',26),
  (13,1,'hola David','Disponible',26),
  (14,1,'hola David','Disponible',26),
  (15,1,'hola David','Disponible',26),
  (16,5,'addsf','Disponible',19),
  (17,5,'rrrrrrr','Disponible',19),
  (18,1,'ecuaciones diferenciales','Disponible',19),
  (19,1,'limites','Disponible',19),
  (20,1,'limites','Disponible',19),
  (21,2,'adfdsfsdfds','Disponible',19),
  (22,2,'asdasdasdsa','Disponible',19),
  (23,1,'Derivadas','Disponible',22),
  (24,1,'Derivadas','Disponible',22);

COMMIT;

#
# Data for the `temas` table  (LIMIT 0,500)
#

INSERT INTO `temas` (`id`, `tema`, `estado`, `prioridad`, `id_contenido`) VALUES 
  (1,'aaa','Activo',2,6),
  (2,'libro diario','activo',2,10),
  (3,'asa','activo',1,11),
  (4,'asdad','activo',3,11),
  (5,'wilman','activo',1,12),
  (6,'cadena','activo',2,12),
  (7,'fracciones','activo',5,13),
  (8,'fracciones','activo',5,14),
  (9,'fracciones','activo',5,15),
  (10,'ssadadf','activo',2,16),
  (11,'dddd','activo',1,16),
  (12,'adafdaf','activo',3,17),
  (13,'graficas','activo',2,18),
  (14,'derivadas y limites','activo',2,19),
  (15,'asfdsfds','activo',2,21),
  (16,'sfdafds','activo',2,22),
  (17,'funciones','activo',5,23),
  (18,'aaaaaaaaa','activo',1,24);

COMMIT;

#
# Data for the `antecesor` table  (LIMIT 0,500)
#

INSERT INTO `antecesor` (`id`, `tema_id`, `antecesor`, `estado`) VALUES 
  (1,5,'Ninguno',1),
  (3,5,'Ninguno',1),
  (4,10,'Ninguno',1);

COMMIT;

#
# Data for the `users` table  (LIMIT 0,500)
#

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES 
  (1,'Wilman Cadena','wilman.c@goubun.com','$2y$10$YL2H.T3GUBkG3tzmTEpnWecDQHRQhdfYbxZ1GROr1Zf5/rmonnn4a','ZAyPs85qT23zlXeLowcn6songjax5PQ0urerJzoYi0PGmFAgSquVjV8pVPIC','2018-07-12 02:01:03','2018-07-12 04:45:33'),
  (2,'José','jose.i@goubun.com','$2y$10$5DknhfTrlZBEAqhKYHrIu.nO2jwbduY6qvgHfJY.CUnQug9Oj34BC','4b2orJbXTQWZTRASQBpcprjPgIGInmsbVhJ39pISwCjKKhmsRVDvlGjZ4Df4','2018-07-12 04:43:31','2018-07-12 04:43:31'),
  (3,'Santiago Quishpe','saquishpe@pucesi.edu.ec','$2y$10$8w9TsEoPC2p/W0ju6SlNmeNdx1jL7G8gQ501VDu8TRhLw4yHhWS3e','4lAgjyFrHoDeguPDNVqE6bpmVlhe8KavCVbHzA6CTANFpr1TR32NkD0TOOcH','2018-07-12 04:44:24','2018-07-12 04:45:01'),
  (4,'Stalin Arciniegas','smarciniegas@pucesi.edu.ec','$2y$10$ulQOnld25bCSuuZKPoFAf.209rQjPzFZQEaHhP/Ivcr0NU4lqau2e',NULL,'2018-07-13 06:02:10','2018-07-13 06:02:10');

COMMIT;

#
# Data for the `periodo_academico` table  (LIMIT 0,500)
#

INSERT INTO `periodo_academico` (`id`, `name`, `estado`) VALUES 
  (1,'Septiembre 2017 - Enero 2018','desactivo'),
  (2,'Abril 2018 - Agosto 2018','activo');

COMMIT;

#
# Data for the `t_docente_asignaturas` table  (LIMIT 0,500)
#

INSERT INTO `t_docente_asignaturas` (`dasg_id`, `user_id`, `asig_id`, `created_at`, `updated_at`, `deleted_at`, `id_periodo`) VALUES 
  (3,5,NULL,NULL,NULL,NULL,NULL),
  (5,NULL,NULL,NULL,NULL,NULL,NULL),
  (6,NULL,NULL,NULL,NULL,NULL,NULL),
  (9,2,19,NULL,NULL,NULL,NULL),
  (10,3,26,NULL,NULL,NULL,NULL),
  (12,7,31,NULL,NULL,NULL,NULL),
  (13,2,22,NULL,NULL,NULL,2);

COMMIT;

#
# Data for the `asignatura_horas` table  (LIMIT 0,500)
#

INSERT INTO `asignatura_horas` (`id`, `horasPracticas`, `horasTeoricas`, `horasLaboratorio`, `dasg_id`) VALUES 
  (1,12,12,12,10),
  (2,12,12,12,10),
  (3,12,12,12,10),
  (4,12,12,12,10),
  (5,12,12,12,10),
  (6,12,12,12,10),
  (7,12,12,12,10),
  (8,12,12,12,10),
  (9,12,12,12,10),
  (10,12,12,12,10),
  (11,12,12,12,10),
  (12,12,12,12,10),
  (13,12,12,12,10),
  (14,12,12,12,10),
  (15,12,12,12,10),
  (16,12,12,12,10),
  (17,12,12,12,10),
  (18,12,12,12,10),
  (19,12,12,12,9),
  (20,12,12,12,10),
  (21,12,12,6,10),
  (22,NULL,NULL,NULL,10),
  (23,12,12,12,10),
  (24,NULL,NULL,NULL,10),
  (25,NULL,NULL,NULL,10),
  (26,12,12,12,10),
  (27,NULL,NULL,NULL,10),
  (28,4,2,1,10),
  (29,1,2,1,10),
  (30,4,2,2,9);

COMMIT;

#
# Data for the `nivelcognoscitivo` table  (LIMIT 0,500)
#

INSERT INTO `nivelcognoscitivo` (`id`, `descripcion`, `dificultad`) VALUES 
  (1,'Conocimiento','Baja'),
  (2,'Comprensión','Baja'),
  (3,'Aplicación','Media'),
  (4,'Análisis','Media'),
  (5,'Síntesis','Alta'),
  (6,'Evaluación','Alta');

COMMIT;

#
# Data for the `taxonomia_blooms` table  (LIMIT 0,500)
#

INSERT INTO `taxonomia_blooms` (`id`, `verbo`, `id_nc`, `estado`) VALUES 
  (1,'Anunciar',1,1),
  (2,'Bosquejar',1,1),
  (3,'Citar',1,1),
  (4,'Contar',1,1),
  (5,'Copiar',1,1),
  (6,'Definir',1,1),
  (7,'Deletrear',1,1),
  (8,'Decir',1,1),
  (9,'Encontrar',1,1),
  (10,'Enlistar',1,1),
  (11,'Escoger',1,1),
  (12,'Escribir',1,1),
  (13,'Etiquetar',1,1),
  (14,'Hacer una lista',1,1),
  (15,'Identificar',1,1),
  (16,'Indicar',1,1),
  (17,'Leer',1,1),
  (18,'Listar',1,1),
  (19,'Localizar',1,1),
  (20,'Nombrar',1,1),
  (21,'Nominar',1,1),
  (22,'Mostrar',1,1),
  (23,'Recitar',1,1),
  (24,'Recordar',1,1),
  (25,'Registrar',1,1),
  (26,'Relatar',1,1),
  (27,'Repetir',1,1),
  (28,'Reportar',1,1),
  (29,'Reproducir',1,1),
  (30,'Rotular',1,1),
  (31,'Clasificar',2,1),
  (32,'Comparar',2,1),
  (33,'Contrastar',2,1),
  (34,'Convertir',2,1),
  (35,'Dar ejemplo',2,1),
  (36,'Describir',2,1),
  (37,'Discutir',2,1),
  (38,'Distinguir',2,1),
  (39,'Explicar',2,1),
  (40,'Expresar',2,1),
  (41,'Identificar',2,1),
  (42,'Ilustrar',2,1),
  (43,'Informar',2,1),
  (44,'Interpretar',2,1),
  (45,'Ordenar',2,1),
  (46,'Parafrasear',2,1),
  (47,'Poner en orden',2,1),
  (48,'Reafirmar',2,1),
  (49,'Reconocer',2,1),
  (50,'Resumir',2,1),
  (51,'Traducir',2,1),
  (52,'Revisar',2,1),
  (53,'Seleccionar',2,1),
  (54,'Aplicar',3,1),
  (55,'Calcular',3,1),
  (56,'Cambiar',3,1),
  (57,'Comprobar',3,1),
  (58,'Computar',3,1),
  (59,'Contrastar',3,1),
  (60,'Construir',3,1),
  (61,'Convertir',3,1),
  (62,'Demostrar',3,1),
  (63,'Desarrollar',3,1),
  (64,'Dibujar',3,1),
  (65,'Dramatizar',3,1),
  (66,'Ejemplificar',3,1),
  (67,'Emplear',3,1),
  (68,'Ensamblar',3,1),
  (69,'Entrevistar',3,1),
  (70,'Escojer',3,1),
  (71,'Estimar',3,1),
  (72,'Extrapolar',3,1),
  (73,'Fabricar',3,1),
  (74,'Ilustar',3,1),
  (75,'Interpolar',3,1),
  (76,'Interpretar',3,1),
  (77,'Hacer uso de',3,1),
  (78,'Manipular',3,1),
  (79,'Modelar',3,1),
  (80,'Modificar',3,1),
  (81,'Mostrar',3,1),
  (82,'Operar',3,1),
  (83,'Organizar',3,1),
  (84,'Analizar',4,1),
  (85,'Asociar',4,1),
  (86,'Asumir',4,1),
  (87,'Calcular',4,1),
  (88,'Categorizar',4,1),
  (89,'Clasificar',4,1),
  (90,'Comparar',4,1),
  (91,'Componer',4,1),
  (92,'Concluir',4,1),
  (93,'Contrastar',4,1),
  (94,'Cuestionar',4,1),
  (95,'Criticar',4,1),
  (96,'Descubrir',4,1),
  (97,'Desmenuzar',4,1),
  (98,'Destacar',4,1),
  (99,'Dibujar',4,1),
  (100,'Diagramar',4,1),
  (101,'Diferenciar',4,1),
  (102,'Discutir',4,1),
  (103,'Discriminar',4,1),
  (104,'Disecar',4,1),
  (105,'Distinguir',4,1),
  (106,'Dividir',4,1),
  (107,'Elegir',4,1),
  (108,'Encuestar',4,1),
  (109,'Ensamblar',4,1),
  (110,'Estimar',4,1),
  (111,'Examinar',4,1),
  (112,'Experimentar',4,1),
  (113,'Explicar',4,1),
  (114,'Adaptar',5,1),
  (115,'Arreglar',5,1),
  (116,'Cambiar',5,1),
  (117,'Coleccionar',5,1),
  (118,'Combinar',5,1),
  (119,'Compilar',5,1),
  (120,'Componer',5,1),
  (121,'Concluir',5,1),
  (122,'Crear',5,1),
  (123,'Deducir',5,1),
  (124,'Definir',5,1),
  (125,'Desarrollar',5,1),
  (126,'Desenvolver',5,1),
  (127,'Dirigir',5,1),
  (128,'Diseñar',5,1),
  (129,'Elaborar',5,1),
  (130,'Eliminar',5,1),
  (131,'Ensamblar',5,1),
  (132,'Escribir',5,1),
  (133,'Escoger',5,1),
  (134,'Establecer',5,1),
  (135,'Especificar',5,1),
  (136,'Examinar',5,1),
  (137,'Fabricar',5,1),
  (138,'Formular',5,1),
  (139,'Gestionar',5,1),
  (140,'Generalizar',5,1),
  (141,'Hacer',5,1),
  (142,'Hipotetizar',5,1),
  (143,'Aceptar',6,1),
  (144,'Aportar',6,1),
  (145,'Apreciar',6,1),
  (146,'Aprobar',6,1),
  (147,'Argumentar',6,1),
  (148,'Avaluar',6,1),
  (149,'Categorizar',6,1),
  (150,'Clasificar',6,1),
  (151,'Calificar',6,1),
  (152,'Comparar',6,1),
  (153,'Concluir',6,1),
  (154,'Considerar',6,1),
  (155,'Criticar',6,1),
  (156,'Debatir',6,1),
  (157,'Decidir',6,1),
  (158,'Defender',6,1),
  (159,'Determinar',6,1),
  (160,'Descubrir',6,1),
  (161,'Disputar',6,1),
  (162,'Dar importancia',6,1),
  (163,'Deducir',6,1),
  (164,'Emitir un juicio',6,1),
  (165,'Estimar',6,1),
  (166,'Evaluar',6,1),
  (167,'Escoger',6,1),
  (168,'Explicar',6,1),
  (169,'Establecer criterio',6,1),
  (170,'Influenciar',6,1),
  (171,'Influir',6,1),
  (172,'Interpretar',6,1),
  (173,'Juzgar',6,1);

COMMIT;

#
# Data for the `competencias` table  (LIMIT 0,500)
#

INSERT INTO `competencias` (`id`, `id_tax`, `descripcion`, `id_horas`) VALUES 
  (2,33,'adsfsdfsafasfsaf',17),
  (3,108,'Encuestar a los diferentes actores principales',18),
  (4,99,'Dibujar a Bob Esponja',19),
  (5,39,'expresar lalalala ',20),
  (6,154,'considerar bal bla bla bla',20),
  (7,49,'hola',21),
  (8,96,'sabes una cosa',23),
  (11,45,'Ordenar los conocimientos de la asignatura',28),
  (12,86,'asumir las cualidades',29),
  (13,44,'Interpretar los diseños ',29),
  (14,37,'estoy viendo que paso ayer',30);

COMMIT;

#
# Data for the `dificultad` table  (LIMIT 0,500)
#

INSERT INTO `dificultad` (`id`, `descripcion`) VALUES 
  (1,'baja'),
  (2,'media'),
  (3,'alta'),
  (4,'moderada');

COMMIT;

#
# Data for the `formato` table  (LIMIT 0,500)
#

INSERT INTO `formato` (`id`, `descripcion`) VALUES 
  (2,'Videos'),
  (3,'Presentación');

COMMIT;

#
# Data for the `idioma` table  (LIMIT 0,500)
#

INSERT INTO `idioma` (`id`, `descripcion`) VALUES 
  (1,'ingles'),
  (2,'español'),
  (3,'portugues'),
  (4,'francés');

COMMIT;

#
# Data for the `migrations` table  (LIMIT 0,500)
#

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES 
  (1,'2014_10_12_000000_create_users_table',1),
  (2,'2014_10_12_100000_create_password_resets_table',1),
  (3,'2015_08_04_131614_create_settings_table',2),
  (4,'2016_05_25_121918_create_pages_table',3),
  (5,'2017_04_10_195926_change_extras_to_longtext',3),
  (6,'2016_05_10_130540_create_permission_tables',4),
  (7,'2016_05_05_115641_create_menu_items_table',5);

COMMIT;

#
# Data for the `permissions` table  (LIMIT 0,500)
#

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES 
  (1,'Mis Asignaturas','web','2018-07-12 07:23:43','2018-07-17 19:05:17'),
  (2,'Designar Curso','web','2018-07-12 07:24:46','2018-07-12 07:24:46'),
  (3,'Usuarios','web','2018-07-12 07:25:11','2018-07-12 07:25:11'),
  (4,'Competencias','web','2018-07-12 07:25:33','2018-07-12 07:25:33'),
  (5,'Contenido y Temas','web','2018-07-13 22:23:29','2018-07-13 22:23:29'),
  (6,'Objetos de Aprendizaje','web','2018-07-13 22:23:48','2018-07-13 22:23:48'),
  (7,'Asignaturas','web','2018-07-15 00:12:51','2018-07-15 00:12:51'),
  (8,'Planificacion Curso','web','2018-07-17 02:45:41','2018-07-17 02:45:41'),
  (9,'Seguimiento Curricular','web','2018-07-20 04:27:33','2018-07-20 04:27:33');

COMMIT;

#
# Data for the `roles` table  (LIMIT 0,500)
#

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES 
  (1,'Académico','web','2018-07-12 02:02:09','2018-07-12 02:02:09'),
  (2,'Docente','web','2018-07-12 02:02:26','2018-07-12 02:02:26'),
  (3,'Administrador','web','2018-07-12 02:02:45','2018-07-12 02:02:45');

COMMIT;

#
# Data for the `model_has_roles` table  (LIMIT 0,500)
#

INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES 
  (1,3,'Backpack\\Base\\app\\Models\\BackpackUser'),
  (2,2,'Backpack\\Base\\app\\Models\\BackpackUser'),
  (2,3,'Backpack\\Base\\app\\Models\\BackpackUser'),
  (2,4,'Backpack\\Base\\app\\Models\\BackpackUser'),
  (3,1,'Backpack\\Base\\app\\Models\\BackpackUser');

COMMIT;

#
# Data for the `tipo_recurso_educativo` table  (LIMIT 0,500)
#

INSERT INTO `tipo_recurso_educativo` (`id`, `descripcion`) VALUES 
  (1,'Conocimiento');

COMMIT;

#
# Data for the `plan` table  (LIMIT 0,500)
#

INSERT INTO `plan` (`id`, `id_tema`, `horas_asignadas`, `porcentaje_aprobacion`, `estado`, `id_seguimiento`) VALUES 
  (1,1,12,12,'activo',NULL),
  (2,2,2,0.5,'activo',NULL),
  (3,3,2,3,'activo',NULL),
  (4,4,4,4,'activo',NULL),
  (5,5,3,1,'activo',NULL),
  (6,6,4,2,'activo',NULL),
  (7,7,12,43,'activo',NULL),
  (8,8,12,43,'activo',NULL),
  (9,9,12,43,'activo',NULL),
  (10,10,2,1,'activo',NULL),
  (11,11,1,3,'activo',NULL),
  (12,12,1,4,'activo',NULL),
  (13,13,2,3,'activo',NULL),
  (14,14,2,15,'activo',NULL),
  (15,15,2,3,'activo',NULL),
  (16,16,2,22,'activo',NULL),
  (17,17,2,12,'activo',NULL),
  (18,18,2,23,'activo',NULL);

COMMIT;

#
# Data for the `role_has_permissions` table  (LIMIT 0,500)
#

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES 
  (1,2),
  (2,1),
  (3,3),
  (4,2),
  (5,2),
  (6,2),
  (7,3),
  (8,2),
  (9,2);

COMMIT;

#
# Data for the `sucesor` table  (LIMIT 0,500)
#

INSERT INTO `sucesor` (`id`, `tema_id`, `sucesor`, `estado`) VALUES 
  (1,5,'cadena',1),
  (4,10,'dddd',1);

COMMIT;

