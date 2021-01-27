<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bitwiseacademy.com/
 * @since             1.0.0
 * @package           Bitwise_Price_Plan
 *
 * @wordpress-plugin
 * Plugin Name:       Bitwise price plan
 * Plugin URI:        https://bitwiseacademy.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Bitwise
 * Author URI:        https://bitwiseacademy.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bitwise-price-plan
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BITWISE_PRICE_PLAN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bitwise-price-plan-activator.php
 */
function activate_bitwise_price_plan() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bitwise-price-plan-activator.php';
	Bitwise_Price_Plan_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bitwise-price-plan-deactivator.php
 */
function deactivate_bitwise_price_plan() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bitwise-price-plan-deactivator.php';
	Bitwise_Price_Plan_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bitwise_price_plan' );
register_deactivation_hook( __FILE__, 'deactivate_bitwise_price_plan' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bitwise-price-plan.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bitwise_price_plan() {

	$plugin = new Bitwise_Price_Plan();
	$plugin->run();

}
run_bitwise_price_plan();

function loginbutton_function(){ ?>
  <span style="margin-top: 6px;" class="mail">Have questions?&nbsp;:&nbsp; <span class="fa fa-envelope"></span>&nbsp;<a href="mailto:info@bitwiseacademy.com">info@bitwiseacademy.com</a></span>
<?php 
 if ( is_user_logged_in() ) { ?>
      <!--<span><a href="<?php echo wp_logout_url(home_url()); ?>"><span  class="btn btn-default sp-btn pull-right ml">Logout</span></a>-->
  <?php }else{ ?>

  <span><a href="<?php echo site_url();?>/login/"><span  class="btn btn-default sp-btn pull-right ml">Login</span></a>
  <a href="<?php echo site_url();?>/register/"><span class="btn btn-default sp-btn pull-right ml">Register</span></a></span>
      <?php }
  ?>

<span class="pull-right newsocial">
  <a href="https://www.facebook.com/bitwiseacademy/" target="_blank" class="fa fa-facebook"></a>

<a href="https://twitter.com/bitwiseacademy" target="_blank" class="fa fa-twitter"></a>
<a href="https://www.linkedin.com/company/bitwise-academy/"  target="_blank" class="fa fa-linkedin"></a>
    <a href="https://www.youtube.com/channel/UCO33cGZ6t2AlhRZOXljRd5w" target="_blank" class="fa fa-youtube-play red"></a>
<a href="https://www.pinterest.com/bitwiseacademy/"  target="_blank" class="fa fa-pinterest"></a>
<?php if ( is_user_logged_in() ) { ?><ul style="background: #353866!important;border: 2px solid #353866;margin-left: 1.5em;"  class="nav navbar-nav navbar-right">
<li class="dropdown menu-item-has-children">
  <a style="padding: 0px 0px 2px 10px!important" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i></a>
  <ul style="left: -35px!important; padding: 0px 10px!important" class="dropdown-menu sub-menu">
  	<?php
  	$usr = wp_get_current_user();
  	if ( in_array( 'subscriber', (array) $usr->roles ) ) {
  	?>
    <li><a href="/profile/">My Profile</a></li>
    <li><a href="/my-account/">My Account</a></li>
    <?php
  	}
  	?>
    <li><a href="/my-courses/">My Courses</a></li>
    <li><a href="<?php echo wp_logout_url(home_url()); ?><?php echo wp_logout_url(home_url()); ?><?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
  </ul>
</li>
</ul>
<?php
}
?>
</span>
<?php 
}

function shortcode_my_orders( $atts ) {
    extract( shortcode_atts( array(
        'order_count' => -1
    ), $atts ) );

    $current_page    = empty( $current_page ) ? 1 : absint( $current_page );
    $customer_orders = wc_get_orders(
      apply_filters(
        'woocommerce_my_account_my_orders_query',
        array(
          'customer' => get_current_user_id(),
          'page'     => $current_page,
          'paginate' => true,
        )
      )
    );

    wc_get_template(
      'myaccount/orders.php',
      array(
        'current_page'    => absint( $current_page ),
        'customer_orders' => $customer_orders,
        'has_orders'      => 0 < $customer_orders->total,
      )
    );
}
add_shortcode('my_orders', 'shortcode_my_orders');
add_action( 'woocommerce_account_content', 'remove_dashboard_account_default', 5 );
function remove_dashboard_account_default() {
    remove_action( 'woocommerce_account_content', 'woocommerce_account_content', 10 );
    add_action( 'woocommerce_account_content', 'custom_account_orders', 10 );
}

function custom_account_orders( $current_page ) {
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
        foreach ( $wp->query_vars as $key => $value ) {
            // Ignore pagename param.
            if ( 'pagename' === $key ) {
                continue;
            }

            if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
                do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
                return;
            }
        }
    }

    $current_page    = empty( $current_page ) ? 1 : absint( $current_page );
    $customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array(
        'customer' => get_current_user_id(),
        'page'     => $current_page,
        'paginate' => true,
    ) ) );

    wc_get_template(
        'myaccount/orders.php',
        array(
            'current_page'    => absint( $current_page ),
            'customer_orders' => $customer_orders,
            'has_orders'      => 0 < $customer_orders->total,
        )
    );
}

add_shortcode( 'price_plan', 'price_plan_function' );

function price_plan_function(){
	global $wpdb;
	$courseid=$_GET['courseid'];

  	$coursemapping = $wpdb->prefix.'course_mapping';

  	$product_ids = $wpdb->get_results("SELECT product_ids FROM $coursemapping  where course_id='$courseid'");

  	$postids=unserialize($product_ids[0]->product_ids);

  	foreach($postids as $productid){
    	$product = wc_get_product( $productid );
  
    	$prodcuct[$productid]=$product->get_price();

	  }
  	arsort($prodcuct);
  

    foreach($prodcuct as $key =>$value){
      $productidnew[]=$key;
    }

	global $wp;
	$curl = home_url( $wp->request ); 
    $_SESSION['ref'] = $curl."/?".$_SERVER['QUERY_STRING'];

    $basicproduct = wc_get_product( $productidnew[0] );
	$basicterms = get_the_terms( $basicproduct->get_id(), 'product_cat' );
	$basicnames = wp_list_pluck( $basicterms, 'name' );

    $proproduct = wc_get_product( $productidnew[1] );
    $proterms = get_the_terms( $proproduct->get_id(), 'product_cat' );
	$pronames = wp_list_pluck( $proterms, 'name' );

    $premiumproduct = wc_get_product( $productidnew[2] );

    $premiumterms = get_the_terms( $premiumproduct->get_id(), 'product_cat' );
	$premiumnames = wp_list_pluck( $premiumterms, 'name' );

		$output='<h2 style="text-align:center;font-weight:bold;"></h2>';

	$output.='<div class="row white">
        <div class="block">';
        foreach($postids as $productid){
      $product = wc_get_product( $productid );
  $basicterms = get_the_terms( $product->get_id(), 'product_cat' );
  $basicnames = wp_list_pluck( $basicterms, 'name' );
if($product->get_meta( "custom_text_field_title")==8){

	$price = get_post_meta( $product->get_id(), '_sale_price', true );
	$currency = get_woocommerce_currency_symbol('USD');

   $output1='   <div class="col-xs-12 col-sm-6 col-md-4">
              <ul class="pricing p-yel">
                <li>
                  <big>'.$product->get_name().'</big>
                  <h2 class="totalclass">'.$product->get_meta( "custom_text_field_title").' Sessions</h2>
                </li>

               <li><a href="/courses/'.get_post_field( 'post_name', $_GET['courseid'] ).'" style="font-size: 20px" class="modal-link">View Description</a></li>
               
                <li>
                  <h3>'.$currency.($product->get_meta( "custom_text_field_title") * $price).'</h3>
    <span class="perdaycls"><strong>Price Per Session</strong>  '.$currency.$price.'</span>
                  
                </li>
                <li>';
  if ( is_user_logged_in() ) {
       $output1.='<a href="'.site_url().'/book-online-tutoring/?category='.$basicnames[0].'&service='.$product->get_title().'&classes=8" > <button>Choose Package</button> </a>';
  }else{
  $output1.=' <a href="'.site_url().'/login/?redirect_to='.site_url().'/choose-package/?courseid='.$_GET['courseid'].'" > <button>Choose Package</button> </a>';
      }
               $output1.='</li>
              </ul>
          </div>';
}
if($product->get_meta( "custom_text_field_title")==15){
	$price = get_post_meta( $product->get_id(), '_sale_price', true );
	$currency = get_woocommerce_currency_symbol('USD');

   $output2='   <div class="col-xs-12 col-sm-6 col-md-4">
              <ul class="pricing p-red">
                <li>
                  <big>'.$product->get_name().'</big>
                  <h2 class="totalclass">'.$product->get_meta( "custom_text_field_title").' Sessions</h2>
                </li>

               <li><a href="/courses/'.get_post_field( 'post_name', $_GET['courseid'] ).'" style="font-size: 20px" class="modal-link">View Description</a></li>
               
                <li>
                  <h3>'.$currency.($product->get_meta( "custom_text_field_title") * $price).'</h3>
    <span class="perdaycls"><strong>Price Per Session</strong>  '.$currency.$price.'</span>
                  
                </li>
                <li>';
  if ( is_user_logged_in() ) {
       $output2.='<a href="'.site_url().'/book-online-tutoring/?category='.$basicnames[0].'&service='.$product->get_title().'&classes=15" > <button>Choose Package</button> </a>';
  }else{
  $output2.=' <a href="'.site_url().'/login/?redirect_to='.site_url().'/choose-package/?courseid='.$_GET['courseid'].'" > <button>Choose Package</button> </a>';
      }
               $output2.='</li>
              </ul>
          </div>';
}
if($product->get_meta( "custom_text_field_title")==25){
	$price = get_post_meta( $product->get_id(), '_sale_price', true );
	$currency = get_woocommerce_currency_symbol('USD');

   $output3='   <div class="col-xs-12 col-sm-6 col-md-4">
              <ul class="pricing p-green">
                <li>
                  <big>'.$product->get_name().'</big>
                  <h2 class="totalclass">'.$product->get_meta( "custom_text_field_title").' Sessions</h2>
                </li>
               <li><a href="/courses/'.get_post_field( 'post_name', $_GET['courseid'] ).'" style="font-size: 20px" class="modal-link">View Description</a></li>
               
                <li>
                  <h3>'.$currency.($product->get_meta( "custom_text_field_title") * $price).'</h3>
    <span class="perdaycls"><strong>Price Per Session</strong>  '.$currency.$price.'</span>
                  
                </li>
                <li>';
  if ( is_user_logged_in() ) {
       $output3.='<a href="'.site_url().'/book-online-tutoring/?category='.$basicnames[0].'&service='.$product->get_title().'&classes=25" > <button>Choose Package</button> </a>';
  }else{
  $output3.=' <a href="'.site_url().'/login/?redirect_to='.site_url().'/choose-package/?courseid='.$_GET['courseid'].'" > <button>Choose Package</button> </a>';
      }
               $output3.='</li>
              </ul>
          </div>';
}
        }
          
$output.=$output1.$output2.$output3;
         $output.='</div><!-- /block -->
      </div><!-- /row -->';
	return apply_filters( 'price_plan', $output);
}

