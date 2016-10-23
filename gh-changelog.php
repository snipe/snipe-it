<?php
#!/usr/bin/php -q

/* PHP requires defined timezone; GitHub uses UTC */
ini_set( 'date.timezone', 'UTC' );

/*
* YOU MUST CHANGE THESE VARIABLES
*/
$gh_user = 'snipe';
$gh_repo = 'snipe-it';
$file = 'CHANGELOG.md';
$string = 'fix|resolve|close|#changelog';
$omit = 'fuck';

/*
* No need to change anything below here
*/

// Clear old changelog info
file_put_contents($file,'');

$url = 'https://api.github.com/repos/'.$gh_user.'/'.$gh_repo.'/releases';
$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	curl_setopt($ch,CURLOPT_USERAGENT,$gh_user);
	$data = curl_exec($ch);
	curl_close($ch);

$releases = json_decode($data, TRUE);

while( $obj = array_shift( $releases ) )
{
	/* Define the beginning of each release block in the changelog */
	$changelog = "\n\n###  ".$obj['name']." - Released ".date("M d, Y h:i:s",strtotime($obj['created_at']))."\n";
	$changelog .= $obj['prerelease'] == 'true' ? '#### This is a pre-release '."\n": '';
	file_put_contents($file,$changelog,FILE_APPEND);

	/* Retrieve and format each commit entry */
	$gitlog = 'git log '.escapeshellarg($obj['tag_name']);

	/* Set commit limit based on next tag name */
	if ( $next = current($releases) )
	{
		$gitlog .= '...'.escapeshellarg($next['tag_name']).' ';
	}
	else $gitlog .= ' ';

	$gitlog .= '--pretty=format:\'* <a href="http://github.com/'.$gh_user.'/'.$gh_repo.'/commit/%H">view</a> &bull;';
	$gitlog .= ' %s \' --reverse | grep -i -E '.escapeshellarg($string).' ';

	if ($omit!=''){
		$gitlog .= ' | grep -i -E -v '.escapeshellarg($omit).'';
	}

	$gitlog .= '>> '.escapeshellarg($file);
	exec($gitlog);
}
