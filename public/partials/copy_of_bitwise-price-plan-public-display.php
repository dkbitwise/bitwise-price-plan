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
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div style="width: 100%!important" class="tml tml-register">
<form id="newregister_bw" name="register_bw" action="#" method="post">
<div class="registerdetails">
<div class="col-md-6">

<div class="parentdetails">
<div class="tml-field-wrap tml-parent_heading-wrap">Parent Details</div>
</div>

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

<div class="tml-field-wrap tml-user_login-wrap">
<label class="tml-label" for="user_login">Username</label>
<input name="user_login" type="text" value="" id="user_login" autocapitalize="off" class="tml-field">
<span class="user_login-error error" style="display:none;">Please Enter User Name</span> 
</div>

<div class="tml-field-wrap tml-user_pass1-wrap">
<label class="tml-label" for="pass1">Password</label>
<input name="user_pass1" type="password" value="" id="passw1" autocomplete="off" class="tml-field">
<span class="password-error error" style="display:none;">Please Enter Password</span> 
</div>

<div class="tml-field-wrap tml-user_pass2-wrap">
<label class="tml-label" for="pass2">Confirm Password</label>
<input name="user_pass2" type="password" value="" id="passw2" autocomplete="off" class="tml-field">
<span class="password2-error error" style="display:none;">Please Enter Confirm Password</span> 
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
<input name="co_code" type="hidden" value="us" id="co_code" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
</div>


</div>

<div class="col-md-6">

<div style="padding-top: 0px!important" class="studentdetails">
<div style="margin-top: 0px!important" class="tml-field-wrap tml-student_heading-wrap">Student Details</div>
</div>

<div class="tml-field-wrap tml-first_name-wrap"><span class="tml-label">First Name</span>
<input name="first_name" type="text" id="first_name" value="" class="tml-field">
<span class="first_name-error error"  style="display:none;">Please Enter First Name</span> 
</div>

<div class="tml-field-wrap tml-last_name-wrap">
<span class="tml-label">Last Name</span>
<input name="last_name" type="text" value="" id="last_name" class="tml-field">
<span class="last_name-error error" style="display:none;">Please Enter Last Name</span> 
</div>

<div class="tml-field-wrap tml-user_email-wrap">
<label class="tml-label" for="user_email">Email</label>
<input name="user_email" type="email" value="" id="user_email" class="tml-field">
<span class="user_email-error error" style="display:none;">Please Enter Email </span> 
</div>

<div class="tml-field-wrap tml-phone-wrap">
<label class="tml-label" for="phone">Phone</label>
<div class="intl-tel-input">
<input name="phone" type="tel" value="" id="phone" class="tml-field" autocomplete="off" placeholder="(201) 555-0123">
<span class="phone-error error" style="display:none;">Please Enter Phone number</span>
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

<?php if( function_exists( 'gglcptch_display' ) ) { echo gglcptch_display(); } ; ?>

</div>

<div class="col-md-12">
<input type="hidden" name="formtype" id="formtype" value="parent_register">
<div class="alreadymember" style="margin: 0px 386px 0px;">Already Registered? Click here to <a href="/login">Login</a> </div>
<div style="margin-top: 0px!important" class="tml-field-wrap tml-submit-wrap" >
<button id="regsubmit" name="regsubmit" value="Register" style="margin-top: 13px;" class="tml-button">Register</button>
</div>

</div>

</div>
</form>
</div>