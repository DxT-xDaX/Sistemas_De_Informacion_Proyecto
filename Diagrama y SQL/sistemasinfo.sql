SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sistemas_info
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sistemas_info` DEFAULT CHARACTER SET utf8 ;
USE `sistemas_info` ;

-- Tabla de Personas
CREATE TABLE personas (
    `id_persona` INT(5) NOT NULL,
    `contrasena` VARCHAR(255) NOT NULL,
    `usuario` VARCHAR(255) NULL,
    PRIMARY KEY (`id_persona`)
);

-- Tabla de Oficios
CREATE TABLE oficios (
    `num_oficio` INT(5) NOT NULL,
    `persona` VARCHAR(255) NOT NULL,
    `area` VARCHAR(255) NOT NULL,
    `asunto` VARCHAR(255) NOT NULL,
    `fecha` VARCHAR(255) NOT NULL,
    `hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`num_oficio`)
);
