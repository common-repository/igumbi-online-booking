<?php
/*
Plugin Name: igumbi Online Booking
Plugin URI: https://www.igumbi.com/en/wordpress?utm_source=wpadmin
Description: Generate commission free online bookings directly on your Wordpress Site. igumbi.com is a simple and fast online booking tool / online booking engine (also a online hotelsoftware / PMS & a revenue / yield management system). igumbi gives you dynamic prices based on revenue management algorithms, which help you implement an upselling strategy. This will help you, as the property owner, to earn more and pay less OTA comissions. The plugin is free to use, but you do need an account with igumbi.com. A free trial account is available at <a href="https://www.igumbi.com/trial">https://www.igumbi.com/trial</a>.
Version: 1.38
Author: Roland Oth
Author URI: https://www.igumbi.com
License: GPLv3
Text Domain: igumbi-online-booking
Domain Path: /lang
*/

__('Generate commission free online bookings directly on your Wordpress Site. igumbi.com is a simple and fast online booking tool / online booking engine (also a online hotelsoftware / PMS & a revenue / yield management system). igumbi gives you dynamic prices based on revenue management algorithms, which help you implement an upselling strategy. This will help you, as the property owner, to earn more and pay less OTA comissions. The plugin is free to use, but you do need an account with igumbi.com. A free trial account is available at <a href="https://www.igumbi.com/trial">https://www.igumbi.com/trial</a>.','igumbi-online-booking');

register_activation_hook(__FILE__,'igumbi_booking_install');
register_deactivation_hook( __FILE__, 'igumbi_booking_remove');


function igumbi_booking_install()  {
  add_option('igumbi_hotel_id', '6BEA7AW', '', 'yes'); // Default is the igumbi Demo Hotel 420, A Stripe test account is connfigured
  add_option('igumbi_language', 'de', '', 'yes');
  add_option('igumbi_wide', '2', '', 'yes');
  add_option('igumbi_custom_css', '', '', 'yes');
  add_option('igumbi_responsive', '1', '', 'yes'); // We set the responsive mode as the dfault mode
}


function igumbi_booking_remove() {
   delete_option('igumbi_language');
   delete_option('igumbi_hotel_id');
   delete_option('igumbi_wide');
   delete_option('igumbi_custom_css');
   delete_option('igumbi_responsive');
}

function igumbi_register_settings() {
  register_setting('igumbi_settings','igumbi_options');

  register_setting('igumbi_settings','igumbi_hotel_id');
  register_setting('igumbi_settings','igumbi_language');
  register_setting('igumbi_settings','igumbi_wide');
  register_setting('igumbi_settings','igumbi_custom_css');
  register_setting('igumbi_settings','igumbi_responsive');

  add_settings_section( 'igumbi_settings_section', 'OBT Code Settings', 'igumbi_settings_callback','igumbi_settings');
}

add_shortcode('igumbi_dialog', 'igumbi_dialog');
add_shortcode('igumbi_avform', 'igumbi_avform');
add_shortcode('igumbi_calendar', 'igumbi_calendar');


function wan_load_textdomain() {
	load_plugin_textdomain( 'igumbi-online-booking', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}

function igumbi_dialog() {
  return "<div id='free_rooms'></div>";
}

function igumbi_avform($atts) {
  extract(shortcode_atts(array(
     'lang' =>get_option('igumbi_language'),
     'wide' =>get_option('igumbi_wide'),
     'responsive' =>get_option('igumbi_responsive'),
     'test' =>false
  ), $atts))
  ;
  $str  = "";
  $str .= "<div id='avform'></div>";
  $str .= "<script src='https://www.igumbi.net/seller/";
   
  $str .= get_option('igumbi_hotel_id');
  $str .= "/". $lang . "/start.js";
  if( $wide == 1 or $wide == 'true') {
    $str .= "?layout=wide";
  } elseif ($wide == 2) {
    $str .= "?layout=wide2";
  } else {
    $str .= "?layout=tall";
  }
  if (($responsive== 1 or $responsive =='true') && $wide != 2) {
    $str .= "&responsive=true";
  }
  if ($test =='true') {
    $str .= "&test=true";
  }
  $str .="&source=wordpress";
  $str .= "'></script>";
  $str .='<style>'. get_option('igumbi_custom_css').'</style>';
  return $str;
}


if (is_admin()) {
  add_action('admin_menu', 'igumbi_menu',1);
  add_action('admin_init', 'igumbi_register_settings');
  function igumbi_menu() {
    add_options_page('igumbi Online Booking', ' igumbi Online Booking', 'administrator', 'igumbi-admin-menu', 'igumbi_admin_page');
  }
}

function igumbi_admin_page() {
  include 'includes/views/admin-page.php';
}

class igumbi_Widget extends WP_Widget {
  // Construction function
  function __construct () {
      parent::__construct('igumbi_Widget','igumbi Widget',
          array('description' =>
                'Display the igumbi online booking tool entry form: dates, rooms and persons' ) );
  }

  function form($instance) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
    $widget_html = $instance['widget_html'];
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">
       Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </label>
    </p>
    <?php
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance) {
    extract($args, EXTR_SKIP);
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    if (!empty($title))
    	echo $before_title . $title . $after_title;
      echo igumbi_avform($args);
      echo $after_widget;
  }
}

