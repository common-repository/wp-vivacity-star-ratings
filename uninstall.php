<?php

if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();

delete_option('wpvisr_settings');
delete_option('wpvisr_version');
global $wpdb;
$qry="DROP TABLE IF EXISTS  `".$wpdb->prefix."wpvisr_votes` , `".$wpdb->prefix."wpvisr_rating`;";
$wpdb->query($qry);
unlink(__FILE__);
@rmdir(__DIR__);
?>