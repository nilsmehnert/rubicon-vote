DROP TABLE IF EXISTS poll;
CREATE TABLE IF NOT EXISTS `poll` (
    `ID` INT(11) unsigned NOT NULL auto_increment,
    `name` VARCHAR(255) NOT NULL default '',
    `options` TEXT NOT NULL default '',
    `expected` INT(11) NOT NULL default '0',
    `created_by` VARCHAR(255) NOT NULL default '',
    `datum` DATETIME NOT NULL default NOW(),
    `open` BOOLEAN NOT NULL default '0',
    PRIMARY KEY  (`ID`)
);


DROP TABLE IF EXISTS vote;
CREATE TABLE IF NOT EXISTS `vote` (
    `ID` INT(11) unsigned NOT NULL auto_increment,
    `poll_id` INT(11) unsigned NOT NULL default '0',
    `answer` VARCHAR(255) NOT NULL default '',
    `session_id` VARCHAR(255) NOT NULL default '',
    `datum` DATETIME NOT NULL default NOW(),
    PRIMARY KEY  (`ID`),
    UNIQUE KEY `session` (`poll_id`,`session_id`)
);