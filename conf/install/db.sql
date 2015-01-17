-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mandala
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mandala
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS 'mandala' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE 'mandala' ;

-- -----------------------------------------------------
-- Table 'mandala'.'user'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS 'mandala'.'user' (
  'userID' INT NOT NULL AUTO_INCREMENT,
  'loginName' VARCHAR(45) NULL,
  'emailAddress' VARCHAR(100) NULL,
  'encPassword' VARCHAR(97) NULL,
  'signupDate' INT(11) NULL,
  'accountActivation' INT(11) NULL,
  'userEnabled' TINYINT(1) NULL,
  PRIMARY KEY ('userID'),
  UNIQUE INDEX 'userLogin_UNIQUE' ('loginName' ASC),
  UNIQUE INDEX 'userEmail_UNIQUE' ('emailAddress' ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table 'mandala'.'user_access_log'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS 'mandala'.'user_access_log' (
  'logID' INT NOT NULL AUTO_INCREMENT,
  'userID' INT NOT NULL,
  'accessDate' INT(11) NULL,
  'ipAddress' VARCHAR(64) NULL,
  'logNote' VARCHAR(255) NULL,
  INDEX 'fk_user_access_log_user_idx' ('userID' ASC),
  PRIMARY KEY ('logID'),
  CONSTRAINT 'fk_user_access_log_user'
    FOREIGN KEY ('userID')
    REFERENCES 'mandala'.'user' ('userID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- Table 'mandala'.'user_ban'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS 'mandala'.'user_ban' (
  'banID' INT NOT NULL AUTO_INCREMENT,
  'bannedUserID' INT NOT NULL,
  'issuingUserID' INT NOT NULL,
  'startDate' INT(11) NOT NULL,
  'endDate' INT(11) NULL,
  'banReason' VARCHAR(255) NOT NULL,
  'revocationDate' INT(11) NULL,
  'revocationReason' VARCHAR(255) NULL,
  PRIMARY KEY ('banID'),
  INDEX 'fk_user_ban_user1_idx' ('bannedUserID' ASC),
  INDEX 'fk_user_ban_user2_idx' ('issuingUserID' ASC),
  CONSTRAINT 'fk_user_ban_user1'
    FOREIGN KEY ('bannedUserID')
    REFERENCES 'mandala'.'user' ('userID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT 'fk_user_ban_user2'
    FOREIGN KEY ('issuingUserID')
    REFERENCES 'mandala'.'user' ('userID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table 'mandala'.'groups'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS 'mandala'.'groups' (
  'groupID' INT NOT NULL AUTO_INCREMENT,
  'groupName' VARCHAR(255) NULL,
  'visible' TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY ('groupID'),
  UNIQUE INDEX 'groupName_UNIQUE' ('groupName' ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table 'mandala'.'user_has_group_membership'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS 'mandala'.'user_has_group_membership' (
  'userID' INT NOT NULL,
  'groupID' INT NOT NULL,
  'groupAdmin' TINYINT(1) NULL DEFAULT 0,
  'groupOwner' TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY ('userID', 'groupID'),
  INDEX 'fk_user_has_group_membership_groups1_idx' ('groupID' ASC),
  CONSTRAINT 'fk_user_has_group_membership_user1'
    FOREIGN KEY ('userID')
    REFERENCES 'mandala'.'user' ('userID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT 'fk_user_has_group_membership_groups1'
    FOREIGN KEY ('groupID')
    REFERENCES 'mandala'.'groups' ('groupID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table 'mandala'.'user_notes'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS 'mandala'.'user_notes' (
  'noteID' INT NOT NULL AUTO_INCREMENT,
  'subjectUserID' INT NOT NULL,
  'autherUserID' INT NOT NULL,
  'noteDate' INT(11) NULL,
  'content' TEXT NULL,
  'visibileToSubject' TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY ('noteID'),
  INDEX 'fk_user_notes_user1_idx' ('subjectUserID' ASC),
  INDEX 'fk_user_notes_user2_idx' ('autherUserID' ASC),
  CONSTRAINT 'fk_user_notes_user1'
    FOREIGN KEY ('subjectUserID')
    REFERENCES 'mandala'.'user' ('userID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT 'fk_user_notes_user2'
    FOREIGN KEY ('autherUserID')
    REFERENCES 'mandala'.'user' ('userID')
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '	';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
