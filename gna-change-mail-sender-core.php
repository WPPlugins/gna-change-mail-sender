<?php
if (!class_exists('GNA_ChangeMailSender')) {
	class GNA_ChangeMailSender {

		var $plugin_url;
		var $admin_init;
		var $configs;
		
		public function init() {
			$class = __CLASS__;
			new $class;
		}
		
		public function __construct() {
			$this->load_configs();
			$this->define_constants();
			$this->define_variables();
			$this->includes();
			$this->loads();
			
			add_action('init', array(&$this, 'plugin_init'), 0);
			add_filter('plugin_row_meta', array(&$this, 'filter_plugin_meta'), 10, 2);
			
			if ( $this->configs->get_value('g_mail_sender_email') != '' ) {
				add_filter('wp_mail_from', array(&$this, 'filter_wp_mail_from'));
			}
			
			if ( $this->configs->get_value('g_mail_sender_name') != '' ) {
				add_filter('wp_mail_from_name', array(&$this, 'filter_wp_mail_from_name'));
			}
		}
		
		public function load_configs() {
			include_once('inc/gna-change-mail-sender-config.php');
			$this->configs = GNA_ChangeMailSender_Config::get_instance();
		}

		public function define_constants() {
			define('GNA_CHANGE_MAIL_SENDER_VERSION', '0.9.8');
			
			define('GNA_CHANGE_MAIL_SENDER_BASENAME', plugin_basename(__FILE__));
			define('GNA_CHANGE_MAIL_SENDER_URL', $this->plugin_url());
		}
		
		public function define_variables() {
			
		}
			
		public function includes() {
			if(is_admin()) {
				include_once('admin/gna-change-mail-sender-admin-init.php');
			}
		}
			
		public function loads() {
			if(is_admin()){
				$this->admin_init = new GNA_ChangeMailSender_Admin_Init();
			}
		}

		public function plugin_init() {
			load_plugin_textdomain('gna-change-mail-sender', false, dirname(plugin_basename(__FILE__ )) . '/languages/');
		}

		public function plugin_url() { 
			if ($this->plugin_url) return $this->plugin_url;
			return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
		}

		public function filter_plugin_meta($links, $file) {
			if( strpos( GNA_CHANGE_MAIL_SENDER_BASENAME, str_replace('.php', '', $file) ) !== false ) { /* After other links */
				$links[] = '<a target="_blank" href="https://profiles.wordpress.org/chris_dev/" rel="external">' . __('Developer\'s Profile', 'gna-change-mail-sender') . '</a>';
			}
			
			return $links;
		}

		public function filter_wp_mail_from($original_email_address) {
			if ( substr($original_email_address, 0, strlen('wordpress@')) === 'wordpress@' ) {
				return $this->configs->get_value('g_mail_sender_email');
			} else {
				return $original_email_address;
			}
		}

		public function filter_wp_mail_from_name($original_email_from) {
			if ( substr($original_email_from, 0, strlen('WordPress')) === 'WordPress' ) {
				return $this->configs->get_value('g_mail_sender_name');
			} else {
				return $original_email_from;
			}
		}

		public function install() {
		}
		
		public function uninstall() {
		}
		
		public function activate_handler() {
		}
		
		public function deactivate_handler() {
		}
	}
}
$GLOBALS['g_changemailsender'] = new GNA_ChangeMailSender();
