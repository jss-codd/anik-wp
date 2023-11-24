<?php

/**

 * Profile_Management_Helper

 *

 * The Profile_Management_Helper Class.

 *

 * @class Profile_Management_Helper 

 * @category Class 

 */  

if ( ! class_exists( 'Profile_Management_Helper', false ) ) : 

	class Profile_Management_Helper {



		public function __construct()

		{  

            //Enqueue Script

			add_action( 'wp_enqueue_scripts', array($this,  'pm_custom_company_script_style'));



            //Register company API route

            add_action('rest_api_init', array($this, 'pm_company_api_route'));



        }



        //check header authentication key

        public function validate_auth_key($auth_key)

        {

            if($auth_key == 'A54dsNLNLfd4ADLBDJBasiasab42adA2ADCSdad')

            {

                return true;

            }else{

                return false;

            }

        } 



        //Register company API route and include authentication

        public function pm_company_api_route() {

            register_rest_route(

                'v1',  

                '/profile/',  

                array(

                    'methods'   => 'POST',

                    'callback'  => array($this, 'custom_company_api_callback'),

                    'permission_callback' => function ($request) {

                        $auth_key = $request->get_header('X-Auth-Key');

                        if (!$auth_key || !$this->validate_auth_key($auth_key)) {

                            return new WP_Error('rest_forbidden', 'Invalid authentication key.', array('status' => 403));

                        }

                        return true;

                    },

                    'args'=> array( 

                        'company_name' => array(

                            'required'          => true, 

                            'type'     => 'string',

                        ),

                        'contact_name' => array(

                            'required'          => true,

                            'type'     => 'string',  

                        ),

                        'mobile_number' => array(

                            'required'  => true,   

                        ),

                        'email' => array(

                            'required'  => true,

                            'type'     => 'string',   

                        ),

                        'password' => array(

                            'required' => true, 

                            'type'     => 'string',  

                        ),

                        'address' => array(

                            'required' => true, 

                            'type'     => 'string',  

                        ),

                    ),

                )

            ); 

        }



        //create api callback 

        public function custom_company_api_callback($request) 

        {

            // Your custom logic goes here

            $company_name = $request->get_param('company_name');

            $contact_name = $request->get_param('contact_name');

            $mobile_number = $request->get_param('mobile_number');

            $email = $request->get_param('email');

            $password = $request->get_param('password');

            $address = $request->get_param('address'); 



            $driver_license = $request->get_param('driver_license');

            $passport = $request->get_param('passport');

            $expiration_date = $request->get_param('expiration_date');

 

            //check validation



            //Password 6 to 8 regex pattern

            $pattern = '/^.{6,15}$/';



            // Australian phone number regex pattern

            $regex = '/^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$/';

 

            $mobile_number = sanitize_text_field($mobile_number); 

            $password = sanitize_text_field($password); 

            $email = sanitize_email($email); 

            

            if(!preg_match($regex, $mobile_number))

            { 

                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Please enter a valid Australian phone number' ) ),

                    array(

                        'status' => 400,

                        'params' => 'document',

                    )

                );

            }



            if (!is_email($email)) {



                return new WP_Error(

                    'rest_invalid_param', 

                    sprintf( __( 'Please enter a valid email' ) ),

                    array(

                        'status' => 400,

                        'params' => 'email',

                    )

                );

            }



            // Define the regular expression for password validation (6 to 8 characters)

            if (!preg_match($pattern, $password)) {

                return new WP_Error(

                    'invalid_password_length', 

                    sprintf( __( 'Password must be between 6 and 15 characters' ) ),

                    array(

                        'status' => 400,

                        'params' => 'password',

                    )

                );

            }



            //get files

            $file = $request->get_file_params(); 



            //check documents

            if(array_key_exists('document', $file))

            {

                $imageFileType = pathinfo($file['document']['name'],PATHINFO_EXTENSION);

                $valid_extensions = array("jpg","jpeg","png", "pdf");



                //This checks if the file is an document.

                if(!in_array(strtolower($imageFileType), $valid_extensions)) {

                    return new WP_Error(

                        'invalid_file_type', 

                        sprintf( __( 'Invalid file type. You can only upload : %s' ), implode( ', ', $valid_extensions ) ),

                        array(

                            'status' => 400,

                            'params' => 'document',

                        )

                    ); 

                }  

            }else{



                return new WP_Error(

                    'rest_missing_callback_param', 

                    sprintf( __( 'Missing parameter(s): %s' ), 'document' ),

                    array(

                        'status' => 400,

                        'params' => 'document',

                    )

                );

            }



            // check if email exists already

            if ( email_exists( $email ) ) { 



                return new WP_Error(

                    'rest_missing_callback_param', 

                    sprintf( __( 'This email is already exist: %s' ), $email ),

                    array(

                        'status' => 409,

                        'params' => 'email',

                    )

                ); 

            }   



            $uploaddir = wp_upload_dir(); 



            $document = $file['document'];

            $document_file = time().'-document-'.$document['name'];

            $document_sourcePath = $document['tmp_name']; 



            $filename_profile = $uploaddir['url'] . '/' . basename( $document_file );

            $uploadfile_profile = $uploaddir['path'] . '/' . basename( $document_file );



            $uploaded_profile = move_uploaded_file( $document_sourcePath , $uploadfile_profile );

              

            if (isset($uploaded_profile['error'])) {

                return new WP_Error(

                    'upload_failed', 

                    sprintf( __( 'Upload Failed: %s' ), $uploaded_file['error'] ),

                    array(

                        'status' => 422,

                        'params' => 'document',

                    )

                );

            }

            





            $userReg=wp_insert_user(array(

                'user_login'     => $email,

                'user_email'     => $email,

                'user_pass'      => $password, 

                'display_name'   => $contact_name, 

            ));

 

            if( isset( $userReg ) && is_numeric( $userReg ) ){



                update_user_meta($userReg, 'company_name', $company_name);

                update_user_meta($userReg, 'contact_name', $contact_name);

                update_user_meta($userReg, 'mobile_number', $mobile_number);

                update_user_meta($userReg, 'email', $email);

                update_user_meta($userReg, 'address_1', $address);

                update_user_meta($userReg, 'driver_license', $driver_license);

                update_user_meta($userReg, 'passport', $passport);

                update_user_meta($userReg, 'expiration_date', $expiration_date);

                update_user_meta( $userReg, 'document_url', $filename_profile ); 



                 $response = array('success' => true, 'message' => 'Sucessfull create user');

                return rest_ensure_response($response);



            }else{

                foreach ($userReg->errors as $key => $errors) {

                    $massage .= $errors[0];

                }

                return new WP_Error(

                    'register failed', 

                    sprintf( __( $massage ) ),

                    array(

                        'status' => 422,

                        'params' => 'register error',

                    )

                );

            } 

        }



        //Enqueue Script

        public function pm_custom_company_script_style()

        {

            wp_enqueue_script('ccpc_custom_jquery', CCPC_CUSTOM_PLUGIN_URL.'/assets/js/jquery.min.js');

			wp_enqueue_script( 'ccpc_custom_jquery' ); 



            //js for custom   

			wp_enqueue_script('ccpc_custom_front_js', CCPC_CUSTOM_PLUGIN_URL.'/assets/js/custom-front-ajax.js');

			wp_enqueue_script( 'ccpc_custom_front_js' ); 

			wp_localize_script('ccpc_custom_front_js','profileManagement',array( 

				'ajax_url'			=> site_url().'/wp-admin/admin-ajax.php',

                'ajax_site_url'      => site_url(),

				'ajax_nonce'		=> wp_create_nonce('customCCPC_nonce')

			));



			wp_enqueue_style('ccpc_custom_css', CCPC_CUSTOM_PLUGIN_URL.'/assets/css/custom-style.css',false,'0.4','all');

			wp_enqueue_style( 'ccpc_custom_css' ); 



            wp_enqueue_style('ccpc_custom_fontsstylesheet', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap',false,'0.1','all');

            wp_enqueue_style( 'ccpc_custom_fontsstylesheet' );





        }

 

    }

endif;

new Profile_Management_Helper();