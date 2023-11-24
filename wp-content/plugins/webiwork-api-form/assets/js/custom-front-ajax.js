jQuery(document).ready(function(){ 

         

    jQuery(document).on('submit', '#ccpc_custom_form', function(e){  

        e.preventDefault();

        var numberReg = /^[0-9]+$/;

        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        var passWordReg = /^[a-zA-Z0-9]{6,15}$/;

        // Australian phone number regex pattern

        var australianRegex = /^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$/; 

        var passportVali = /^(?!^0+$)[a-zA-Z0-9]{3,20}$/; 

        var drivRegex = /^[A-Za-z0-9]{8}$/;

 

        var company_name = jQuery('#company_name').val();

        var contact_name = jQuery('#contact_name').val(); 

        var mobile_number = jQuery('#mobile_number').val();

        var email = jQuery('#bb-email').val();

        var password = jQuery('#password').val(); 

        var address = jQuery('#address').val(); 

        var passport  = jQuery('#passport ').val(); 

        var address = jQuery('#address').val(); 



        var documentFile = jQuery('#document').val(); 

        var passport = jQuery('#passport').val(); 

        var driver_license = jQuery('#driver_license').val(); 

        var expiration_date = jQuery('#expiration_date').val(); 

        console.log('process');

 

       var form_errors = 0; 



       jQuery('.form_errors').remove(); 

 

        if(company_name == '')

        {

            jQuery('#company_name').after('<p class="form_errors">Please enter company name.</p>');

            form_errors = 1;

        }

        if(contact_name == '')

        {

            jQuery('#contact_name').after('<p class="form_errors">Please enter contact name.</p>');

            form_errors = 1;

        } 

        if(email == '')

        {

            jQuery('#bb-email').after('<p class="form_errors">Please enter email.</p>');

            form_errors = 1;

        } else if(!emailReg.test(email)){

            form_errors=1; 

            jQuery('#bb-email').after('<p class="form_errors">Please enter a valid email</p>');

        }



        if(mobile_number == '')

        {

            jQuery('#mobile_number').after('<p class="form_errors">Please enter mobile number.</p>');

            form_errors = 1;

        }else if(!australianRegex.test(mobile_number)){

            form_errors=1; 

            jQuery('#mobile_number').after('<p class="form_errors">Please enter a valid australian phone number</p>');

        }

        console.log('ppp');



        if(password == '' || password == 0)

        {

            jQuery('#password').after('<p class="form_errors">Please enter password.</p>');

            form_errors = 1;

        }else if(!passWordReg.test(password)){

            form_errors=1; 

            jQuery('#password').after('<p class="form_errors">Password must be between 6 and 15 characters</p>');

        }



        if(passport != '' && !passportVali.test(passport)){

            form_errors=1; 

            jQuery('#passport').after('<p class="form_errors">Passport number is invalid. Please enter a valid number</p>');

        }

        if(driver_license != '' && !drivRegex.test(driver_license)){

            form_errors=1; 

            jQuery('#driver_license').after('<p class="form_errors">Invalid license number. Please check and try again</p>');

        }



        if(form_errors == 0)

        {



            var $this = jQuery(this);

            var fd = new FormData($this[0]); 

            var $this = jQuery(this);  

            var ajaxurl = profileManagement.ajax_site_url+'/wp-json/v1/company/create'; 

            $.ajax({

                url: ajaxurl,

                type: "POST",  

                data: fd,  

                beforeSend: function(request) {

                    request.setRequestHeader("X-Auth-Key", 'A54dsNLNLfd4ADLBDJBasiasab42adA2ADCSdad');

                    jQuery('#ccpc_custom-loader').show();

                },

                processData: false,

                contentType: false,

                success: function(res) {

                    console.log('success');

                    console.log(res);

                    jQuery('#ccpc_custom-loader').hide();

                    jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="color:green;font-size:12px">Sucessfull create user</p>');

                    setTimeout(function(){

                        location.reload(true);

                    },3000); 

                },

                error: function(xhr, status, error) {

                    console.log('error');

                    console.log(error);

                    console.log(xhr.responseJSON);

                    console.log(xhr);

                    jQuery('#ccpc_custom-loader').hide(); 

                   jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="font-size:12px">'+xhr.responseJSON.message+'</p>');



                }

            })

        }else{

            return false;

        }

                                    

    });

});

