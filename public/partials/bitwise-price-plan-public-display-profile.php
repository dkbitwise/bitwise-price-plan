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
<form id="newupdate_bw" name="register_bw" action="#" method="post">
<div class="registerdetails">
<div class="col-md-6">

<div class="parentdetails">
<div class="tml-field-wrap tml-parent_heading-wrap">Parent Details</div>
</div>

<div class="tml-field-wrap tml-parent_f_name-wrap">
<span class="tml-label">First Name</span>
<input name="parent_f_name" id="parentfname" type="text" value="<?php echo get_user_meta( $cu->ID, 'first_name', true ) ?>" class="tml-field">
<span class="parent_f_name-error error" style="display:none;">Please Enter First Name</span>
</div>

<div class="tml-field-wrap tml-parent_l_name-wrap">
<span class="tml-label">Last name</span>
<input name="parent_l_name" type="text" id="parentlname" value="<?php echo get_user_meta( $cu->ID, 'last_name', true ) ?>" class="tml-field">
<span class="parent_l_name-error error" style="display:none;">Please Enter Last Name</span>
</div>

<div class="tml-field-wrap tml-user_login-wrap">
<label class="tml-label" for="user_login">Username</label>
<input name="user_login" disabled type="text" value="<?php echo $cu->user_login ?>" id="user_login" autocapitalize="off" class="tml-field">
<span class="user_login-error error" style="display:none;">Please Enter User Name</span> 
</div>

<!--<div class="tml-field-wrap tml-user_pass1-wrap">
<label class="tml-label" for="pass1">Password</label>
<input name="user_pass1" type="password" value="" id="passw1" autocomplete="off" class="tml-field">
<span class="password-error error" style="display:none;">Please Enter Password</span> 
</div>-->

<!--<div class="tml-field-wrap tml-user_pass2-wrap">
<label class="tml-label" for="pass2">Confirm Password</label>
<input name="user_pass2" type="password" value="" id="passw2" autocomplete="off" class="tml-field">
<span class="password2-error error" style="display:none;">Please Enter Confirm Password</span> 
</div>-->

<div class="tml-field-wrap tml-parent_email-wrap">
<span class="tml-label">Email</span>
<input name="parent_email" type="email" id="parentemail" value="<?php echo $cu->user_email ?>" class="tml-field">
<span class="parent_email-error error" style="display:none;">Please Enter Email Address</span> 
</div>

<div class="tml-field-wrap tml-parent_cnf_email-wrap">
<span class="tml-label">Confirm Email</span>
<input name="parent_cnf_email" type="email" id="parentcnfemail" value="<?php echo $cu->user_email ?>" class="tml-field">
<span class="confirmemail-error error" style="display:none;">Please Enter Confirm Email</span> 
</div>

<div class="tml-field-wrap tml-parent_phone-wrap">
<label class="tml-label" for="parent_phone">Phone</label>
<div class="intl-tel-input">
<input name="parent_phone" type="tel" value="<?php echo get_user_meta( $cu->ID, 'parent_phone', true ) ?>" id="parent_phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="parent_phone-error error" style="display:none;">Please Enter Phone number</span>
<input name="co_code" type="hidden" value="" id="co_code" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
</div>
</div>


</div>

<div class="col-md-6">

<div style="padding-top: 0px!important" class="studentdetails">
<div style="margin-top: 0px!important" class="tml-field-wrap tml-student_heading-wrap">Student Details</div>
</div>

<div class="tml-field-wrap tml-first_name-wrap"><span class="tml-label">First Name</span>
<input name="first_name" type="text" id="first_name" value="<?php echo $stu_fname ?>" class="tml-field">
<span class="first_name-error error"  style="display:none;">Please Enter First Name</span> 
</div>

<div class="tml-field-wrap tml-last_name-wrap">
<span class="tml-label">Last Name</span>
<input name="last_name" type="text" value="<?php echo $stu_lname ?>" id="last_name" class="tml-field">
<span class="last_name-error error" style="display:none;">Please Enter Last Name</span> 
</div>

