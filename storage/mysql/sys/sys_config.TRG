TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER sys_config_insert_set_user BEFORE INSERT on sys_config\n    FOR EACH ROW\nBEGIN\n    IF @sys.ignore_sys_config_triggers != true AND NEW.set_by IS NULL THEN\n        SET NEW.set_by = USER();\n    END IF;\nEND' 'CREATE DEFINER=`root`@`localhost` TRIGGER sys_config_update_set_user BEFORE UPDATE on sys_config\n    FOR EACH ROW\nBEGIN\n    IF @sys.ignore_sys_config_triggers != true AND NEW.set_by IS NULL THEN\n        SET NEW.set_by = USER();\n    END IF;\nEND'
sql_modes=0 0
definers='root@localhost' 'root@localhost'
client_cs_names='utf8mb3' 'utf8mb3'
connection_cl_names='utf8mb3_general_ci' 'utf8mb3_general_ci'
db_cl_names='utf8mb3_general_ci' 'utf8mb3_general_ci'
created=166941853691 166941853691
