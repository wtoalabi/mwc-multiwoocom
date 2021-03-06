<?php
	namespace Config;
	
	use WP_Error;
	
	function config($key){
		$config = [
		  "plugin_page" => "multiwoocom",
			"plugin_version" => "0.0.1",
			"rest_namespace" => "multiwoocom/v1",
			"controllers_path" => "App\Controllers",
			"rest_url" => site_url(). "/?rest_route=/",
			"plugin" => plugin_basename( __DIR__ ),
			"plugin_url" => plugin_dir_url( __FILE__ ) . "src/",
			"plugin_path" => plugin_dir_path( __FILE__ ) . "src/",
			"plugin_assets" => plugin_dir_url( __FILE__ ) . "src/Assets/",
		];
		$value = $config[$key];
		if($value){
			return $value;
		}
		return new \Exception("$key Not found in configs");
	}
	
	function doOrDie(){
		
		if ( ! defined( "ABSPATH" ) ) {
			die( "Get away you silly human!" );
		}
	}
