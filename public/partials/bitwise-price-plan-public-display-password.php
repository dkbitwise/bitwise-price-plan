<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://bitwiseacademy.com/
 * @since      1.0.0
 *
 * @package    Bitwise_Price_Plan
 * @subpackage Bitwise_Price_Plan/public/partials
 */
if ( is_user_logged_in() ) {

$cu = wp_get_current_user();
$cu_meta = get_user_meta( $cu->ID );

if(isset($_POST['changepass']))
{

	$user = wp_get_current_user();
	$pass = $_POST['current_pass'];
	$new_pass = $_POST['new_pass'];
	if ( $user && wp_check_password( $pass, $user->user_pass, $user->ID ) && isset($new_pass) ) {
		wp_update_user(array('ID' => $user->ID, 'user_pass' => ''.$new_pass.''));
	?>
	<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Success!</strong> You have changed your password successfully!
	</div>
	<?php
	}	
	else
	{
	?>
	<div class="alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Failed!</strong> Your password change failed!
	</div>
	<?php
	}
	
}

?>
<div style="width: 100%!important" class="tml tml-register">
<form id="passupdate_bw" name="passupdate_bw" action="#" method="post">
<div class="col-md-4">
	<span class="tml-label">Current Password</span>
	<input required class="tml-field" type="text" name="current_pass" id="current_pass">
</div>
<div class="col-md-4">
	<span class="tml-label">New Password</span>
	<input required class="tml-field" type="text" name="new_pass" id="new_pass">
</div>
<div class="col-md-4">
<span class="tml-label">&nbsp;</span>
<input type="submit" name="changepass" id="changepass" value="Update Password" class="btn btn-success btn-block">
</div>
</form>
<?php

}

?>