<div class="tml-field-wrap tml-user_email-wrap">
<label class="tml-label" for="user_email">Email</label>
<input name="user_email" type="email" value="<?php echo $stu_email ?>" id="user_email" class="tml-field">
<span class="user_email-error error" style="display:none;">Please Enter Email </span> 
</div>

<div class="tml-field-wrap tml-phone-wrap">
<label class="tml-label" for="phone">Phone</label>
<div class="intl-tel-input">
<input name="phone" type="tel" value="<?php echo $stu_mob ?>" id="phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="phone-error error" style="display:none;">Please Enter Phone number</span>
</div>
</div>


<div class="tml-field-wrap tml-timezone-wrap">
<label class="tml-label" for="timezone">Timezone</label>
<select name="timezone" id="timezone" class="tml-field">
<option <?php if($stu_slot == 'NA'){ echo "selected"; } ?> value="NA">Select Timezone</option>
<option <?php if($stu_slot == 'Pacific/Midway'){ echo "selected"; } ?> value="Pacific/Midway">(UTC-11:00) Midway Island</option>
<option <?php if($stu_slot == 'Pacific/Samoa'){ echo "selected"; } ?> value="Pacific/Samoa">(UTC-11:00) Samoa</option>
<option <?php if($stu_slot == 'Pacific/Honolulu'){ echo "selected"; } ?> value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
<option <?php if($stu_slot == 'US/Alaska'){ echo "selected"; } ?> value="US/Alaska">(UTC-09:00) Alaska</option>
<option <?php if($stu_slot == 'America/Los_Angeles'){ echo "selected"; } ?> value="America/Los_Angeles">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
<option <?php if($stu_slot == 'America/Tijuana'){ echo "selected"; } ?> value="America/Tijuana">(UTC-08:00) Tijuana</option>
<option <?php if($stu_slot == 'US/Arizona'){ echo "selected"; } ?> value="US/Arizona">(UTC-07:00) Arizona</option>
<option <?php if($stu_slot == 'America/Chihuahua'){ echo "selected"; } ?> value="America/Chihuahua">(UTC-07:00) La Paz</option>
<option <?php if($stu_slot == 'America/Mazatlan'){ echo "selected"; } ?> value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
<option <?php if($stu_slot == 'US/Mountain'){ echo "selected"; } ?> value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
<option <?php if($stu_slot == 'America/Managua'){ echo "selected"; } ?> value="America/Managua">(UTC-06:00) Central America</option>
<option <?php if($stu_slot == 'US/Central'){ echo "selected"; } ?> value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
<option <?php if($stu_slot == 'America/Mexico_City'){ echo "selected"; } ?> value="America/Mexico_City">(UTC-06:00) Mexico City</option>
<option <?php if($stu_slot == 'America/Monterrey'){ echo "selected"; } ?> value="America/Monterrey">(UTC-06:00) Monterrey</option>
<option <?php if($stu_slot == 'Canada/Saskatchewan'){ echo "selected"; } ?> value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
<option <?php if($stu_slot == 'America/Bogota'){ echo "selected"; } ?> value="America/Bogota">(UTC-05:00) Quito</option>
<option <?php if($stu_slot == 'US/Eastern'){ echo "selected"; } ?> value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
<option <?php if($stu_slot == 'US/East-Indiana'){ echo "selected"; } ?> value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
<option <?php if($stu_slot == 'America/Lima'){ echo "selected"; } ?> value="America/Lima">(UTC-05:00) Lima</option>
<option <?php if($stu_slot == 'Canada/Atlantic'){ echo "selected"; } ?> value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
<option <?php if($stu_slot == 'America/Caracas'){ echo "selected"; } ?> value="America/Caracas">(UTC-04:30) Caracas</option>
<option <?php if($stu_slot == 'America/La_Paz'){ echo "selected"; } ?> value="America/La_Paz">(UTC-04:00) La Paz</option>
<option <?php if($stu_slot == 'America/Santiago'){ echo "selected"; } ?> value="America/Santiago">(UTC-04:00) Santiago</option>
<option <?php if($stu_slot == 'Canada/Newfoundland'){ echo "selected"; } ?> value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
<option <?php if($stu_slot == 'America/Sao_Paulo'){ echo "selected"; } ?> value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
<option <?php if($stu_slot == 'America/Argentina/Buenos_Aires'){ echo "selected"; } ?> value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown</option>
<option <?php if($stu_slot == 'America/Godthab'){ echo "selected"; } ?> value="America/Godthab">(UTC-03:00) Greenland</option>
<option <?php if($stu_slot == 'America/Noronha'){ echo "selected"; } ?> value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
<option <?php if($stu_slot == 'Atlantic/Azores'){ echo "selected"; } ?> value="Atlantic/Azores">(UTC-01:00) Azores</option>
<option <?php if($stu_slot == 'Atlantic/Cape_Verde'){ echo "selected"; } ?> value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
<option <?php if($stu_slot == 'Africa/Casablanca'){ echo "selected"; } ?> value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
<option <?php if($stu_slot == 'Europe/London'){ echo "selected"; } ?> value="Europe/London">(UTC+00:00) London</option>
<option <?php if($stu_slot == 'Etc/Greenwich'){ echo "selected"; } ?> value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
<option <?php if($stu_slot == 'Europe/Lisbon'){ echo "selected"; } ?> value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
<option <?php if($stu_slot == 'Africa/Monrovia'){ echo "selected"; } ?> value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
<option <?php if($stu_slot == 'UTC'){ echo "selected"; } ?> value="UTC">(UTC+00:00) UTC</option>
<option <?php if($stu_slot == 'Europe/Amsterdam'){ echo "selected"; } ?> value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
<option <?php if($stu_slot == 'Europe/Belgrade'){ echo "selected"; } ?> value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
<option <?php if($stu_slot == 'Europe/Berlin'){ echo "selected"; } ?> value="Europe/Berlin">(UTC+01:00) Bern</option>
<option <?php if($stu_slot == 'Europe/Bratislava'){ echo "selected"; } ?> value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
<option <?php if($stu_slot == 'Europe/Brussels'){ echo "selected"; } ?> value="Europe/Brussels">(UTC+01:00) Brussels</option>
<option <?php if($stu_slot == 'Europe/Budapest'){ echo "selected"; } ?> value="Europe/Budapest">(UTC+01:00) Budapest</option>
<option <?php if($stu_slot == 'Europe/Copenhagen'){ echo "selected"; } ?> value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
<option <?php if($stu_slot == 'Europe/Ljubljana'){ echo "selected"; } ?> value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
<option <?php if($stu_slot == 'Europe/Madrid'){ echo "selected"; } ?> value="Europe/Madrid">(UTC+01:00) Madrid</option>
<option <?php if($stu_slot == 'Europe/Paris'){ echo "selected"; } ?> value="Europe/Paris">(UTC+01:00) Paris</option>
<option <?php if($stu_slot == 'Europe/Prague'){ echo "selected"; } ?> value="Europe/Prague">(UTC+01:00) Prague</option>
<option <?php if($stu_slot == 'Europe/Rome'){ echo "selected"; } ?> value="Europe/Rome">(UTC+01:00) Rome</option>
<option <?php if($stu_slot == 'Europe/Sarajevo'){ echo "selected"; } ?> value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
<option <?php if($stu_slot == 'Europe/Skopje'){ echo "selected"; } ?> value="Europe/Skopje">(UTC+01:00) Skopje</option>
<option <?php if($stu_slot == 'Europe/Stockholm'){ echo "selected"; } ?> value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
<option <?php if($stu_slot == 'Europe/Vienna'){ echo "selected"; } ?> value="Europe/Vienna">(UTC+01:00) Vienna</option>
<option <?php if($stu_slot == 'Europe/Warsaw'){ echo "selected"; } ?> value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
<option <?php if($stu_slot == 'Africa/Lagos'){ echo "selected"; } ?> value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
<option <?php if($stu_slot == 'Europe/Zagreb'){ echo "selected"; } ?> value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
<option <?php if($stu_slot == 'Europe/Athens'){ echo "selected"; } ?> value="Europe/Athens">(UTC+02:00) Athens</option>
<option <?php if($stu_slot == 'Europe/Bucharest'){ echo "selected"; } ?> value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
<option <?php if($stu_slot == 'Africa/Cairo'){ echo "selected"; } ?> value="Africa/Cairo">(UTC+02:00) Cairo</option>
<option <?php if($stu_slot == 'Africa/Harare'){ echo "selected"; } ?> value="Africa/Harare">(UTC+02:00) Harare</option>
<option <?php if($stu_slot == 'Europe/Helsinki'){ echo "selected"; } ?> value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
<option <?php if($stu_slot == 'Europe/Istanbul'){ echo "selected"; } ?> value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
<option <?php if($stu_slot == 'Asia/Jerusalem'){ echo "selected"; } ?> value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
<option <?php if($stu_slot == 'Africa/Johannesburg'){ echo "selected"; } ?> value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
<option <?php if($stu_slot == 'Europe/Riga'){ echo "selected"; } ?> value="Europe/Riga">(UTC+02:00) Riga</option>
<option <?php if($stu_slot == 'Europe/Sofia'){ echo "selected"; } ?> value="Europe/Sofia">(UTC+02:00) Sofia</option>
<option <?php if($stu_slot == 'Europe/Tallinn'){ echo "selected"; } ?> value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
<option <?php if($stu_slot == 'Europe/Vilnius'){ echo "selected"; } ?> value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
<option <?php if($stu_slot == 'Asia/Baghdad'){ echo "selected"; } ?> value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
<option <?php if($stu_slot == 'Asia/Kuwait'){ echo "selected"; } ?> value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
<option <?php if($stu_slot == 'Europe/Minsk'){ echo "selected"; } ?> value="Europe/Minsk">(UTC+03:00) Minsk</option>
<option <?php if($stu_slot == 'Africa/Nairobi'){ echo "selected"; } ?> value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
<option <?php if($stu_slot == 'Asia/Riyadh'){ echo "selected"; } ?> value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
<option <?php if($stu_slot == 'Europe/Volgograd'){ echo "selected"; } ?> value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
<option <?php if($stu_slot == 'Asia/Tehran'){ echo "selected"; } ?> value="Asia/Tehran">(UTC+03:30) Tehran</option>
<option <?php if($stu_slot == 'Asia/Muscat'){ echo "selected"; } ?> value="Asia/Muscat">(UTC+04:00) Muscat</option>
<option <?php if($stu_slot == 'Asia/Baku'){ echo "selected"; } ?> value="Asia/Baku">(UTC+04:00) Baku</option>
<option <?php if($stu_slot == 'Europe/Moscow'){ echo "selected"; } ?> value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
<option <?php if($stu_slot == 'Asia/Tbilisi'){ echo "selected"; } ?> value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
<option <?php if($stu_slot == 'Asia/Yerevan'){ echo "selected"; } ?> value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
<option <?php if($stu_slot == 'Asia/Kabul'){ echo "selected"; } ?> value="Asia/Kabul">(UTC+04:30) Kabul</option>
<option <?php if($stu_slot == 'Asia/Karachi'){ echo "selected"; } ?> value="Asia/Karachi">(UTC+05:00) Karachi</option>
<option <?php if($stu_slot == 'Asia/Tashkent'){ echo "selected"; } ?> value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
<option <?php if($stu_slot == 'Asia/Calcutta'){ echo "selected"; } ?> value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
<option <?php if($stu_slot == 'Asia/Kolkata'){ echo "selected"; } ?> value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
<option <?php if($stu_slot == 'Asia/Katmandu'){ echo "selected"; } ?> value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
<option <?php if($stu_slot == 'Asia/Almaty'){ echo "selected"; } ?> value="Asia/Almaty">(UTC+06:00) Almaty</option>
<option <?php if($stu_slot == 'Asia/Dhaka'){ echo "selected"; } ?> value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
<option <?php if($stu_slot == 'Asia/Yekaterinburg'){ echo "selected"; } ?> value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
<option <?php if($stu_slot == 'Asia/Rangoon'){ echo "selected"; } ?> value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
<option <?php if($stu_slot == 'Asia/Bangkok'){ echo "selected"; } ?> value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
<option <?php if($stu_slot == 'Asia/Jakarta'){ echo "selected"; } ?> value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
<option <?php if($stu_slot == 'Asia/Novosibirsk'){ echo "selected"; } ?> value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
<option <?php if($stu_slot == 'Asia/Hong_Kong'){ echo "selected"; } ?> value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
<option <?php if($stu_slot == 'Asia/Chongqing'){ echo "selected"; } ?> value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
<option <?php if($stu_slot == 'Asia/Krasnoyarsk'){ echo "selected"; } ?> value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
<option <?php if($stu_slot == 'Asia/Kuala_Lumpur'){ echo "selected"; } ?> value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
<option <?php if($stu_slot == 'Australia/Perth'){ echo "selected"; } ?> value="Australia/Perth">(UTC+08:00) Perth</option>
<option <?php if($stu_slot == 'Asia/Singapore'){ echo "selected"; } ?> value="Asia/Singapore">(UTC+08:00) Singapore</option>
<option <?php if($stu_slot == 'Asia/Taipei'){ echo "selected"; } ?> value="Asia/Taipei">(UTC+08:00) Taipei</option>
<option <?php if($stu_slot == 'Asia/Ulan_Bator'){ echo "selected"; } ?> value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
<option <?php if($stu_slot == 'Asia/Urumqi'){ echo "selected"; } ?> value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
<option <?php if($stu_slot == 'Asia/Irkutsk'){ echo "selected"; } ?> value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
<option <?php if($stu_slot == 'Asia/Tokyo'){ echo "selected"; } ?> value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
<option <?php if($stu_slot == 'Asia/Seoul'){ echo "selected"; } ?> value="Asia/Seoul">(UTC+09:00) Seoul</option>
<option <?php if($stu_slot == 'Australia/Adelaide'){ echo "selected"; } ?> value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
<option <?php if($stu_slot == 'Australia/Darwin'){ echo "selected"; } ?> value="Australia/Darwin">(UTC+09:30) Darwin</option>
<option <?php if($stu_slot == 'Australia/Brisbane'){ echo "selected"; } ?> value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
<option <?php if($stu_slot == 'Australia/Canberra'){ echo "selected"; } ?> value="Australia/Canberra">(UTC+10:00) Canberra</option>
<option <?php if($stu_slot == 'Pacific/Guam'){ echo "selected"; } ?> value="Pacific/Guam">(UTC+10:00) Guam</option>
<option <?php if($stu_slot == 'Australia/Hobart'){ echo "selected"; } ?> value="Australia/Hobart">(UTC+10:00) Hobart</option>
<option <?php if($stu_slot == 'Australia/Melbourne'){ echo "selected"; } ?> value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
<option <?php if($stu_slot == 'Pacific/Port_Moresby'){ echo "selected"; } ?> value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
<option <?php if($stu_slot == 'Australia/Sydney'){ echo "selected"; } ?> value="Australia/Sydney">(UTC+10:00) Sydney</option>
<option <?php if($stu_slot == 'Asia/Yakutsk'){ echo "selected"; } ?> value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
<option <?php if($stu_slot == 'Asia/Vladivostok'){ echo "selected"; } ?> value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
<option <?php if($stu_slot == 'Pacific/Auckland'){ echo "selected"; } ?> value="Pacific/Auckland">(UTC+12:00) Wellington</option>
<option <?php if($stu_slot == 'Pacific/Fiji'){ echo "selected"; } ?> value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
<option <?php if($stu_slot == 'Pacific/Kwajalein'){ echo "selected"; } ?> value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
<option <?php if($stu_slot == 'Asia/Kamchatka'){ echo "selected"; } ?> value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
<option <?php if($stu_slot == 'Asia/Magadan'){ echo "selected"; } ?> value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
<option <?php if($stu_slot == 'Pacific/Tongatapu'){ echo "selected"; } ?> value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
</select>
<span class="timezone-error error" style="display:none;">Please Select TimeZone</span> 
</div>

