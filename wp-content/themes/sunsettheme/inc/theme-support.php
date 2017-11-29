<?php
/**
 * Created by PhpStorm.
 * User: ALEX
 * Date: 19.11.2017
 * Time: 0:14
 */

$options = get_option('post_formats');

if (!empty($options)){
	add_theme_support('post-formats', array_keys($options));
}

$header = get_option('custom_header');
if(@$header == 1){
	add_theme_support('custom-header');
}

$background = get_option('custom_background');
if(@$background == 1){
	add_theme_support('custom-background');
}