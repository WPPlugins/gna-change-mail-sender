<?php
if (!class_exists('GNA_ChangeMailSender_Settings_Menu')) {
	class GNA_ChangeMailSender_Settings_Menu extends GNA_ChangeMailSender_Admin_Menu {
		var $menu_page_slug = 'gna-change-mail-sender-settings-menu';
		
		/* Specify all the tabs of this menu in the following array */
		var $menu_tabs;

		var $menu_tabs_handler = array(
			'tab1' => 'render_tab1', 
			);

		public function __construct() {
			$this->render_menu_page();
		}

		public function set_menu_tabs() {
			$this->menu_tabs = array(
				'tab1' => __('General Settings', 'gna-change-mail-sender'),
			);
		}

		public function get_current_tab() {
			$tab_keys = array_keys($this->menu_tabs);
			$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $tab_keys[0];
			return $tab;
		}

		/*
		 * Renders our tabs of this menu as nav items
		 */
		public function render_menu_tabs() {
			$current_tab = $this->get_current_tab();

			echo '<h2 class="nav-tab-wrapper">';
			foreach ( $this->menu_tabs as $tab_key => $tab_caption ) 
			{
				$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
				echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->menu_page_slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
			}
			echo '</h2>';
		}
		
		/*
		 * The menu rendering goes here
		 */
		public function render_menu_page() {
			echo '<div class="wrap">';
			echo '<h2>'.__('Settings', 'gna-change-mail-sender').'</h2>';//Interface title
			$this->set_menu_tabs();
			$tab = $this->get_current_tab();
			$this->render_menu_tabs();
			?>
			<div id="poststuff"><div id="post-body">
			<?php 
				//$tab_keys = array_keys($this->menu_tabs);
				call_user_func(array(&$this, $this->menu_tabs_handler[$tab]));
			?>
			</div></div>
			</div><!-- end of wrap -->
			<?php
		}
			
		public function render_tab1() {
			global $g_changemailsender;
			if(isset($_POST['gna_mail_save_settings'])) {
				$nonce = $_REQUEST['_wpnonce'];
				if(!wp_verify_nonce($nonce, 'n_gna-mail-save-settings')) {
					die("Nonce check failed on save settings!");
				}

				$g_changemailsender->configs->set_value('g_mail_sender_name', isset($_POST["g_mail_sender_name"]) ? $_POST["g_mail_sender_name"] : '');
				$g_changemailsender->configs->set_value('g_mail_sender_email', isset($_POST["g_mail_sender_email"]) ? $_POST["g_mail_sender_email"] : '');
				$g_changemailsender->configs->save_config();
				$this->show_msg_settings_updated();
			}
			?>
			<div class="postbox">
				<h3 class="hndle"><label for="title"><?php _e('GNA Change Mail Sender', 'gna-change-mail-sender'); ?></label></h3>
				<div class="inside">
					<p><?php _e('Thank you for using our GNA Change Mail Sender plugin. This plugin provide you that Easy to change WordPress default mail sender name and email address.', 'gna-change-mail-sender'); ?></p>
				</div>
			</div> <!-- end postbox-->
			
			<div class="postbox">
				<h3 class="hndle"><label for="title"><?php _e('GNA Change Mail Sender Options', 'gna-change-mail-sender'); ?></label></h3>
				<div class="inside">
					<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
						<?php wp_nonce_field('n_gna-mail-save-settings'); ?>
						<table class="form-table">
							<tr valign="top">
								<th scope="row"><?php _e('Mail Sender Name', 'gna-change-mail-sender')?>:</th>
								<td>
									<input name="g_mail_sender_name" type="text" value="<?php echo $g_changemailsender->configs->get_value('g_mail_sender_name'); ?>" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row"><?php _e('Mail Sender Email', 'gna-change-mail-sender')?>:</th>
								<td>
									<input name="g_mail_sender_email" type="email" value="<?php echo $g_changemailsender->configs->get_value('g_mail_sender_email'); ?>" />
								</td>
							</tr>
						</table>
						<input type="submit" name="gna_mail_save_settings" value="<?php _e('Save Settings', 'gna-change-mail-sender')?>" class="button" />
					</form>
				</div>
			</div> <!-- end postbox-->
			<?php
		}
	} //end class
}