add_shortcode( 'new_register', 'newregisterform' );
function newregisterform(){
global $wpdb;
wp_enqueue_style( 'inltel', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css', array(  ) );
wp_enqueue_script( 'inltel_js',  'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js', array( 'jquery' ), '1.0.0', false );
wp_enqueue_script( 'bitwise_custom_validate_public_js',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js', array( 'jquery' ), '1.0.0', false );
wp_enqueue_script( 'bitwise_price_plan_public_js', plugin_dir_url( __FILE__ ) . 'public/js/bitwise-price-plan-public.js', array( 'jquery' ), '1.0.0', false );
$register='';
?>
        <script>
        jQuery(document).ready(function( $ ) {
            var parent_phone = $("#parent_phone"),
                phone = $("#student_phone");

            parent_phone.intlTelInput({
                utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
                preferredCountries: ["us","in"],
                initialCountry: "auto",
            });
            parent_phone.keyup(function() {
                if( $(".parent_phone_msg").length ==0 ){
                    $('.tml-label[for="parent_phone"]').append(' <span class="parent_phone_msg"></span>')
                }
                if ($.trim(parent_phone.val())) {
                    if (parent_phone.intlTelInput("isValidNumber")) {
                        var getCode = parent_phone.intlTelInput('getSelectedCountryData').dialCode;
                        $(".parent_phone_msg").html('✓ Valid');
                        $(".parent_phone_msg").removeClass('error').addClass('success');

                        $("#parent_phone_code").val(getCode);
                    } else {
                        $(".parent_phone_msg").html('Invalid');
                        $(".parent_phone_msg").removeClass('success').addClass('error');
                        $("#parent_phone_code").val('');
                    }
                }
            });

            phone.intlTelInput({
                utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
                preferredCountries: ["us","in"],
                initialCountry: "auto",
            });
            phone.keyup(function() {
                if( $(".phone_msg").length ==0 ){
                    $('.tml-label[for="phone"]').append(' <span class="phone_msg"></span>')
                }
                if ($.trim(phone.val())) {
                    if (phone.intlTelInput("isValidNumber")) {
                        var getCode = phone.intlTelInput('getSelectedCountryData').dialCode;

                        $(".phone_msg").html('✓ Valid');
                        $(".phone_msg").removeClass('error').addClass('success');

                        $("#phone_code").val(getCode);
                    } else {
                        $(".phone_msg").html('Invalid');
                        $(".phone_msg").removeClass('success').addClass('error');
                        $("#phone_code").val('');
                    }
                }
            });

        })
    </script>

<div class="tml tml-register">
<form id="newregister" name="register" action="<?php echo site_url();?>/register/" method="post"  data-ajax="1">
<div class="registerdetails">
<div class="parentdetails"><div class="tml-field-wrap tml-parent_heading-wrap">
Parent Details</div>
<div class="tml-field-wrap tml-parent_f_name-wrap">
<span class="tml-label">First Name</span>
<input name="parent_f_name" id="parentfname" type="text" value="" class="tml-field">
<span class="parent_f_name-error error" style="display:none;">Please Enter First Name</span>
</div>
<div class="tml-field-wrap tml-parent_l_name-wrap">
<span class="tml-label">Last name</span>
<input name="parent_l_name" type="text" id="parentlname" value="" class="tml-field">
<span class="parent_l_name-error error" style="display:none;">Please Enter Last Name</span>
</div>
<div class="tml-field-wrap tml-parent_email-wrap">
<span class="tml-label">Email</span>
<input name="parent_email" type="email" id="parentemail" value="" class="tml-field">
<span class="parent_email-error error" style="display:none;">Please Enter Email Address</span> 
</div>
<div class="tml-field-wrap tml-parent_cnf_email-wrap">
<span class="tml-label">Confirm Email</span>
<input name="parent_cnf_email" type="email" id="parentcnfemail" value="" class="tml-field">
<span class="confirmemail-error error" style="display:none;">Please Enter Confirm Email</span> 
</div>
<div class="tml-field-wrap tml-parent_phone-wrap">
<label class="tml-label" for="parent_phone">Phone</label>
<div class="intl-tel-input">

<input name="parent_phone" type="tel" value="" id="parent_phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="parent_phone-error error" style="display:none;">Please Enter Phone number</span>
</div>
</div>
</div>
<div class="studentdetails">
<div class="tml-field-wrap tml-student_heading-wrap">Student Details</div>
<div class="tml-field-wrap tml-first_name-wrap"><span class="tml-label">First Name</span>
<input name="first_name" type="text" id="first_name" value="" class="tml-field">
<span class="first_name-error error"  style="display:none;">Please Enter First Name</span> 
</div>
<div class="tml-field-wrap tml-last_name-wrap">
<span class="tml-label">Last Name</span>
<input name="last_name" type="text" value="" id="last_name" class="tml-field">
<span class="last_name-error error" style="display:none;">Please Enter Last Name</span> 
</div>
<div class="tml-field-wrap tml-student_phone-wrap">
<label class="tml-label" for="student_phone">Phone</label>
<div class="intl-tel-input">
<div class="flag-container"><div style="height: 40px" tabindex="0" class="selected-flag" title="United States: +1"><div class="iti-flag us"></div><div style="top:45%!important" class="arrow"></div></div><ul class="country-list hide"><li class="country preferred active highlight" data-dial-code="1" data-country-code="us"><div class="flag"><div class="iti-flag us"></div></div><span class="country-name">United States</span><span class="dial-code">+1</span></li><li class="country preferred" data-dial-code="91" data-country-code="in"><div class="flag"><div class="iti-flag in"></div></div><span class="country-name">India (भारत)</span><span class="dial-code">+91</span></li><li class="divider"></li><li class="country" data-dial-code="93" data-country-code="af"><div class="flag"><div class="iti-flag af"></div></div><span class="country-name">Afghanistan (&#8235;افغانستان&#8236;&lrm;)</span><span class="dial-code">+93</span></li><li class="country" data-dial-code="355" data-country-code="al"><div class="flag"><div class="iti-flag al"></div></div><span class="country-name">Albania (Shqipëri)</span><span class="dial-code">+355</span></li><li class="country" data-dial-code="213" data-country-code="dz"><div class="flag"><div class="iti-flag dz"></div></div><span class="country-name">Algeria (&#8235;الجزائر&#8236;&lrm;)</span><span class="dial-code">+213</span></li><li class="country" data-dial-code="1684" data-country-code="as"><div class="flag"><div class="iti-flag as"></div></div><span class="country-name">American Samoa</span><span class="dial-code">+1684</span></li><li class="country" data-dial-code="376" data-country-code="ad"><div class="flag"><div class="iti-flag ad"></div></div><span class="country-name">Andorra</span><span class="dial-code">+376</span></li><li class="country" data-dial-code="244" data-country-code="ao"><div class="flag"><div class="iti-flag ao"></div></div><span class="country-name">Angola</span><span class="dial-code">+244</span></li><li class="country" data-dial-code="1264" data-country-code="ai"><div class="flag"><div class="iti-flag ai"></div></div><span class="country-name">Anguilla</span><span class="dial-code">+1264</span></li><li class="country" data-dial-code="1268" data-country-code="ag"><div class="flag"><div class="iti-flag ag"></div></div><span class="country-name">Antigua and Barbuda</span><span class="dial-code">+1268</span></li><li class="country" data-dial-code="54" data-country-code="ar"><div class="flag"><div class="iti-flag ar"></div></div><span class="country-name">Argentina</span><span class="dial-code">+54</span></li><li class="country" data-dial-code="374" data-country-code="am"><div class="flag"><div class="iti-flag am"></div></div><span class="country-name">Armenia (Հայաստան)</span><span class="dial-code">+374</span></li><li class="country" data-dial-code="297" data-country-code="aw"><div class="flag"><div class="iti-flag aw"></div></div><span class="country-name">Aruba</span><span class="dial-code">+297</span></li><li class="country" data-dial-code="61" data-country-code="au"><div class="flag"><div class="iti-flag au"></div></div><span class="country-name">Australia</span><span class="dial-code">+61</span></li><li class="country" data-dial-code="43" data-country-code="at"><div class="flag"><div class="iti-flag at"></div></div><span class="country-name">Austria (Österreich)</span><span class="dial-code">+43</span></li><li class="country" data-dial-code="994" data-country-code="az"><div class="flag"><div class="iti-flag az"></div></div><span class="country-name">Azerbaijan (Azərbaycan)</span><span class="dial-code">+994</span></li><li class="country" data-dial-code="1242" data-country-code="bs"><div class="flag"><div class="iti-flag bs"></div></div><span class="country-name">Bahamas</span><span class="dial-code">+1242</span></li><li class="country" data-dial-code="973" data-country-code="bh"><div class="flag"><div class="iti-flag bh"></div></div><span class="country-name">Bahrain (&#8235;البحرين&#8236;&lrm;)</span><span class="dial-code">+973</span></li><li class="country" data-dial-code="880" data-country-code="bd"><div class="flag"><div class="iti-flag bd"></div></div><span class="country-name">Bangladesh (বাংলাদেশ)</span><span class="dial-code">+880</span></li><li class="country" data-dial-code="1246" data-country-code="bb"><div class="flag"><div class="iti-flag bb"></div></div><span class="country-name">Barbados</span><span class="dial-code">+1246</span></li><li class="country" data-dial-code="375" data-country-code="by"><div class="flag"><div class="iti-flag by"></div></div><span class="country-name">Belarus (Беларусь)</span><span class="dial-code">+375</span></li><li class="country" data-dial-code="32" data-country-code="be"><div class="flag"><div class="iti-flag be"></div></div><span class="country-name">Belgium (België)</span><span class="dial-code">+32</span></li><li class="country" data-dial-code="501" data-country-code="bz"><div class="flag"><div class="iti-flag bz"></div></div><span class="country-name">Belize</span><span class="dial-code">+501</span></li><li class="country" data-dial-code="229" data-country-code="bj"><div class="flag"><div class="iti-flag bj"></div></div><span class="country-name">Benin (Bénin)</span><span class="dial-code">+229</span></li><li class="country" data-dial-code="1441" data-country-code="bm"><div class="flag"><div class="iti-flag bm"></div></div><span class="country-name">Bermuda</span><span class="dial-code">+1441</span></li><li class="country" data-dial-code="975" data-country-code="bt"><div class="flag"><div class="iti-flag bt"></div></div><span class="country-name">Bhutan (འབྲུག)</span><span class="dial-code">+975</span></li><li class="country" data-dial-code="591" data-country-code="bo"><div class="flag"><div class="iti-flag bo"></div></div><span class="country-name">Bolivia</span><span class="dial-code">+591</span></li><li class="country" data-dial-code="387" data-country-code="ba"><div class="flag"><div class="iti-flag ba"></div></div><span class="country-name">Bosnia and Herzegovina (Босна и Херцеговина)</span><span class="dial-code">+387</span></li><li class="country" data-dial-code="267" data-country-code="bw"><div class="flag"><div class="iti-flag bw"></div></div><span class="country-name">Botswana</span><span class="dial-code">+267</span></li><li class="country" data-dial-code="55" data-country-code="br"><div class="flag"><div class="iti-flag br"></div></div><span class="country-name">Brazil (Brasil)</span><span class="dial-code">+55</span></li><li class="country" data-dial-code="246" data-country-code="io"><div class="flag"><div class="iti-flag io"></div></div><span class="country-name">British Indian Ocean Territory</span><span class="dial-code">+246</span></li><li class="country" data-dial-code="1284" data-country-code="vg"><div class="flag"><div class="iti-flag vg"></div></div><span class="country-name">British Virgin Islands</span><span class="dial-code">+1284</span></li><li class="country" data-dial-code="673" data-country-code="bn"><div class="flag"><div class="iti-flag bn"></div></div><span class="country-name">Brunei</span><span class="dial-code">+673</span></li><li class="country" data-dial-code="359" data-country-code="bg"><div class="flag"><div class="iti-flag bg"></div></div><span class="country-name">Bulgaria (България)</span><span class="dial-code">+359</span></li><li class="country" data-dial-code="226" data-country-code="bf"><div class="flag"><div class="iti-flag bf"></div></div><span class="country-name">Burkina Faso</span><span class="dial-code">+226</span></li><li class="country" data-dial-code="257" data-country-code="bi"><div class="flag"><div class="iti-flag bi"></div></div><span class="country-name">Burundi (Uburundi)</span><span class="dial-code">+257</span></li><li class="country" data-dial-code="855" data-country-code="kh"><div class="flag"><div class="iti-flag kh"></div></div><span class="country-name">Cambodia (កម្ពុជា)</span><span class="dial-code">+855</span></li><li class="country" data-dial-code="237" data-country-code="cm"><div class="flag"><div class="iti-flag cm"></div></div><span class="country-name">Cameroon (Cameroun)</span><span class="dial-code">+237</span></li><li class="country" data-dial-code="1" data-country-code="ca"><div class="flag"><div class="iti-flag ca"></div></div><span class="country-name">Canada</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="238" data-country-code="cv"><div class="flag"><div class="iti-flag cv"></div></div><span class="country-name">Cape Verde (Kabu Verdi)</span><span class="dial-code">+238</span></li><li class="country" data-dial-code="599" data-country-code="bq"><div class="flag"><div class="iti-flag bq"></div></div><span class="country-name">Caribbean Netherlands</span><span class="dial-code">+599</span></li><li class="country" data-dial-code="1345" data-country-code="ky"><div class="flag"><div class="iti-flag ky"></div></div><span class="country-name">Cayman Islands</span><span class="dial-code">+1345</span></li><li class="country" data-dial-code="236" data-country-code="cf"><div class="flag"><div class="iti-flag cf"></div></div><span class="country-name">Central African Republic (République centrafricaine)</span><span class="dial-code">+236</span></li><li class="country" data-dial-code="235" data-country-code="td"><div class="flag"><div class="iti-flag td"></div></div><span class="country-name">Chad (Tchad)</span><span class="dial-code">+235</span></li><li class="country" data-dial-code="56" data-country-code="cl"><div class="flag"><div class="iti-flag cl"></div></div><span class="country-name">Chile</span><span class="dial-code">+56</span></li><li class="country" data-dial-code="86" data-country-code="cn"><div class="flag"><div class="iti-flag cn"></div></div><span class="country-name">China (中国)</span><span class="dial-code">+86</span></li><li class="country" data-dial-code="61" data-country-code="cx"><div class="flag"><div class="iti-flag cx"></div></div><span class="country-name">Christmas Island</span><span class="dial-code">+61</span></li><li class="country" data-dial-code="61" data-country-code="cc"><div class="flag"><div class="iti-flag cc"></div></div><span class="country-name">Cocos (Keeling) Islands</span><span class="dial-code">+61</span></li><li class="country" data-dial-code="57" data-country-code="co"><div class="flag"><div class="iti-flag co"></div></div><span class="country-name">Colombia</span><span class="dial-code">+57</span></li><li class="country" data-dial-code="269" data-country-code="km"><div class="flag"><div class="iti-flag km"></div></div><span class="country-name">Comoros (&#8235;جزر القمر&#8236;&lrm;)</span><span class="dial-code">+269</span></li><li class="country" data-dial-code="243" data-country-code="cd"><div class="flag"><div class="iti-flag cd"></div></div><span class="country-name">Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)</span><span class="dial-code">+243</span></li><li class="country" data-dial-code="242" data-country-code="cg"><div class="flag"><div class="iti-flag cg"></div></div><span class="country-name">Congo (Republic) (Congo-Brazzaville)</span><span class="dial-code">+242</span></li><li class="country" data-dial-code="682" data-country-code="ck"><div class="flag"><div class="iti-flag ck"></div></div><span class="country-name">Cook Islands</span><span class="dial-code">+682</span></li><li class="country" data-dial-code="506" data-country-code="cr"><div class="flag"><div class="iti-flag cr"></div></div><span class="country-name">Costa Rica</span><span class="dial-code">+506</span></li><li class="country" data-dial-code="225" data-country-code="ci"><div class="flag"><div class="iti-flag ci"></div></div><span class="country-name">Côte d’Ivoire</span><span class="dial-code">+225</span></li><li class="country" data-dial-code="385" data-country-code="hr"><div class="flag"><div class="iti-flag hr"></div></div><span class="country-name">Croatia (Hrvatska)</span><span class="dial-code">+385</span></li><li class="country" data-dial-code="53" data-country-code="cu"><div class="flag"><div class="iti-flag cu"></div></div><span class="country-name">Cuba</span><span class="dial-code">+53</span></li><li class="country" data-dial-code="599" data-country-code="cw"><div class="flag"><div class="iti-flag cw"></div></div><span class="country-name">Curaçao</span><span class="dial-code">+599</span></li><li class="country" data-dial-code="357" data-country-code="cy"><div class="flag"><div class="iti-flag cy"></div></div><span class="country-name">Cyprus (Κύπρος)</span><span class="dial-code">+357</span></li><li class="country" data-dial-code="420" data-country-code="cz"><div class="flag"><div class="iti-flag cz"></div></div><span class="country-name">Czech Republic (Česká republika)</span><span class="dial-code">+420</span></li><li class="country" data-dial-code="45" data-country-code="dk"><div class="flag"><div class="iti-flag dk"></div></div><span class="country-name">Denmark (Danmark)</span><span class="dial-code">+45</span></li><li class="country" data-dial-code="253" data-country-code="dj"><div class="flag"><div class="iti-flag dj"></div></div><span class="country-name">Djibouti</span><span class="dial-code">+253</span></li><li class="country" data-dial-code="1767" data-country-code="dm"><div class="flag"><div class="iti-flag dm"></div></div><span class="country-name">Dominica</span><span class="dial-code">+1767</span></li><li class="country" data-dial-code="1" data-country-code="do"><div class="flag"><div class="iti-flag do"></div></div><span class="country-name">Dominican Republic (República Dominicana)</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="593" data-country-code="ec"><div class="flag"><div class="iti-flag ec"></div></div><span class="country-name">Ecuador</span><span class="dial-code">+593</span></li><li class="country" data-dial-code="20" data-country-code="eg"><div class="flag"><div class="iti-flag eg"></div></div><span class="country-name">Egypt (&#8235;مصر&#8236;&lrm;)</span><span class="dial-code">+20</span></li><li class="country" data-dial-code="503" data-country-code="sv"><div class="flag"><div class="iti-flag sv"></div></div><span class="country-name">El Salvador</span><span class="dial-code">+503</span></li><li class="country" data-dial-code="240" data-country-code="gq"><div class="flag"><div class="iti-flag gq"></div></div><span class="country-name">Equatorial Guinea (Guinea Ecuatorial)</span><span class="dial-code">+240</span></li><li class="country" data-dial-code="291" data-country-code="er"><div class="flag"><div class="iti-flag er"></div></div><span class="country-name">Eritrea</span><span class="dial-code">+291</span></li><li class="country" data-dial-code="372" data-country-code="ee"><div class="flag"><div class="iti-flag ee"></div></div><span class="country-name">Estonia (Eesti)</span><span class="dial-code">+372</span></li><li class="country" data-dial-code="251" data-country-code="et"><div class="flag"><div class="iti-flag et"></div></div><span class="country-name">Ethiopia</span><span class="dial-code">+251</span></li><li class="country" data-dial-code="500" data-country-code="fk"><div class="flag"><div class="iti-flag fk"></div></div><span class="country-name">Falkland Islands (Islas Malvinas)</span><span class="dial-code">+500</span></li><li class="country" data-dial-code="298" data-country-code="fo"><div class="flag"><div class="iti-flag fo"></div></div><span class="country-name">Faroe Islands (Føroyar)</span><span class="dial-code">+298</span></li><li class="country" data-dial-code="679" data-country-code="fj"><div class="flag"><div class="iti-flag fj"></div></div><span class="country-name">Fiji</span><span class="dial-code">+679</span></li><li class="country" data-dial-code="358" data-country-code="fi"><div class="flag"><div class="iti-flag fi"></div></div><span class="country-name">Finland (Suomi)</span><span class="dial-code">+358</span></li><li class="country" data-dial-code="33" data-country-code="fr"><div class="flag"><div class="iti-flag fr"></div></div><span class="country-name">France</span><span class="dial-code">+33</span></li><li class="country" data-dial-code="594" data-country-code="gf"><div class="flag"><div class="iti-flag gf"></div></div><span class="country-name">French Guiana (Guyane française)</span><span class="dial-code">+594</span></li><li class="country" data-dial-code="689" data-country-code="pf"><div class="flag"><div class="iti-flag pf"></div></div><span class="country-name">French Polynesia (Polynésie française)</span><span class="dial-code">+689</span></li><li class="country" data-dial-code="241" data-country-code="ga"><div class="flag"><div class="iti-flag ga"></div></div><span class="country-name">Gabon</span><span class="dial-code">+241</span></li><li class="country" data-dial-code="220" data-country-code="gm"><div class="flag"><div class="iti-flag gm"></div></div><span class="country-name">Gambia</span><span class="dial-code">+220</span></li><li class="country" data-dial-code="995" data-country-code="ge"><div class="flag"><div class="iti-flag ge"></div></div><span class="country-name">Georgia (საქართველო)</span><span class="dial-code">+995</span></li><li class="country" data-dial-code="49" data-country-code="de"><div class="flag"><div class="iti-flag de"></div></div><span class="country-name">Germany (Deutschland)</span><span class="dial-code">+49</span></li><li class="country" data-dial-code="233" data-country-code="gh"><div class="flag"><div class="iti-flag gh"></div></div><span class="country-name">Ghana (Gaana)</span><span class="dial-code">+233</span></li><li class="country" data-dial-code="350" data-country-code="gi"><div class="flag"><div class="iti-flag gi"></div></div><span class="country-name">Gibraltar</span><span class="dial-code">+350</span></li><li class="country" data-dial-code="30" data-country-code="gr"><div class="flag"><div class="iti-flag gr"></div></div><span class="country-name">Greece (Ελλάδα)</span><span class="dial-code">+30</span></li><li class="country" data-dial-code="299" data-country-code="gl"><div class="flag"><div class="iti-flag gl"></div></div><span class="country-name">Greenland (Kalaallit Nunaat)</span><span class="dial-code">+299</span></li><li class="country" data-dial-code="1473" data-country-code="gd"><div class="flag"><div class="iti-flag gd"></div></div><span class="country-name">Grenada</span><span class="dial-code">+1473</span></li><li class="country" data-dial-code="590" data-country-code="gp"><div class="flag"><div class="iti-flag gp"></div></div><span class="country-name">Guadeloupe</span><span class="dial-code">+590</span></li><li class="country" data-dial-code="1671" data-country-code="gu"><div class="flag"><div class="iti-flag gu"></div></div><span class="country-name">Guam</span><span class="dial-code">+1671</span></li><li class="country" data-dial-code="502" data-country-code="gt"><div class="flag"><div class="iti-flag gt"></div></div><span class="country-name">Guatemala</span><span class="dial-code">+502</span></li><li class="country" data-dial-code="44" data-country-code="gg"><div class="flag"><div class="iti-flag gg"></div></div><span class="country-name">Guernsey</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="224" data-country-code="gn"><div class="flag"><div class="iti-flag gn"></div></div><span class="country-name">Guinea (Guinée)</span><span class="dial-code">+224</span></li><li class="country" data-dial-code="245" data-country-code="gw"><div class="flag"><div class="iti-flag gw"></div></div><span class="country-name">Guinea-Bissau (Guiné Bissau)</span><span class="dial-code">+245</span></li><li class="country" data-dial-code="592" data-country-code="gy"><div class="flag"><div class="iti-flag gy"></div></div><span class="country-name">Guyana</span><span class="dial-code">+592</span></li><li class="country" data-dial-code="509" data-country-code="ht"><div class="flag"><div class="iti-flag ht"></div></div><span class="country-name">Haiti</span><span class="dial-code">+509</span></li><li class="country" data-dial-code="504" data-country-code="hn"><div class="flag"><div class="iti-flag hn"></div></div><span class="country-name">Honduras</span><span class="dial-code">+504</span></li><li class="country" data-dial-code="852" data-country-code="hk"><div class="flag"><div class="iti-flag hk"></div></div><span class="country-name">Hong Kong (香港)</span><span class="dial-code">+852</span></li><li class="country" data-dial-code="36" data-country-code="hu"><div class="flag"><div class="iti-flag hu"></div></div><span class="country-name">Hungary (Magyarország)</span><span class="dial-code">+36</span></li><li class="country" data-dial-code="354" data-country-code="is"><div class="flag"><div class="iti-flag is"></div></div><span class="country-name">Iceland (Ísland)</span><span class="dial-code">+354</span></li><li class="country" data-dial-code="91" data-country-code="in"><div class="flag"><div class="iti-flag in"></div></div><span class="country-name">India (भारत)</span><span class="dial-code">+91</span></li><li class="country" data-dial-code="62" data-country-code="id"><div class="flag"><div class="iti-flag id"></div></div><span class="country-name">Indonesia</span><span class="dial-code">+62</span></li><li class="country" data-dial-code="98" data-country-code="ir"><div class="flag"><div class="iti-flag ir"></div></div><span class="country-name">Iran (&#8235;ایران&#8236;&lrm;)</span><span class="dial-code">+98</span></li><li class="country" data-dial-code="964" data-country-code="iq"><div class="flag"><div class="iti-flag iq"></div></div><span class="country-name">Iraq (&#8235;العراق&#8236;&lrm;)</span><span class="dial-code">+964</span></li><li class="country" data-dial-code="353" data-country-code="ie"><div class="flag"><div class="iti-flag ie"></div></div><span class="country-name">Ireland</span><span class="dial-code">+353</span></li><li class="country" data-dial-code="44" data-country-code="im"><div class="flag"><div class="iti-flag im"></div></div><span class="country-name">Isle of Man</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="972" data-country-code="il"><div class="flag"><div class="iti-flag il"></div></div><span class="country-name">Israel (&#8235;ישראל&#8236;&lrm;)</span><span class="dial-code">+972</span></li><li class="country" data-dial-code="39" data-country-code="it"><div class="flag"><div class="iti-flag it"></div></div><span class="country-name">Italy (Italia)</span><span class="dial-code">+39</span></li><li class="country" data-dial-code="1876" data-country-code="jm"><div class="flag"><div class="iti-flag jm"></div></div><span class="country-name">Jamaica</span><span class="dial-code">+1876</span></li><li class="country" data-dial-code="81" data-country-code="jp"><div class="flag"><div class="iti-flag jp"></div></div><span class="country-name">Japan (日本)</span><span class="dial-code">+81</span></li><li class="country" data-dial-code="44" data-country-code="je"><div class="flag"><div class="iti-flag je"></div></div><span class="country-name">Jersey</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="962" data-country-code="jo"><div class="flag"><div class="iti-flag jo"></div></div><span class="country-name">Jordan (&#8235;الأردن&#8236;&lrm;)</span><span class="dial-code">+962</span></li><li class="country" data-dial-code="7" data-country-code="kz"><div class="flag"><div class="iti-flag kz"></div></div><span class="country-name">Kazakhstan (Казахстан)</span><span class="dial-code">+7</span></li><li class="country" data-dial-code="254" data-country-code="ke"><div class="flag"><div class="iti-flag ke"></div></div><span class="country-name">Kenya</span><span class="dial-code">+254</span></li><li class="country" data-dial-code="686" data-country-code="ki"><div class="flag"><div class="iti-flag ki"></div></div><span class="country-name">Kiribati</span><span class="dial-code">+686</span></li><li class="country" data-dial-code="965" data-country-code="kw"><div class="flag"><div class="iti-flag kw"></div></div><span class="country-name">Kuwait (&#8235;الكويت&#8236;&lrm;)</span><span class="dial-code">+965</span></li><li class="country" data-dial-code="996" data-country-code="kg"><div class="flag"><div class="iti-flag kg"></div></div><span class="country-name">Kyrgyzstan (Кыргызстан)</span><span class="dial-code">+996</span></li><li class="country" data-dial-code="856" data-country-code="la"><div class="flag"><div class="iti-flag la"></div></div><span class="country-name">Laos (ລາວ)</span><span class="dial-code">+856</span></li><li class="country" data-dial-code="371" data-country-code="lv"><div class="flag"><div class="iti-flag lv"></div></div><span class="country-name">Latvia (Latvija)</span><span class="dial-code">+371</span></li><li class="country" data-dial-code="961" data-country-code="lb"><div class="flag"><div class="iti-flag lb"></div></div><span class="country-name">Lebanon (&#8235;لبنان&#8236;&lrm;)</span><span class="dial-code">+961</span></li><li class="country" data-dial-code="266" data-country-code="ls"><div class="flag"><div class="iti-flag ls"></div></div><span class="country-name">Lesotho</span><span class="dial-code">+266</span></li><li class="country" data-dial-code="231" data-country-code="lr"><div class="flag"><div class="iti-flag lr"></div></div><span class="country-name">Liberia</span><span class="dial-code">+231</span></li><li class="country" data-dial-code="218" data-country-code="ly"><div class="flag"><div class="iti-flag ly"></div></div><span class="country-name">Libya (&#8235;ليبيا&#8236;&lrm;)</span><span class="dial-code">+218</span></li><li class="country" data-dial-code="423" data-country-code="li"><div class="flag"><div class="iti-flag li"></div></div><span class="country-name">Liechtenstein</span><span class="dial-code">+423</span></li><li class="country" data-dial-code="370" data-country-code="lt"><div class="flag"><div class="iti-flag lt"></div></div><span class="country-name">Lithuania (Lietuva)</span><span class="dial-code">+370</span></li><li class="country" data-dial-code="352" data-country-code="lu"><div class="flag"><div class="iti-flag lu"></div></div><span class="country-name">Luxembourg</span><span class="dial-code">+352</span></li><li class="country" data-dial-code="853" data-country-code="mo"><div class="flag"><div class="iti-flag mo"></div></div><span class="country-name">Macau (澳門)</span><span class="dial-code">+853</span></li><li class="country" data-dial-code="389" data-country-code="mk"><div class="flag"><div class="iti-flag mk"></div></div><span class="country-name">Macedonia (FYROM) (Македонија)</span><span class="dial-code">+389</span></li><li class="country" data-dial-code="261" data-country-code="mg"><div class="flag"><div class="iti-flag mg"></div></div><span class="country-name">Madagascar (Madagasikara)</span><span class="dial-code">+261</span></li><li class="country" data-dial-code="265" data-country-code="mw"><div class="flag"><div class="iti-flag mw"></div></div><span class="country-name">Malawi</span><span class="dial-code">+265</span></li><li class="country" data-dial-code="60" data-country-code="my"><div class="flag"><div class="iti-flag my"></div></div><span class="country-name">Malaysia</span><span class="dial-code">+60</span></li><li class="country" data-dial-code="960" data-country-code="mv"><div class="flag"><div class="iti-flag mv"></div></div><span class="country-name">Maldives</span><span class="dial-code">+960</span></li><li class="country" data-dial-code="223" data-country-code="ml"><div class="flag"><div class="iti-flag ml"></div></div><span class="country-name">Mali</span><span class="dial-code">+223</span></li><li class="country" data-dial-code="356" data-country-code="mt"><div class="flag"><div class="iti-flag mt"></div></div><span class="country-name">Malta</span><span class="dial-code">+356</span></li><li class="country" data-dial-code="692" data-country-code="mh"><div class="flag"><div class="iti-flag mh"></div></div><span class="country-name">Marshall Islands</span><span class="dial-code">+692</span></li><li class="country" data-dial-code="596" data-country-code="mq"><div class="flag"><div class="iti-flag mq"></div></div><span class="country-name">Martinique</span><span class="dial-code">+596</span></li><li class="country" data-dial-code="222" data-country-code="mr"><div class="flag"><div class="iti-flag mr"></div></div><span class="country-name">Mauritania (&#8235;موريتانيا&#8236;&lrm;)</span><span class="dial-code">+222</span></li><li class="country" data-dial-code="230" data-country-code="mu"><div class="flag"><div class="iti-flag mu"></div></div><span class="country-name">Mauritius (Moris)</span><span class="dial-code">+230</span></li><li class="country" data-dial-code="262" data-country-code="yt"><div class="flag"><div class="iti-flag yt"></div></div><span class="country-name">Mayotte</span><span class="dial-code">+262</span></li><li class="country" data-dial-code="52" data-country-code="mx"><div class="flag"><div class="iti-flag mx"></div></div><span class="country-name">Mexico (México)</span><span class="dial-code">+52</span></li><li class="country" data-dial-code="691" data-country-code="fm"><div class="flag"><div class="iti-flag fm"></div></div><span class="country-name">Micronesia</span><span class="dial-code">+691</span></li><li class="country" data-dial-code="373" data-country-code="md"><div class="flag"><div class="iti-flag md"></div></div><span class="country-name">Moldova (Republica Moldova)</span><span class="dial-code">+373</span></li><li class="country" data-dial-code="377" data-country-code="mc"><div class="flag"><div class="iti-flag mc"></div></div><span class="country-name">Monaco</span><span class="dial-code">+377</span></li><li class="country" data-dial-code="976" data-country-code="mn"><div class="flag"><div class="iti-flag mn"></div></div><span class="country-name">Mongolia (Монгол)</span><span class="dial-code">+976</span></li><li class="country" data-dial-code="382" data-country-code="me"><div class="flag"><div class="iti-flag me"></div></div><span class="country-name">Montenegro (Crna Gora)</span><span class="dial-code">+382</span></li><li class="country" data-dial-code="1664" data-country-code="ms"><div class="flag"><div class="iti-flag ms"></div></div><span class="country-name">Montserrat</span><span class="dial-code">+1664</span></li><li class="country" data-dial-code="212" data-country-code="ma"><div class="flag"><div class="iti-flag ma"></div></div><span class="country-name">Morocco (&#8235;المغرب&#8236;&lrm;)</span><span class="dial-code">+212</span></li><li class="country" data-dial-code="258" data-country-code="mz"><div class="flag"><div class="iti-flag mz"></div></div><span class="country-name">Mozambique (Moçambique)</span><span class="dial-code">+258</span></li><li class="country" data-dial-code="95" data-country-code="mm"><div class="flag"><div class="iti-flag mm"></div></div><span class="country-name">Myanmar (Burma) (မြန်မာ)</span><span class="dial-code">+95</span></li><li class="country" data-dial-code="264" data-country-code="na"><div class="flag"><div class="iti-flag na"></div></div><span class="country-name">Namibia (Namibië)</span><span class="dial-code">+264</span></li><li class="country" data-dial-code="674" data-country-code="nr"><div class="flag"><div class="iti-flag nr"></div></div><span class="country-name">Nauru</span><span class="dial-code">+674</span></li><li class="country" data-dial-code="977" data-country-code="np"><div class="flag"><div class="iti-flag np"></div></div><span class="country-name">Nepal (नेपाल)</span><span class="dial-code">+977</span></li><li class="country" data-dial-code="31" data-country-code="nl"><div class="flag"><div class="iti-flag nl"></div></div><span class="country-name">Netherlands (Nederland)</span><span class="dial-code">+31</span></li><li class="country" data-dial-code="687" data-country-code="nc"><div class="flag"><div class="iti-flag nc"></div></div><span class="country-name">New Caledonia (Nouvelle-Calédonie)</span><span class="dial-code">+687</span></li><li class="country" data-dial-code="64" data-country-code="nz"><div class="flag"><div class="iti-flag nz"></div></div><span class="country-name">New Zealand</span><span class="dial-code">+64</span></li><li class="country" data-dial-code="505" data-country-code="ni"><div class="flag"><div class="iti-flag ni"></div></div><span class="country-name">Nicaragua</span><span class="dial-code">+505</span></li><li class="country" data-dial-code="227" data-country-code="ne"><div class="flag"><div class="iti-flag ne"></div></div><span class="country-name">Niger (Nijar)</span><span class="dial-code">+227</span></li><li class="country" data-dial-code="234" data-country-code="ng"><div class="flag"><div class="iti-flag ng"></div></div><span class="country-name">Nigeria</span><span class="dial-code">+234</span></li><li class="country" data-dial-code="683" data-country-code="nu"><div class="flag"><div class="iti-flag nu"></div></div><span class="country-name">Niue</span><span class="dial-code">+683</span></li><li class="country" data-dial-code="672" data-country-code="nf"><div class="flag"><div class="iti-flag nf"></div></div><span class="country-name">Norfolk Island</span><span class="dial-code">+672</span></li><li class="country" data-dial-code="850" data-country-code="kp"><div class="flag"><div class="iti-flag kp"></div></div><span class="country-name">North Korea (조선 민주주의 인민 공화국)</span><span class="dial-code">+850</span></li><li class="country" data-dial-code="1670" data-country-code="mp"><div class="flag"><div class="iti-flag mp"></div></div><span class="country-name">Northern Mariana Islands</span><span class="dial-code">+1670</span></li><li class="country" data-dial-code="47" data-country-code="no"><div class="flag"><div class="iti-flag no"></div></div><span class="country-name">Norway (Norge)</span><span class="dial-code">+47</span></li><li class="country" data-dial-code="968" data-country-code="om"><div class="flag"><div class="iti-flag om"></div></div><span class="country-name">Oman (&#8235;عُمان&#8236;&lrm;)</span><span class="dial-code">+968</span></li><li class="country" data-dial-code="92" data-country-code="pk"><div class="flag"><div class="iti-flag pk"></div></div><span class="country-name">Pakistan (&#8235;پاکستان&#8236;&lrm;)</span><span class="dial-code">+92</span></li><li class="country" data-dial-code="680" data-country-code="pw"><div class="flag"><div class="iti-flag pw"></div></div><span class="country-name">Palau</span><span class="dial-code">+680</span></li><li class="country" data-dial-code="970" data-country-code="ps"><div class="flag"><div class="iti-flag ps"></div></div><span class="country-name">Palestine (&#8235;فلسطين&#8236;&lrm;)</span><span class="dial-code">+970</span></li><li class="country" data-dial-code="507" data-country-code="pa"><div class="flag"><div class="iti-flag pa"></div></div><span class="country-name">Panama (Panamá)</span><span class="dial-code">+507</span></li><li class="country" data-dial-code="675" data-country-code="pg"><div class="flag"><div class="iti-flag pg"></div></div><span class="country-name">Papua New Guinea</span><span class="dial-code">+675</span></li><li class="country" data-dial-code="595" data-country-code="py"><div class="flag"><div class="iti-flag py"></div></div><span class="country-name">Paraguay</span><span class="dial-code">+595</span></li><li class="country" data-dial-code="51" data-country-code="pe"><div class="flag"><div class="iti-flag pe"></div></div><span class="country-name">Peru (Perú)</span><span class="dial-code">+51</span></li><li class="country" data-dial-code="63" data-country-code="ph"><div class="flag"><div class="iti-flag ph"></div></div><span class="country-name">Philippines</span><span class="dial-code">+63</span></li><li class="country" data-dial-code="48" data-country-code="pl"><div class="flag"><div class="iti-flag pl"></div></div><span class="country-name">Poland (Polska)</span><span class="dial-code">+48</span></li><li class="country" data-dial-code="351" data-country-code="pt"><div class="flag"><div class="iti-flag pt"></div></div><span class="country-name">Portugal</span><span class="dial-code">+351</span></li><li class="country" data-dial-code="1" data-country-code="pr"><div class="flag"><div class="iti-flag pr"></div></div><span class="country-name">Puerto Rico</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="974" data-country-code="qa"><div class="flag"><div class="iti-flag qa"></div></div><span class="country-name">Qatar (&#8235;قطر&#8236;&lrm;)</span><span class="dial-code">+974</span></li><li class="country" data-dial-code="262" data-country-code="re"><div class="flag"><div class="iti-flag re"></div></div><span class="country-name">Réunion (La Réunion)</span><span class="dial-code">+262</span></li><li class="country" data-dial-code="40" data-country-code="ro"><div class="flag"><div class="iti-flag ro"></div></div><span class="country-name">Romania (România)</span><span class="dial-code">+40</span></li><li class="country" data-dial-code="7" data-country-code="ru"><div class="flag"><div class="iti-flag ru"></div></div><span class="country-name">Russia (Россия)</span><span class="dial-code">+7</span></li><li class="country" data-dial-code="250" data-country-code="rw"><div class="flag"><div class="iti-flag rw"></div></div><span class="country-name">Rwanda</span><span class="dial-code">+250</span></li><li class="country" data-dial-code="590" data-country-code="bl"><div class="flag"><div class="iti-flag bl"></div></div><span class="country-name">Saint Barthélemy (Saint-Barthélemy)</span><span class="dial-code">+590</span></li><li class="country" data-dial-code="290" data-country-code="sh"><div class="flag"><div class="iti-flag sh"></div></div><span class="country-name">Saint Helena</span><span class="dial-code">+290</span></li><li class="country" data-dial-code="1869" data-country-code="kn"><div class="flag"><div class="iti-flag kn"></div></div><span class="country-name">Saint Kitts and Nevis</span><span class="dial-code">+1869</span></li><li class="country" data-dial-code="1758" data-country-code="lc"><div class="flag"><div class="iti-flag lc"></div></div><span class="country-name">Saint Lucia</span><span class="dial-code">+1758</span></li><li class="country" data-dial-code="590" data-country-code="mf"><div class="flag"><div class="iti-flag mf"></div></div><span class="country-name">Saint Martin (Saint-Martin (partie française))</span><span class="dial-code">+590</span></li><li class="country" data-dial-code="508" data-country-code="pm"><div class="flag"><div class="iti-flag pm"></div></div><span class="country-name">Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)</span><span class="dial-code">+508</span></li><li class="country" data-dial-code="1784" data-country-code="vc"><div class="flag"><div class="iti-flag vc"></div></div><span class="country-name">Saint Vincent and the Grenadines</span><span class="dial-code">+1784</span></li><li class="country" data-dial-code="685" data-country-code="ws"><div class="flag"><div class="iti-flag ws"></div></div><span class="country-name">Samoa</span><span class="dial-code">+685</span></li><li class="country" data-dial-code="378" data-country-code="sm"><div class="flag"><div class="iti-flag sm"></div></div><span class="country-name">San Marino</span><span class="dial-code">+378</span></li><li class="country" data-dial-code="239" data-country-code="st"><div class="flag"><div class="iti-flag st"></div></div><span class="country-name">São Tomé and Príncipe (São Tomé e Príncipe)</span><span class="dial-code">+239</span></li><li class="country" data-dial-code="966" data-country-code="sa"><div class="flag"><div class="iti-flag sa"></div></div><span class="country-name">Saudi Arabia (&#8235;المملكة العربية السعودية&#8236;&lrm;)</span><span class="dial-code">+966</span></li><li class="country" data-dial-code="221" data-country-code="sn"><div class="flag"><div class="iti-flag sn"></div></div><span class="country-name">Senegal (Sénégal)</span><span class="dial-code">+221</span></li><li class="country" data-dial-code="381" data-country-code="rs"><div class="flag"><div class="iti-flag rs"></div></div><span class="country-name">Serbia (Србија)</span><span class="dial-code">+381</span></li><li class="country" data-dial-code="248" data-country-code="sc"><div class="flag"><div class="iti-flag sc"></div></div><span class="country-name">Seychelles</span><span class="dial-code">+248</span></li><li class="country" data-dial-code="232" data-country-code="sl"><div class="flag"><div class="iti-flag sl"></div></div><span class="country-name">Sierra Leone</span><span class="dial-code">+232</span></li><li class="country" data-dial-code="65" data-country-code="sg"><div class="flag"><div class="iti-flag sg"></div></div><span class="country-name">Singapore</span><span class="dial-code">+65</span></li><li class="country" data-dial-code="1721" data-country-code="sx"><div class="flag"><div class="iti-flag sx"></div></div><span class="country-name">Sint Maarten</span><span class="dial-code">+1721</span></li><li class="country" data-dial-code="421" data-country-code="sk"><div class="flag"><div class="iti-flag sk"></div></div><span class="country-name">Slovakia (Slovensko)</span><span class="dial-code">+421</span></li><li class="country" data-dial-code="386" data-country-code="si"><div class="flag"><div class="iti-flag si"></div></div><span class="country-name">Slovenia (Slovenija)</span><span class="dial-code">+386</span></li><li class="country" data-dial-code="677" data-country-code="sb"><div class="flag"><div class="iti-flag sb"></div></div><span class="country-name">Solomon Islands</span><span class="dial-code">+677</span></li><li class="country" data-dial-code="252" data-country-code="so"><div class="flag"><div class="iti-flag so"></div></div><span class="country-name">Somalia (Soomaaliya)</span><span class="dial-code">+252</span></li><li class="country" data-dial-code="27" data-country-code="za"><div class="flag"><div class="iti-flag za"></div></div><span class="country-name">South Africa</span><span class="dial-code">+27</span></li><li class="country" data-dial-code="82" data-country-code="kr"><div class="flag"><div class="iti-flag kr"></div></div><span class="country-name">South Korea (대한민국)</span><span class="dial-code">+82</span></li><li class="country" data-dial-code="211" data-country-code="ss"><div class="flag"><div class="iti-flag ss"></div></div><span class="country-name">South Sudan (&#8235;جنوب السودان&#8236;&lrm;)</span><span class="dial-code">+211</span></li><li class="country" data-dial-code="34" data-country-code="es"><div class="flag"><div class="iti-flag es"></div></div><span class="country-name">Spain (España)</span><span class="dial-code">+34</span></li><li class="country" data-dial-code="94" data-country-code="lk"><div class="flag"><div class="iti-flag lk"></div></div><span class="country-name">Sri Lanka (ශ්&zwj;රී ලංකාව)</span><span class="dial-code">+94</span></li><li class="country" data-dial-code="249" data-country-code="sd"><div class="flag"><div class="iti-flag sd"></div></div><span class="country-name">Sudan (&#8235;السودان&#8236;&lrm;)</span><span class="dial-code">+249</span></li><li class="country" data-dial-code="597" data-country-code="sr"><div class="flag"><div class="iti-flag sr"></div></div><span class="country-name">Suriname</span><span class="dial-code">+597</span></li><li class="country" data-dial-code="47" data-country-code="sj"><div class="flag"><div class="iti-flag sj"></div></div><span class="country-name">Svalbard and Jan Mayen</span><span class="dial-code">+47</span></li><li class="country" data-dial-code="268" data-country-code="sz"><div class="flag"><div class="iti-flag sz"></div></div><span class="country-name">Swaziland</span><span class="dial-code">+268</span></li><li class="country" data-dial-code="46" data-country-code="se"><div class="flag"><div class="iti-flag se"></div></div><span class="country-name">Sweden (Sverige)</span><span class="dial-code">+46</span></li><li class="country" data-dial-code="41" data-country-code="ch"><div class="flag"><div class="iti-flag ch"></div></div><span class="country-name">Switzerland (Schweiz)</span><span class="dial-code">+41</span></li><li class="country" data-dial-code="963" data-country-code="sy"><div class="flag"><div class="iti-flag sy"></div></div><span class="country-name">Syria (&#8235;سوريا&#8236;&lrm;)</span><span class="dial-code">+963</span></li><li class="country" data-dial-code="886" data-country-code="tw"><div class="flag"><div class="iti-flag tw"></div></div><span class="country-name">Taiwan (台灣)</span><span class="dial-code">+886</span></li><li class="country" data-dial-code="992" data-country-code="tj"><div class="flag"><div class="iti-flag tj"></div></div><span class="country-name">Tajikistan</span><span class="dial-code">+992</span></li><li class="country" data-dial-code="255" data-country-code="tz"><div class="flag"><div class="iti-flag tz"></div></div><span class="country-name">Tanzania</span><span class="dial-code">+255</span></li><li class="country" data-dial-code="66" data-country-code="th"><div class="flag"><div class="iti-flag th"></div></div><span class="country-name">Thailand (ไทย)</span><span class="dial-code">+66</span></li><li class="country" data-dial-code="670" data-country-code="tl"><div class="flag"><div class="iti-flag tl"></div></div><span class="country-name">Timor-Leste</span><span class="dial-code">+670</span></li><li class="country" data-dial-code="228" data-country-code="tg"><div class="flag"><div class="iti-flag tg"></div></div><span class="country-name">Togo</span><span class="dial-code">+228</span></li><li class="country" data-dial-code="690" data-country-code="tk"><div class="flag"><div class="iti-flag tk"></div></div><span class="country-name">Tokelau</span><span class="dial-code">+690</span></li><li class="country" data-dial-code="676" data-country-code="to"><div class="flag"><div class="iti-flag to"></div></div><span class="country-name">Tonga</span><span class="dial-code">+676</span></li><li class="country" data-dial-code="1868" data-country-code="tt"><div class="flag"><div class="iti-flag tt"></div></div><span class="country-name">Trinidad and Tobago</span><span class="dial-code">+1868</span></li><li class="country" data-dial-code="216" data-country-code="tn"><div class="flag"><div class="iti-flag tn"></div></div><span class="country-name">Tunisia (&#8235;تونس&#8236;&lrm;)</span><span class="dial-code">+216</span></li><li class="country" data-dial-code="90" data-country-code="tr"><div class="flag"><div class="iti-flag tr"></div></div><span class="country-name">Turkey (Türkiye)</span><span class="dial-code">+90</span></li><li class="country" data-dial-code="993" data-country-code="tm"><div class="flag"><div class="iti-flag tm"></div></div><span class="country-name">Turkmenistan</span><span class="dial-code">+993</span></li><li class="country" data-dial-code="1649" data-country-code="tc"><div class="flag"><div class="iti-flag tc"></div></div><span class="country-name">Turks and Caicos Islands</span><span class="dial-code">+1649</span></li><li class="country" data-dial-code="688" data-country-code="tv"><div class="flag"><div class="iti-flag tv"></div></div><span class="country-name">Tuvalu</span><span class="dial-code">+688</span></li><li class="country" data-dial-code="1340" data-country-code="vi"><div class="flag"><div class="iti-flag vi"></div></div><span class="country-name">U.S. Virgin Islands</span><span class="dial-code">+1340</span></li><li class="country" data-dial-code="256" data-country-code="ug"><div class="flag"><div class="iti-flag ug"></div></div><span class="country-name">Uganda</span><span class="dial-code">+256</span></li><li class="country" data-dial-code="380" data-country-code="ua"><div class="flag"><div class="iti-flag ua"></div></div><span class="country-name">Ukraine (Україна)</span><span class="dial-code">+380</span></li><li class="country" data-dial-code="971" data-country-code="ae"><div class="flag"><div class="iti-flag ae"></div></div><span class="country-name">United Arab Emirates (&#8235;الإمارات العربية المتحدة&#8236;&lrm;)</span><span class="dial-code">+971</span></li><li class="country" data-dial-code="44" data-country-code="gb"><div class="flag"><div class="iti-flag gb"></div></div><span class="country-name">United Kingdom</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="1" data-country-code="us"><div class="flag"><div class="iti-flag us"></div></div><span class="country-name">United States</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="598" data-country-code="uy"><div class="flag"><div class="iti-flag uy"></div></div><span class="country-name">Uruguay</span><span class="dial-code">+598</span></li><li class="country" data-dial-code="998" data-country-code="uz"><div class="flag"><div class="iti-flag uz"></div></div><span class="country-name">Uzbekistan (Oʻzbekiston)</span><span class="dial-code">+998</span></li><li class="country" data-dial-code="678" data-country-code="vu"><div class="flag"><div class="iti-flag vu"></div></div><span class="country-name">Vanuatu</span><span class="dial-code">+678</span></li><li class="country" data-dial-code="39" data-country-code="va"><div class="flag"><div class="iti-flag va"></div></div><span class="country-name">Vatican City (Città del Vaticano)</span><span class="dial-code">+39</span></li><li class="country" data-dial-code="58" data-country-code="ve"><div class="flag"><div class="iti-flag ve"></div></div><span class="country-name">Venezuela</span><span class="dial-code">+58</span></li><li class="country" data-dial-code="84" data-country-code="vn"><div class="flag"><div class="iti-flag vn"></div></div><span class="country-name">Vietnam (Việt Nam)</span><span class="dial-code">+84</span></li><li class="country" data-dial-code="681" data-country-code="wf"><div class="flag"><div class="iti-flag wf"></div></div><span class="country-name">Wallis and Futuna</span><span class="dial-code">+681</span></li><li class="country" data-dial-code="212" data-country-code="eh"><div class="flag"><div class="iti-flag eh"></div></div><span class="country-name">Western Sahara (&#8235;الصحراء الغربية&#8236;&lrm;)</span><span class="dial-code">+212</span></li><li class="country" data-dial-code="967" data-country-code="ye"><div class="flag"><div class="iti-flag ye"></div></div><span class="country-name">Yemen (&#8235;اليمن&#8236;&lrm;)</span><span class="dial-code">+967</span></li><li class="country" data-dial-code="260" data-country-code="zm"><div class="flag"><div class="iti-flag zm"></div></div><span class="country-name">Zambia</span><span class="dial-code">+260</span></li><li class="country" data-dial-code="263" data-country-code="zw"><div class="flag"><div class="iti-flag zw"></div></div><span class="country-name">Zimbabwe</span><span class="dial-code">+263</span></li><li class="country" data-dial-code="358" data-country-code="ax"><div class="flag"><div class="iti-flag ax"></div></div><span class="country-name">Åland Islands</span><span class="dial-code">+358</span></li></ul></div>

<input name="student_phone" type="tel" value="" id="student_phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="student_phone-error error" style="display:none;">Please Enter Phone number</span>
</div>
</div>
<div class="tml-field-wrap tml-timezone-wrap">
<label class="tml-label" for="timezone">Timezone</label>
<select name="timezone" id="timezone" class="tml-field">
<option value="NA" selected="selected">Select Timezone</option>
<option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
<option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
<option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
<option value="US/Alaska">(UTC-09:00) Alaska</option>
<option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
<option value="America/Tijuana">(UTC-08:00) Tijuana</option>
<option value="US/Arizona">(UTC-07:00) Arizona</option>
<option value="America/Chihuahua">(UTC-07:00) La Paz</option>
<option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
<option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
<option value="America/Managua">(UTC-06:00) Central America</option>
<option value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
<option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
<option value="America/Monterrey">(UTC-06:00) Monterrey</option>
<option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
<option value="America/Bogota">(UTC-05:00) Quito</option>
<option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
<option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
<option value="America/Lima">(UTC-05:00) Lima</option>
<option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
<option value="America/Caracas">(UTC-04:30) Caracas</option>
<option value="America/La_Paz">(UTC-04:00) La Paz</option>
<option value="America/Santiago">(UTC-04:00) Santiago</option>
<option value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
<option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
<option value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown</option>
<option value="America/Godthab">(UTC-03:00) Greenland</option>
<option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
<option value="Atlantic/Azores">(UTC-01:00) Azores</option>
<option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
<option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
<option value="Europe/London">(UTC+00:00) London</option>
<option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
<option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
<option value="UTC">(UTC+00:00) UTC</option>
<option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
<option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
<option value="Europe/Berlin">(UTC+01:00) Bern</option>
<option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
<option value="Europe/Brussels">(UTC+01:00) Brussels</option>
<option value="Europe/Budapest">(UTC+01:00) Budapest</option>
<option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
<option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
<option value="Europe/Madrid">(UTC+01:00) Madrid</option>
<option value="Europe/Paris">(UTC+01:00) Paris</option>
<option value="Europe/Prague">(UTC+01:00) Prague</option>
<option value="Europe/Rome">(UTC+01:00) Rome</option>
<option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
<option value="Europe/Skopje">(UTC+01:00) Skopje</option>
<option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
<option value="Europe/Vienna">(UTC+01:00) Vienna</option>
<option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
<option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
<option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
<option value="Europe/Athens">(UTC+02:00) Athens</option>
<option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
<option value="Africa/Cairo">(UTC+02:00) Cairo</option>
<option value="Africa/Harare">(UTC+02:00) Harare</option>
<option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
<option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
<option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
<option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
<option value="Europe/Riga">(UTC+02:00) Riga</option>
<option value="Europe/Sofia">(UTC+02:00) Sofia</option>
<option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
<option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
<option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
<option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
<option value="Europe/Minsk">(UTC+03:00) Minsk</option>
<option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
<option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
<option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
<option value="Asia/Tehran">(UTC+03:30) Tehran</option>
<option value="Asia/Muscat">(UTC+04:00) Muscat</option>
<option value="Asia/Baku">(UTC+04:00) Baku</option>
<option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
<option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
<option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
<option value="Asia/Kabul">(UTC+04:30) Kabul</option>
<option value="Asia/Karachi">(UTC+05:00) Karachi</option>
<option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
<option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
<option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
<option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
<option value="Asia/Almaty">(UTC+06:00) Almaty</option>
<option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
<option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
<option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
<option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
<option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
<option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
<option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
<option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
<option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
<option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
<option value="Australia/Perth">(UTC+08:00) Perth</option>
<option value="Asia/Singapore">(UTC+08:00) Singapore</option>
<option value="Asia/Taipei">(UTC+08:00) Taipei</option>
<option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
<option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
<option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
<option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
<option value="Asia/Seoul">(UTC+09:00) Seoul</option>
<option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
<option value="Australia/Darwin">(UTC+09:30) Darwin</option>
<option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
<option value="Australia/Canberra">(UTC+10:00) Canberra</option>
<option value="Pacific/Guam">(UTC+10:00) Guam</option>
<option value="Australia/Hobart">(UTC+10:00) Hobart</option>
<option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
<option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
<option value="Australia/Sydney">(UTC+10:00) Sydney</option>
<option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
<option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
<option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
<option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
<option value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
<option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
<option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
<option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
</select>
<span class="timezone-error error" style="display:none;">Please Select TimeZone</span> 
</div>
<div class="tml-field-wrap tml-user_email-wrap">
<label class="tml-label" for="user_email">Email</label>
<input name="user_email" type="email" value="" id="user_email" class="tml-field">
<span class="user_email-error error" style="display:none;">Please Enter Email </span> 
</div>
<div class="tml-field-wrap tml-user_login-wrap">
<label class="tml-label" for="user_login">Username</label>
<input name="user_login" type="text" value="" id="user_login" autocapitalize="off" class="tml-field">
<span class="user_login-error error" style="display:none;">Please Enter User Name</span> 
</div>
<div class="tml-field-wrap tml-user_pass1-wrap">
<label class="tml-label" for="pass1">Password</label>
<input name="user_pass1" type="password" value="" id="pass1" autocomplete="off" class="tml-field">
<span class="password-error error" style="display:none;">Please Enter Password</span> 
</div>
<div class="tml-field-wrap tml-user_pass2-wrap">
<label class="tml-label" for="pass2">Confirm Password</label>
<input name="user_pass2" type="password" value="" id="pass2" autocomplete="off" class="tml-field">
<span class="password2-error error" style="display:none;">Please Enter Confirm Password</span> 
</div>
</div>
</div>
<div class="tml-field-wrap tml-submit-wrap" >
<button name="submit" type="button" id="registersubmit" style="margin-top: 17px;" class="tml-button">Register</button>
</div>

</form>
<?php 
//return apply_filters( 'new_register', $register);

}

add_shortcode( 'edit_profile', 'editform' );

function editform(){

if ( is_user_logged_in() ) {

$cu = wp_get_current_user();
$cu_meta = get_user_meta( $cu->ID );

global $wpdb;

wp_enqueue_style( 'intel', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css', array(  ) );
wp_enqueue_script( 'intel_js',  'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js', array( 'jquery' ), '1.0.0', false );
wp_enqueue_script( 'bitwise_custom_validate_public_js',  'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js', array( 'jquery' ), '1.0.0', false );
wp_enqueue_script( 'bitwise_price_plan_public_js', plugin_dir_url( __FILE__ ) . 'public/js/bitwise-price-plan-public.js', array( 'jquery' ), '1.0.0', false );
$register='';
?>

<div class="tml tml-register">
<form id="newregister" name="register" action="<?php echo site_url();?>/register/" method="post"  data-ajax="1">
<div class="registerdetails">
<div class="parentdetails"><div class="tml-field-wrap tml-parent_heading-wrap">
Parent Details</div>
<div class="tml-field-wrap tml-parent_f_name-wrap">
<span class="tml-label">First Name</span>
<input name="parent_f_name" id="parentfname" type="text" value="<?php echo get_user_meta( $cu->ID, 'parent_f_name', true ) ?>" class="tml-field">
<span class="parent_f_name-error error" style="display:none;">Please Enter First Name</span>
</div>
<div class="tml-field-wrap tml-parent_l_name-wrap">
<span class="tml-label">Last name</span>
<input name="parent_l_name" type="text" id="parentlname" value="<?php echo get_user_meta( $cu->ID, 'parent_l_name', true ) ?>" class="tml-field">
<span class="parent_l_name-error error" style="display:none;">Please Enter Last Name</span>
</div>
<div class="tml-field-wrap tml-parent_email-wrap">
<span class="tml-label">Email</span>
<input name="parent_email" type="email" id="parentemail" value="<?php echo get_user_meta( $cu->ID, 'parent_email', true ) ?>" class="tml-field">
<span class="parent_email-error error" style="display:none;">Please Enter Email Address</span> 
</div>
<div class="tml-field-wrap tml-parent_cnf_email-wrap">
<span class="tml-label">Confirm Email</span>
<input name="parent_cnf_email" type="email" id="parentcnfemail" value="<?php echo get_user_meta( $cu->ID, 'parent_email', true ) ?>" class="tml-field">
<span class="confirmemail-error error" style="display:none;">Please Enter Confirm Email</span> 
</div>
<div class="tml-field-wrap tml-parent_phone-wrap">
<label class="tml-label" for="parent_phone">Phone</label>
<div class="intl-tel-input">
<div class="flag-container"><div style="height:40px!important" tabindex="0" class="selected-flag" title="United States: +1"><div class="iti-flag us"></div><div style="top:45%!important" class="arrow"></div></div><ul class="country-list hide"><li class="country preferred active" data-dial-code="1" data-country-code="us"><div class="flag"><div class="iti-flag us"></div></div><span class="country-name">United States</span><span class="dial-code">+1</span></li><li class="country preferred" data-dial-code="91" data-country-code="in"><div class="flag"><div class="iti-flag in"></div></div><span class="country-name">India (भारत)</span><span class="dial-code">+91</span></li><li class="divider"></li><li class="country" data-dial-code="93" data-country-code="af"><div class="flag"><div class="iti-flag af"></div></div><span class="country-name">Afghanistan (&#8235;افغانستان&#8236;&lrm;)</span><span class="dial-code">+93</span></li><li class="country" data-dial-code="355" data-country-code="al"><div class="flag"><div class="iti-flag al"></div></div><span class="country-name">Albania (Shqipëri)</span><span class="dial-code">+355</span></li><li class="country" data-dial-code="213" data-country-code="dz"><div class="flag"><div class="iti-flag dz"></div></div><span class="country-name">Algeria (&#8235;الجزائر&#8236;&lrm;)</span><span class="dial-code">+213</span></li><li class="country" data-dial-code="1684" data-country-code="as"><div class="flag"><div class="iti-flag as"></div></div><span class="country-name">American Samoa</span><span class="dial-code">+1684</span></li><li class="country" data-dial-code="376" data-country-code="ad"><div class="flag"><div class="iti-flag ad"></div></div><span class="country-name">Andorra</span><span class="dial-code">+376</span></li><li class="country" data-dial-code="244" data-country-code="ao"><div class="flag"><div class="iti-flag ao"></div></div><span class="country-name">Angola</span><span class="dial-code">+244</span></li><li class="country" data-dial-code="1264" data-country-code="ai"><div class="flag"><div class="iti-flag ai"></div></div><span class="country-name">Anguilla</span><span class="dial-code">+1264</span></li><li class="country" data-dial-code="1268" data-country-code="ag"><div class="flag"><div class="iti-flag ag"></div></div><span class="country-name">Antigua and Barbuda</span><span class="dial-code">+1268</span></li><li class="country" data-dial-code="54" data-country-code="ar"><div class="flag"><div class="iti-flag ar"></div></div><span class="country-name">Argentina</span><span class="dial-code">+54</span></li><li class="country" data-dial-code="374" data-country-code="am"><div class="flag"><div class="iti-flag am"></div></div><span class="country-name">Armenia (Հայաստան)</span><span class="dial-code">+374</span></li><li class="country" data-dial-code="297" data-country-code="aw"><div class="flag"><div class="iti-flag aw"></div></div><span class="country-name">Aruba</span><span class="dial-code">+297</span></li><li class="country" data-dial-code="61" data-country-code="au"><div class="flag"><div class="iti-flag au"></div></div><span class="country-name">Australia</span><span class="dial-code">+61</span></li><li class="country" data-dial-code="43" data-country-code="at"><div class="flag"><div class="iti-flag at"></div></div><span class="country-name">Austria (Österreich)</span><span class="dial-code">+43</span></li><li class="country" data-dial-code="994" data-country-code="az"><div class="flag"><div class="iti-flag az"></div></div><span class="country-name">Azerbaijan (Azərbaycan)</span><span class="dial-code">+994</span></li><li class="country" data-dial-code="1242" data-country-code="bs"><div class="flag"><div class="iti-flag bs"></div></div><span class="country-name">Bahamas</span><span class="dial-code">+1242</span></li><li class="country" data-dial-code="973" data-country-code="bh"><div class="flag"><div class="iti-flag bh"></div></div><span class="country-name">Bahrain (&#8235;البحرين&#8236;&lrm;)</span><span class="dial-code">+973</span></li><li class="country" data-dial-code="880" data-country-code="bd"><div class="flag"><div class="iti-flag bd"></div></div><span class="country-name">Bangladesh (বাংলাদেশ)</span><span class="dial-code">+880</span></li><li class="country" data-dial-code="1246" data-country-code="bb"><div class="flag"><div class="iti-flag bb"></div></div><span class="country-name">Barbados</span><span class="dial-code">+1246</span></li><li class="country" data-dial-code="375" data-country-code="by"><div class="flag"><div class="iti-flag by"></div></div><span class="country-name">Belarus (Беларусь)</span><span class="dial-code">+375</span></li><li class="country" data-dial-code="32" data-country-code="be"><div class="flag"><div class="iti-flag be"></div></div><span class="country-name">Belgium (België)</span><span class="dial-code">+32</span></li><li class="country" data-dial-code="501" data-country-code="bz"><div class="flag"><div class="iti-flag bz"></div></div><span class="country-name">Belize</span><span class="dial-code">+501</span></li><li class="country" data-dial-code="229" data-country-code="bj"><div class="flag"><div class="iti-flag bj"></div></div><span class="country-name">Benin (Bénin)</span><span class="dial-code">+229</span></li><li class="country" data-dial-code="1441" data-country-code="bm"><div class="flag"><div class="iti-flag bm"></div></div><span class="country-name">Bermuda</span><span class="dial-code">+1441</span></li><li class="country" data-dial-code="975" data-country-code="bt"><div class="flag"><div class="iti-flag bt"></div></div><span class="country-name">Bhutan (འབྲུག)</span><span class="dial-code">+975</span></li><li class="country" data-dial-code="591" data-country-code="bo"><div class="flag"><div class="iti-flag bo"></div></div><span class="country-name">Bolivia</span><span class="dial-code">+591</span></li><li class="country" data-dial-code="387" data-country-code="ba"><div class="flag"><div class="iti-flag ba"></div></div><span class="country-name">Bosnia and Herzegovina (Босна и Херцеговина)</span><span class="dial-code">+387</span></li><li class="country" data-dial-code="267" data-country-code="bw"><div class="flag"><div class="iti-flag bw"></div></div><span class="country-name">Botswana</span><span class="dial-code">+267</span></li><li class="country" data-dial-code="55" data-country-code="br"><div class="flag"><div class="iti-flag br"></div></div><span class="country-name">Brazil (Brasil)</span><span class="dial-code">+55</span></li><li class="country" data-dial-code="246" data-country-code="io"><div class="flag"><div class="iti-flag io"></div></div><span class="country-name">British Indian Ocean Territory</span><span class="dial-code">+246</span></li><li class="country" data-dial-code="1284" data-country-code="vg"><div class="flag"><div class="iti-flag vg"></div></div><span class="country-name">British Virgin Islands</span><span class="dial-code">+1284</span></li><li class="country" data-dial-code="673" data-country-code="bn"><div class="flag"><div class="iti-flag bn"></div></div><span class="country-name">Brunei</span><span class="dial-code">+673</span></li><li class="country" data-dial-code="359" data-country-code="bg"><div class="flag"><div class="iti-flag bg"></div></div><span class="country-name">Bulgaria (България)</span><span class="dial-code">+359</span></li><li class="country" data-dial-code="226" data-country-code="bf"><div class="flag"><div class="iti-flag bf"></div></div><span class="country-name">Burkina Faso</span><span class="dial-code">+226</span></li><li class="country" data-dial-code="257" data-country-code="bi"><div class="flag"><div class="iti-flag bi"></div></div><span class="country-name">Burundi (Uburundi)</span><span class="dial-code">+257</span></li><li class="country" data-dial-code="855" data-country-code="kh"><div class="flag"><div class="iti-flag kh"></div></div><span class="country-name">Cambodia (កម្ពុជា)</span><span class="dial-code">+855</span></li><li class="country" data-dial-code="237" data-country-code="cm"><div class="flag"><div class="iti-flag cm"></div></div><span class="country-name">Cameroon (Cameroun)</span><span class="dial-code">+237</span></li><li class="country" data-dial-code="1" data-country-code="ca"><div class="flag"><div class="iti-flag ca"></div></div><span class="country-name">Canada</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="238" data-country-code="cv"><div class="flag"><div class="iti-flag cv"></div></div><span class="country-name">Cape Verde (Kabu Verdi)</span><span class="dial-code">+238</span></li><li class="country" data-dial-code="599" data-country-code="bq"><div class="flag"><div class="iti-flag bq"></div></div><span class="country-name">Caribbean Netherlands</span><span class="dial-code">+599</span></li><li class="country" data-dial-code="1345" data-country-code="ky"><div class="flag"><div class="iti-flag ky"></div></div><span class="country-name">Cayman Islands</span><span class="dial-code">+1345</span></li><li class="country" data-dial-code="236" data-country-code="cf"><div class="flag"><div class="iti-flag cf"></div></div><span class="country-name">Central African Republic (République centrafricaine)</span><span class="dial-code">+236</span></li><li class="country" data-dial-code="235" data-country-code="td"><div class="flag"><div class="iti-flag td"></div></div><span class="country-name">Chad (Tchad)</span><span class="dial-code">+235</span></li><li class="country" data-dial-code="56" data-country-code="cl"><div class="flag"><div class="iti-flag cl"></div></div><span class="country-name">Chile</span><span class="dial-code">+56</span></li><li class="country" data-dial-code="86" data-country-code="cn"><div class="flag"><div class="iti-flag cn"></div></div><span class="country-name">China (中国)</span><span class="dial-code">+86</span></li><li class="country" data-dial-code="61" data-country-code="cx"><div class="flag"><div class="iti-flag cx"></div></div><span class="country-name">Christmas Island</span><span class="dial-code">+61</span></li><li class="country" data-dial-code="61" data-country-code="cc"><div class="flag"><div class="iti-flag cc"></div></div><span class="country-name">Cocos (Keeling) Islands</span><span class="dial-code">+61</span></li><li class="country" data-dial-code="57" data-country-code="co"><div class="flag"><div class="iti-flag co"></div></div><span class="country-name">Colombia</span><span class="dial-code">+57</span></li><li class="country" data-dial-code="269" data-country-code="km"><div class="flag"><div class="iti-flag km"></div></div><span class="country-name">Comoros (&#8235;جزر القمر&#8236;&lrm;)</span><span class="dial-code">+269</span></li><li class="country" data-dial-code="243" data-country-code="cd"><div class="flag"><div class="iti-flag cd"></div></div><span class="country-name">Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)</span><span class="dial-code">+243</span></li><li class="country" data-dial-code="242" data-country-code="cg"><div class="flag"><div class="iti-flag cg"></div></div><span class="country-name">Congo (Republic) (Congo-Brazzaville)</span><span class="dial-code">+242</span></li><li class="country" data-dial-code="682" data-country-code="ck"><div class="flag"><div class="iti-flag ck"></div></div><span class="country-name">Cook Islands</span><span class="dial-code">+682</span></li><li class="country" data-dial-code="506" data-country-code="cr"><div class="flag"><div class="iti-flag cr"></div></div><span class="country-name">Costa Rica</span><span class="dial-code">+506</span></li><li class="country" data-dial-code="225" data-country-code="ci"><div class="flag"><div class="iti-flag ci"></div></div><span class="country-name">Côte d’Ivoire</span><span class="dial-code">+225</span></li><li class="country" data-dial-code="385" data-country-code="hr"><div class="flag"><div class="iti-flag hr"></div></div><span class="country-name">Croatia (Hrvatska)</span><span class="dial-code">+385</span></li><li class="country" data-dial-code="53" data-country-code="cu"><div class="flag"><div class="iti-flag cu"></div></div><span class="country-name">Cuba</span><span class="dial-code">+53</span></li><li class="country" data-dial-code="599" data-country-code="cw"><div class="flag"><div class="iti-flag cw"></div></div><span class="country-name">Curaçao</span><span class="dial-code">+599</span></li><li class="country" data-dial-code="357" data-country-code="cy"><div class="flag"><div class="iti-flag cy"></div></div><span class="country-name">Cyprus (Κύπρος)</span><span class="dial-code">+357</span></li><li class="country" data-dial-code="420" data-country-code="cz"><div class="flag"><div class="iti-flag cz"></div></div><span class="country-name">Czech Republic (Česká republika)</span><span class="dial-code">+420</span></li><li class="country" data-dial-code="45" data-country-code="dk"><div class="flag"><div class="iti-flag dk"></div></div><span class="country-name">Denmark (Danmark)</span><span class="dial-code">+45</span></li><li class="country" data-dial-code="253" data-country-code="dj"><div class="flag"><div class="iti-flag dj"></div></div><span class="country-name">Djibouti</span><span class="dial-code">+253</span></li><li class="country" data-dial-code="1767" data-country-code="dm"><div class="flag"><div class="iti-flag dm"></div></div><span class="country-name">Dominica</span><span class="dial-code">+1767</span></li><li class="country" data-dial-code="1" data-country-code="do"><div class="flag"><div class="iti-flag do"></div></div><span class="country-name">Dominican Republic (República Dominicana)</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="593" data-country-code="ec"><div class="flag"><div class="iti-flag ec"></div></div><span class="country-name">Ecuador</span><span class="dial-code">+593</span></li><li class="country" data-dial-code="20" data-country-code="eg"><div class="flag"><div class="iti-flag eg"></div></div><span class="country-name">Egypt (&#8235;مصر&#8236;&lrm;)</span><span class="dial-code">+20</span></li><li class="country" data-dial-code="503" data-country-code="sv"><div class="flag"><div class="iti-flag sv"></div></div><span class="country-name">El Salvador</span><span class="dial-code">+503</span></li><li class="country" data-dial-code="240" data-country-code="gq"><div class="flag"><div class="iti-flag gq"></div></div><span class="country-name">Equatorial Guinea (Guinea Ecuatorial)</span><span class="dial-code">+240</span></li><li class="country" data-dial-code="291" data-country-code="er"><div class="flag"><div class="iti-flag er"></div></div><span class="country-name">Eritrea</span><span class="dial-code">+291</span></li><li class="country" data-dial-code="372" data-country-code="ee"><div class="flag"><div class="iti-flag ee"></div></div><span class="country-name">Estonia (Eesti)</span><span class="dial-code">+372</span></li><li class="country" data-dial-code="251" data-country-code="et"><div class="flag"><div class="iti-flag et"></div></div><span class="country-name">Ethiopia</span><span class="dial-code">+251</span></li><li class="country" data-dial-code="500" data-country-code="fk"><div class="flag"><div class="iti-flag fk"></div></div><span class="country-name">Falkland Islands (Islas Malvinas)</span><span class="dial-code">+500</span></li><li class="country" data-dial-code="298" data-country-code="fo"><div class="flag"><div class="iti-flag fo"></div></div><span class="country-name">Faroe Islands (Føroyar)</span><span class="dial-code">+298</span></li><li class="country" data-dial-code="679" data-country-code="fj"><div class="flag"><div class="iti-flag fj"></div></div><span class="country-name">Fiji</span><span class="dial-code">+679</span></li><li class="country" data-dial-code="358" data-country-code="fi"><div class="flag"><div class="iti-flag fi"></div></div><span class="country-name">Finland (Suomi)</span><span class="dial-code">+358</span></li><li class="country" data-dial-code="33" data-country-code="fr"><div class="flag"><div class="iti-flag fr"></div></div><span class="country-name">France</span><span class="dial-code">+33</span></li><li class="country" data-dial-code="594" data-country-code="gf"><div class="flag"><div class="iti-flag gf"></div></div><span class="country-name">French Guiana (Guyane française)</span><span class="dial-code">+594</span></li><li class="country" data-dial-code="689" data-country-code="pf"><div class="flag"><div class="iti-flag pf"></div></div><span class="country-name">French Polynesia (Polynésie française)</span><span class="dial-code">+689</span></li><li class="country" data-dial-code="241" data-country-code="ga"><div class="flag"><div class="iti-flag ga"></div></div><span class="country-name">Gabon</span><span class="dial-code">+241</span></li><li class="country" data-dial-code="220" data-country-code="gm"><div class="flag"><div class="iti-flag gm"></div></div><span class="country-name">Gambia</span><span class="dial-code">+220</span></li><li class="country" data-dial-code="995" data-country-code="ge"><div class="flag"><div class="iti-flag ge"></div></div><span class="country-name">Georgia (საქართველო)</span><span class="dial-code">+995</span></li><li class="country" data-dial-code="49" data-country-code="de"><div class="flag"><div class="iti-flag de"></div></div><span class="country-name">Germany (Deutschland)</span><span class="dial-code">+49</span></li><li class="country" data-dial-code="233" data-country-code="gh"><div class="flag"><div class="iti-flag gh"></div></div><span class="country-name">Ghana (Gaana)</span><span class="dial-code">+233</span></li><li class="country" data-dial-code="350" data-country-code="gi"><div class="flag"><div class="iti-flag gi"></div></div><span class="country-name">Gibraltar</span><span class="dial-code">+350</span></li><li class="country" data-dial-code="30" data-country-code="gr"><div class="flag"><div class="iti-flag gr"></div></div><span class="country-name">Greece (Ελλάδα)</span><span class="dial-code">+30</span></li><li class="country" data-dial-code="299" data-country-code="gl"><div class="flag"><div class="iti-flag gl"></div></div><span class="country-name">Greenland (Kalaallit Nunaat)</span><span class="dial-code">+299</span></li><li class="country" data-dial-code="1473" data-country-code="gd"><div class="flag"><div class="iti-flag gd"></div></div><span class="country-name">Grenada</span><span class="dial-code">+1473</span></li><li class="country" data-dial-code="590" data-country-code="gp"><div class="flag"><div class="iti-flag gp"></div></div><span class="country-name">Guadeloupe</span><span class="dial-code">+590</span></li><li class="country" data-dial-code="1671" data-country-code="gu"><div class="flag"><div class="iti-flag gu"></div></div><span class="country-name">Guam</span><span class="dial-code">+1671</span></li><li class="country" data-dial-code="502" data-country-code="gt"><div class="flag"><div class="iti-flag gt"></div></div><span class="country-name">Guatemala</span><span class="dial-code">+502</span></li><li class="country" data-dial-code="44" data-country-code="gg"><div class="flag"><div class="iti-flag gg"></div></div><span class="country-name">Guernsey</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="224" data-country-code="gn"><div class="flag"><div class="iti-flag gn"></div></div><span class="country-name">Guinea (Guinée)</span><span class="dial-code">+224</span></li><li class="country" data-dial-code="245" data-country-code="gw"><div class="flag"><div class="iti-flag gw"></div></div><span class="country-name">Guinea-Bissau (Guiné Bissau)</span><span class="dial-code">+245</span></li><li class="country" data-dial-code="592" data-country-code="gy"><div class="flag"><div class="iti-flag gy"></div></div><span class="country-name">Guyana</span><span class="dial-code">+592</span></li><li class="country" data-dial-code="509" data-country-code="ht"><div class="flag"><div class="iti-flag ht"></div></div><span class="country-name">Haiti</span><span class="dial-code">+509</span></li><li class="country" data-dial-code="504" data-country-code="hn"><div class="flag"><div class="iti-flag hn"></div></div><span class="country-name">Honduras</span><span class="dial-code">+504</span></li><li class="country" data-dial-code="852" data-country-code="hk"><div class="flag"><div class="iti-flag hk"></div></div><span class="country-name">Hong Kong (香港)</span><span class="dial-code">+852</span></li><li class="country" data-dial-code="36" data-country-code="hu"><div class="flag"><div class="iti-flag hu"></div></div><span class="country-name">Hungary (Magyarország)</span><span class="dial-code">+36</span></li><li class="country" data-dial-code="354" data-country-code="is"><div class="flag"><div class="iti-flag is"></div></div><span class="country-name">Iceland (Ísland)</span><span class="dial-code">+354</span></li><li class="country" data-dial-code="91" data-country-code="in"><div class="flag"><div class="iti-flag in"></div></div><span class="country-name">India (भारत)</span><span class="dial-code">+91</span></li><li class="country" data-dial-code="62" data-country-code="id"><div class="flag"><div class="iti-flag id"></div></div><span class="country-name">Indonesia</span><span class="dial-code">+62</span></li><li class="country" data-dial-code="98" data-country-code="ir"><div class="flag"><div class="iti-flag ir"></div></div><span class="country-name">Iran (&#8235;ایران&#8236;&lrm;)</span><span class="dial-code">+98</span></li><li class="country" data-dial-code="964" data-country-code="iq"><div class="flag"><div class="iti-flag iq"></div></div><span class="country-name">Iraq (&#8235;العراق&#8236;&lrm;)</span><span class="dial-code">+964</span></li><li class="country" data-dial-code="353" data-country-code="ie"><div class="flag"><div class="iti-flag ie"></div></div><span class="country-name">Ireland</span><span class="dial-code">+353</span></li><li class="country" data-dial-code="44" data-country-code="im"><div class="flag"><div class="iti-flag im"></div></div><span class="country-name">Isle of Man</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="972" data-country-code="il"><div class="flag"><div class="iti-flag il"></div></div><span class="country-name">Israel (&#8235;ישראל&#8236;&lrm;)</span><span class="dial-code">+972</span></li><li class="country" data-dial-code="39" data-country-code="it"><div class="flag"><div class="iti-flag it"></div></div><span class="country-name">Italy (Italia)</span><span class="dial-code">+39</span></li><li class="country" data-dial-code="1876" data-country-code="jm"><div class="flag"><div class="iti-flag jm"></div></div><span class="country-name">Jamaica</span><span class="dial-code">+1876</span></li><li class="country" data-dial-code="81" data-country-code="jp"><div class="flag"><div class="iti-flag jp"></div></div><span class="country-name">Japan (日本)</span><span class="dial-code">+81</span></li><li class="country" data-dial-code="44" data-country-code="je"><div class="flag"><div class="iti-flag je"></div></div><span class="country-name">Jersey</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="962" data-country-code="jo"><div class="flag"><div class="iti-flag jo"></div></div><span class="country-name">Jordan (&#8235;الأردن&#8236;&lrm;)</span><span class="dial-code">+962</span></li><li class="country" data-dial-code="7" data-country-code="kz"><div class="flag"><div class="iti-flag kz"></div></div><span class="country-name">Kazakhstan (Казахстан)</span><span class="dial-code">+7</span></li><li class="country" data-dial-code="254" data-country-code="ke"><div class="flag"><div class="iti-flag ke"></div></div><span class="country-name">Kenya</span><span class="dial-code">+254</span></li><li class="country" data-dial-code="686" data-country-code="ki"><div class="flag"><div class="iti-flag ki"></div></div><span class="country-name">Kiribati</span><span class="dial-code">+686</span></li><li class="country" data-dial-code="965" data-country-code="kw"><div class="flag"><div class="iti-flag kw"></div></div><span class="country-name">Kuwait (&#8235;الكويت&#8236;&lrm;)</span><span class="dial-code">+965</span></li><li class="country" data-dial-code="996" data-country-code="kg"><div class="flag"><div class="iti-flag kg"></div></div><span class="country-name">Kyrgyzstan (Кыргызстан)</span><span class="dial-code">+996</span></li><li class="country" data-dial-code="856" data-country-code="la"><div class="flag"><div class="iti-flag la"></div></div><span class="country-name">Laos (ລາວ)</span><span class="dial-code">+856</span></li><li class="country" data-dial-code="371" data-country-code="lv"><div class="flag"><div class="iti-flag lv"></div></div><span class="country-name">Latvia (Latvija)</span><span class="dial-code">+371</span></li><li class="country" data-dial-code="961" data-country-code="lb"><div class="flag"><div class="iti-flag lb"></div></div><span class="country-name">Lebanon (&#8235;لبنان&#8236;&lrm;)</span><span class="dial-code">+961</span></li><li class="country" data-dial-code="266" data-country-code="ls"><div class="flag"><div class="iti-flag ls"></div></div><span class="country-name">Lesotho</span><span class="dial-code">+266</span></li><li class="country" data-dial-code="231" data-country-code="lr"><div class="flag"><div class="iti-flag lr"></div></div><span class="country-name">Liberia</span><span class="dial-code">+231</span></li><li class="country" data-dial-code="218" data-country-code="ly"><div class="flag"><div class="iti-flag ly"></div></div><span class="country-name">Libya (&#8235;ليبيا&#8236;&lrm;)</span><span class="dial-code">+218</span></li><li class="country" data-dial-code="423" data-country-code="li"><div class="flag"><div class="iti-flag li"></div></div><span class="country-name">Liechtenstein</span><span class="dial-code">+423</span></li><li class="country" data-dial-code="370" data-country-code="lt"><div class="flag"><div class="iti-flag lt"></div></div><span class="country-name">Lithuania (Lietuva)</span><span class="dial-code">+370</span></li><li class="country" data-dial-code="352" data-country-code="lu"><div class="flag"><div class="iti-flag lu"></div></div><span class="country-name">Luxembourg</span><span class="dial-code">+352</span></li><li class="country" data-dial-code="853" data-country-code="mo"><div class="flag"><div class="iti-flag mo"></div></div><span class="country-name">Macau (澳門)</span><span class="dial-code">+853</span></li><li class="country" data-dial-code="389" data-country-code="mk"><div class="flag"><div class="iti-flag mk"></div></div><span class="country-name">Macedonia (FYROM) (Македонија)</span><span class="dial-code">+389</span></li><li class="country" data-dial-code="261" data-country-code="mg"><div class="flag"><div class="iti-flag mg"></div></div><span class="country-name">Madagascar (Madagasikara)</span><span class="dial-code">+261</span></li><li class="country" data-dial-code="265" data-country-code="mw"><div class="flag"><div class="iti-flag mw"></div></div><span class="country-name">Malawi</span><span class="dial-code">+265</span></li><li class="country" data-dial-code="60" data-country-code="my"><div class="flag"><div class="iti-flag my"></div></div><span class="country-name">Malaysia</span><span class="dial-code">+60</span></li><li class="country" data-dial-code="960" data-country-code="mv"><div class="flag"><div class="iti-flag mv"></div></div><span class="country-name">Maldives</span><span class="dial-code">+960</span></li><li class="country" data-dial-code="223" data-country-code="ml"><div class="flag"><div class="iti-flag ml"></div></div><span class="country-name">Mali</span><span class="dial-code">+223</span></li><li class="country" data-dial-code="356" data-country-code="mt"><div class="flag"><div class="iti-flag mt"></div></div><span class="country-name">Malta</span><span class="dial-code">+356</span></li><li class="country" data-dial-code="692" data-country-code="mh"><div class="flag"><div class="iti-flag mh"></div></div><span class="country-name">Marshall Islands</span><span class="dial-code">+692</span></li><li class="country" data-dial-code="596" data-country-code="mq"><div class="flag"><div class="iti-flag mq"></div></div><span class="country-name">Martinique</span><span class="dial-code">+596</span></li><li class="country" data-dial-code="222" data-country-code="mr"><div class="flag"><div class="iti-flag mr"></div></div><span class="country-name">Mauritania (&#8235;موريتانيا&#8236;&lrm;)</span><span class="dial-code">+222</span></li><li class="country" data-dial-code="230" data-country-code="mu"><div class="flag"><div class="iti-flag mu"></div></div><span class="country-name">Mauritius (Moris)</span><span class="dial-code">+230</span></li><li class="country" data-dial-code="262" data-country-code="yt"><div class="flag"><div class="iti-flag yt"></div></div><span class="country-name">Mayotte</span><span class="dial-code">+262</span></li><li class="country" data-dial-code="52" data-country-code="mx"><div class="flag"><div class="iti-flag mx"></div></div><span class="country-name">Mexico (México)</span><span class="dial-code">+52</span></li><li class="country" data-dial-code="691" data-country-code="fm"><div class="flag"><div class="iti-flag fm"></div></div><span class="country-name">Micronesia</span><span class="dial-code">+691</span></li><li class="country" data-dial-code="373" data-country-code="md"><div class="flag"><div class="iti-flag md"></div></div><span class="country-name">Moldova (Republica Moldova)</span><span class="dial-code">+373</span></li><li class="country" data-dial-code="377" data-country-code="mc"><div class="flag"><div class="iti-flag mc"></div></div><span class="country-name">Monaco</span><span class="dial-code">+377</span></li><li class="country" data-dial-code="976" data-country-code="mn"><div class="flag"><div class="iti-flag mn"></div></div><span class="country-name">Mongolia (Монгол)</span><span class="dial-code">+976</span></li><li class="country" data-dial-code="382" data-country-code="me"><div class="flag"><div class="iti-flag me"></div></div><span class="country-name">Montenegro (Crna Gora)</span><span class="dial-code">+382</span></li><li class="country" data-dial-code="1664" data-country-code="ms"><div class="flag"><div class="iti-flag ms"></div></div><span class="country-name">Montserrat</span><span class="dial-code">+1664</span></li><li class="country" data-dial-code="212" data-country-code="ma"><div class="flag"><div class="iti-flag ma"></div></div><span class="country-name">Morocco (&#8235;المغرب&#8236;&lrm;)</span><span class="dial-code">+212</span></li><li class="country" data-dial-code="258" data-country-code="mz"><div class="flag"><div class="iti-flag mz"></div></div><span class="country-name">Mozambique (Moçambique)</span><span class="dial-code">+258</span></li><li class="country" data-dial-code="95" data-country-code="mm"><div class="flag"><div class="iti-flag mm"></div></div><span class="country-name">Myanmar (Burma) (မြန်မာ)</span><span class="dial-code">+95</span></li><li class="country" data-dial-code="264" data-country-code="na"><div class="flag"><div class="iti-flag na"></div></div><span class="country-name">Namibia (Namibië)</span><span class="dial-code">+264</span></li><li class="country" data-dial-code="674" data-country-code="nr"><div class="flag"><div class="iti-flag nr"></div></div><span class="country-name">Nauru</span><span class="dial-code">+674</span></li><li class="country" data-dial-code="977" data-country-code="np"><div class="flag"><div class="iti-flag np"></div></div><span class="country-name">Nepal (नेपाल)</span><span class="dial-code">+977</span></li><li class="country" data-dial-code="31" data-country-code="nl"><div class="flag"><div class="iti-flag nl"></div></div><span class="country-name">Netherlands (Nederland)</span><span class="dial-code">+31</span></li><li class="country" data-dial-code="687" data-country-code="nc"><div class="flag"><div class="iti-flag nc"></div></div><span class="country-name">New Caledonia (Nouvelle-Calédonie)</span><span class="dial-code">+687</span></li><li class="country" data-dial-code="64" data-country-code="nz"><div class="flag"><div class="iti-flag nz"></div></div><span class="country-name">New Zealand</span><span class="dial-code">+64</span></li><li class="country" data-dial-code="505" data-country-code="ni"><div class="flag"><div class="iti-flag ni"></div></div><span class="country-name">Nicaragua</span><span class="dial-code">+505</span></li><li class="country" data-dial-code="227" data-country-code="ne"><div class="flag"><div class="iti-flag ne"></div></div><span class="country-name">Niger (Nijar)</span><span class="dial-code">+227</span></li><li class="country" data-dial-code="234" data-country-code="ng"><div class="flag"><div class="iti-flag ng"></div></div><span class="country-name">Nigeria</span><span class="dial-code">+234</span></li><li class="country" data-dial-code="683" data-country-code="nu"><div class="flag"><div class="iti-flag nu"></div></div><span class="country-name">Niue</span><span class="dial-code">+683</span></li><li class="country" data-dial-code="672" data-country-code="nf"><div class="flag"><div class="iti-flag nf"></div></div><span class="country-name">Norfolk Island</span><span class="dial-code">+672</span></li><li class="country" data-dial-code="850" data-country-code="kp"><div class="flag"><div class="iti-flag kp"></div></div><span class="country-name">North Korea (조선 민주주의 인민 공화국)</span><span class="dial-code">+850</span></li><li class="country" data-dial-code="1670" data-country-code="mp"><div class="flag"><div class="iti-flag mp"></div></div><span class="country-name">Northern Mariana Islands</span><span class="dial-code">+1670</span></li><li class="country" data-dial-code="47" data-country-code="no"><div class="flag"><div class="iti-flag no"></div></div><span class="country-name">Norway (Norge)</span><span class="dial-code">+47</span></li><li class="country" data-dial-code="968" data-country-code="om"><div class="flag"><div class="iti-flag om"></div></div><span class="country-name">Oman (&#8235;عُمان&#8236;&lrm;)</span><span class="dial-code">+968</span></li><li class="country" data-dial-code="92" data-country-code="pk"><div class="flag"><div class="iti-flag pk"></div></div><span class="country-name">Pakistan (&#8235;پاکستان&#8236;&lrm;)</span><span class="dial-code">+92</span></li><li class="country" data-dial-code="680" data-country-code="pw"><div class="flag"><div class="iti-flag pw"></div></div><span class="country-name">Palau</span><span class="dial-code">+680</span></li><li class="country" data-dial-code="970" data-country-code="ps"><div class="flag"><div class="iti-flag ps"></div></div><span class="country-name">Palestine (&#8235;فلسطين&#8236;&lrm;)</span><span class="dial-code">+970</span></li><li class="country" data-dial-code="507" data-country-code="pa"><div class="flag"><div class="iti-flag pa"></div></div><span class="country-name">Panama (Panamá)</span><span class="dial-code">+507</span></li><li class="country" data-dial-code="675" data-country-code="pg"><div class="flag"><div class="iti-flag pg"></div></div><span class="country-name">Papua New Guinea</span><span class="dial-code">+675</span></li><li class="country" data-dial-code="595" data-country-code="py"><div class="flag"><div class="iti-flag py"></div></div><span class="country-name">Paraguay</span><span class="dial-code">+595</span></li><li class="country" data-dial-code="51" data-country-code="pe"><div class="flag"><div class="iti-flag pe"></div></div><span class="country-name">Peru (Perú)</span><span class="dial-code">+51</span></li><li class="country" data-dial-code="63" data-country-code="ph"><div class="flag"><div class="iti-flag ph"></div></div><span class="country-name">Philippines</span><span class="dial-code">+63</span></li><li class="country" data-dial-code="48" data-country-code="pl"><div class="flag"><div class="iti-flag pl"></div></div><span class="country-name">Poland (Polska)</span><span class="dial-code">+48</span></li><li class="country" data-dial-code="351" data-country-code="pt"><div class="flag"><div class="iti-flag pt"></div></div><span class="country-name">Portugal</span><span class="dial-code">+351</span></li><li class="country" data-dial-code="1" data-country-code="pr"><div class="flag"><div class="iti-flag pr"></div></div><span class="country-name">Puerto Rico</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="974" data-country-code="qa"><div class="flag"><div class="iti-flag qa"></div></div><span class="country-name">Qatar (&#8235;قطر&#8236;&lrm;)</span><span class="dial-code">+974</span></li><li class="country" data-dial-code="262" data-country-code="re"><div class="flag"><div class="iti-flag re"></div></div><span class="country-name">Réunion (La Réunion)</span><span class="dial-code">+262</span></li><li class="country" data-dial-code="40" data-country-code="ro"><div class="flag"><div class="iti-flag ro"></div></div><span class="country-name">Romania (România)</span><span class="dial-code">+40</span></li><li class="country" data-dial-code="7" data-country-code="ru"><div class="flag"><div class="iti-flag ru"></div></div><span class="country-name">Russia (Россия)</span><span class="dial-code">+7</span></li><li class="country" data-dial-code="250" data-country-code="rw"><div class="flag"><div class="iti-flag rw"></div></div><span class="country-name">Rwanda</span><span class="dial-code">+250</span></li><li class="country" data-dial-code="590" data-country-code="bl"><div class="flag"><div class="iti-flag bl"></div></div><span class="country-name">Saint Barthélemy (Saint-Barthélemy)</span><span class="dial-code">+590</span></li><li class="country" data-dial-code="290" data-country-code="sh"><div class="flag"><div class="iti-flag sh"></div></div><span class="country-name">Saint Helena</span><span class="dial-code">+290</span></li><li class="country" data-dial-code="1869" data-country-code="kn"><div class="flag"><div class="iti-flag kn"></div></div><span class="country-name">Saint Kitts and Nevis</span><span class="dial-code">+1869</span></li><li class="country" data-dial-code="1758" data-country-code="lc"><div class="flag"><div class="iti-flag lc"></div></div><span class="country-name">Saint Lucia</span><span class="dial-code">+1758</span></li><li class="country" data-dial-code="590" data-country-code="mf"><div class="flag"><div class="iti-flag mf"></div></div><span class="country-name">Saint Martin (Saint-Martin (partie française))</span><span class="dial-code">+590</span></li><li class="country" data-dial-code="508" data-country-code="pm"><div class="flag"><div class="iti-flag pm"></div></div><span class="country-name">Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)</span><span class="dial-code">+508</span></li><li class="country" data-dial-code="1784" data-country-code="vc"><div class="flag"><div class="iti-flag vc"></div></div><span class="country-name">Saint Vincent and the Grenadines</span><span class="dial-code">+1784</span></li><li class="country" data-dial-code="685" data-country-code="ws"><div class="flag"><div class="iti-flag ws"></div></div><span class="country-name">Samoa</span><span class="dial-code">+685</span></li><li class="country" data-dial-code="378" data-country-code="sm"><div class="flag"><div class="iti-flag sm"></div></div><span class="country-name">San Marino</span><span class="dial-code">+378</span></li><li class="country" data-dial-code="239" data-country-code="st"><div class="flag"><div class="iti-flag st"></div></div><span class="country-name">São Tomé and Príncipe (São Tomé e Príncipe)</span><span class="dial-code">+239</span></li><li class="country" data-dial-code="966" data-country-code="sa"><div class="flag"><div class="iti-flag sa"></div></div><span class="country-name">Saudi Arabia (&#8235;المملكة العربية السعودية&#8236;&lrm;)</span><span class="dial-code">+966</span></li><li class="country" data-dial-code="221" data-country-code="sn"><div class="flag"><div class="iti-flag sn"></div></div><span class="country-name">Senegal (Sénégal)</span><span class="dial-code">+221</span></li><li class="country" data-dial-code="381" data-country-code="rs"><div class="flag"><div class="iti-flag rs"></div></div><span class="country-name">Serbia (Србија)</span><span class="dial-code">+381</span></li><li class="country" data-dial-code="248" data-country-code="sc"><div class="flag"><div class="iti-flag sc"></div></div><span class="country-name">Seychelles</span><span class="dial-code">+248</span></li><li class="country" data-dial-code="232" data-country-code="sl"><div class="flag"><div class="iti-flag sl"></div></div><span class="country-name">Sierra Leone</span><span class="dial-code">+232</span></li><li class="country" data-dial-code="65" data-country-code="sg"><div class="flag"><div class="iti-flag sg"></div></div><span class="country-name">Singapore</span><span class="dial-code">+65</span></li><li class="country" data-dial-code="1721" data-country-code="sx"><div class="flag"><div class="iti-flag sx"></div></div><span class="country-name">Sint Maarten</span><span class="dial-code">+1721</span></li><li class="country" data-dial-code="421" data-country-code="sk"><div class="flag"><div class="iti-flag sk"></div></div><span class="country-name">Slovakia (Slovensko)</span><span class="dial-code">+421</span></li><li class="country" data-dial-code="386" data-country-code="si"><div class="flag"><div class="iti-flag si"></div></div><span class="country-name">Slovenia (Slovenija)</span><span class="dial-code">+386</span></li><li class="country" data-dial-code="677" data-country-code="sb"><div class="flag"><div class="iti-flag sb"></div></div><span class="country-name">Solomon Islands</span><span class="dial-code">+677</span></li><li class="country" data-dial-code="252" data-country-code="so"><div class="flag"><div class="iti-flag so"></div></div><span class="country-name">Somalia (Soomaaliya)</span><span class="dial-code">+252</span></li><li class="country" data-dial-code="27" data-country-code="za"><div class="flag"><div class="iti-flag za"></div></div><span class="country-name">South Africa</span><span class="dial-code">+27</span></li><li class="country" data-dial-code="82" data-country-code="kr"><div class="flag"><div class="iti-flag kr"></div></div><span class="country-name">South Korea (대한민국)</span><span class="dial-code">+82</span></li><li class="country" data-dial-code="211" data-country-code="ss"><div class="flag"><div class="iti-flag ss"></div></div><span class="country-name">South Sudan (&#8235;جنوب السودان&#8236;&lrm;)</span><span class="dial-code">+211</span></li><li class="country" data-dial-code="34" data-country-code="es"><div class="flag"><div class="iti-flag es"></div></div><span class="country-name">Spain (España)</span><span class="dial-code">+34</span></li><li class="country" data-dial-code="94" data-country-code="lk"><div class="flag"><div class="iti-flag lk"></div></div><span class="country-name">Sri Lanka (ශ්&zwj;රී ලංකාව)</span><span class="dial-code">+94</span></li><li class="country" data-dial-code="249" data-country-code="sd"><div class="flag"><div class="iti-flag sd"></div></div><span class="country-name">Sudan (&#8235;السودان&#8236;&lrm;)</span><span class="dial-code">+249</span></li><li class="country" data-dial-code="597" data-country-code="sr"><div class="flag"><div class="iti-flag sr"></div></div><span class="country-name">Suriname</span><span class="dial-code">+597</span></li><li class="country" data-dial-code="47" data-country-code="sj"><div class="flag"><div class="iti-flag sj"></div></div><span class="country-name">Svalbard and Jan Mayen</span><span class="dial-code">+47</span></li><li class="country" data-dial-code="268" data-country-code="sz"><div class="flag"><div class="iti-flag sz"></div></div><span class="country-name">Swaziland</span><span class="dial-code">+268</span></li><li class="country" data-dial-code="46" data-country-code="se"><div class="flag"><div class="iti-flag se"></div></div><span class="country-name">Sweden (Sverige)</span><span class="dial-code">+46</span></li><li class="country" data-dial-code="41" data-country-code="ch"><div class="flag"><div class="iti-flag ch"></div></div><span class="country-name">Switzerland (Schweiz)</span><span class="dial-code">+41</span></li><li class="country" data-dial-code="963" data-country-code="sy"><div class="flag"><div class="iti-flag sy"></div></div><span class="country-name">Syria (&#8235;سوريا&#8236;&lrm;)</span><span class="dial-code">+963</span></li><li class="country" data-dial-code="886" data-country-code="tw"><div class="flag"><div class="iti-flag tw"></div></div><span class="country-name">Taiwan (台灣)</span><span class="dial-code">+886</span></li><li class="country" data-dial-code="992" data-country-code="tj"><div class="flag"><div class="iti-flag tj"></div></div><span class="country-name">Tajikistan</span><span class="dial-code">+992</span></li><li class="country" data-dial-code="255" data-country-code="tz"><div class="flag"><div class="iti-flag tz"></div></div><span class="country-name">Tanzania</span><span class="dial-code">+255</span></li><li class="country" data-dial-code="66" data-country-code="th"><div class="flag"><div class="iti-flag th"></div></div><span class="country-name">Thailand (ไทย)</span><span class="dial-code">+66</span></li><li class="country" data-dial-code="670" data-country-code="tl"><div class="flag"><div class="iti-flag tl"></div></div><span class="country-name">Timor-Leste</span><span class="dial-code">+670</span></li><li class="country" data-dial-code="228" data-country-code="tg"><div class="flag"><div class="iti-flag tg"></div></div><span class="country-name">Togo</span><span class="dial-code">+228</span></li><li class="country" data-dial-code="690" data-country-code="tk"><div class="flag"><div class="iti-flag tk"></div></div><span class="country-name">Tokelau</span><span class="dial-code">+690</span></li><li class="country" data-dial-code="676" data-country-code="to"><div class="flag"><div class="iti-flag to"></div></div><span class="country-name">Tonga</span><span class="dial-code">+676</span></li><li class="country" data-dial-code="1868" data-country-code="tt"><div class="flag"><div class="iti-flag tt"></div></div><span class="country-name">Trinidad and Tobago</span><span class="dial-code">+1868</span></li><li class="country" data-dial-code="216" data-country-code="tn"><div class="flag"><div class="iti-flag tn"></div></div><span class="country-name">Tunisia (&#8235;تونس&#8236;&lrm;)</span><span class="dial-code">+216</span></li><li class="country" data-dial-code="90" data-country-code="tr"><div class="flag"><div class="iti-flag tr"></div></div><span class="country-name">Turkey (Türkiye)</span><span class="dial-code">+90</span></li><li class="country" data-dial-code="993" data-country-code="tm"><div class="flag"><div class="iti-flag tm"></div></div><span class="country-name">Turkmenistan</span><span class="dial-code">+993</span></li><li class="country" data-dial-code="1649" data-country-code="tc"><div class="flag"><div class="iti-flag tc"></div></div><span class="country-name">Turks and Caicos Islands</span><span class="dial-code">+1649</span></li><li class="country" data-dial-code="688" data-country-code="tv"><div class="flag"><div class="iti-flag tv"></div></div><span class="country-name">Tuvalu</span><span class="dial-code">+688</span></li><li class="country" data-dial-code="1340" data-country-code="vi"><div class="flag"><div class="iti-flag vi"></div></div><span class="country-name">U.S. Virgin Islands</span><span class="dial-code">+1340</span></li><li class="country" data-dial-code="256" data-country-code="ug"><div class="flag"><div class="iti-flag ug"></div></div><span class="country-name">Uganda</span><span class="dial-code">+256</span></li><li class="country" data-dial-code="380" data-country-code="ua"><div class="flag"><div class="iti-flag ua"></div></div><span class="country-name">Ukraine (Україна)</span><span class="dial-code">+380</span></li><li class="country" data-dial-code="971" data-country-code="ae"><div class="flag"><div class="iti-flag ae"></div></div><span class="country-name">United Arab Emirates (&#8235;الإمارات العربية المتحدة&#8236;&lrm;)</span><span class="dial-code">+971</span></li><li class="country" data-dial-code="44" data-country-code="gb"><div class="flag"><div class="iti-flag gb"></div></div><span class="country-name">United Kingdom</span><span class="dial-code">+44</span></li><li class="country" data-dial-code="1" data-country-code="us"><div class="flag"><div class="iti-flag us"></div></div><span class="country-name">United States</span><span class="dial-code">+1</span></li><li class="country" data-dial-code="598" data-country-code="uy"><div class="flag"><div class="iti-flag uy"></div></div><span class="country-name">Uruguay</span><span class="dial-code">+598</span></li><li class="country" data-dial-code="998" data-country-code="uz"><div class="flag"><div class="iti-flag uz"></div></div><span class="country-name">Uzbekistan (Oʻzbekiston)</span><span class="dial-code">+998</span></li><li class="country" data-dial-code="678" data-country-code="vu"><div class="flag"><div class="iti-flag vu"></div></div><span class="country-name">Vanuatu</span><span class="dial-code">+678</span></li><li class="country" data-dial-code="39" data-country-code="va"><div class="flag"><div class="iti-flag va"></div></div><span class="country-name">Vatican City (Città del Vaticano)</span><span class="dial-code">+39</span></li><li class="country" data-dial-code="58" data-country-code="ve"><div class="flag"><div class="iti-flag ve"></div></div><span class="country-name">Venezuela</span><span class="dial-code">+58</span></li><li class="country" data-dial-code="84" data-country-code="vn"><div class="flag"><div class="iti-flag vn"></div></div><span class="country-name">Vietnam (Việt Nam)</span><span class="dial-code">+84</span></li><li class="country" data-dial-code="681" data-country-code="wf"><div class="flag"><div class="iti-flag wf"></div></div><span class="country-name">Wallis and Futuna</span><span class="dial-code">+681</span></li><li class="country" data-dial-code="212" data-country-code="eh"><div class="flag"><div class="iti-flag eh"></div></div><span class="country-name">Western Sahara (&#8235;الصحراء الغربية&#8236;&lrm;)</span><span class="dial-code">+212</span></li><li class="country" data-dial-code="967" data-country-code="ye"><div class="flag"><div class="iti-flag ye"></div></div><span class="country-name">Yemen (&#8235;اليمن&#8236;&lrm;)</span><span class="dial-code">+967</span></li><li class="country" data-dial-code="260" data-country-code="zm"><div class="flag"><div class="iti-flag zm"></div></div><span class="country-name">Zambia</span><span class="dial-code">+260</span></li><li class="country" data-dial-code="263" data-country-code="zw"><div class="flag"><div class="iti-flag zw"></div></div><span class="country-name">Zimbabwe</span><span class="dial-code">+263</span></li><li class="country" data-dial-code="358" data-country-code="ax"><div class="flag"><div class="iti-flag ax"></div></div><span class="country-name">Åland Islands</span><span class="dial-code">+358</span></li></ul></div>

<input name="parent_phone" type="tel" value="<?php echo get_user_meta( $cu->ID, 'parent_phone', true ) ?>" id="parent_phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="parent_phone-error error" style="display:none;">Please Enter Phone number</span>
</div>
</div>
</div>
<div class="studentdetails">
<div class="tml-field-wrap tml-student_heading-wrap">Student Details</div>
<div class="tml-field-wrap tml-first_name-wrap"><span class="tml-label">First Name</span>
<input name="first_name" type="text" id="first_name" value="<?php echo get_user_meta( $cu->ID, 'first_name', true ) ?>" class="tml-field">
<span class="first_name-error error"  style="display:none;">Please Enter First Name</span> 
</div>
<div class="tml-field-wrap tml-last_name-wrap">
<span class="tml-label">Last Name</span>
<input name="last_name" type="text" value="<?php echo get_user_meta( $cu->ID, 'last_name', true ) ?>" id="last_name" class="tml-field">
<span class="last_name-error error" style="display:none;">Please Enter Last Name</span> 
</div>
<div class="tml-field-wrap tml-student_phone-wrap">
<label class="tml-label" for="student_phone">Phone</label>
<div class="intl-tel-input">

<input name="student_phone" type="tel" value="<?php echo  $cu->phone; ?>" id="student_phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="student_phone-error error" style="display:none;">Please Enter Phone number</span>
</div>
</div>
<div class="tml-field-wrap tml-timezone-wrap">
<label class="tml-label" for="timezone">Timezone</label>
<select name="timezone" id="timezone" class="tml-field">
<option value="NA" selected="selected">Select Timezone</option>
<option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
<option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
<option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
<option value="US/Alaska">(UTC-09:00) Alaska</option>
<option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
<option value="America/Tijuana">(UTC-08:00) Tijuana</option>
<option value="US/Arizona">(UTC-07:00) Arizona</option>
<option value="America/Chihuahua">(UTC-07:00) La Paz</option>
<option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
<option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
<option value="America/Managua">(UTC-06:00) Central America</option>
<option value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
<option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
<option value="America/Monterrey">(UTC-06:00) Monterrey</option>
<option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
<option value="America/Bogota">(UTC-05:00) Quito</option>
<option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
<option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
<option value="America/Lima">(UTC-05:00) Lima</option>
<option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
<option value="America/Caracas">(UTC-04:30) Caracas</option>
<option value="America/La_Paz">(UTC-04:00) La Paz</option>
<option value="America/Santiago">(UTC-04:00) Santiago</option>
<option value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
<option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
<option value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown</option>
<option value="America/Godthab">(UTC-03:00) Greenland</option>
<option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
<option value="Atlantic/Azores">(UTC-01:00) Azores</option>
<option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
<option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
<option value="Europe/London">(UTC+00:00) London</option>
<option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
<option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
<option value="UTC">(UTC+00:00) UTC</option>
<option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
<option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
<option value="Europe/Berlin">(UTC+01:00) Bern</option>
<option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
<option value="Europe/Brussels">(UTC+01:00) Brussels</option>
<option value="Europe/Budapest">(UTC+01:00) Budapest</option>
<option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
<option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
<option value="Europe/Madrid">(UTC+01:00) Madrid</option>
<option value="Europe/Paris">(UTC+01:00) Paris</option>
<option value="Europe/Prague">(UTC+01:00) Prague</option>
<option value="Europe/Rome">(UTC+01:00) Rome</option>
<option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
<option value="Europe/Skopje">(UTC+01:00) Skopje</option>
<option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
<option value="Europe/Vienna">(UTC+01:00) Vienna</option>
<option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
<option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
<option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
<option value="Europe/Athens">(UTC+02:00) Athens</option>
<option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
<option value="Africa/Cairo">(UTC+02:00) Cairo</option>
<option value="Africa/Harare">(UTC+02:00) Harare</option>
<option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
<option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
<option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
<option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
<option value="Europe/Riga">(UTC+02:00) Riga</option>
<option value="Europe/Sofia">(UTC+02:00) Sofia</option>
<option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
<option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
<option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
<option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
<option value="Europe/Minsk">(UTC+03:00) Minsk</option>
<option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
<option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
<option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
<option value="Asia/Tehran">(UTC+03:30) Tehran</option>
<option value="Asia/Muscat">(UTC+04:00) Muscat</option>
<option value="Asia/Baku">(UTC+04:00) Baku</option>
<option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
<option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
<option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
<option value="Asia/Kabul">(UTC+04:30) Kabul</option>
<option value="Asia/Karachi">(UTC+05:00) Karachi</option>
<option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
<option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
<option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
<option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
<option value="Asia/Almaty">(UTC+06:00) Almaty</option>
<option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
<option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
<option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
<option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
<option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
<option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
<option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
<option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
<option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
<option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
<option value="Australia/Perth">(UTC+08:00) Perth</option>
<option value="Asia/Singapore">(UTC+08:00) Singapore</option>
<option value="Asia/Taipei">(UTC+08:00) Taipei</option>
<option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
<option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
<option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
<option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
<option value="Asia/Seoul">(UTC+09:00) Seoul</option>
<option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
<option value="Australia/Darwin">(UTC+09:30) Darwin</option>
<option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
<option value="Australia/Canberra">(UTC+10:00) Canberra</option>
<option value="Pacific/Guam">(UTC+10:00) Guam</option>
<option value="Australia/Hobart">(UTC+10:00) Hobart</option>
<option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
<option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
<option value="Australia/Sydney">(UTC+10:00) Sydney</option>
<option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
<option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
<option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
<option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
<option value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
<option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
<option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
<option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
</select>
<span class="timezone-error error" style="display:none;">Please Select TimeZone</span> 
</div>
<div class="tml-field-wrap tml-user_email-wrap">
<label class="tml-label" for="user_email">Email</label>
<input name="user_email" type="email" value="<?php echo $cu->user_email ?>" id="user_email" class="tml-field">
<span class="user_email-error error" style="display:none;">Please Enter Email </span> 
</div>
<div class="tml-field-wrap tml-user_login-wrap">
<label class="tml-label" for="user_login">Username</label>
<input disabled name="user_login" type="text" value="<?php echo $cu->user_login ?>" id="user_login" autocapitalize="off" class="tml-field">
<span class="user_login-error error" style="display:none;">Please Enter User Name</span> 
</div>
<div class="tml-field-wrap tml-user_pass1-wrap">
<label class="tml-label" for="pass1">Password</label>
<input name="user_pass_u1" type="password" value="<?php echo $cu->user_email ?>" id="upass1" autocomplete="off" class="tml-field">
<span class="password-error error" style="display:none;">Please Enter Password</span> 
</div>
<div class="tml-field-wrap tml-user_pass2-wrap">
<label class="tml-label" for="pass2">Confirm Password</label>
<input name="user_pass_u2" type="password" value="<?php echo $cu->user_pass ?>" id="upass2" autocomplete="off" class="tml-field">
<span class="password2-error error" style="display:none;">Please Enter Confirm Password</span> 
</div>
</div>
</div>
<div class="tml-field-wrap tml-submit-wrap" >
<button disabled name="submit" type="button" id="registersubmit" style="margin-top: 17px;" class="tml-button">Update Profile</button>
</div>
</form>
<?php 
}
}

add_shortcode( 'bw_mycourses', 'my_course_page' );
function my_course_page(){
if ( is_user_logged_in() ) {

$cu = wp_get_current_user();
$cu_meta = get_user_meta( $cu->ID );

global $wpdb;
	?>
 <script>
        jQuery(document).ready(function( $ ) {
        	$(".course_list").click(function() {
        		$(".courselist").show();
        		$(".quizlist").hide();
        		$(".courses").removeClass('active');
        	});
        	$(".quiz_result").click(function() {
        		$(".courselist").hide();
        		$(".quizlist").show();
        		$(".quizzes").addClass('active');
        	});
        });
  </script>
  
 <a href="https://devlive.bitwise.academy/live-courses"><button style="padding: 4px 10px!important; float: right" type="button" class="btn btn-primary pull-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> ENROLL FOR TUTORING</button></a>
<ul class="nav nav-tabs" role="tablist">
<li class="courses active thim-profile-list-6">
<a href="javascript:void(0)" class="course_list" data-slug="">
<i class="fa fa-book"></i><span class="text">Courses</span> </a>
</li>

<li class="quizzes  thim-profile-list-6">
<a href="javascript:void(0)" class="quiz_result" data-slug="">
<i class="fa fa-check-square-o"></i><span class="text">Quiz Results</span> </a>
</li>

</ul>
<div class="courselist">

<div id="thim-course-archive" class="thim-course-grid" data-cookie="grid-layout">
	<?php
	
	if(in_array('subscriber', $cu->roles))
	{
		$customer_orders = get_posts(array(
	        'numberposts' => -1,
	        'meta_key' => '_customer_user',
	        'orderby' => 'date',
	        'order' => 'DESC',
	        'meta_value' => get_current_user_id(),
	        'post_type' => wc_get_order_types(),
	        'post_status' => array_keys(wc_get_order_statuses()), 'post_status' => array('wc-completed'),
	    ));

	    $Order_Array = []; //
	    $allcourses = [];
	    foreach ($customer_orders as $customer_order) {
	        $orderq = wc_get_order($customer_order);
	        $Order_Array[] = [
	            "ID" => $orderq->get_id(),
	            "Value" => $orderq->get_total(),
	            "Date" => $orderq->get_date_created()->date_i18n('Y-m-d'),
	        ];
	
	        $order = new WC_Order( $orderq->get_id() );
			$items = $order->get_items();
			$mappingtable= $wpdb->prefix.'course_mapping';
	
			foreach ( $items as $item ) {
	     		$product_name = $item['name'];
	     		$product_id = $item['product_id'];
	   			$ordercourses = $wpdb->get_results("SELECT course_id FROM $mappingtable WHERE `product_ids` LIKE '%$product_id%'"); 
	   			$allcourses[]= ($ordercourses[0]->course_id);
			}
	
	    }
	}
	else if(in_array('lp_teacher', $cu->roles))
	{
		$mappingtable= $wpdb->prefix.'course_mapping';
		$faculty_id=$wpdb->get_var( $wpdb->prepare("select id from ".$wpdb->prefix."bookme_employee where email=%s ",$cu->user_email) );
        $services=$wpdb->get_results($wpdb->prepare(" select name,product_id from ".$wpdb->prefix."bookme_service where staff=%d ",$faculty_id) );
		foreach($services as $item)
		{
			$product_id = $item->product_id;
			$ordercourses = $wpdb->get_results("SELECT course_id FROM $mappingtable WHERE `product_ids` LIKE '%$product_id%'"); 
	   		$allcourses[]= ($ordercourses[0]->course_id);
		}
	}

	foreach (array_unique($allcourses) as $key => $value){
		$args = array(
  			'p'         => $value, // ID of a page, post, or custom type
  			'post_type' => 'any'
		);
		$available_courses = new WP_Query($args);


foreach ( $available_courses->posts as $available_course ) {
?>	
<div id="post-<?php echo $available_course->ID; ?>" class="course-grid-4 lpr_course post-<?php echo $available_course->ID; ?> lp_course type-lp_course status-publish has-post-thumbnail hentry course_category-physics pmpro-has-access course"><div class="course-item">
<div class="course-thumbnail"><a class="thumb" href="<?php echo get_permalink($available_course->ID).'?enroll-course='.$available_course->ID.''; ?>" ><img style="height: 160px!important;" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($available_course->ID), 'medium' );;?>" width="400" height="250"></a><a class="course-readmore" href="<?php echo get_permalink($available_course->ID).'?enroll-course='.$available_course->ID.''; ?>">Get Started</a></div>
		<div class="thim-course-content">
			
<div class="course-author" itemscope="" itemtype="http://schema.org/Person">
	<img alt="" src="//www.gravatar.com/avatar/75ce00bc36cc865546ac155bacb1502b?s=40&amp;r=g&amp;d=mm" srcset="//www.gravatar.com/avatar/75ce00bc36cc865546ac155bacb1502b?s=40&amp;r=g&amp;d=mm 2x" class="avatar avatar-40 photo" height="40" width="40">	<div class="author-contain">
		<div class="value" itemprop="name">
					</div>
	</div>
</div>			<h2 class="course-title"><a href="<?php echo get_permalink($available_course->ID).'?enroll-course='.$available_course->ID; ?>" rel="bookmark"><?php echo $available_course->post_title;?></a></h2>		
<div class="course-meta">
				
<div class="course-author" itemscope="" itemtype="http://schema.org/Person">
	<img alt="" src="//www.gravatar.com/avatar/75ce00bc36cc865546ac155bacb1502b?s=40&amp;r=g&amp;d=mm" srcset="//www.gravatar.com/avatar/75ce00bc36cc865546ac155bacb1502b?s=40&amp;r=g&amp;d=mm 2x" class="avatar avatar-40 photo" height="40" width="40">	<div class="author-contain">
		
	</div>
</div>
<div class="course-review"></div>
<div class="course-students"></div>
</div>
<div class="course-description"></div>
			<div class="course-readmore">
				<a href="<?php echo get_permalink($available_course->ID).'?enroll-course='.$available_course->ID.''; ?>">Get Started</a>
			</div>
		</div>
	</div>
</div>
<?php		
	}
	} ?>
	</div>
</div>
<div class="quizlist" style="display:none;">
<?php
$h5presultstable= $wpdb->prefix.'h5p_results';
$h5pcontenttable= $wpdb->prefix.'h5p_contents';
$h5presults = $wpdb->get_results("SELECT * FROM $h5presultstable  where user_id='$cu->ID'"); ?>
<table class="lp-list-table profile-list-h5p profile-list-table">
<thead>
<tr>
<th class="column-h5p">Name</th>
<th class="column-padding-grade">Passing Grade</th>
<th class="column-mark">Score</th>
</tr>
</thead>
<tbody>
<?php
foreach($h5presults as $hresults){
$h5pcontent = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $h5pcontenttable  where id='$hresults->content_id'" ) ); ?>
<tr>
<td class="column-h5p">
<?php echo $h5pcontent[0]->title;?>
</td>
<td class="column-padding-grade">
<?php echo $hresults->max_score;?></td>
<td class="column-status">
<?php echo $hresults->score;?> </td>
</tr>
<?php 	
}
?>
</tbody>
<tfoot>
</tfoot>
</table>
</div>
	<?php
}
}
add_shortcode( 'bw_login', 'my_login_page' );
function my_login_page(){
/*
Template Name: Login
*/
?>
<h2 style="text-align: center; color: #2ec4b6; font-size: 24px; font-weight: bold;">Parent / Instructor Login</h2>
<div class="tml tml-login">
<div class="tml-alerts"></div><form name="login" action="https://devlive.bitwise.academy/login/" method="post" data-ajax="1">
<div class="tml-field-wrap tml-log-wrap">
<label class="tml-label" for="user_login">User ID</label>
<input name="log" type="text" required value="" id="user_login" autocapitalize="off" class="tml-field">
</div>

<div class="tml-field-wrap tml-pwd-wrap">
<label class="tml-label" for="user_pass">Password</label>
<input name="pwd" required type="password" value="" id="user_pass" class="tml-field">
</div>
			<style type="text/css" media="screen">
				.login-action-login #loginform,
				.login-action-lostpassword #lostpasswordform,
				.login-action-register #registerform {
					width: 302px !important;
				}
				#login_error,
				.message {
					width: 322px !important;
				}
				.login-action-login #loginform .gglcptch,
				.login-action-lostpassword #lostpasswordform .gglcptch,
				.login-action-register #registerform .gglcptch {
					margin-bottom: 10px;
				}
			</style>
	
<div class="tml-field-wrap tml-rememberme-wrap">
<input name="rememberme" type="checkbox" value="forever" id="rememberme" class="tml-checkbox">
<label class="tml-label" for="rememberme">Remember Me</label>
</div>
<div class="tml-field-wrap tml-submit-wrap">
<button name="submit" type="submit" class="tml-button">Log In</button>
</div>
<input name="redirect_to" type="hidden" value="https://devlive.bitwise.academy">
<input name="testcookie" type="hidden" value="1">
</form>
<ul class="tml-links"><li class="tml-register-link"><a href="https://devlive.bitwise.academy/register/">Register</a></li><li class="tml-lostpassword-link"><a href="https://devlive.bitwise.academy/lostpassword/">Forgot your password?</a></li></ul></div>
	<?php
}

