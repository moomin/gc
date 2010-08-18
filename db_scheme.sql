SET NAMES 'utf8';

-- geocache table

-- this line should be deleted once system is live
DROP TABLE IF EXISTS `geocache`;

CREATE TABLE IF NOT EXISTS `geocache` (
  `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `point` POINT NOT NULL,
-- will try to use spatial POINT column instead of lat and longt
--  latitude FLOAT(10,6),
--  longtitude FLOAT(10,6),
  `birthTimestamp` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  `submitTimestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator` VARCHAR(1000) NOT NULL COMMENT 'OpenID identifier',
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `cacheDescription` TEXT,
  `locationDescription` TEXT,
  CONSTRAINT PRIMARY KEY (`id`),
  INDEX (`creator`)
)
ENGINE = MyISAM
AUTO_INCREMENT = 1
CHARACTER SET = 'utf8'
COMMENT = 'storage for geocaches';

-- time zone table

DROP TABLE IF EXISTS `timeZone`;

CREATE TABLE IF NOT EXISTS `timeZone` (
  `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `diff` SMALLINT NOT NULL DEFAULT 0 COMMENT 'difference from UTC in minutes',
  CONSTRAINT PRIMARY KEY (`id`)
)
ENGINE = MyISAM
AUTO_INCREMENT = 1
CHARACTER SET = 'utf8'
COMMENT = 'Time zones';

INSERT INTO `timeZone` VALUES(NULL, 'GMT (UTC)', 0);

-- translations table

DROP TABLE IF EXISTS `translation`;

CREATE TABLE IF NOT EXISTS `translation` (
  `controller` VARCHAR(100) DEFAULT NULL,
  `method` VARCHAR(100) DEFAULT NULL,
  `languageId` TINYINT UNSIGNED DEFAULT 1,
  `label` VARCHAR(255) NOT NULL,
  `text` TEXT,
  CONSTRAINT PRIMARY KEY (`languageId`, `label`),
  INDEX (`controller`, `method`, `languageId`)
)
ENGINE = MyISAM
AUTO_INCREMENT = 1
CHARACTER SET = 'utf8'
COMMENT = 'text in different languages';
