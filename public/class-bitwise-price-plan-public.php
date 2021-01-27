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
		wp_register_script( $this->plugin_name.'_public', plugin_dir_url( __FILE__ ) . 'js/bitwise-price-plan-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name.'_public', "bitpp_data", array('ajaxurl'=>admin_url('admin-ajax.php')) );
		wp_enqueue_script( $this->plugin_name.'_public' );
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

	public function bw_course_page() {
		global $wpdb;

		$mathids           = array( '19096', '19104', '19098', '19100', '19102' );
		$argsnew           = array(
			'post_status'     => 'publish',
			'post_type'       => 'lp_course',
			'course_category' => 'Math',
			'posts_per_page'  => '-1',
			'post__in'        => $mathids, //pass our own post ids to display updated by suresh
			'orderby'         => 'post__in',
		);
		$available_courses = new WP_Query( $argsnew ); //Get all the available courses in our Learnpress ?>
		<h2 class="bitlive-subject-heads">
		    <div class="title float-left"><span>Math</span></div>
		<?php

		/*** Getting all students of current loggin in parent  ***/
		$bwlive_students            = $wpdb->prefix . 'bwlive_students';
		$current_user = wp_get_current_user();
		$user_roles   = $current_user->roles;
		$student_id = 0;
		if ( in_array( 'subscriber', $user_roles, true ) ) {
		    $parent_id = $current_user->ID;
			$student_details = $wpdb->get_results( "SELECT `student_fname`, `student_lname`, `student_id` FROM $bwlive_students WHERE `parent_id`='$parent_id'", ARRAY_A ); ?>
			<div class="bitliive-student-select float-right">
                <label class="select-label">Select Student</label>
                <select id="bitlive_student_select">
                    <?php
                    if (count($student_details) > 0){
                        $count = 0;
                        foreach ($student_details as $student_detail){
                            if ($count < 1){
                                $student_id = $student_detail['student_id'];
                            }
                            $count++;
                            ?>
                            <option value="<?php echo $student_detail['student_id']?>"><?php echo $student_detail['student_fname'].' '.$student_detail['student_lname'] ?></option>
                       <?php }
                    }else{ ?>
                        <option value="0">-No Student-</option>
                    <?php }
                    ?>
                </select>
            </div>
			<?php
		}
		$allcourses = $this->bitlive_get_all_lp_courses($student_id);

		?>
		</h2>
        <div id="thim-course-archive" class="thim-course-grid" data-cookie="grid-layout">
        <?php
		foreach ( $available_courses->posts as $available_course ) { ?>
            <div id="post-<?php echo $available_course->ID; ?>" class="course-grid-4 lpr_course post-<?php echo $available_course->ID; ?> lp_course type-lp_course status-publish has-post-thumbnail hentry course_category-physics pmpro-has-access course">
                <div class="course-item" style="330px;">
                    <div class="course-thumbnail">
                        <a class="thumb" href="<?php echo get_permalink( $available_course->ID ); ?>">
                            <img style="height: 160px!important;" src="<?php echo get_the_post_thumbnail_url( $available_course->ID, 'medium_large' ); ?>" alt="" title="" width="400" height="250">
                        </a>
                        <a class="course-readmore" href="<?php echo get_permalink( $available_course->ID ); ?>">Read More</a>
                    </div>
                    <div class="thim-course-content">
                        <h2 class="course-title"><a href="<?php echo get_permalink( $available_course->ID ); ?>" rel="bookmark"><?php echo $available_course->post_title; ?></a></h2>
                        <div class="course-meta">

							<?php if ( ! in_array( $available_course->ID, $allcourses ) || ! is_user_logged_in() ) { ?>
                                <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">ENROLL NOW</a>
                                </div>
							<?php } else { ?>
                                <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <a href="<?php echo get_permalink( $available_course->ID ) . '?enroll-course=' . $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">GET STARTED</a>
                                </div>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php }

		echo '</div>';

		$phyids = array( '19113', '19115', '19117', '19119' );

		$argsnew           = array(
			'post_status'     => 'publish',
			'post_type'       => 'lp_course',
			'course_category' => 'Physics',
			'posts_per_page'  => '-1',
			'post__in'        => $phyids, //pass our own post ids to display updated by suresh
			'orderby'         => 'date',
		);
		$available_courses = new WP_Query( $argsnew ); //Get all the available courses in our Learnpress

		echo $output = '<h2 style=" text-align: center; font-size: 29px;font-weight: bold;text-transform: uppercase;">Physics</h2><div id="thim-course-archive" class="thim-course-grid" data-cookie="grid-layout">';
		foreach ( $available_courses->posts as $available_course ) { ?>

            <div id="post-<?php echo $available_course->ID; ?>" class="course-grid-4 lpr_course post-<?php echo $available_course->ID; ?> lp_course type-lp_course status-publish has-post-thumbnail hentry course_category-physics pmpro-has-access course">
                <div class="course-item" style="330px;">
                    <div class="course-thumbnail">
                        <a class="thumb" href="<?php echo get_permalink( $available_course->ID ); ?>"><img style="height: 160px!important;" src="<?php echo get_the_post_thumbnail_url( $available_course->ID, 'medium_large' ); ?>" alt="" title="" width="400" height="250"></a>
                        <a class="course-readmore" href="<?php echo get_permalink( $available_course->ID ); ?>">Read More</a>
                    </div>
                    <div class="thim-course-content">
                        <h2 class="course-title"><a href="<?php echo get_permalink( $available_course->ID ); ?>" rel="bookmark"><?php echo $available_course->post_title; ?></a></h2>
                        <div class="course-meta">
							<?php if ( ! in_array( $available_course->ID, $allcourses ) || ! is_user_logged_in() ) { ?>
                                <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">ENROLL NOW</a>
                                </div>
							<?php } else { ?>
                                <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">Get Started</a>
                                </div>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
		echo '</div>';
		$chmids = array( '19107', '19109', '19111' );

		$argsnew           = array(
			'post_status'     => 'publish',
			'post_type'       => 'lp_course',
			'course_category' => 'Chemistry',
			'post__in'        => $chmids, //pass our own post ids to display updated by suresh
			'orderby'         => 'date',
			'posts_per_page'  => '-1'
		);
		$available_courses = new WP_Query( $argsnew ); //Get all the available courses in our Learnpress
		echo $output = '<h2 style=" text-align: center; font-size: 29px;font-weight: bold;text-transform: uppercase;">Chemistry</h2><div id="thim-course-archive" class="thim-course-grid" data-cookie="grid-layout">';
		foreach ( $available_courses->posts as $available_course ) { ?>

            <div id="post-<?php echo $available_course->ID; ?>" class="course-grid-4 lpr_course post-<?php echo $available_course->ID; ?> lp_course type-lp_course status-publish has-post-thumbnail hentry course_category-physics pmpro-has-access course">
                <div class="course-item" style="330px;">
                    <div class="course-thumbnail">
                        <a class="thumb" href="<?php echo get_permalink( $available_course->ID ); ?>"><img style="height: 160px!important;" src="<?php echo get_the_post_thumbnail_url( $available_course->ID, 'medium_large' ); ?>" alt="" title="" width="400" height="250"></a>
                        <a class="course-readmore" href="<?php echo get_permalink( $available_course->ID ); ?>">Read More</a>
                    </div>
                    <div class="thim-course-content">
                        <h2 class="course-title"><a href="<?php echo get_permalink( $available_course->ID ); ?>" rel="bookmark"><?php echo $available_course->post_title; ?></a></h2>
                        <div class="course-meta">
							<?php if ( ! in_array( $available_course->ID, $allcourses ) || ! is_user_logged_in() ) { ?>
                                <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">ENROLL NOW</a>
                                </div>
							<?php } else { ?>
                                <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                    <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">Get Started</a>
                                </div>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php }
		echo '</div>';
		$bioids            = array( '19092', '19094' );
		$argsnew           = array(
			'post_status'     => 'publish',
			'post_type'       => 'lp_course',
			'course_category' => 'Biology',

			'post__in'       => $bioids, //pass our own post ids to display updated by suresh
			'orderby'        => 'date',
			'posts_per_page' => '-1'
		);
		$available_courses = new WP_Query( $argsnew ); //Get all the available courses in our Learnpress
		echo $output = '<h2 style=" text-align: center; font-size: 29px;font-weight: bold;text-transform: uppercase;">Biology</h2><div id="thim-course-archive" class="thim-course-grid" data-cookie="grid-layout">';
		foreach ( $available_courses->posts as $available_course ) { ?>
            <div id="post-<?php echo $available_course->ID; ?>" class="course-grid-4 lpr_course post-<?php echo $available_course->ID; ?> lp_course type-lp_course status-publish has-post-thumbnail hentry course_category-physics pmpro-has-access course">
                <div class="course-item" style="330px;">
                    <div class="course-thumbnail">
                        <a class="thumb" href="<?php echo get_permalink( $available_course->ID ); ?>"><img style="height: 160px!important;" src="<?php echo get_the_post_thumbnail_url( $available_course->ID, 'medium_large' ); ?>" alt="" title="" width="400" height="250"></a>
                        <a class="course-readmore" href="<?php echo get_permalink( $available_course->ID ); ?>">Read More</a>
                    </div>
                    <div class="thim-course-content">
                        <h2 class="course-title"><a href="<?php echo get_permalink( $available_course->ID ); ?>" rel="bookmark"><?php echo $available_course->post_title; ?></a></h2>
                        <div class="course-meta">
							<?php if ( isset( $allcourses ) ) {
								if ( ! in_array( $available_course->ID, $allcourses ) || ! is_user_logged_in() ) { ?>
                                    <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                        <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">ENROLL NOW</a>
                                    </div>
								<?php } else { ?>
                                    <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                        <a href="<?php echo site_url(); ?>/choose-package/?courseid=<?php echo $available_course->ID; ?>" class="btn btn-md btn-default sp-btn pull-right ml">Get Started</a>
                                    </div>
								<?php }
							} ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php }
		echo '</div>';
	}

	/**
     * Handle ajax request for course puachase status
    */
    public function bookme_course_purchase_status(){
        global $wpdb;
        $posted_data = isset($_POST)?wc_clean($_POST):[];
        $student_id = $posted_data['student_id'];

        $student_courses = $this->bitlive_get_all_lp_courses($student_id);

        wp_send_json($student_courses);
    }

    /**
    * @param $student_id
     *
     * @return array
     */
    public function bitlive_get_all_lp_courses($student_id){
        global $wpdb;
        $allcourses  = [];

        $customer_orders = $this->bitlive_get_all_customer_orders();

		foreach ( $customer_orders as $customer_order ) {
			$orderq        = wc_get_order( $customer_order );

			$order        = new WC_Order( $orderq->get_id() );
			$items        = $order->get_items();
			$mappingtable = $wpdb->prefix . 'course_mapping';

			foreach ( $items as $item ) {
			    $bookme_data = isset($item['bookme'])?$item['bookme']:[];
				$order_student_id = isset($bookme_data['student'])?$bookme_data['student']:0;
				if ($order_student_id !== $student_id){
				    continue;
				}

				$product_id   = $item['product_id'];
				$ordercourses = $wpdb->get_results( "SELECT course_id FROM $mappingtable WHERE `product_ids` LIKE '%$product_id%'" );
				$allcourses[] = $ordercourses[0]->course_id;
			}
		}

		return $allcourses;
    }

    public function bitlive_get_all_customer_orders(){
        return get_posts( array(
			'numberposts' => - 1,
			'meta_key'    => '_customer_user',
			'orderby'     => 'date',
			'order'       => 'DESC',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types(),
			'post_status' => array_keys( wc_get_is_paid_statuses() ),
		) );
    }
}
