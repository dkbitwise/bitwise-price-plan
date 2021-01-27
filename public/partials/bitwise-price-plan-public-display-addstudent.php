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

global $wpdb;
$table = $wpdb->prefix . 'bwlive_students';
$sql = "SELECT student_fname,student_lname,student_mobile,student_email,student_slot FROM $table where parent_id=".get_current_user_id();
$results = $wpdb->get_results($sql);
$tot = count($results);

$stu_fname = $results[0]->student_fname;
$stu_lname = $results[0]->student_lname;
$stu_mob = $results[0]->student_mobile;
$stu_email = $results[0]->student_email;
$stu_slot = $results[0]->student_slot;

$key = 'country_code';
$single = true;
$co_code = get_user_meta( $cu->ID, $key, $single ); 

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div style="width: 100%!important" class="tml tml-register">

<?php
if($tot == 1)
{
	$rm = 1;
	$clr = "green";
}
else
{
	$rm = 0;
	$clr = "red";
}
?>
<div class="col-md-12">
	
<?php

if(isset($_POST['adtype']))
{

	global $wpdb;
	$student_table = $wpdb->prefix.'bwlive_students';
	$sql_stu = "SELECT student_fname,student_slot FROM $student_table where parent_id=".get_current_user_id();
	$results_stu = $wpdb->get_results($sql_stu);
	
	$tot_stu = count($results_stu);
	
	if($tot_stu < 2)
	{
		$user_id = get_current_user_id();
		$stud_id = $user_id."_2";
		$ins = $wpdb->insert($student_table, array(
	    	'parent_id' => $user_id,
	    	'student_id' => $stud_id,
	    	'student_fname' => $_POST['ad_first_name'],
			'student_lname' => $_POST['ad_last_name'],
	    	'student_mobile' => $_POST['ad_phone'],
			'student_email' => $_POST['ad_user_email'],
			'student_slot' => $results_stu[0]->student_slot
		));
		
		if($ins)
		{
			?>
			
			<script>
				window.setTimeout(function() {
				    $(".alert").fadeTo(500, 0).slideUp(500, function(){
				        $(this).remove(); 
				    });
				    window.location.href="<?php echo site_url('student-details') ?>";
				}, 4000);
			</script>
			<div style="background: #39c5b5; color: #fff; font-size: 16px" class="alert alert-success" role="alert">
			  <strong>Success!</strong> You have been signed in successfully!
			</div>
			
			<?php				
		}
		
	}

}

?>
<!--<p style="font-weight: bold; margin-bottom: 10px"><i class="fa fa-user-plus" aria-hidden="true"></i> Remaining students registration : <span style="color: <?php echo $clr ?>"><?php echo $rm; ?></span></p>-->
</div>
<div class="registerdetails">

<?php

$ik = 1;
foreach($results as $st)
{
?>
<div class="col-md-6">
	<div class="panel panel-primary">
	<div style="margin-top: 0px!important" class="tml-field-wrap tml-student_heading-wrap">Student <?php echo $ik ?> Details</div>
      <div style="border: 2px solid #39c5b5; border-radius: 25px; padding: 2%" class="panel-body">
      	
      	<table id="stu-tbl">
      		<tr>
      			<td><b>Student Name</b></td>
      			<td><b>:</b> <?php echo $st->student_fname ?> <?php echo $st->student_lname ?></td>
      		</tr>
      		<tr>
      			<td><b>Student Email</b></td>
      			<td><b>:</b> <?php echo $st->student_email ?></td>
      		</tr>
      		<tr>
      			<td><b>Student Phone</b</td>
      			<td><b>:</b> <?php $output = substr($st->student_mobile, -10, -7) . "-" . substr($st->student_mobile, -7, -4) . "-" . substr($st->student_mobile, -4); echo $output; ?></td>
      		</tr>
      		<tr>
      			<td><b>Student Timezone</b</td>
      			<td><b>:</b> <?php echo $st->student_slot ?></td>
      		</tr>
      	</table>
      	
      </div>
    </div>
</div>
<?php
$ik++;
}
?>

