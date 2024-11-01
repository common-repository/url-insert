<?php
/*
Plugin Name: URL Insert
Plugin URI: http://wewa.kilu.de/2008/03/01/plugin-insert-url/
Description: This Plugin replaces [uri] with your siteurl 
Version: 1.0
Author: Christoph Weber
Author URI: http://wewa.kilu.de/
For Help visit http://wewa.kilu.de/2008/03/01/plugin-insert-url/.
*/

add_filter('the_content', 'url_insert');
add_filter('content_save_pre', 'url_replace');
//add_filter('comment_save_pre(comment_author_url)', 'url_replace');

function url_get_siteurl()
{
	global $wpdb;
	$sql = "SELECT option_value FROM $wpdb->options as options WHERE options.option_name='siteurl' ORDER BY option_id ASC";
	$results = array();
    $values = array();
    $results = $wpdb->get_results($sql);
    if (!empty($results))
        foreach ($results as $result) { $values[] = $result->option_value; };
	return $values[0];
}

function url_insert($content)
{
	$str=stristr($content,'<!--not-uri-->');
	if(empty($str))
	{
		$pattern = "/[uri]/i";
		$content = str_replace("[uri]", url_get_siteurl()."/", $content);
	}
    return $content;
}

function url_replace($content)
{
	$str=stristr($content,'<!--not-->');
	if(empty($str))
	{
		$content = str_replace(url_get_siteurl(), "[uri]", $content);
	}
	return $content;
}
?>