<?php
/* 
 * Inits the admin dashboard side of things.
 * Main admin file which loads all settings panels and sets up admin menus. 
 */
if (!class_exists('GNA_ChangeMailSender_Admin_Init')) {
	class GNA_ChangeMailSender_Admin_Init {
		var $main_menu_page;
		//var $dashboard_menu;
		var $settings_menu;
		
		public function __construct() {
			//This class is only initialized if is_admin() is true
			$this->admin_includes();
			add_action('admin_menu', array(&$this, 'create_admin_menus'));
		}
		
		public function admin_includes() {
			include_once('gna-change-mail-sender-admin-menu.php');
		}

		public function create_admin_menus() {
			$this->main_menu_page = add_menu_page( __('GNA Mail Sender', 'gna-change-mail-sender'), __('GNA Mail Sender', 'gna-change-mail-sender'), 'manage_options', 'gna-mail-settings-menu', array(&$this, 'handle_settings_menu_rendering'), GNA_CHANGE_MAIL_SENDER_URL . '/assets/images/gna_20x20.png' );
			
			add_submenu_page('gna-mail-settings-menu', __('Settings', 'gna-change-mail-sender'),  __('Settings', 'gna-change-mail-sender'), 'manage_options', 'gna-mail-settings-menu', array(&$this, 'handle_settings_menu_rendering'));
			
			add_action( 'admin_init', array(&$this, 'register_gna_change_mail_senders_settings') );
		}

		public function register_gna_change_mail_senders_settings() {
			register_setting( 'gna-mail-sender-setting-group', 'g_changemailsender_configs' );
		}

		public function handle_settings_menu_rendering() {
			include_once('gna-change-mail-sender-admin-settings-menu.php');
			$this->settings_menu = new GNA_ChangeMailSender_Settings_Menu();
		}
	}
}
