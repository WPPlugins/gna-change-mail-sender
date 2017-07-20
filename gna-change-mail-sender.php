<?php
/*
Plugin Name: GNA Change Mail Sender
Version: 0.9.8
Plugin URI: http://wordpress.org/plugins/gna-change-mail-sender/
Author: Chris Mok
Author URI: http://webgna.com/
Description: Easy to change WordPress default mail sender name and email address
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: gna-change-mail-sender
*/

if(!defined('ABSPATH'))exit; //Exit if accessed directly

include_once('gna-change-mail-sender-core.php');

register_activation_hook(__FILE__, array('GNA_ChangeMailSender', 'activate_handler'));		//activation hook
register_deactivation_hook(__FILE__, array('GNA_ChangeMailSender', 'deactivate_handler'));	//deactivation hook
