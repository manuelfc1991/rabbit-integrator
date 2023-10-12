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
        if (!is_admin()) 
            require_once RI_PLUGIN_BASE_DIR . 'lib/head.php';
    }
    public static function rabbitIn_config()
    {
        self::rabbitIn_navbar();
        self::rabbitIn_asset();
        self::rabbitIn_pages();
        self::rabbitIn_ajaxfunction();
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

            wp_register_script( 'rabbit_tail_rabbit_integrator_script', RI_PLUGIN_URL. 'assets/js/rabbit-integrator.js');
            wp_enqueue_script( 'rabbit_tail_rabbit_integrator_script' );

            if (isset($_GET['page'])) {
                if(in_array($_GET['page'], array('rabbit-integrator-new-template','rabbit-integrator-edit-template')))
                {
                    wp_register_style('rabbit_tail_simple_color_picker_style', RI_PLUGIN_URL. 'assets/css/jquery.simple-color-picker.css');
                    wp_enqueue_style('rabbit_tail_simple_color_picker_style');
                    wp_register_script( 'rabbit_tail_simple_color_picker_script', RI_PLUGIN_URL. 'assets/js/jquery.simple-color-picker.js');
                    wp_enqueue_script( 'rabbit_tail_simple_color_picker_script' );
                    wp_register_script( 'rabbit_tail_new_template_script', RI_PLUGIN_URL. 'assets/js/new-template.js');
                    wp_enqueue_script( 'rabbit_tail_new_template_script' );
                } 
                else if(in_array($_GET['page'], array('rabbit-integrator-template-list')))
                {
                    wp_register_script( 'rabbit_tail_template_list_script', RI_PLUGIN_URL. 'assets/js/template-list.js');
                    wp_enqueue_script( 'rabbit_tail_template_list_script' );
                }
                else if(in_array($_GET['page'], array('rabbit-integrator-settings')))
                {
                    wp_register_script( 'rabbit_tail_settings_script', RI_PLUGIN_URL. 'assets/js/settings.js');
                    wp_enqueue_script( 'rabbit_tail_settings_script' );
                }
            }
        }
        add_action( 'admin_enqueue_scripts', 'rabbitin_plugin_script_style' );
    }
    public static function rabbitIn_pages() {
        add_menu_page('Dashbord', 'Rabbit Integrator', 'edit_posts', 'rabbit-integrator-dashboard', 'rabbitIn_dashboard', 'dashicons-bank');
        add_submenu_page('rabbit-integrator-new-template', 'New Template', 'New Template', 'edit_posts', 'rabbit-integrator-new-template', 'rabbitIn_new_template');
        add_submenu_page('rabbit-integrator-edit-template', 'Edit Template', 'Edit Template', 'edit_posts', 'rabbit-integrator-edit-template', 'rabbitIn_edit_template');
        add_submenu_page('rabbit-integrator-template-list', 'Template List', 'Template List', 'edit_posts', 'rabbit-integrator-template-list', 'rabbitIn_template_list');
        add_submenu_page('rabbit-integrator-settings', 'Settings', 'Settings', 'edit_posts', 'rabbit-integrator-settings', 'rabbitIn_settings');
        function rabbitIn_dashboard(){
            global $wpdb;
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-popup.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-dashboard.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
        function rabbitIn_new_template(){
            global $wpdb;
            $cpy_id = isset($_GET['cpy_id']) ? $_GET['cpy_id'] : null;
            $title = '';
            $price = '';
            $button_text = '';
            $button_text_size = '';
            $button_width = '';
            $button_height = '';
            $button_text_color = '';
            $button_color = '';
            $data_flag = false;
            $cpy_flag = false;
            $templateResults = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_template WHERE template_id = '$cpy_id'", ARRAY_A);
            if($templateResults)
            {
                $cpy_flag = true;
                $title = $templateResults[0]['template_title'];
                $price = empty($templateResults[0]['template_price']) ? '' : $templateResults[0]['template_price'];    
                $button_text = $templateResults[0]['template_btn_txt']; 
                $button_text_size = $templateResults[0]['template_btn_txt_size'];
                $button_width = $templateResults[0]['template_btn_width'];
                $button_height = $templateResults[0]['template_btn_height'];
                $button_text_color = $templateResults[0]['template_btn_txt_color'];
                $button_color = $templateResults[0]['template_btn_bg_color'];
            }
            $nav = 'new-temp';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-popup.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-new-template.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
        function rabbitIn_template_list(){
            global $wpdb;
            $nav = 'temp-list';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-popup.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-template-list.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
        function rabbitIn_edit_template(){
            global $wpdb;
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $title = '';
            $price = '';
            $button_text = '';
            $button_text_size = '';
            $button_width = '';
            $button_height = '';
            $button_text_color = '';
            $button_color = '';
            $data_flag = false;
            $templateResults = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_template WHERE template_id = '$id'", ARRAY_A);
            if($templateResults)
            {
                $data_flag = true;
                $title = $templateResults[0]['template_title'];
                $price = empty($templateResults[0]['template_price']) ? '' : $templateResults[0]['template_price'];    
                $button_text = $templateResults[0]['template_btn_txt']; 
                $button_text_size = $templateResults[0]['template_btn_txt_size'];
                $button_width = $templateResults[0]['template_btn_width'];
                $button_height = $templateResults[0]['template_btn_height'];
                $button_text_color = $templateResults[0]['template_btn_txt_color'];
                $button_color = $templateResults[0]['template_btn_bg_color'];
            }
            $nav = 'new-temp';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-popup.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-new-template.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
        function rabbitIn_settings(){
            global $wpdb;
            $nav = '';
            $paypal_id  = ''; 
            $server = '';
            $success_url = '';
            $return_url = '';
            $notify_url = '';
            $currency = '';
            $tax = '';
            $settingsResults = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "rabbit_integrator_settings ORDER BY settings_id DESC", ARRAY_A);
            if($settingsResults)
            {
                $paypal_id  = $settingsResults[0]['paypal_id']; 
                $server = $settingsResults[0]['server']; 
                $success_url = $settingsResults[0]['success_url']; 
                $return_url = $settingsResults[0]['return_url']; 
                $notify_url = $settingsResults[0]['notify_url']; 
                $currency = $settingsResults[0]['currency']; 
                $tax = $settingsResults[0]['tax']; 
            }
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-popup.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-header.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/rabbit-integrator-settings.php';
            require_once RI_PLUGIN_BASE_DIR. 'pages/parts/rabbit-integrator-footer.php';
        }
    }
    public static function rabbitIn_ajaxfunction()
    {
        add_action( 'wp_ajax_rabbit_integrator_new_template', 'rabbit_integrator_new_template' );
        function rabbit_integrator_new_template() {
            global $wpdb; 
            require_once RI_PLUGIN_BASE_DIR. 'pages/ajax/rabbit-integrator-template.php';
            wp_die(); 
        }
        add_action( 'wp_ajax_rabbit_integrator_template_list', 'rabbit_integrator_template_list' );
        function rabbit_integrator_template_list() {
            global $wpdb; 
            require_once RI_PLUGIN_BASE_DIR. 'pages/ajax/rabbit-integrator-template.php';
            wp_die(); 
        }
        add_action( 'wp_ajax_rabbit_integrator_settings', 'rabbit_integrator_settings' );
        function rabbit_integrator_settings() {
            global $wpdb; 
            require_once RI_PLUGIN_BASE_DIR. 'pages/ajax/rabbit-integrator-settings.php';
            wp_die(); 
        }
    }
    public static function rabbitIn_generate_pages() {
        $page_content = '<div class="rabbit-integrator-paypal-warning">[rabbit_integrator_ipn] Please do not delete this page, as it contains the vital PayPal IPN shortcode necessary for handling PayPal Instant Payment Notifications. Your cooperation is greatly appreciated, and if you require any assistance, please don\'t hesitate to reach out. Thank you.</div>';
        $page_slug = 'rabbit-integrator-ipn';
        $page = get_page_by_path($page_slug);
        if (empty($page)) {
            $page_data = array(
                'post_content'   => $page_content,
                'post_name'      => $page_slug,
                'post_title'     => 'Rabbit Integrator PayPal Ipn Page [do not delete]',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            );
            $page_id = wp_insert_post($page_data);

            if (!is_wp_error($page_id)) {
                //echo 'Page ['.$page_slug.'] created successfully with ID: ' . $page_id;
            } else {
                //echo 'Error creating page: ' . $page_id->get_error_message();
            }
        } else {
            //echo 'Page with the specified slug already exists.';
        }

        $page_content = '<div class="rabbit-integrator-paypal-success"><img src="'.RI_PLUGIN_URL.'/assets/images/check.png" /><strong>Payment has been successfully completed.</strong></div>';
        $page_slug = 'rabbit-integrator-paypal-success';
        $page = get_page_by_path($page_slug);
        if (empty($page)) {
            $page_data = array(
                'post_content'   => $page_content,
                'post_name'      => $page_slug,
                'post_title'     => 'Rabbit Integrator PayPal Success Page',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            );
            $page_id = wp_insert_post($page_data);

            if (!is_wp_error($page_id)) {
                //echo 'Page ['.$page_slug.'] created successfully with ID: ' . $page_id;
            } else {
                //echo 'Error creating page: ' . $page_id->get_error_message();
            }
        } else {
            //echo 'Page with the specified slug already exists.';
        }

        $page_content = '<div class="rabbit-integrator-paypal-failed"><img src="'.RI_PLUGIN_URL.'/assets/images/cross.png" /><strong>I\'m sorry, but your payment could not be processed successfully. Your transaction has been cancelled. Please double-check your payment details and try again. If the problem persists, feel free to reach out to our customer support for further assistance.</strong></div>';
        $page_slug = 'rabbit-integrator-paypal-failed';
        $page = get_page_by_path($page_slug);
        if (empty($page)) {
            $page_data = array(
                'post_content'   => $page_content,
                'post_name'      => $page_slug,
                'post_title'     => 'Rabbit Integrator PayPal Cancelled Page',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'comment_status' => 'closed',
            );
            $page_id = wp_insert_post($page_data);

            if (!is_wp_error($page_id)) {
                //echo 'Page ['.$page_slug.'] created successfully with ID: ' . $page_id;
            } else {
                //echo 'Error creating page: ' . $page_id->get_error_message();
            }
        } else {
            //echo 'Page with the specified slug already exists.';
        }
    }
    public static function rabbitIn_activation() {
        global $wpdb;
        try
        {
            dbDelta("CREATE TABLE `".$wpdb->prefix. "rabbit_integrator_template` (
                `template_id` bigint(20) NOT NULL AUTO_INCREMENT,
                `template_title` varchar(250) NOT NULL,
                `template_price` float NOT NULL,
                `template_btn_txt` varchar(250) NOT NULL,
                `template_btn_txt_size` varchar(250) NOT NULL,
                `template_btn_width` varchar(250) NOT NULL,
                `template_btn_height` varchar(250) NOT NULL,
                `template_btn_txt_color` varchar(250) NOT NULL,
                `template_btn_bg_color` varchar(250) NOT NULL,
                `template_status` enum('Y','N') NOT NULL DEFAULT 'N',
                `template_datetime` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`template_id`)
            );");

            dbDelta("CREATE TABLE `".$wpdb->prefix. "rabbit_integrator_settings` (
                `settings_id` int(11) NOT NULL AUTO_INCREMENT,
                `paypal_id` varchar(500) NOT NULL,
                `server` enum('sandbox','live') NOT NULL,
                `success_url` tinytext NOT NULL,
                `return_url` tinytext NOT NULL,
                `notify_url` tinytext NOT NULL,
                `currency` varchar(50) NOT NULL,
                `tax` float NOT NULL,
                `settings_status` enum('Y','N') NOT NULL DEFAULT 'Y',
                `settings_datetime` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`settings_id`)
            );");
            self::rabbitIn_generate_pages();
        } 
        catch (Exception $e) {}	
    }
}