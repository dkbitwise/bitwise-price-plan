<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bitwiseacademy.com/
 * @since      1.0.0
 *
 * @package    Bitwise_Price_Plan
 * @subpackage Bitwise_Price_Plan/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bitwise_Price_Plan
 * @subpackage Bitwise_Price_Plan/public
 * @author     Bitwise <dev.bitwise@gmail.com>
 */
class Bitwise_Price_Plan_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bitwise_Price_Plan_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bitwise_Price_Plan_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bitwise-price-plan-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'inltel', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/css/intlTelInput.css', array() );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'inltel_js', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/6.4.1/js/intlTelInput.min.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( 'bitwise_custom_validate_public_js', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js', array( 'jquery' ), '1.0.0', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bitwise-price-plan-public.js', array( 'jquery' ), $this->version, false );
	}

	public function live_parent_register() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/bitwise-price-plan-public-display.php';
	}

	public function live_parent_profile() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/bitwise-price-plan-public-display-profile.php';
	}

	public function live_parent_password() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/bitwise-price-plan-public-display-password.php';
	}

	public function live_parent_addstudent() {
		require_once plugin_dir_path( __FILE__ ) . 'partials/bitwise-price-plan-public-display-addstudent.php';
	}

	public function username_check() {
		$username = $_POST['username'];
		if ( username_exists( $username ) ) {
			echo "1";
		} else {
			echo "2";
		}
		die();
	}

	public function useremail_check() {
		$useremail = $_POST['useremail'];
		if ( email_exists( $useremail ) ) {
			echo "1";
		} else {
			global $wpdb;
			$table   = $wpdb->prefix . 'bwlive_students';
			$sql     = "SELECT student_email FROM $table where student_email='" . $useremail . "'";
			$results = $wpdb->get_results( $sql );
			if ( count( $results ) >= 1 ) {
				echo "1";
			} else {
				echo "2";
			}
		}
		die();
	}

	public function live_toolbar() { ?>
        <span style="margin-top: 6px;" class="mail">Have questions?&nbsp;:&nbsp; <span class="fa fa-envelope"></span>&nbsp;
            <a href="mailto:live@bitwise.academy">live@bitwise.academy</a>
        </span>
		<?php
		if ( is_user_logged_in() ) { ?>
            <!--<span><a href="<?php echo wp_logout_url( home_url() ); ?>"><span  class="btn btn-default sp-btn pull-right ml">Logout</span></a>-->
		<?php } else { ?>
            <span><a href="<?php echo site_url(); ?>/login/"><span class="btn btn-default sp-btn pull-right ml">Login</span></a>
  <a href="<?php echo site_url(); ?>/register/"><span class="btn btn-default sp-btn pull-right ml">Register</span></a></span>
		<?php }
		?>
        <span class="pull-right newsocial">
  <a href="https://www.facebook.com/bitwiseacademy/" target="_blank" class="fa fa-facebook"></a>

<a href="https://twitter.com/bitwiseacademy" target="_blank" class="fa fa-twitter"></a>
<a href="https://www.linkedin.com/company/bitwise-academy/" target="_blank" class="fa fa-linkedin"></a>
    <a href="https://www.youtube.com/channel/UCO33cGZ6t2AlhRZOXljRd5w" target="_blank" class="fa fa-youtube-play red"></a>
<a href="https://www.pinterest.com/bitwiseacademy/" target="_blank" class="fa fa-pinterest"></a>
<?php if ( is_user_logged_in() ) { ?>
    <ul style="background: #353866!important; border: 2px solid #353866; margin-left: 1.5em;" class="nav navbar-nav navbar-right">

	<?php echo do_shortcode( "[woo_cart_but]" ); ?>

    <li class="dropdown menu-item-has-children">
  <a style="padding: 0px 0px 2px 10px!important; color: #fff!important;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i></a>
  <ul style="left: -35px!important; padding: 0px 10px!important;" class="dropdown-menu sub-menu">
  	<?php
    $usr = wp_get_current_user();
    if ( in_array( 'subscriber', (array) $usr->roles ) ) {
	    ?>
        <!--<li><a href="/profile/">My Profile</a></li>-->
        <li><a href="/student-details/">Student Details</a></li>
        <li><a href="/my-account/">My Account</a></li>
        <li><a href="/my-courses/">My Courses</a></li>
	    <?php
    }
    ?>
    <li><a href="<?php echo wp_logout_url( home_url() ); ?><?php echo wp_logout_url( home_url() ); ?><?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
  </ul>
</li>
        <li class="fepm-message-box">
            <a class="messagebox-link" href="<?php echo esc_url( site_url() ) ?>/chat/?fepaction=messagebox"><i class="fa fa-bell"></i></a>
        </li>
    </ul>
	<?php
}
?>
</span>
		<?php
	}
}
