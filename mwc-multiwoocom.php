<?php
  
  /**
   * Plugin Name: MultiWooCom
   * Plugin URI: https://pph.me/wto
   * Description: MultiWooCom
   * Version: 0.0.1
   * Author: Olawale Alabi
   * Author URI: https://pph.me/wto
   * Text Domain: mwc-multiwoocom
   * Domain Path: /i18n/languages/
   * Requires at least: 5.4
   * Requires PHP: 7.0
   *
   */
  
	require __DIR__  . '/vendor/autoload.php';
	
	use App\Core\Configs\Instance;
	
	\Config\doOrDie();
	
	register_activation_hook( __FILE__, 'mwc_multiwoocom_activate_plugin' );
	register_deactivation_hook( __FILE__, 'mwc_multiwoocom_deactivate_plugin' );
	Initialize();
	
	function Initialize() {
		add_action( 'init', [ "App\Core\Configs\Instance", "Initialize" ] );
	}
	
	function mwc_multiwoocom_activate_plugin() {
		Instance::Activate();
	}
	
	function mwc_multiwoocom_deactivate_plugin() {
		Instance::Deactivate();
	}
	
