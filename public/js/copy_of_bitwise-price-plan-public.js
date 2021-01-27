(function($) {
    'use strict';
    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    /*
     *The following function  check the phone number valid or not updated by suresh on 12-4-2020
     *return boolean
     *param $phone
     */
    function validatePhone($phone) {
        
        var a = $phone;
        var filter = /^\d{10}$/;
        //var filter = /^(\+91-|\+91|0)?\d{10}$/;
        if (filter.test(a)) {
            return 1;
        } else {
            return 0;
        }
        
    }

    /*
     *The following function is check the email  is valid or not updated by suresh on 12-4-2020
     *return boolean
     *param string $email
     */
    function validateEmail($email) {
    	
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
        
    }
    
    function allowedEmaildomain($email) {
    	
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

    /*
     *The following function  is avoid the user copy paste method in confirm email field
     *Code updated by suresh on 13-4-2020
     */
    function DisableCopyPaste(e) {
        /*Message to display*/
        var message = "Copy Paste is not allowed";
        /*check mouse right click or Ctrl key press*/
        var kCode = event.keyCode || e.charCode;
        /*FF and Safari use e.charCode, while IE use e.keyCode*/
        if (kCode == 17 || kCode == 2) {
            Swal.fire(message);
            return false;
        }
    }

    /*
     *The following function is used  to check the email already registred or not
     *updated by suresh on 12-4-2020
     *param string email
     */
    function userexist($email) {
        var ajaxurl = window.location.origin + "/wp-admin/admin-ajax.php";
        var data = {
            'action': 'useremail_check',
            'useremail': $('#parentemail').val()
        };
        var res = 0;
        /*since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php*/
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function(response) {
                res = response;
            },
            async: false /*this turns it into synchronous*/
        });
        return res;
    }
    
    function userexist_stu($email) {
        var ajaxurl = window.location.origin + "/wp-admin/admin-ajax.php";
        var data = {
            'action': 'useremail_check',
            'useremail': $('#user_email').val()
        };
        var res = 0;
        /*since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php*/
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function(response) {
                res = response;
            },
            async: false /*this turns it into synchronous*/
        });
        return res;    	
    }

    function usernameexist($uname) {
        var ajaxurl = window.location.origin + "/wp-admin/admin-ajax.php";
        var data = {
            'action': 'username_check',
            'username': $('#user_login').val()
        };
        var res = 0;
        /*since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php*/
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            success: function(response) {
                res = response;
            },
            async: false /*this turns it into synchronous*/
        });
        return res;
    }

    /*Check the minimum length of password*/
    var minLength = 6;

    function checkminlength($pssword) {
        var char = $("#passw1").val();
        var charLength = $("#passw1").val().length;
        if (charLength < minLength) {
            $('.password-error').text('Min length ' + minLength + ' required');
            $('.password-error').css("display", "block");
            return 1;
        } else {
            $('.password-error').hide();
            return 0;
        }
    }
    /*check minimum length end*/

    /*check password and confirm password same or not . Updated by suresh*/
    function checkpasswordmatch() {
        if(!$('#passw2').val())
        {
            $(".password2-error").css('display', 'block');
        } else if ($('#passw2').val() != $('#passw1').val()) {
            $(".password2-error").text('Please enter same password');
            $(".password2-error").css('display', 'block');
        } else {
            $(".password2-error").hide();
        }
    }

    /*Only number*/
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    $(document).ready(function() {
	    	
    	$('.country').click(function(){
			var code = $(this).attr("data-country-code");
			$("#co_code").val(code);
    	});
    	
        $("#parentfname").on('keyup keydown change', function() {

            if (!$('#parentfname').val()) {
                $(".parent_f_name-error").css('display', 'block');
                $("#parentfname").focus();
            } else {
                $(".parent_f_name-error").hide();
            }

        });

        $("#parentlname").on('keyup keydown change', function() {

            if (!$('#parentlname').val()) {
                $(".parent_l_name-error").css('display', 'block');
                $("#parentlname").focus();
            } else {
                $(".parent_l_name-error").hide();
            }

        });

		/*User Name on Change*/
		$("#user_login").on('keyup keydown change', function(e) {

            if (!$('#user_login').val()) {
                $("#regsubmit").prop("disabled", true);
				$(this).attr("data-ref",1);
                $(".user_login-error").css('display', 'block');
                $("#user_login").focus();
            } else {
            	/*Only on onchange*/
            	if(e.type === 'change')
            	{
	            	var namecheck = usernameexist($("#user_login").val());
	            	if (namecheck == 1) {
						$(this).attr("data-ref",1);
						$(this).attr("data-reval",1);
	                    $(".user_login-error").text('Username already exist');
	                    $(".user_login-error").css("display", "block");
	                	$("#user_login").focus();
	                } else {
						$(this).attr("data-ref",0);
	                    $(".user_login-error").hide();
	                }
            	}
            	else
            	{
            		var reval = $(this).attr("data-reval");
					if(reval == 1)
					{
		            	var namecheck = usernameexist($("#user_login").val());
		            	if (namecheck == 1) {
							$(this).attr("data-ref",1);
							$(this).attr("data-reval",1);
		                    $(".user_login-error").text('Username already exist');
		                    $(".user_login-error").css("display", "block");
		                	$("#user_login").focus();
		                } else {
							$(this).attr("data-ref",0);
							$(this).attr("data-reval",0);
		                    $(".user_login-error").hide();
		                }
					}
					else
					{
						$(".user_login-error").hide();
					}
            	}
            	
            }
            
        	var refr = $(this).attr("data-ref");
			if(refr == 0)
			{
				$("#regsubmit").prop("disabled", false);
			}
			else
			{
				$("#regsubmit").prop("disabled", true);
			}

    	});


        /*$("#user_login").on('keyup keydown', function() {
        	
        	if (!$('#user_login').val()) {
                $(".user_login-error").css('display', 'block');
                $("#user_login").focus();
            } else {
                $(".user_login-error").hide();
            }

        });


        $("#user_login").on('change', function() {

            if (!$('#user_login').val()) {
                $(".user_login-error").css('display', 'block');
                $("#user_login").focus();
            } else {
            	var namecheck = usernameexist($("#user_login").val());
            	if (namecheck == 1) {
                    $(".user_login-error").text('Username already exist');
                    $(".user_login-error").css("display", "block");
                	$("#user_login").focus();
                } else {
                    $(".user_login-error").hide();
                }
            }

        });*/
        
        $('#passw1').on('keyup keydown change', function() {
            checkminlength($(this).val());
        });
        
        $('#passw2').on('keyup change', function() {
            checkpasswordmatch();
        });
        
        $("#parentemail").on('keyup keydown change', function(e) {
        	
        	var did = $("#add-stu").data("id");
        	if (!$('#parentemail').val()) {
				$(this).attr("data-ref",1);
                $(".parent_email-error").css('display', 'block');
                $("#parentemail").focus();
            } else if (!validateEmail($('#parentemail').val())) {
				$(this).attr("data-ref",1);
                $(".parent_email-error").text('Enter valid Email address');
                $(".parent_email-error").css('display', 'block');
                $("#parentemail").focus();
            } else {
				$(this).attr("data-ref",0);
				var ref = $(this).attr("data-ref");
            	/*Only on onchange*/
            	if(e.type === 'change')
            	{
            		var usercheck = userexist($("#parentemail").val());
	                if (usercheck == 1) {
						$(this).attr("data-ref",1);
						$(this).attr("data-reval",1);
	                    $(".parent_email-error").text('Email address already exists');
	                    $(".parent_email-error").css("display", "block");
	                	$("#parentemail").focus();
	                }
					/*var usercheck = userexist($("#parentemail").val());
	                if (usercheck == 1) {
						$(this).attr("data-ref",1);
						$(this).attr("data-reval",1);
	                    $(".parent_email-error").text('Email address already exists');
	                    $(".parent_email-error").css("display", "block");
	                	$("#parentemail").focus();
	                } else if ($('#parentemail').val() == $('#user_email1').val()) {
						$(this).attr("data-ref",1);
						$(this).attr("data-reval",1);
                		$(".parent_email-error").text('Enter different Email address');
                		$("#parentemail").focus();
            		} else {
            			if(did == 2)
            			{
							if ($('#parentemail').val() == $('#user_email2').val()) {
								$(this).attr("data-ref",1);
								$(this).attr("data-reval",1);
		                		$(".parent_email-error").text('Enter different Email address');
		                		$("#parentemail").focus();
		            		}
		            		else
		            		{
								$(this).attr("data-ref",0);
		                    	$(".parent_email-error").hide();
		            		}
            			}
            			else
            			{
							$(this).attr("data-ref",0);
	                    	$(".parent_email-error").hide();
            			}
			            if ($('#parentcnfemail').val() != "" && $('#parentcnfemail').val() != $('#parentemail').val()) {
							$("#regsubmit").prop("disabled", true);
							$('#parentcnfemail').attr("data-ref",1);
			                $(".confirmemail-error").text('Please enter same email address');
			                $(".confirmemail-error").css('display', 'block');
			                $("#parentcnfemail").focus();
			            }
	                }*/
            	}
            	else
            	{
					$(".parent_email-error").hide();
            	}
            }

        	var refr = $(this).attr("data-ref");
			if(refr == 0)
			{
				$("#regsubmit").prop("disabled", false);
			}
			else
			{
				$("#regsubmit").prop("disabled", true);
			}

        });
        
        $("#parentcnfemail").on('keyup keydown change', function() {

            if ($('#parentcnfemail').val() != $('#parentemail').val()) {
				$(this).attr("data-ref",1);
                $(".confirmemail-error").text('Please enter same email address');
                $(".confirmemail-error").css('display', 'block');
                $("#parentcnfemail").focus();
            } else if (!$('#parentcnfemail').val()) {
				$(this).attr("data-ref",1);
                $(".confirmemail-error").text('Please Enter Email Address');
                $(".confirmemail-error").css('display', 'block');
                $("#parentcnfemail").focus();
            } else {
				$(this).attr("data-ref",0);
                $(".confirmemail-error").hide();
            }

        	var refr = $(this).attr("data-ref");
			if(refr == 0)
			{
				$("#regsubmit").prop("disabled", false);
			}
			else
			{
				$("#regsubmit").prop("disabled", true);
			}
            
        });


        $("#first_name").on('keyup keydown change', function() {
			
            if (!$('#first_name').val()) {
                $(".first_name-error").css('display', 'block');
                $("#first_name").focus();
            } else {
                $(".first_name-error").hide();
            }

        });

        $("#last_name").on('keyup keydown change', function() {

            if (!$('#last_name').val()) {
                $(".last_name-error").css('display', 'block');
                $("#last_name").focus();
            } else {
                $(".last_name-error").hide();
            }

        });

        $("#user_email1").on('keyup keydown change', function(e) {
        	
        	var did = $("#add-stu").data("id");
        	if (!$('#user_email1').val()) {
				$(this).attr("data-ref",1);
                $(".user_email1-error").css('display', 'block');
                $("#user_email1").focus();
            } else if (!validateEmail($('#user_email1').val())) {
				$(this).attr("data-ref",1);
                $(".user_email1-error").text('Enter valid Email address');
                $("#user_email1").focus();
                $(".user_email1-error").css('display', 'block');
            } else {

				$(this).attr("data-ref",0);
				var ref = $(this).attr("data-ref");
            	if(e.type === 'change') {

            		if(allowedEmaildomain($('#user_email1').val()))
                	{
		                var usercheck = userexist_stu($("#user_email1").val());
		                if (usercheck == 1) {
							$(this).attr("data-ref",1);
		                    $(".user_email1-error").text('Email address already exists');
		                    $(".user_email1-error").css("display", "block");
		                	$("#user_email1").focus();
		                } else if ($('#parentemail').val() == $('#user_email1').val()) {
							$(this).attr("data-ref",1);
	                		$(".user_email1-error").text('Enter different Email address');
		                    $(".user_email1-error").css("display", "block");
	                		$("#user_email1").focus();
	            		} else {
	
	            			if(did == 2)
	            			{
								if ($('#user_email1').val() == $('#user_email2').val()) {
									$(this).attr("data-ref",1);
			                		$(".user_email1-error").text('Enter different Email address');
				                    $(".user_email1-error").css("display", "block");
			                		$("#user_email1").focus();
			            		}
			            		else
			            		{
									$(this).attr("data-ref",0);
			                    	$(".user_email1-error").hide();
			            		}
	            			}
	            			else
	            			{
								$(this).attr("data-ref",0);
		                    	$(".user_email1-error").hide();
	            			}
	            			
		                }
                	}
                	else
                	{
            			$(this).attr("data-ref",1);
		                $(".user_email1-error").css("display", "block");
                		$(".user_email1-error").text('Please use a general email address with domain ending in .com, .net. or .edu');
                		$("#user_email1").focus();
                	}
            	}
            	else
            	{
					$(this).attr("data-ref",0);
	            	$(".user_email1-error").hide();
            	}

            }

        	var refr = $(this).attr("data-ref");
			if(refr == 0)
			{
				$("#regsubmit").prop("disabled", false);
			}
			else
			{
				$("#regsubmit").prop("disabled", true);
			}
            
        });
        
        /*var global2Timeout = null;
        $("#user_email").on('change', function() {

			if(allowedEmaildomain($('#user_email').val()))
			{
	            if (global2Timeout != null)
	                clearTimeout(global2Timeout);
	            	global2Timeout = setTimeout(SearchFunc_stu, 300);
	            	$("#user_email").focus();
			}
			else
			{
            	$(".user_email-error").text('Please use a general email address with domain ending in .com, .net. or .edu');
                $(".user_email-error").css("display", "block");
            	$("#user_email").focus();
			}
			
        });

		function SearchFunc_stu() {

            globalTimeout = null;
            if (!$('#user_email').val()) {
                $(".user_email-error").css('display', 'block');
                $("#user_email").focus();
            } else if (!validateEmail($('#user_email').val())) {
                $(".user_email-error").text('Enter valid Email address');
                $(".user_email-error").css('display', 'block');
                $("#user_email").focus();
            } else {
                var usercheck = userexist_stu($("#user_email").val());
                if (usercheck == 1) {
                    $(".user_email-error").text('Email address already exists');
                    $(".user_email-error").css("display", "block");
                	$("#user_email").focus();
                    $("#newregister_bw").prop("disabled", true);
                } else {
                    $("#newregister_bw").prop("disabled", false);
                    $(".user_email-error").hide();
                }
            }

        }*/


        $("#first_name1").on('keyup keydown change', function() {
            
            if (!$('#first_name1').val()) {
                $(".first_name1-error").css('display', 'block');
                $("#first_name1").focus();
            } else {
                $(".first_name1-error").hide();
            }

        });

        $("#last_name1").on('keyup keydown change', function() {

            if (!$('#last_name1').val()) {
                $(".last_name1-error").css('display', 'block');
                $("#last_name1").focus();
            } else {
                $(".last_name1-error").hide();
            }

        });

        $("#user_email2").on('keyup keydown', function(e) {
            
        	var did = $("#add-stu").data("id");
            if (!$('#user_email2').val()) {
 				$(this).attr("data-ref",1);
                $(".user_email2-error").css('display', 'block');
                $("#user_email2").focus();
            } else if (!validateEmail($('#user_email2').val())) {
				$(this).attr("data-ref",1);
                $(".user_email2-error").text('Enter valid Email address');
                $("#user_email2").focus();
                $(".user_email2-error").css('display', 'block');
            } else {

				$(this).attr("data-ref",0);
				var ref = $(this).attr("data-ref");
            	if(e.type === 'change') {
            		
            		if(allowedEmaildomain($('#user_email2').val()))
                	{
		                var usercheck = userexist_stu($("#user_email2").val());
		                if (usercheck == 1) {
							$(this).attr("data-ref",1);
		                    $(".user_email2-error").text('Email address already exists');
		                    $(".user_email2-error").css("display", "block");
		                	$("#user_email2").focus();
		                } else if ($('#parentemail').val() == $('#user_email2').val()) {
							$(this).attr("data-ref",1);
	                		$(".user_email2-error").text('Enter different Email address');
	                		$("#user_email2").focus();
	            		} else {
	
	            			if(did == 2)
	            			{
								if ($('#user_email2').val() == $('#user_email1').val()) {
									$(this).attr("data-ref",1);
			                		$(".user_email2-error").text('Enter different Email address');
			                		$("#user_email2").focus();
			            		}
			            		else
			            		{
									$(this).attr("data-ref",0);
			                    	$(".user_email2-error").hide();
			            		}
	            			}
	            			else
	            			{
								$(this).attr("data-ref",0);
		                    	$(".user_email2-error").hide();
	            			}
	            			
		                }
                	}
                	else
                	{
            			$(this).attr("data-ref",1);
		                $(".user_email2-error").css("display", "block");
                		$(".user_email2-error").text('Please use a general email address with domain ending in .com, .net. or .edu');
                		$("#user_email2").focus();
                	}
            	}
            	else
            	{
					$(this).attr("data-ref",0);
	            	$(".user_email2-error").hide();
            	}

            }

        	var refr = $(this).attr("data-ref");
			if(refr == 0)
			{
				$("#regsubmit").prop("disabled", false);
			}
			else
			{
				$("#regsubmit").prop("disabled", true);
			}
            
        });
        
        $("#first_name2").on('keyup keydown change', function() {
            
            if (!$('#first_name2').val()) {
                $(".first_name2-error").css('display', 'block');
                $("#first_name2").focus();
            } else {
                $(".first_name2-error").hide();
            }

        });

        $("#last_name2").on('keyup keydown change', function() {

            if (!$('#last_name2').val()) {
                $(".last_name2-error").css('display', 'block');
                $("#last_name2").focus();
            } else {
                $(".last_name2-error").hide();
            }

        });

        
       $("#timezone").on('keyup keydown change', function() {

            if (!$('#timezone').val() || $('#timezone').val() == 'NA') {
                $(".timezone-error").css('display', 'block');
                $('#timezone').focus();
                $("#newregister_bw").prop("disabled", true);
            } else {
                $("#newregister_bw").prop("disabled", false);
                $(".timezone-error").hide();
            }

        });

        $('#parent_phone').on('keyup change', function() {
        	
        	var pa_phone= $('#parent_phone').val();
			var pa_ph = pa_phone.match(/\d/g);
			if(pa_ph != null)
			{
				pa_ph = pa_ph.join("");
			}
		
			$('#parent_phone').val(pa_ph);
            if (!$('#parent_phone').val()) {
                $("#regsubmit").prop("disabled", true);
                $(".parent_phone-error").css('display', 'block');
                $("#parent_phone").focus();
            } else if (!validatePhone($('#parent_phone').val())) {
                $("#regsubmit").prop("disabled", true);
                $(".parent_phone-error-msg").text('Please enter valid mobile number');
                $(".parent_phone-error-msg").css('display', 'block');
                $("#parent_phone").focus();
            } else {
                $("#regsubmit").prop("disabled", false);
                $(".parent_phone-error-msg").css('display', 'none');
            }

        });

        $('#phone1').on('keyup change', function() {
          
        	var st_phone1= $('#phone1').val();
	    	var st_ph = st_phone1.match(/\d/g);
			if(st_ph != null)
			{
	    		st_ph = st_ph.join("");
			}
			
	        $('#phone1').val(st_ph);
	        if (!$('#phone1').val()) {
	            $("#regsubmit").prop("disabled", true);
	            $(".phone1-error").css('display', 'block');
	            $("#phone1").focus();
	        } else if (!validatePhone($('#phone1').val())) {
	            $("#regsubmit").prop("disabled", true);
	            $(".phone1-error-msg").text('Please enter valid mobile number');
	            $(".phone1-error-msg").css('display', 'block');
	            $("#phone1").focus();
	        } else {
	            $("#regsubmit").prop("disabled", false);
	            $(".phone1-error-msg").css('display', 'none');
	        }

        });

        $('#phone2').on('keyup change', function() {
          
        	var st_phone2= $('#phone2').val();
        	var st_ph = st_phone2.match(/\d/g);
			if(st_ph != null)
        	{
        		st_ph = st_ph.join("");
        	}

            $('#phone2').val(st_ph);
            if (!$('#phone2').val()) {
                $("#regsubmit").prop("disabled", true);
                $(".phone2-error").css('display', 'block');
                $("#phone2").focus();
            } else if (!validatePhone($('#phone2').val())) {
                $("#regsubmit").prop("disabled", true);
                $(".phone2-error-msg").text('Please enter valid mobile number');
                $(".phone2-error-msg").css('display', 'block');
                $("#phone2").focus();
            } else {
                $("#regsubmit").prop("disabled", false);
                $(".phone2-error-msg").css('display', 'none');
            }

        });

		
		$('#regsubmit').click(function() {
			
			var error = 0;

			var did = $("#add-stu").data("id");
        	var user_lo = $("#user_login").attr("data-ref");
        	var parent_em = $("#parentemail").attr("data-ref");
        	var user1_em = $("#user_email1").attr("data-ref");

			if(user_lo == 1)
			{
                $(".user_login-error").css('display', 'block');
                $('#user_login').focus()
                error = 1;
			}

			if(parent_em == 1)
			{
                $(".parentemail-error").css('display', 'block');
                $('#parentemail').focus()
                error = 1;
			}

			if(user1_em == 1)
			{
                $(".user_email1-error").css('display', 'block');
                $('#user_email1').focus()
                error = 1;
			}
			
			if(did == 2)
			{
        		var user2_em = $("#user_email2").attr("data-ref");
				if(user2_em == 1)
				{
	                $(".user_email2-error").css('display', 'block');
	                $('#user_email2').focus()
	                error = 1;
				}
			}
			
			if (!$('#parentfname').val()) {
                $(".parent_f_name-error").css('display', 'block');
                $("#parentfname").focus();
                error = 1;
            } else {
                $(".parent_f_name-error").hide();
            }

            if (!$('#parentlname').val()) {
                $(".parent_l_name-error").css('display', 'block');
                $("#parentlname").focus();
                error = 1;
            } else {
                $(".parent_l_name-error").hide();
            }
            
            if (!$('#user_login').val()) {
                $(".user_login-error").css('display', 'block');
                $('#user_login').focus()
                error = 1;
            } else {
                $(".user_login-error").hide();
            }
			
			if (!$('#passw1').val()) {
                $(".password-error").css('display', 'block');
                error = 1;
            } else if (checkminlength($("#passw1").val())) {
                error = 1;
            } else {
                $(".password-error").hide();
            }

            if (!$('#passw2').val()) {
                $(".password2-error").css('display', 'block');
                error = 1;
            } else if ($('#passw2').val() != $('#passw1').val()) {
                $(".password2-error").text('Please enter same password');
                $(".password2-error").css('display', 'block');
                error = 1;
            } else {
                $(".password2-error").hide();
            }
            
            if (!$('#parentcnfemail').val()) {
                $(".confirmemail-error").css('display', 'block');
                $("#parentcnfemail").focus();
                error = 1;
            } else if (!validateEmail($('#parentcnfemail').val())) {
                $(".confirmemail-error").text('Enter valid Email address');
                $(".confirmemail-error").css('display', 'block');
                $("#parentcnfemail").focus();
                error = 1;
            } else if ($('#parentcnfemail').val() != $('#parentemail').val()) {
                $(".confirmemail-error").text('Please enter same email address');
                $(".confirmemail-error").css('display', 'block');
                $("#parentcnfemail").focus();
                error = 1;
            } else {
                $(".confirmemail-error-msg").hide();
            }
            
            if (!$('#parentemail').val()) {
                $(".parent_email-error").css('display', 'block');
                $("#parentemail").focus();
                error = 1;
            } else if (!validateEmail($('#parentemail').val())) {
                $(".parent_email-error").text('Enter valid Email address');
                $("#parentemail").focus();
                $(".parent_email-error").css('display', 'block');
                error = 1;
            } else {
                $(".parent_email-error").hide();
            }

            if (!$('#parent_phone').val()) {
                $(".parent_phone-error").css('display', 'block');
                $("#parent_phone").focus();
                error = 1;
            } else if (!validatePhone($('#parent_phone').val())) {
                $(".parent_phone-error").text('Please enter valid mobile number');
                $(".parent_phone-error").css('display', 'block');
                $("#parent_phone").focus();
                error = 1;
            } else {
                $(".parent_phone-error").hide();
            }

            if (!$('#first_name1').val()) {
                $(".first_name1-error").css('display', 'block');
                $("#first_name1").focus();
                error = 1;
            } else {
                $(".first_name1-error").hide();
            }

            if (!$('#last_name1').val()) {
                $(".last_name1-error").css('display', 'block');
                $('#last_name1').focus()
                error = 1;
            } else {
                $(".last_name1-error").hide();
            }
            
            if (!$('#user_email1').val()) {
                $(".user_email1-error").css('display', 'block');
                $("#user_email1").focus();
                error = 1;
            } else if (!validateEmail($('#user_email1').val())) {
                $(".user_email1-error").text('Enter valid Email address');
                $("#user_email1").focus();
                $(".user_email1-error").css('display', 'block');
                error = 1;
            } else if ($('#parentcnfemail').val() == $('#user_email1').val()) {
                $(".user_email1-error").text('Enter different Email address');
                $("#user_email1").focus();
                $(".user_email1-error").css('display', 'block');
                error = 1;
            } else {
                if(allowedEmaildomain($('#user_email1').val()))
                {
                    $(".user_email1-error").hide();
                }
                else
                {
                    $(".user_email1-error").text('Please use a general email address with domain ending in .com, .net. or .edu');
                    $("#user_email1").focus();
                    $(".user_email1-error").css('display', 'block');
                    error = 1;
                }
            }

            if (!$('#phone1').val()) {
                $(".phone1-error").css('display', 'block');
                $("#phone1").focus();
                error = 1;
            } else if (!validatePhone($('#phone1').val())) {
                $(".phone1-error").text('Please enter valid mobile number');
                $(".phone1-error").css('display', 'block');
                $("#phone1").focus();
                error = 1;
            } else {
                $(".phone1-error").hide();
            }

			if(did == 2)
			{

	            if (!$('#first_name2').val()) {
	                $(".first_name2-error").css('display', 'block');
	                $("#first_name2").focus();
	                error = 1;
	            } else {
	                $(".first_name2-error").hide();
	            }
	
	            if (!$('#last_name2').val()) {
	                $(".last_name2-error").css('display', 'block');
	                $('#last_name2').focus()
	                error = 1;
	            } else {
	                $(".last_name2-error").hide();
	            }
	            
	            if (!$('#user_email2').val()) {
	                $(".user_email2-error").css('display', 'block');
	                $("#user_email2").focus();
	                error = 1;
	            } else if (!validateEmail($('#user_email2').val())) {
	                $(".user_email2-error").text('Enter valid Email address');
	                $("#user_email2").focus();
	                $(".user_email2-error").css('display', 'block');
	                error = 1;
	            } else if ($('#parentcnfemail').val() == $('#user_email2').val() || $('#user_email1').val() == $('#user_email2').val()) {
	                $(".user_email2-error").text('Enter different Email address');
	                $("#user_email2").focus();
	                $(".user_email2-error").css('display', 'block');
	                error = 1;
	            } else {
	                if(allowedEmaildomain($('#user_email2').val()))
	                {
	                    $(".user_email2-error").hide();
	                }
	                else
	                {
	                    $(".user_email2-error").text('Please use a general email address with domain ending in .com, .net. or .edu');
	                    $("#user_email2").focus();
	                    $(".user_email2-error").css('display', 'block');
	                    error = 1;
	                }
	            }
	            if (!$('#phone2').val()) {
	                $(".phone2-error").css('display', 'block');
	                $("#phone2").focus();
	                error = 1;
	            } else if (!validatePhone($('#phone2').val())) {
	                $(".phone2-error").text('Please enter valid mobile number');
	                $(".phone2-error").css('display', 'block');
	                $("#phone2").focus();
	                error = 1;
	            } else {
	                $(".phone2-error").hide();
	            }
				
			}

            if (!$('#timezone').val() || $('#timezone').val() == 'NA') {
                $(".timezone-error").css('display', 'block');
                $('#timezone').focus()
                error = 1;
            } else {
                $(".timezone-error").hide();
            }

            if (error == 0) {
                $('#newregister_bw').submit();
            } else {
                return false;
            }
            

		});
		

		$('#add-stu').click(function(e) {
			e.preventDefault();
			
			var did = $("#add-stu").attr("data-id");
			if(did == 1)
			{
				$("#add-stu").attr("data-id",2);
				$("#add-stu").html('<i class="fa fa-user-times" aria-hidden="true"></i>');
				$("#stud2").css("display","block");
				$('#stu1').collapse('hide');
				$('#stu2').collapse("toggle");
			}
			else
			{
				$("#stu2 input").val("");
				$("#add-stu").attr("data-id",1);
				$("#add-stu").html('<i class="fa fa-user-plus" aria-hidden="true"></i>');
				$("#stud2").css("display","none");
				$('#stu2').collapse('hide');
				$('#stu1').collapse("toggle");
			}
			
		});
   

    });






})(jQuery);