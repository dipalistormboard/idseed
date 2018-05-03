<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!-- Footer Section Start-->
	<div class="footer">
    	<div class="ftnav">
        	<div class="wrapper">
<!--                <ul >
                	<li><a href="index.html" class="active">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="fact-sheets.html">Fact sheets</a></li>
                    <li><a href="keys.html">keys</a></li>
                    <li><a href="glossary.html">Glossary</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>-->
                <?php 	echo $this->data['hooks_footerpages_list'];?>
            </div>
        </div>
        <div class="ftlogo-section">
        	<div class="wrapper">
                <div class="ftleft">
            		<p><?php if(!empty($this->data['site_settings']->edition)){ echo $this->data['site_settings']->edition; } ?></p>
                </div>
                <?php if(!empty($this->data['footer_logo'])){ ?>
                <ul class="ftlogos">
                    <?php foreach($this->data['footer_logo'] as $footer_logo){ //pre($footer_logo);
                        if(!empty($footer_logo->footer_logo) && is_file(file_upload_absolute_path()."footer_logo_photo/".$footer_logo->footer_logo)) { ?>
                    <?php //if($footer_logo->id != 6 && $footer_logo->id != 7){ ?>
                    <li><a target="<?php if(!empty($footer_logo->url)){ ?>_blank<?php } ?>" href="<?php if(!empty($footer_logo->url)){ echo $footer_logo->url;}else{ ?>javascript:void(0)<?php } ?>"><img src="<?php echo base_url("public/uploads/footer_logo_photo/".$footer_logo->footer_logo); ?>" alt="" title="" /></a></li>
                    <?php /*}else if($footer_logo->id == 6 & $this->session->userdata('language_version') == "french"){ ?>
                    
                    <?php }else if($footer_logo->id == 7 & $this->session->userdata('language_version') == "english"){ ?>
                    
                    <?php }else{ ?>
                    <li><a target="<?php if(!empty($footer_logo->url)){ ?>_blank<?php } ?>" href="<?php if(!empty($footer_logo->url)){ echo $footer_logo->url;}else{ ?>javascript:void(0)<?php } ?>"><img src="<?php echo base_url("public/uploads/footer_logo_photo/".$footer_logo->footer_logo); ?>" alt="" title="" /></a></li>
                    <?php } */ ?>
                    <?php   } 
                        }?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="copyright">
    	<div class="wrapper">
        	<ul class="ftsocial">
                <?php echo socialLinks(); ?>
            </ul>
        	<p class="copytext">&copy; <?php echo date("Y"); ?> <?php echo $this->data['site_settings']->copyright; ?></p>
            <p class="designby"><?php if($this->session->userdata('language_version') == "french"){ echo "Ce site Web est développés et conçus par"; ?>
                        <?php } ?>
                        <?php if($this->session->userdata('language_version') == "english"){ echo "Website Designed & Developed by"; ?>
                        <?php } ?> <a href="https://www.2webdesign.com/" rel="nofollow" target="_blank">2 Web Design</a></p>
        </div>
    </div>
	<span class="back-to-top"  id="toTop"  href="javascript:void(0);"></span>
<!-- Footer Section End-->
<?php if(!empty($this->data['site_settings']->analytics_code)){ ?>
<?php echo $this->data['site_settings']->analytics_code; ?>
<?php } ?>
</body>
</html>