</div>

<div class="col-md-12">
<div class="tml-field-wrap tml-submit-wrap" >
<input type="hidden" name="formtype" id="formtype" value="parent_update">
<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $cu->ID ?>">
<button id="upsubmit" name="upsubmit" value="Register" style="margin-top: 13px;" class="tml-button">Update Profile</button>
</div>
</div>

</div>
</form>
</div>
<?php
    global $post;
    $post_slug = $post->post_name;

    if( $post_slug == 'profile' ){
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<script>
$(document).ready(function() {

	var parent_phone = $("#parent_phone"),
        phone = $("#phone"),
        phone1 = $("#phone1"),
        phone2 = $("#phone2");

    parent_phone.intlTelInput({
        utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
        preferredCountries: ["<?php echo $co_code ?>"],
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
                $(".parent_phone-error").css('display', 'none');
            } else {
                $(".parent_phone_msg").html('Invalid');
                $(".parent_phone_msg").removeClass('success').addClass('error');
                $("#parent_phone_code").val('');
            }
        }
    });


    phone.intlTelInput({
        utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
        preferredCountries: ["<?php echo $co_code ?>"],
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
                $(".phone-error").css('display', 'none');
            } else {
                $(".phone_msg").html('Invalid');
                $(".phone_msg").removeClass('success').addClass('error');
                $("#phone_code").val('');
            }
        }
    });

    phone1.intlTelInput({
        utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
        preferredCountries: ["<?php echo $co_code ?>"],
        initialCountry: "auto",
    });
    phone1.keyup(function() {
        if( $(".phone1_msg").length ==0 ){
            $('.tml-label[for="phone1"]').append(' <span class="phone1_msg"></span>')
        }
        if ($.trim(phone1.val())) {
            if (phone1.intlTelInput("isValidNumber")) {
                var getCode = phone1.intlTelInput('getSelectedCountryData').dialCode;
                $(".phone1_msg").html('✓ Valid');
                $(".phone1_msg").removeClass('error').addClass('success');
                $("#phone1_code").val(getCode);
                $(".phone1-error").css('display', 'none');
            } else {
                $(".phone1_msg").html('Invalid');
                $(".phone1_msg").removeClass('success').addClass('error');
                $("#phone1_code").val('');
            }
        }
    });

    phone2.intlTelInput({
        utilsScript:"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js",
        preferredCountries: ["<?php echo $co_code ?>"],
        initialCountry: "auto",
    });
    phone2.keyup(function() {
        if( $(".phone2_msg").length ==0 ){
            $('.tml-label[for="phone2"]').append(' <span class="phone2_msg"></span>')
        }
        if ($.trim(phone2.val())) {
            if (phone2.intlTelInput("isValidNumber")) {
                var getCode = phone2.intlTelInput('getSelectedCountryData').dialCode;
                $(".phone2_msg").html('✓ Valid');
                $(".phone2_msg").removeClass('error').addClass('success');
                $("#phone2_code").val(getCode);
                $(".phone2-error").css('display', 'none');
            } else {
                $(".phone2_msg").html('Invalid');
                $(".phone2_msg").removeClass('success').addClass('error');
                $("#phone2_code").val('');
            }
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



