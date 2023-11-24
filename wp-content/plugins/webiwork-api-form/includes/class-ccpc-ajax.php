<?php

/**

 * Profile_Management_Ajax

 *

 * The Profile_Management_Ajax Class.

 *

 * @class    Profile_Management_Ajax

 * @parent Profile_Management_Base

 * @category Class 

 */  

if ( ! class_exists( 'Profile_Management_Ajax', false ) ) : 

	class Profile_Management_Ajax extends Profile_Management_Base {



		public function __construct()

		{  

			 // Add the shortcode

			 add_shortcode('profile_company_management_form', array($this, 'profile_company_management_form_shortcode'));

		}

		//profile company management form html

		public function profile_company_management_form_shortcode()

        {

            ob_start();  

            ?>

           

            <div class="main-wrapper">

                <form action="" id="ccpc_custom_form" method="post" enctype="multipart/form-data">

					<div id="ccpc_custom-loader"></div> 



					<!-- Step 2 starts -->

					<section class="inner-html" id="step2">

						<div class="container">

							

								<div class="row">

									<div class="col-md-12">

										<div class="form-group">

											<label for="company_name">Company Name<span>&#42;</span></label>

											<input type="text" class="form-control" id="company_name" name="company_name" value="">

										</div>

									</div>	

									

								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="contact_name">Primary Contact Name <span>&#42;</span></label>

											<input type="text" class="form-control" id="contact_name" name="contact_name" value="">

										</div>

									</div>

									<div class="col-md-6">

										<div class="form-group">

											<label for="mobile_number">Mobile Number <span>&#42;</span></label>

											<input type="text" class="form-control" id="mobile_number" name="mobile_number" value="">

										</div>

									</div>	

								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="bb-email">Email <span>&#42;</span></label>

											<input type="text" class="form-control" id="bb-email" name="email" value="">

										</div>

									</div>	

									<div class="col-md-6">

										<div class="form-group">

											<label for="password">Password <span>&#42;</span></label>

											<input type="password" class="form-control" id="password" name="password" value="">

										</div>

									</div>

								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="address">Address</label>

											<input type="text" class="form-control" id="address" name="address" value="">

										</div>

									</div>	

									<div class="col-md-6">

										<div class="form-group">

											<label for="document">Document Upload</label>

											<input type="file" class="form-control" id="document" name="document" value="">

										</div>

									</div>

								</div>

								<div class="row">

									<div class="col-md-6">

										<div class="form-group">

											<label for="passport">Passport</label>

											<input type="text" class="form-control" id="passport" name="passport" value="">

										</div>

									</div>	

									<div class="col-md-6">

										<div class="form-group">

											<label for="driver_license">Driver's License</label>

											<input type="text" class="form-control" id="driver_license" name="driver_license" value="">

										</div>

									</div>	

									<div class="col-md-6">

										<div class="form-group">

											<label for="expiration_date">Expiration date</label>

											<input type="date" class="form-control" id="expiration_date" name="expiration_date" value="">

										</div>

									</div>

								</div>

								<div class="row mt-15">

									<div class="col-md-12">

										<button type="submit" id="ccpc_custom_formbtn" class="btn btn-theme btn-block">Save Now</button>

									</div>	

									 

								</div> 

						</div>

					</section>

					<!-- Step 2 ends -->



                </form>

            </div> 



            <?php 

            return ob_get_clean();  

        } 



    }

endif;

new Profile_Management_Ajax();