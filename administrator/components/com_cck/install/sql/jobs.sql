
CREATE TABLE IF NOT EXISTS `#__cck_more_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `folder` int(11) NOT NULL DEFAULT '1',
  `type` varchar(50) NOT NULL,
  `description` varchar(5120) NOT NULL,
  `options` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL DEFAULT '0',
  `run_as` int(10) unsigned NOT NULL DEFAULT '0',
  `run_url` int(11) NOT NULL DEFAULT '0',
  `run_url_custom` varchar(255) NOT NULL,
  `checked_out` int(10) UNSIGNED,
  `checked_out_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=500 ;


-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `#__cck_more_job_processing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) NOT NULL,
  `processing_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `processing_id` (`processing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;
