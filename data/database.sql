CREATE TABLE `devices` (
	`device_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`modified` TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
	`created` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`account_id` BIGINT(20) UNSIGNED NOT NULL,
	`platform` VARCHAR(255) NOT NULL,
	`credentials` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`device_id`),
	UNIQUE KEY (`platform`, `credentials`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
