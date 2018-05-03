<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view($header); 
/*echo link_tag("public/validator/css/validationEngine.jquery.css")."\n";*/
?>
<?
          if($this->session->userdata('language_version') == "french"){
            $email_us_at='Envoyez-nous un courriel à l’adresse';
            $send_your_msg='Envoyez-nous un message';
            $your_name='Votre nom';
            $your_email='Votre courriel';
            $phone_number='Numéro de téléphone';
            $subject='Sujet';
            $your_message='Votre message';
            $im_not_robot='Je ne suis pas un robot';
            $submit='Soumettre';
          }
          else{
            $email_us_at='Email us at';
            $send_your_msg='Send us your message';
            $your_name='Your Name';
            $your_email='Your email address';
            $phone_number='Phone number';
            $subject='Subject';
            $your_message='Your message';
            $im_not_robot='I am not a robot';
            $submit='Submit';
          }
            
        ?>
    <!--content section start-->
    <div class="contact-section">
     <?php if(!empty($contact_list)){ ?>
    	<div class="contact-info">
            <div class="wrapper">
                <ul>
                <?php if(!empty($contact_list->address)){ ?>
                    <li class="address">
                        <span></span>
                        <p><?php echo nl2br($contact_list->address); ?></p>
                    </li>
                    <?php } ?>
                    <?php if(!empty($contact_list->email)){ ?>
                    <li class="call">
                        <span></span>
                        <p><?=$email_us_at?>: <strong><?php echo $contact_list->email; ?></strong></p>
                    </li>
                   <?php } ?>
                </ul>
            </div>
       </div>
      <?php } ?>
       <div class="wrapper"  id ="success">
         <div id="full_contact"></div>
            <div class="contact-form">
                <div id="success"></div>
            	<h2><?=$send_your_msg?></h2>
                
                <p><?php if(!empty($this->data['hooks_meta']->content)){ echo outputEscapeString($this->data['hooks_meta']->content);} ?></p>
                 
               <form method="post" action="<?php echo site_url("common/contact_form");?>" id="contactForm"  class="contactForm">
                	<div class="common">
                    	<div class="contact-left">
                        	<input type="text" placeholder="<?=$your_name?>*" id="name" name="name" class="inputinpt validate[required]"/>
                        </div>
                        <div class="contact-left contact-right">
                        	<input type="text" placeholder="<?=$your_email?>*" id="email" name="email" class="inputinpt validate[required,custom[email]]"/>
                        </div>
                    </div>
                    <div class="common">
                    	<div class="contact-left">
                        	<input type="text" placeholder="<?=$phone_number?>" id="phone" name="phone" />
                        </div>
                        <div class="contact-left contact-right">
                        	<input type="text" placeholder="<?=$subject?>" id="subject" name="subject" />
                        </div>
                    </div>
                    <div class="common">
                    	<div class="textarea">
                    		<textarea id="message" class="validate[required]" name="message" placeholder="<?=$your_message?>*"></textarea>
                        </div>
                    </div>
                    <div class="common">
                    	<div class="captcha"  id="recaptcha2">
                        </div>
                        <input type="submit" value="<?=$submit?>" />
                    </div>
                </form>
            	<div class="clear"></div>
            </div>
        </div>
    </div>
    <!--content section end-->
    
 <!-- <script src="<?php echo base_url("public/validator/js/languages/jquery.validationEngine-en.js");?>" type="text/javascript" charset="utf-8"></script> 
<script src="<?php echo base_url("public/validator/js/jquery.validationEngine.js");?>" type="text/javascript" charset="utf-8"></script>-->

<script type="text/javascript">

		function beforeCall(form, options){
			return true;
		}
            
		// Called once the server replies to the ajax form validation request
		function ajaxValidationCallback(status, form, json, options){			    
			if (status === true) {
				from_send(json);
			}
		}
            function ajaxValidationbcall1(){ 
                                var recaptcha = $('#g-recaptcha-response').val();
                                if(recaptcha == ""){
                                    alert("Please check the captcha checkbox.");
                                    return false;
                                }else{
                                
                                }
                }
		jQuery(document).ready(function(){ 
			jQuery("#contactForm").validationEngine('attach',{
				relative: true,
				overflownDIV:"#divOverflown",
				promptPosition:"bottomLeft",
				ajaxFormValidation: true,
				ajaxFormValidationMethod: 'post',
				onAjaxFormComplete: ajaxValidationCallback,
                onBeforeAjaxFormValidation: ajaxValidationbcall1
			});
		});
		function showval(id,val)
		{
			if(val==$("#"+id).val())
			{
				jQuery("#"+id).val('');
			}
			else if($("#"+id).val()=='')
			{
				jQuery("#"+id).val(val);
			}
		}
		function from_send(json){
			var vl ='';
			jQuery(json).each(function(i,val){
				jQuery.each(val,function(k,v){
					if(v!=""){
						vl+=v;
					}
					
			});
			});
			if(vl=="")
			{
				jQuery("#full_contact").html("");
				jQuery("#success").html("<h2 align='center'><br/>Thank you for contacting us. Have a great day!</h2>");
                                //jQuery(window).scrollTop($(".new-inner-section contact-form").offset().top);
			}
			else
			{
				 jQuery("#full_contact").html(vl);
                                 //jQuery(window).scrollTop($(".new-inner-section contact-form").offset().top);
			}
		}
	</script>
    
    
        <script>
    var recaptcha1;
      var recaptcha2;
      var myCallBack = function() {
        
        //Render the recaptcha2 on the element with ID "recaptcha2"
        recaptcha2 = grecaptcha.render('recaptcha2', {
          'sitekey' : '6LfDzR8TAAAAAF7XQicXowz6QwpbP-MDw_rYjVf9', //Replace this with your Site key
          'theme' : 'light'
        });
      };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit" async defer></script>
<?php $this->load->view($footer); ?>