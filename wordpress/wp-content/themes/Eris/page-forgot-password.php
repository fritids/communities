<?php
/*
 * Template Name: Forgot Password
 */

/**
 * @package WordPress
 * @subpackage White Label
 */

//Form handler
if(! empty($_POST)) {
	
	//Only proceed if SSO plugin is active
	if(class_exists('SSO_Profile_Request')) {
	
		//Forgot password request
		if(isset($_POST['login_email'])) {
			
			$response = SSO_Profile_Request::factory()->reset_password($_POST['login_email']);//$profile->reset_password($_POST['login_email']);
			
		}
		
		//Enter new password 
		if(isset($_POST['new_password']) && isset($_POST['auth_token'])) {
			
			$response = SSO_Profile_Request::factory()->authorize_reset($_POST['new_password'], $_POST['auth_token']); 
		}
	
	}
	
	/**
	 * $response is an array with the response message. 
	 * Access the message via $response['message']
	 */
}
if(! is_ajax()):

get_template_part('parts/header'); ?>
	<section class="span8">
<?php endif;?>	

		<article class="content-container forgot-password span12">
			<section class="content-body clearfix">
			
	<?php if(empty($_POST) || (isset($response) && $response['code'] != '200')):?>
	
				<h5 class="content-headline"><?php echo (isset($_GET['auth_token'])) ? 'Enter New Password' : 'Forgot Password'?></h5>
				<p>
        	<?php 
        		echo (isset($_GET['auth_token'])) ? 'Enter a new password for your account below.' : 'Please verify the email address for your account and press continue.';
        		
        endif;
     ?>
       			 </p>
				
				<form class="form_login" method="post" action="<?php echo site_url('/forgot-password/') . ((isset($_GET['auth_token'])) ? '?auth_token=' . $_GET['auth_token'] : null); ?>" shc:gizmo="transFormer" />

		 <?php if(!empty($_POST)): ?>
		 	<h6 class="content-headline">
				<?php if(isset($_GET['auth_token'])):
				
						echo ($response['code'] == '200') ? 'Congratulations!' : 'Oops! There was a problem.';
				?>
					
				
				<?php else:
						
						echo ($response['code'] == '200') ? 'You\'re almost done!' : '';
				?>
				
				<?php endif;?>
			</h6>		
				
			<?php if(isset($response)): 
				if ($response['code'] != '404'):?>
					<p><?php echo $response['message']?></p>
				
				<?php else: ?>
					<p id="sso-error">Please enter a valid email address.</p>
				<?php endif;?> 
			<?php endif;?> 
		 
		 <?php endif;?>
		 
          <ul class="form-fields">
              <?php if(! isset($_GET['auth_token'])):
              			if(empty($_POST) || (isset($response) && $response['code'] != '200')):
              ?>
              <li>
                  <dl class="clearfix">
                      <dt class="span3"><label for="login_email">Email:</label></dt>
                      <dd class="span9"><input type="text" name="login_email" class="input_text" id="login_email" /></dd>
                  </dl>
              </li>
              <?php 
              		endif;
              else:
              			if(empty($_POST)):
              ?>
              <li>
                  <dl class="clearfix">
                      <dt class="span3"><label for="new_password">New Password:</label></dt>
                      <dd class="span9"><input type="password" 
                      							name="new_password"
                      							autocomplete="off" 
                      							class="input_text input_password" 
                      							id="new_password"
                      							shc:gizmo:form="{required:true, pattern: /^\w*(?=\w{6,})(?=\w*\d)(?=\w*[a-zA-Z])(?!\w*_)\w*$/, message: 'Please enter a valid password.'}"
                            					shc:gizmo="tooltip"
					                            shc:gizmo:options="
					                            {
					                                tooltip: {
					                                    displayData: {
					                                        element: 'passInfo'
					                                    },
					                                    events: {
					                                        click: {
					                                            active: false
					                                        },
					                                        blur: {
					                                            active: true
					                                        },
					                                        focus: {
					                                            active: true
					                                        }
					                                    },
					                                    arrowPosition: 'left'
					                                }
					                            }" /></dd>
                  </dl>
              </li>
              
               <input type="hidden" name="auth_token" value="<?php echo $_GET['auth_token'];?>" />
               
              <?php endif;
              			endif;
              ?>
              
              <?php if(empty($_POST) || (isset($response) && $response['code'] != '200')):?>
              <li class="clearfix">
                  <dl>
                      <dd class="span3">&nbsp;</dd>
                      <dd class="span9">
                          <button type="submit" class="<?php echo theme_option("brand"); ?>_button">Continue</button>
                      </dd>
                  </dl>
              </li>
              <?php endif;?>
          </ul>
	          <div id="passInfo" class="info hide">
	            <p class="bold">Your password must have:</p>
	            <ul>
	                <li>6 or more characters total</li>
	                <li>At least one letter</li>
	                <li>At least one number</li>
	                <li>No space</li>
	                <li>No special characters such as ! or ?</li>
	            </ul>
	            <p>All passwords are cAsE sEnSiTiVe.</p>
	        </div>
				</form>
		<?php //else:?>
			
		
		<?php //endif;?>
			</section>
	
		</article>
		
			<?php if(! is_ajax()):?>
	</section>


	<section class="span4">
	</section>
	
<?php
get_template_part('parts/footer');

endif;