<?php
if($rm == 1)
{
?>
<div class="col-md-6">

<form id="addstudent" name="addstudent" action="#" method="post">
<div style="padding-top: 0px!important" class="studentdetails">
<div style="margin-top: 0px!important" class="tml-field-wrap tml-student_heading-wrap">New Student Details</div>
</div>

<div class="tml-field-wrap tml-ad_first_name-wrap"><span class="tml-label">First Name</span>
<input name="ad_first_name" type="text" id="ad_first_name" value="" class="tml-field">
<span class="ad_first_name-error error"  style="display:none;">Please Enter First Name</span> 
</div>

<div class="tml-field-wrap tml-ad_last_name-wrap">
<span class="tml-label">Last Name</span>
<input name="ad_last_name" type="text" value="" id="ad_last_name" class="tml-field">
<span class="ad_last_name-error error" style="display:none;">Please Enter Last Name</span> 
</div>

<div class="tml-field-wrap tml-ad_user_email-wrap">
<label class="tml-label" for="ad_user_email">Email</label>
<input name="ad_user_email" type="email" value="" id="ad_user_email" class="tml-field">
<span class="ad_user_email-error error" style="display:none;">Please Enter Email </span> 
</div>

<div class="tml-field-wrap tml-ad_phone-wrap">
<label class="tml-label" for="ad_phone">Phone</label>
<div class="intl-tel-input">
<input name="ad_phone" type="tel" value="" id="ad_phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="ad_phone-error error" style="display:none;">Please Enter Phone number</span>
</div>
</div>

<div class="tml-field-wrap tml-submit-wrap" >
<input type="hidden" name="adtype" id="adtype" value="parent_update">
<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $cu->ID ?>">
<button id="addstu" name="addstu" value="Register" style="margin-top: 13px;" class="tml-button">Add Student</button>
</div>

</form>
</div>

<?php
}
?>

</div>
</div>
<?php
    global $post;
    $post_slug = $post->post_name;

