<?php
/*
	Create function for register plugin configuration at activation time.
	Setup Database, Create Pages, Insert Widget, Insert Menu, Define Constants All are manage at lugin activation time.
*/
function dentalfocus_active_plugin(){
    /*
        Define Global variable to use database connection
    */
    global $wpdb;
    /*
        Get and set database default charset
        Create table for social media url manage
    */
    $df_social_table = 'trentium_membership_settings';
    /*
        Check IF table not exist then create table.
    */
    $createTable = "CREATE TABLE IF NOT EXISTS $df_social_table (
						id 		                INT(11) 		NOT NULL AUTO_INCREMENT,
						memership_term 		    INT(11) 		NOT NULL,
						eprosit_digital 	    DECIMAL(15,2)   NOT NULL,
						eprosit_print_usa 	    DECIMAL(15,2)   NOT NULL,
						eprosit_print_ca_mx     DECIMAL(15,2)   NOT NULL,
						eprosit_print_all 	    DECIMAL(15,2)   NOT NULL,
						PRIMARY KEY id (id)
					)";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $createTable );

    $df_trentium_membership_payments = 'trentium_membership_payments';
    /*
        Check IF table not exist then create table.
    */
    $createTablePaypal = "CREATE TABLE IF NOT EXISTS $df_trentium_membership_payments (
						id 		                INT(11) 	   NOT NULL AUTO_INCREMENT,
						memership_term 		    INT(11) 	   NOT NULL,
						memership_country 	    VARCHAR(191)   NOT NULL,
						print_or_digital 	    VARCHAR(191)   NOT NULL,
						membership 	            VARCHAR(191)   NOT NULL,
						paypal_payer_id         VARCHAR(255)   NULL,
						paypal_st 	            VARCHAR(255)   NULL,
						paypal_tx 	            VARCHAR(255)   NULL,
						paypal_cc 	            VARCHAR(255)   NULL,
						paypal_amount 	        DECIMAL(15,2)  NULL,
						payer_email 	        VARCHAR(255)   NULL,
						payer_id 	            VARCHAR(255)   NULL,
						payer_status 	        VARCHAR(255)   NULL,
						first_name 	            VARCHAR(255)   NULL,
						last_name 	            VARCHAR(255)   NULL,
						address_name 	        VARCHAR(255)   NULL,
						address_street 	        VARCHAR(255)   NULL,
						address_city 	        VARCHAR(255)   NULL,
						address_state 	        VARCHAR(255)   NULL,
						address_country_code 	VARCHAR(255)   NULL,
						address_zip 	        VARCHAR(255)   NULL,
						residence_country 	    VARCHAR(255)   NULL,
						txn_id 	                VARCHAR(255)   NULL,
						mc_currency 	        VARCHAR(255)   NULL,
						mc_fee 	                DECIMAL(15,2)   NULL,
						mc_gross 	            DECIMAL(15,2)   NULL,
						protection_eligibility 	VARCHAR(255)   NULL,
						payment_fee 	        DECIMAL(15,2)   NULL,
						payment_gross 	        VARCHAR(255)   NULL,
						payment_status 	        VARCHAR(255)   NULL,
						payment_type 	        VARCHAR(255)   NULL,
						handling_amount 	    DECIMAL(15,2)   NULL,
						shipping 	            DECIMAL(15,2)   NULL,
						item_name 	            VARCHAR(255)   NULL,
						quantity 	            INT(11)   NULL,
						txn_type 	            VARCHAR(255)   NULL,
						payment_date 	        TIMESTAMP   NULL,
						receiver_id 	        VARCHAR(255)   NULL,
						notify_version 	        VARCHAR(255)   NULL,
						verify_sign 	        VARCHAR(255)   NULL,
						PRIMARY KEY id (id)
					)";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $createTablePaypal );

    $df_trentium_membership_users = 'trentium_membership_users';
    /*
        Check IF table not exist then create table.
    */
    $createTableUsers = "CREATE TABLE IF NOT EXISTS $df_trentium_membership_users (
						member_no 		        INT(11) 	   NOT NULL AUTO_INCREMENT,
						last_payment_id 		INT(11) 	   NULL,
						username 		        VARCHAR(191)   NULL,
						password 	            VARCHAR(191)   NULL,
						customer_email 	        VARCHAR(191)   NULL,
						customer_first_name 	VARCHAR(191)   NULL,
						customer_last_name 	    VARCHAR(191)   NULL,
						customer_spouse         VARCHAR(255)   NULL,
						customer_address 	    VARCHAR(255)   NULL,
						customer_city 	        VARCHAR(255)   NULL,
						customer_state 	        VARCHAR(255)   NULL,
						customer_zip 	        VARCHAR(255)   NULL,
						customer_country 	    VARCHAR(255)   NULL,
						customer_home_phone 	VARCHAR(255)   NULL,
						customer_mobile_phone 	VARCHAR(255)   NULL,
						listing_option 	        VARCHAR(255)   NULL,
						referred_by 	        VARCHAR(255)   NULL,
						purchaser_name 	        VARCHAR(255)   NULL,
						purchaser_email 	    VARCHAR(255)   NULL,
						chapter 	            VARCHAR(255)   NULL,
						master_steinologist 	VARCHAR(255)   NULL,
						local_chapter_officer 	VARCHAR(255)   NULL,
						collecting_interests 	VARCHAR(255)   NULL,
						is_admin 	        TINYINT(1) DEFAULT 0 NULL,
						paid_until 	        VARCHAR(255)   NULL,
						can_see_paid_until 	TINYINT(1) DEFAULT 0 NULL,
						last_login 	        DATE           NULL,
						first_class 	    VARCHAR(255)   NULL,
						trans 	            VARCHAR(255)   NULL,
						paid_qtr 	        VARCHAR(255)   NULL,
						changes 	        VARCHAR(255)   NULL,
						company 	        VARCHAR(255)   NULL,
						cell_phone 	        VARCHAR(255)   NULL,
						Office_phone 	    VARCHAR(255)   NULL,
						No_list 	        VARCHAR(255)   NULL,
						chapter_position 	VARCHAR(255)   NULL,
						comments 	        VARCHAR(255)   NULL,
						SubCode 	        VARCHAR(255)   NULL,
						FirstYear 	        VARCHAR(255)   NULL,
						LastUpdate 	        VARCHAR(255)   NULL,
						PastMember 	        VARCHAR(255)   NULL,
						TypeOfMembership 	VARCHAR(255)   NULL,
						Notes 	            VARCHAR(255)   NULL,
						PRIMARY KEY member_no (member_no)
					)";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $createTableUsers );
}
/*
	Create function to remove plugin at uninstall time
*/
function dentalfocus_uninstall_plugin(){
    /*
        Define Global variable to use database connection
    */
    global $wpdb;
    /*
        Get and set database default charset
        Drop table at deactivation of plugin
    */
    $df_social_table = 'trentium_membership_settings';
    $df_trentium_membership_payments = 'trentium_membership_payments';
    /*
        Check IF Table exist then remove
    */
    $deleteTable = "DROP TABLE IF EXISTS $df_social_table";
    $deleteTablePaypal = "DROP TABLE IF EXISTS $df_trentium_membership_payments";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $deleteTable );
    dbDelta( $deleteTablePaypal );
}
/*
	Register Current Plugin And Manage Current Plugin Path
*/
function dentalfocus_register_current_plugin_path(){
    /*
        Define Plugin Asserts
        Check the Asserts Path is defined, If not Then define
    */
    if(!defined('DENTALFOCUS_IMAGES')){
        define("DENTALFOCUS_IMAGES", plugins_url('../images/', __FILE__ ));
    }
    if(!defined('DENTALFOCUS_CSS')){
        define("DENTALFOCUS_CSS", plugins_url('../css/', __FILE__ ));
    }
    if(!defined('DENTALFOCUS_SCRIPTS')){
        define("DENTALFOCUS_SCRIPTS", plugins_url('../scripts/', __FILE__ ));
    }
    if(!defined('DENTALFOCUS_WP_ADMIN_URL')){
        define("DENTALFOCUS_WP_ADMIN_URL", site_url().'/wp-admin/');
    }
}
/*
	Create function for iitialize dentalfocus settings.
	Register action and hooks.
*/
function init_dentalfocus(){
    /*
        Add action to register dentalfocus menu
    */
    add_action('admin_menu', 'dentalfocus_admin_menu');
}
/*
	Create function for register dentalfocus menu.
	Register dashboard of dantal focus and give all manage option in the dashboard.
*/
function dentalfocus_admin_menu(){
    /*
        Add dentalfocus menu page for manage option
    */
    add_menu_page('SCI Membership', 'SCI Membership', 'manage_options', 'dentalfocus', 'dentalfocusmanager', DENTALFOCUS_IMAGES.'favicon.ico', 81);
    add_menu_page('Membership Setting', 'eProsit Setting', 'manage_options', 'tssettings', 'dentalfocusmanager', 'dashicons-share-alt', 88);
}
/*
	Create function for initialize custom texonomy
	Register Custom Post Type
*/
function dentalfocus_custom_cms_register() {
    $labelsTestimonial = array(
        'name'                => _x( 'Testimonial', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Testimonial', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Testimonial', 'text_domain' ),
        'view_item'           => __( 'View Testimonial', 'text_domain' ),
        'add_new_item'        => __( 'Add New Testimonial', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Testimonial', 'text_domain' ),
        'update_item'         => __( 'Update Testimonial', 'text_domain' ),
        'search_items'        => __( 'Search Testimonial', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $labelsTeam = array(
        'name'                => _x( 'Team', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Team', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Team', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Team', 'text_domain' ),
        'view_item'           => __( 'View Team', 'text_domain' ),
        'add_new_item'        => __( 'Add New Team', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Team', 'text_domain' ),
        'update_item'         => __( 'Update Team', 'text_domain' ),
        'search_items'        => __( 'Search Team', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $labelsTreatment = array(
        'name'                => _x( 'Treatment', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Treatment', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Treatment', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Treatment', 'text_domain' ),
        'view_item'           => __( 'View Treatment', 'text_domain' ),
        'add_new_item'        => __( 'Add New Treatment', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Treatment', 'text_domain' ),
        'update_item'         => __( 'Update Treatment', 'text_domain' ),
        'search_items'        => __( 'Search Treatment', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $labelsPortfolio = array(
        'name'                => _x( 'Portfolio', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Portfolio', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Portfolio', 'text_domain' ),
        'view_item'           => __( 'View Portfolio', 'text_domain' ),
        'add_new_item'        => __( 'Add New Portfolio', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Portfolio', 'text_domain' ),
        'update_item'         => __( 'Update Portfolio', 'text_domain' ),
        'search_items'        => __( 'Search Portfolio', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $labelsBanner = array(
        'name'                => _x( 'Banner', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Banner', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Banner', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Banner', 'text_domain' ),
        'view_item'           => __( 'View Banner', 'text_domain' ),
        'add_new_item'        => __( 'Add New Banner', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Banner', 'text_domain' ),
        'update_item'         => __( 'Update Banner', 'text_domain' ),
        'search_items'        => __( 'Search Banner', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );

    $argsTestimonial = array(
        'label'               => __( 'df-testimonial', 'text_domain' ),
        'description'         => __( 'Post Type Description', 'text_domain' ),
        'labels'              => $labelsTestimonial,
        'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
        'taxonomies'          => array( 'df-category-testimonial' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 82,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon' 		  => 'dashicons-testimonial'
    );
    $argsTeam = array(
        'label'               => __( 'df-team', 'text_domain' ),
        'description'         => __( 'Post Type Description', 'text_domain' ),
        'labels'              => $labelsTeam,
        'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
        'taxonomies'          => array( 'df-category-team' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 83,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon' 		  => 'dashicons-groups'
    );
    $argsTreatment = array(
        'label'               => __( 'df-treatment', 'text_domain' ),
        'description'         => __( 'Post Type Description', 'text_domain' ),
        'labels'              => $labelsTreatment,
        'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
        'taxonomies'          => array( 'df-category-treatment' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 84,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon' 		  => 'dashicons-plus-alt'
    );
    $argsPortfolio = array(
        'label'               => __( 'df-portfolio', 'text_domain' ),
        'description'         => __( 'Post Type Description', 'text_domain' ),
        'labels'              => $labelsPortfolio,
        'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
        'taxonomies'          => array( 'df-category-portfolio' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 85,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon' 		  => 'dashicons-portfolio'
    );
    $argsBanner = array(
        'label'               => __( 'df-banner', 'text_domain' ),
        'description'         => __( 'Post Type Description', 'text_domain' ),
        'labels'              => $labelsBanner,
        'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes'),
        'taxonomies'          => array( 'df-category-banner' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 86,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon' 		  => 'dashicons-format-gallery'
    );

    register_post_type( 'df-testimonial', $argsTestimonial );
    register_post_type( 'df-team', $argsTeam );
    register_post_type( 'df-treatment', $argsTreatment );
    register_post_type( 'df-portfolio', $argsPortfolio );
    register_post_type( 'df-banner', $argsBanner );
}
/*
	Create function for initialize custom texonomy
	Register a taxonomy
*/
function dentalfocus_custom_register_taxonomy(){

    register_taxonomy( 'df-treatment-categories', 'df-treatment',
        array(
            'labels' => array(
                'name'              => 'Treatment Categories',
                'singular_name'     => 'Treatment Categories',
                'search_items'      => 'Search Treatment Categories',
                'all_items'         => 'All Treatment Categories',
                'edit_item'         => 'Edit Treatment Categories',
                'update_item'       => 'Update Treatment Categories',
                'add_new_item'      => 'Add New Treatment Categories',
                'new_item_name'     => 'New Treatment Categories Name',
                'menu_name'         => 'Treatment Categories',
            ),

            'hierarchical' => true,
            'sort' => true,
            'args' => array( 'orderby' => 'term_order' ),
            'rewrite' => array( 'slug' => 'treatment-categories' ),
            'show_admin_column' => true
        )
    );

    register_taxonomy( 'df-banner-categories', 'df-banner',
        array(
            'labels' => array(
                'name'              => 'Banner Categories',
                'singular_name'     => 'Banner Categories',
                'search_items'      => 'Search Banner Categories',
                'all_items'         => 'All Banner Categories',
                'edit_item'         => 'Edit Banner Categories',
                'update_item'       => 'Update Banner Categories',
                'add_new_item'      => 'Add New Banner Categories',
                'new_item_name'     => 'New Banner Categories Name',
                'menu_name'         => 'Banner Categories',
            ),
            'hierarchical' => true,
            'sort' => true,
            'args' => array( 'orderby' => 'term_order' ),
            'rewrite' => array( 'slug' => 'banner-categories' ),
            'show_admin_column' => true
        )
    );

    register_taxonomy( 'df-portfolio-categories', 'df-portfolio',
        array(
            'labels' => array(
                'name'              => 'Portfolio Categories',
                'singular_name'     => 'Portfolio Categories',
                'search_items'      => 'Search Portfolio Categories',
                'all_items'         => 'All Portfolio Categories',
                'edit_item'         => 'Edit Portfolio Categories',
                'update_item'       => 'Update Portfolio Categories',
                'add_new_item'      => 'Add New Portfolio Categories',
                'new_item_name'     => 'New Portfolio Categories Name',
                'menu_name'         => 'Portfolio Categories',
            ),
            'hierarchical' => true,
            'sort' => true,
            'args' => array( 'orderby' => 'term_order' ),
            'rewrite' => array( 'slug' => 'portfolio-categories' ),
            'show_admin_column' => true
        )
    );

    register_taxonomy( 'df-team-categories', 'df-team',
        array(
            'labels' => array(
                'name'              => 'Team Categories',
                'singular_name'     => 'Team Categories',
                'search_items'      => 'Search Team Categories',
                'all_items'         => 'All Team Categories',
                'edit_item'         => 'Edit Team Categories',
                'update_item'       => 'Update Team Categories',
                'add_new_item'      => 'Add New Team Categories',
                'new_item_name'     => 'New Team Categories Name',
                'menu_name'         => 'Team Categories',
            ),
            'hierarchical' => true,
            'sort' => true,
            'args' => array( 'orderby' => 'term_order' ),
            'rewrite' => array( 'slug' => 'team-categories' ),
            'show_admin_column' => true
        )
    );

    register_taxonomy( 'df-category-testimonial', 'df-testimonial',
        array(
            'labels' => array(
                'name'              => 'Testimonial Categories',
                'singular_name'     => 'Testimonial Categories',
                'search_items'      => 'Search Testimonial Categories',
                'all_items'         => 'All Testimonial Categories',
                'edit_item'         => 'Edit Testimonial Categories',
                'update_item'       => 'Update Testimonial Categories',
                'add_new_item'      => 'Add New Testimonial Categories',
                'new_item_name'     => 'New Testimonial Categories Name',
                'menu_name'         => 'Testimonial Categories',
            ),
            'hierarchical' => true,
            'sort' => true,
            'args' => array( 'orderby' => 'term_order' ),
            'rewrite' => array( 'slug' => 'testimonial-categories' ),
            'show_admin_column' => true
        )
    );
}
/*
	Create function for register css and js
*/
function dentalfocus_register_css_js(){
    /*
         Register Stylesheet for plugin
    */
    wp_enqueue_style('validationEngine-jquery-css', DENTALFOCUS_CSS . 'validationengine.jquery.css');

    /*
         Register Scripts for plugin
    */
    wp_enqueue_script('jquery-validationEngine-js', DENTALFOCUS_SCRIPTS . 'jquery.validationEngine.js');
    wp_enqueue_script('jquery-validationEngine-en-js', DENTALFOCUS_SCRIPTS . 'jquery.validationEngine-en.js');
}
/*
	Function to create for message display.
	Message class are below.
	
	.media-upload-form .notice, 
	.media-upload-form div.error, 
	.wrap .notice, .wrap div.error, 
	.wrap div.updated
*/
function dentalfocus_messagedisplay(){
    if(isset($_REQUEST['msg']) && !empty($_REQUEST['msg'])){
        switch ($_REQUEST['msg']) {
            case "swr":
                $messageText = "Something went wrong please try again.";
                $divClass = 'error';
                break;
            case "rsi":
                $messageText = "Record has been successfully inserted.";
                $divClass = 'updated';
                break;
            case "rds":
                $messageText = "Record has been successfully deleted.";
                $divClass = 'updated';
                break;
            case "rus":
                $messageText = "Record has been successfully updated.";
                $divClass = 'updated';
                break;
            case "imn":
                $messageText = "Invalid record number, please try again.";
                $divClass = 'error';
                break;
            default:
                $messageText = "Something went wrong please try again.";
                $divClass = 'error';
        }
        ?><div class="updated <?php echo $divClass; ?> below-h4">
        <h4><?php echo $messageText; ?></h4>
        </div><?php
    }
}

function dentalfocus_export_members() {
    // Check for the custom action in the URL
    if (isset($_GET['action']) && $_GET['action'] === 'export_members_df') {
        ob_start();

        // Database call to fetch records
        $objDB = new dentalfocus_db_function();
        $resData = $objDB->dentalfocus_select_all_records('trentium_membership_users');

        if (!empty($resData)) {
            // CSV Header Row
            $csv_header_row = "Mbr #,last_name,first_name,spouse/partner,street_address,city,state,zip,country,HomePhone,cell_phone,email address,chapter,master_steinologist,paid_until,eProsit,Date Paid,NoList,Pmt Terms,FirstYear,Mbr Status,Notes,ReferdBy,collecting_interests\n";

            $output = $csv_header_row;

            // CSV Content Rows
            foreach ($resData as $valueData) {
                $csv_row_content = '"' . implode('","', array_map('addslashes', $valueData)) . '"' . "\n";
                $output .= $csv_row_content;
            }

            // Generate and Output CSV
            $today = date("Y-m-d");
            $filename = "MMT_all_members_sorted_" . $today . ".csv";

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo $output;
            exit;
        } else {
            // Redirect if no data is found
            wp_redirect("admin.php?page=tssettings&tab=members&msg=swr");
            exit;
        }
    }
}
function dentalfocus_backup_members() {
    // Check for the custom action in the URL
    if (isset($_GET['action']) && $_GET['action'] === 'backup_members_df') {
        ob_start();

        // Database call to fetch records
        $objDB = new dentalfocus_db_function();
        $resData = $objDB->dentalfocus_select_all_records('trentium_membership_users');

        if (!empty($resData)) {
            $i = 0;
            $csv_header_row = '';
            foreach($resData[0] as $keyDataField => $valueDataField){
                if($i == 0){
                    $csv_header_row .= $keyDataField;
                }
                else{
                    $csv_header_row .= ',' . $keyDataField;
                }
                $i++;
            }
            $csv_header_row .= "\n";
            $output = $csv_header_row;

            // CSV Content Rows
            foreach ($resData as $valueData) {
                $csv_row_content = '"' . implode('","', array_map('addslashes', $valueData)) . '"' . "\n";
                $output .= $csv_row_content;
            }

            // Generate and Output CSV
            $today = date("Y-m-d");
            $filename = "Users_" . $today . ".csv";

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename=' . $filename);
            echo $output;
            exit;
        } else {
            // Redirect if no data is found
            wp_redirect("admin.php?page=tssettings&tab=members&msg=swr");
            exit;
        }
    }
}
?>