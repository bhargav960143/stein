<?php
if(isset($_REQUEST['page']) && !empty($_REQUEST['page'])){
    if($_REQUEST['page'] == "dfsettings"){
        ob_start();
    }
}
/*
	Include config function file to manage plugin configuration
*/
include 'config-function.php';
/*
	Register Current Plufin Path
*/
dentalfocus_register_current_plugin_path();
/*
	Add hook (action) to initialize plugin default function
*/
add_action('init', 'init_dentalfocus');
add_action('init', 'dentalfocus_custom_cms_register');
add_action('init', 'dentalfocus_custom_register_taxonomy');
add_action('admin_enqueue_scripts', 'dentalfocus_register_css_js');
add_action('admin_post_export_members_df', 'dentalfocus_export_members');
add_action('admin_post_backup_members_df', 'dentalfocus_backup_members');