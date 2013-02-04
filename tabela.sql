SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `teste` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `teste` ;

-- -----------------------------------------------------
-- Table `teste`.`products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `teste`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` TINYTEXT NOT NULL ,
  `slug` TINYTEXT NOT NULL ,
  `description` TEXT NOT NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `teste`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` TINYTEXT NOT NULL ,
  `email` TINYTEXT NOT NULL ,
  `password` TINYTEXT NOT NULL ,
  `reset` TINYTEXT NULL ,
  `last_access` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `is_active` TINYINT(1) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`medias`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `teste`.`medias` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `model` TINYTEXT NOT NULL ,
  `foreign_key` INT NOT NULL ,
  `name` TINYTEXT NOT NULL ,
  `media` TINYTEXT NOT NULL ,
  `dir` TINYTEXT NOT NULL ,
  `type` TINYTEXT NOT NULL ,
  `size` INT NOT NULL ,
  `description` TEXT NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk` (`foreign_key` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `teste`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `parent_id` INT NULL ,
  `title` TINYTEXT NOT NULL ,
  `slug` TINYTEXT NOT NULL ,
  `is_active` TINYINT(1) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_categories_categories1_idx` (`parent_id` ASC) ,
  CONSTRAINT `fk_categories_categories1`
    FOREIGN KEY (`parent_id` )
    REFERENCES `teste`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`categories_products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `teste`.`categories_products` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `category_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_categories_has_products_products1_idx` (`product_id` ASC) ,
  INDEX `fk_categories_has_products_categories1_idx` (`category_id` ASC) ,
  CONSTRAINT `fk_categories_has_products_categories1`
    FOREIGN KEY (`category_id` )
    REFERENCES `teste`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_categories_has_products_products1`
    FOREIGN KEY (`product_id` )
    REFERENCES `teste`.`products` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `teste` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `teste`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `teste`;
INSERT INTO `teste`.`users` (`id`, `name`, `email`, `password`, `reset`, `last_access`, `is_active`, `created`, `modified`) VALUES (1, 'Marcelo Siqueira', 'eu@marcelosiqueira.com.br', '20236cd8e3144a01635be6e35adae32546b34b1c', '', '', 1, NOW(), NOW());

COMMIT;

-- -----------------------------------------------------
-- Data for table `teste`.`categories`
-- -----------------------------------------------------
START TRANSACTION;
USE `teste`;
INSERT INTO `teste`.`categories` (`id`, `parent_id`, `title`, `slug`, `is_active`, `created`, `modified`) VALUES (1, NULL, 'Telefonia', 'telefonia', 1, NOW(), NOW());
INSERT INTO `teste`.`categories` (`id`, `parent_id`, `title`, `slug`, `is_active`, `created`, `modified`) VALUES (2, 1, 'Celular', 'celular', 1, NOW(), NOW());
INSERT INTO `teste`.`categories` (`id`, `parent_id`, `title`, `slug`, `is_active`, `created`, `modified`) VALUES (3, 2, 'Smartphone', 'smartphone', 1, NOW(), NOW());
INSERT INTO `teste`.`categories` (`id`, `parent_id`, `title`, `slug`, `is_active`, `created`, `modified`) VALUES (4, NULL, 'InformÃ¡tica', 'informatica', 1, NOW(), NOW());
INSERT INTO `teste`.`categories` (`id`, `parent_id`, `title`, `slug`, `is_active`, `created`, `modified`) VALUES (5, 4, 'Notebook', 'notebook', 1, NOW(), NOW());

COMMIT;
