<?php

//if user is logged in, redirect to home page
if(is_user_logged_in()) {
	
	wp_redirect(get_site_url());
	exit;
}

/**
 * @package WordPress
 * @subpackage White Label
 */

if(! is_ajax()):

get_template_part('parts/header'); ?>
	<section class="span8">
<?php endif;?>		
<article class="content-container sign-in span12">
	
	<section class="content-body clearfix">

		<h6 class="content-headline">Sign in</h6>
		
	<form class="form_login" method="post" action="" shc:gizmo="transFormer" id="login">
      <ul class="form-fields">
          
          <li>
              <dl class="clearfix">
                  <dt class="span3"><label for="loginId">Email:</label></dt>
                  <dd class="span9"><input type="text" name="loginId" class="input_text" id="login_email" shc:gizmo:form="{required:true, trim:true, pattern: /^.+@.+?\.[a-zA-Z]{2,}$/, message:'The email address you enter should follow this format: name@domain.com. Please try again.'}" /></dd>
              </dl>
          </li>
          
          <li>
              <dl class="clearfix">
                  <dt class="span3"><label for="logonPassword">Password:</label></dt>
                  <dd class="span8"><input type="password" name="logonPassword" class="input_text input_password" id="password" shc:gizmo:form="{required:true, pattern: /^\w*(?=\w{6,})(?=\w*\d)(?=\w*[a-zA-Z])(?!\w*_)\w*$/, message: 'Please enter your password.'}" /></dd>
                  <dd class="span1"><a href="<?php echo get_site_url(); ?>/forgot-password/" title="Forgot your password?" class="forgot">Forgot?</a></dd>
              </dl>
          </li>
          
          <li id="sso-error">
          </li>
          
          <li class="clearfix">
              <dl>
                  <dd class="span3">&nbsp;</dd>
                  <dd class="span9">
                      <button type="submit" class="<?php echo theme_option("brand"); ?>_button">Sign in</button>
                  </dd>
              </dl>
          </li>
          
      </ul>
      		<input type="hidden" name="service" value="<?php //echo $opts->url_append_qs("origin={$origin}&ssologin", urldecode($origin));?>" />
			<input type="hidden" name="sourceSiteid" value="<?php //echo $opts->sso_site_id;?>" />
		
		</form>
		

		
		<ul>
      <li class="clearfix">
        <dl>
          <dd class="span3">&nbsp;</dd>
          <dd class="span9">
            <p class="bold">
              New Customer? <a href="/register/" title="Sign Up" shc:gizmo="moodle" shc:gizmo:options="{moodle: {width:480, target:ajaxdata.ajaxurl, type:'POST', data:{action: 'get_template_ajax', template: 'page-register'}}}">Register Now</a>
            </p>
          </dd>
        </dl>
      </li>
    </ul>
		
		<section id="login-open-id" class="open-id" shc:gizmo="openID">
			<span class="or">OR</span>
			<p>use your account from</p>
			<ul class="open-id-services clearfix">
				<li class="open-id_service open-id_facebook"><a href="#" shc:openID="facebook">Facebook</a></li>
				<li class="open-id_service open-id_yahoo"><a href="#" shc:openID="yahoo">Yahoo!</a></li>
				<li class="open-id_service open-id_google"><a href="#" shc:openID="google">Google</a></li>
				<!-- <li class="open-id_service open-id_twitter"><a href="#" shc:openID="twitter">Twitter</a></li> -->
			</ul>
		</section>
		
	</section>

</article>
			<?php if(! is_ajax()):?>
	</section>


	<section class="span4">
	</section>
	
<?php
get_template_part('parts/footer');

endif;
?>