function igumbi_calendar($args){
  $a=shortcode_atts( array('productcategory_id'=>1113),$args);
  //echo '<h3>' . __('Availability Calendar','igumbi-online-booking') .'</h3>';
  $div = "<div id='igumbicalendar'></div>";
  return $div . ' <script src="https://api.igumbi.net/calendars/start.js/' . get_option('igumbi_hotel_id') . '/'. $a['productcategory_id'] .'"></script>';
}

function productcategorylist(){
  $api_url = 'https://api.igumbi.net/api/v1/hotels/productcategorylist/' . get_option('igumbi_hotel_id') . '.json';
  $request = wp_remote_get($api_url);

  if( is_wp_error( $request ) ) {
    echo wp_error( $request );
    echo '<h2>' .  __('We could not fetch the Productcategories from igumbi','igumbi-online-booking') . '</h2>';
  	return false; // Bail early
  } else {

    $body = wp_remote_retrieve_body( $request );
    $data = json_decode( $body);

    if( ! empty( $data ) ) {
    
      echo '<h2>' .  __('List of Productcategories for the availability calendar','igumbi-online-booking') . '</h2>';
      echo '<p>' . __('It is possible to embed a <b>classic availability calender</b> showing the dates of the current month for the entire next year. Typically such calendars are embedded on a page describing hotel rooms, an apartment or a holidayrental. Below you will find a list of the categories and a sample of the availability calendar.','igumbi-online-booking') . '</p>';
      echo '<h3>' .  $data->name . ", " . $data->city ."</h3>";
      echo '<p>' . __('Hotel Code','igumbi-online-booking') .": <code>" . $data->code . '</code></p>';
      echo '<ul>';
        $i=0;
        foreach( $data->productcategories as $productcategory ) {


          echo '<li>';
      			//echo '<a href="' . esc_url( $product->info->link ) . '">' . $product->info->title . '</a>';
             echo '<h4>' .  $productcategory->name . "</b></h4>";
             echo '<p>';
             if ($productcategory->description) {
               echo $productcategory->description . "</br>";
             }
             echo __('Shortcode for the Availability Calendar','igumbi-online-booking') . ':<br/>';
             echo '<code>[igumbi_calendar productcategory_id=' . $productcategory->id . ']</code>';
             echo '</p>';
             if ($productcategory->seller_picture_url != '/pictures/medium/missing.png') {
               echo "<img src='" .$productcategory->seller_picture_url . "'/>'";
             }
          echo '</li>';
          if($i == 0) {$firstid = $productcategory->id;}
          $i+=1;
      	}
    	echo '</ul>';

      echo do_shortcode('[igumbi_calendar productcategory_id="' . $firstid . '"]');
    }
  }
}

function inject_igumbi_dialog() {
  //echo "<h3>HULLO IGUMBI</h3>";
  global $post;
  $post_content = $post->post_content;
  if (has_shortcode($post_content, 'igumbi_dialog')){
  } else {
    echo igumbi_dialog();
  };
}

function add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=igumbi-admin-menu' ) . '">'. __('Settings').'</a>',
 );
return array_merge( $links, $mylinks );
}

//add_filter('the_post', 'inject_igumbi_dialog');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links' );

add_action('plugins_loaded', 'wan_load_textdomain');

add_action('widgets_init', function() {
  return register_widget('igumbi_Widget');
} );

function my_plugin_load_textdomain() {
  load_plugin_textdomain( 'igumbi-online-booking', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'my_plugin_load_textdomain' );

?>
