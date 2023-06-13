<?php
/*
Plugin Name: Calculate Distance
Plugin URI: ishtiaqjlm@gmail.com
Description: Calculate Distance fromm your location to Mecca -  Saudi Arabia
Author: ishtiaq Ahmed
Version: 1.0
Author URI: ishtiaqjlm@gmail.com
*/
register_activation_hook(__FILE__, 'calculate_distance_plugin_install');
function calculate_distance_plugin_install(){
	
}

register_deactivation_hook(__FILE__, 'custom_plugin_uninstall');

function calculate_distance_plugin(){
	return "<script>
	       var site_url='".site_url()."';
	      </script>
	      <h2>Calculate Distance</h2>
	      <div id='show_data'></div>";
}
add_shortcode('calculate_distance', 'calculate_distance_plugin');

add_action('wp_ajax_get_user_location', 'get_user_location');
add_action('wp_ajax_nopriv_get_user_location', 'get_user_location');

function get_user_location(){

	$current_latitude  = $_POST['lat'];
	$current_longitude = $_POST['long'];
	//echo $latitude." <> ".$longitude;exit;
	$current_address   = $current_latitude.",".$current_longitude;
	//echo "Your current address is ".$current_address;
	$mecca_latitude    = "21.422487";
	$mecca_longitude   = "39.826206";
	$total_distance = distance($current_latitude, $current_longitude, $mecca_latitude, $mecca_longitude, "K");
	echo "Total distance between <b>".$current_address."</b> and <b>Mecca Saudia</b> is <b>".$total_distance." km</b>";
	exit;
}

function add_plugin_scripts() {
    wp_enqueue_script( 'jquery-script','https://code.jquery.com/jquery-3.7.0.min.js', array( 'jquery' ), '3.7.0', true );
    wp_enqueue_script( 'custom-script', plugin_dir_url(__FILE__) . 'js/custom-script.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'add_plugin_scripts' );

function distance($lat1, $lon1, $lat2, $lon2, $unit="K") {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
      return round($miles * 1.609344,2);
  } else if ($unit == "N") {
      return round($miles * 0.8684,2);
  } else {
      return round($miles,2);
  }
}
?>