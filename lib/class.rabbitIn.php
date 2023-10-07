<?php

class RabbitIn {
    public static function rabbitIn_init() {
        if(is_admin())
        {
            self::rabbitIn_config();
        }
        self::rabbitIn_front();
    }
    public static function rabbitIn_front()
    {

    }
    public static function rabbitIn_config()
    {
        self::rabbitIn_navbar();
        self::rabbitIn_asset();
        self::rabbitIn_pages();
    }
    public static function rabbitIn_navbar() {

    }
    public static function rabbitIn_asset() {
        function  rabbitIn_plugin_script_style() {
            wp_register_style('rabbit_tail', RI_PLUGIN_URL. 'assets/css/rabbit-tail.css');
            wp_enqueue_style('rabbit_tail');
        
            wp_register_style('rabbit_tail_datatables_style', RI_PLUGIN_URL. 'assets/datatables/datatables.min.css');
            wp_enqueue_style('rabbit_tail_datatables_style');
        
            wp_enqueue_script('jquery');
            wp_register_script( 'rabbit_tail_datatables_script', RI_PLUGIN_URL. 'assets/datatables/datatables.min.js');
            wp_enqueue_script( 'rabbit_tail_datatables_script' );	

            wp_register_script( 'rabbit_tail_validator_script', RI_PLUGIN_URL. 'assets/js/validator.js');
            wp_enqueue_script( 'rabbit_tail_validator_script' );

            if (isset($_GET['page'])) {
                if(in_array($_GET['page'], array('rabbit-integrator-new-template')))
                {
                    wp_register_script( 'rabbit_tail_new_template_script', RI_PLUGIN_URL. 'assets/js/new-template.js');
                    wp_enqueue_script( 'rabbit_tail_new_template_script' );
                }
            }
        }
        add_action( 'admin_enqueue_scripts', 'rabbitin_plugin_script_style' );
    }
    public static function rabbitIn_pages() {
        add_menu_page('Dashbord', 'Rabbit Integrator', 'edit_posts', 'rabbit-integrator-dashboard', 'rabbitIn_dashboard', 'dashicons-bank');
        add_submenu_page('rabbit-integrator-new-template', 'New Template', 'New Template', 'edit_posts', 'rabbit-integrator-new-template', 'rabbitIn_new_template');
        function rabbitIn_dashboard(){
            global $wpdb;
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-dashboard.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
        function rabbitIn_new_template(){
            global $wpdb;
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-new-template.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
    }
    public static function rabbitIn_activation() {
        global $wpdb;
        try
        {
            // dbDelta("CREATE TABLE `".$wpdb->prefix. "rabbit_creator_template` (
            //     `template_id` bigint(20) NOT NULL AUTO_INCREMENT,
            //     `template_name` varchar(250) NOT NULL,
            //     `template_post_type` varchar(250) NOT NULL,
            //     `template_post_author` bigint(20) NOT NULL,
            //     `template_post_title` varchar(250) NOT NULL,
            //     `template_post_content` longtext NOT NULL,
            //     `template_data_file` varchar(250) NOT NULL,
            //     `template_data_file_skip_row` VARCHAR(10) NOT NULL,
            //     `template_placeholder` text NOT NULL,
            //     `template_data_column` text NOT NULL,
            //     `template_post_date_column` text NOT NULL,
            //     `template_post_ids` LONGTEXT NOT NULL,
            //     `template_post_ids_temp` LONGTEXT NOT NULL, 
            //     `template_category` TEXT NOT NULL,
            //     `template_tag` TEXT NOT NULL,
            //     `template_post_slug_column` TEXT NOT NULL,
            //     `template_page_template` TEXT NOT NULL,
            //     `template_parent_page` INT NOT NULL,
            //     `template_post_status` TEXT NOT NULL,
            //     `template_seo_title` TEXT NOT NULL,
            //     `template_seo_description` TEXT NOT NULL,
            //     `template_seo_focus_keyword` TEXT NOT NULL,
            //     `template_featured_image_column` text NOT NULL,
            //     `template_featured_image_alt_column` INT NOT NULL,
            //     `template_featured_image_title_column` INT NOT NULL,
            //     `template_featured_image_caption_column` INT NOT NULL,
            //     `template_featured_image_description_column` INT NOT NULL,
            //     `template_keyword` TEXT NOT NULL,
            //     `template_robots_meta` TEXT NOT NULL,
            //     `template_parent_page_column` TEXT NOT NULL,
            //     `template_datetime` datetime NOT NULL,
            //     `template_csv_rows` LONGTEXT NOT NULL,
            //     `template_csv_data` LONGTEXT NOT NULL,
            //     `template_status` ENUM('publish','draft') NOT NULL DEFAULT 'publish',
            //     `template_processing_pointer` BIGINT NOT NULL,
            //     PRIMARY KEY (`template_id`)
            // );");

            // dbDelta("CREATE TABLE `".$wpdb->prefix. "rabbit_creator` (
            //     `id` int(11) NOT NULL AUTO_INCREMENT,
            //     `option_name` text NOT NULL,
            //     `option_value` text NOT NULL,
            //     `status` enum('Y','N') NOT NULL DEFAULT 'Y',
            //     PRIMARY KEY (`id`)
            // );");

            // dbDelta("CREATE TABLE `".$wpdb->prefix. "rabbit_creator_pages` (
            //     `page_id` bigint(20) NOT NULL AUTO_INCREMENT,
            //     `post_id` bigint(20) NOT NULL,
            //     `template_id` bigint(20) NOT NULL,
            //     `created_date` datetime NOT NULL DEFAULT current_timestamp(),
            //     PRIMARY KEY (`page_id`)
            // );");
        } 
        catch (Exception $e) {}	
    }
}