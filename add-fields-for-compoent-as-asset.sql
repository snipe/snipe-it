ALTER TABLE `components` ADD   `model_id` int(11) DEFAULT NULL;
ALTER TABLE `components` ADD   `component_tag` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `components` ADD   `supplier_id` int(11) DEFAULT NULL;
ALTER TABLE `components` ADD   `warranty_months` int(11) DEFAULT NULL;
ALTER TABLE `components` ADD   `notes` text COLLATE utf8_unicode_ci;


ALTER TABLE `settings` ADD   `auto_increment_components` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `settings` ADD   `auto_increment_components_prefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0';