if( $post_slug == 'student-details' ){
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>

function validateEmail_stu($email) {
	
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
    
}

function allowedEmaildomain_stu($email) {
	
	var eml = $email;
	var ed = eml.split('@');
	
	if(ed[1])
	{
		var em = ed[1].split('.').slice(1);
		if(!em)
		{
			return 0;
		}
		else if(em == 'com' || em == 'net' || em == 'edu')
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	else
	{
		return 0;
	}
}

function validatePhone_stu($phone) {
    
    var a = $phone;
    var filter = /^\d{10}$/;
    //var filter = /^(\+91-|\+91|0)?\d{10}$/;
    if (filter.test(a)) {
        return 1;
    } else {
        return 0;
    }
    
}

$(document).ready(function() {

	var ad_phone = $("#ad_phone");
    ad_phone.intlTelInput({
	    nationalMode: true,
        utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
	    allowDropdown: true,
	    onlyCountries: ["us"],
        preferredCountries: ["us"]
	});

	$("#ad_first_name").on('keyup keydown change', function() {
	
	    if (!$('#ad_first_name').val()) {
	    	$("#addstu").prop("disabled", true);
	        $(".ad_first_name-error").css('display', 'block');
	        $("#ad_first_name").focus();
	    } else {
	    	$("#addstu").prop("disabled", false);
	        $(".ad_first_name-error").hide();
	    }
	
	});

	$("#ad_last_name").on('keyup keydown change', function() {
	
	    if (!$('#ad_last_name').val()) {
	    	$("#addstu").prop("disabled", true);
	        $(".ad_last_name-error").css('display', 'block');
	        $("#ad_last_name").focus();
	    } else {
	    	$("#addstu").prop("disabled", false);
	        $(".ad_last_name-error").hide();
	    }
	
	});
	
	
	$("#ad_user_email").on('keyup keydown', function() {
	
		if (!$('#ad_user_email').val()) {
	    	$("#addstu").prop("disabled", true);
	        $(".ad_user_email-error").css('display', 'block');
	        $("#ad_user_email").focus();
	    } else if (!validateEmail_stu($('#ad_user_email').val())) {
	    	$("#addstu").prop("disabled", true);
	        $(".ad_user_email-error").text('Enter valid Email address');
	        $(".ad_user_email-error").css('display', 'block');
	        $("#ad_user_email").focus();
	    } else {
	    	$("#addstu").prop("disabled", false);
	    	$(".ad_user_email-error").hide();
	    }

	});
	
	$('#ad_phone').on('keyup change', function() {
	
		var pa_phone= $('#ad_phone').val();
		var pa_ph = pa_phone.match(/\d/g);
		if(pa_ph != null)
		{
			pa_ph = pa_ph.join("");
		}
	
		$('#ad_phone').val(pa_ph);
	    if (!$('#ad_phone').val()) {
	        $(".ad_phone-error").css('display', 'block');
	        $("#ad_phone").focus();
	        $("#addstu").prop("disabled", true);
	    } else if (!validatePhone_stu($('#ad_phone').val())) {
	        $(".ad_phone-error-msg").text('Please enter valid mobile number');
	        $(".ad_phone-error-msg").css('display', 'block');
	        $("#ad_phone").focus();
	        $("#addstu").prop("disabled", true);
	    } else {
	        $(".ad_phone-error-msg").css('display', 'none');
	        $("#addstu").prop("disabled", false);
	    }

	});

	ad_phone.keyup(function() {
	    if( $(".ad_phone_msg").length ==0 ){
	        $('.tml-label[for="ad_phone"]').append(' <span class="ad_phone_msg"></span>')
	    }
	    if ($.trim(ad_phone.val())) {
	        if (ad_phone.intlTelInput("isValidNumber")) {
		    	$("#addstu").prop("disabled", false);
	            var getCode = ad_phone.intlTelInput('getSelectedCountryData').dialCode;
	            $(".ad_phone_msg").html('✓ Valid');
	            $(".ad_phone_msg").removeClass('error').addClass('success');
	    		$(".ad_phone-error").css('display', 'none');
	            $("#ad_phone_code").val(getCode);
	        } else {
		    	$("#addstu").prop("disabled", true);
	            var getCode = ad_phone.intlTelInput('getSelectedCountryData').dialCode;
	            $(".ad_phone_msg").html('Invalid');
	            $(".ad_phone_msg").removeClass('success').addClass('error');
	    		$(".ad_phone-error").css('display', 'block');
	            $("#ad_phone_code").val('');
	        }
	    }
	});
	
	$('#addstu').click(function() {
	
		var error = 0;
		
		if (!$('#ad_first_name').val()) {
	        $(".ad_first_name-error").css('display', 'block');
	        $("#ad_first_name").focus();
	        error = 1;
	    } else {
	        $(".ad_first_name-error").hide();
	    }
	
	    if (!$('#ad_last_name').val()) {
	        $(".ad_last_name-error").css('display', 'block');
	        $("#ad_last_name").focus();
	        error = 1;
	    } else {
	        $(".ad_last_name-error").hide();
	    }
	    
	    if (!$('#ad_phone').val()) {
	        $(".ad_phone-error").css('display', 'block');
	        $("#ad_phone").focus();
	        error = 1;
	    } else if (!validatePhone($('#ad_phone').val())) {
	        $(".ad_phone-error").text('Please enter valid mobile number');
	        $(".ad_phone-error").css('display', 'block');
	        $("#ad_phone").focus();
	        error = 1;
	    } else {
	        $(".ad_phone-error").hide();
	    }

	    if (!$('#ad_user_email').val()) {
	        $(".ad_user_email-error").css('display', 'block');
	        $("#ad_user_email").focus();
	        error = 1;
	    } else if (!validateEmail_stu($('#ad_user_email').val())) {
	        $(".ad_user_email-error").text('Enter valid Email address');
	        $("#ad_user_email").focus();
	        $(".ad_user_email-error").css('display', 'block');
	        error = 1;
	    } else {
	        if(allowedEmaildomain_stu($('#ad_user_email').val()))
	        {
	            $(".ad_user_email-error").hide();
	        }
	        else
	        {
	            $(".ad_user_email-error").text('Please use a general email address with domain ending in .com, .net. or .edu');
	            $("#ad_user_email").focus();
	            $(".ad_user_email-error").css('display', 'block');
	            error = 1;
	        }
	    }    

	
	    if (error == 0) {
	        $('#addstu').submit();
	    } else {
	        return false;
	    }
	
	});


});
</script>
<?php
}
}
else
{
?>
echo "Login Please";
<?php
}
?>



