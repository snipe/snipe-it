<?php

/**
 * Define env variable from env_FILE if exists (docker secrets support).
 * 
 * A helper function to lookup "env_FILE", "env", then fallback. Mainly used
 * for Docker Secrets.
 * Cribbed from the entrypoint php script of the official wordpress docker image:
 * https://github.com/docker-library/wordpress/blob/f5389a9a0cb963b3cd7f99484308428a14920790/wp-config-docker.php
 * 
 * @param string $env
 * @param string $default
 * 
 * @return string
 */

if (! function_exists('getenv_docker')) {
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return file_get_contents($fileEnv);
		}
		else if ($val = getenv($env)) {
			return $val;
		}
		else {
			return $default;
		}
	}
}
